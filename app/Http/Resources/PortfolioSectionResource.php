<?php

namespace App\Http\Resources;

use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'module' => $this->module,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'is_active' => (bool) $this->is_active,
            'order' => (int) $this->order,
            'limit' => (int) $this->limit,
            'items' => PortfolioItemResource::collection($this->items())->resolve($request),
        ];
    }

    private function items()
    {
        $model = self::modules()[$this->module] ?? null;

        if (!$model) {
            return collect();
        }

        return $model::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->latest()
            ->limit($this->limit)
            ->get();
    }

    public static function modules(): array
    {
        return [
            'services' => Service::class,
            'projects' => Project::class,
            'case-studies' => CaseStudy::class,
            'team' => TeamMember::class,
            'testimonials' => Testimonial::class,
            'clients' => Client::class,
            'blog' => BlogPost::class,
        ];
    }
}
