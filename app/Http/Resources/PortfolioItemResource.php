<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $model = $this->resource;
        $data = [
            'id' => $model->getKey(),
            'type' => Str::kebab(class_basename($model)),
            'is_active' => (bool) $model->getAttribute('is_active'),
            'is_featured' => (bool) $model->getAttribute('is_featured'),
            'order' => (int) ($model->getAttribute('order') ?? 0),
        ];

        foreach ([
            'slug',
            'title_en', 'title_ar', 'summary_en', 'summary_ar', 'description_en', 'description_ar',
            'client_name', 'industry_en', 'industry_ar', 'results_en', 'results_ar', 'project_url',
            'challenge_en', 'challenge_ar', 'solution_en', 'solution_ar',
            'name', 'name_en', 'name_ar', 'role_en', 'role_ar', 'bio_en', 'bio_ar',
            'client_name_en', 'client_name_ar', 'client_title_en', 'client_title_ar',
            'company', 'quote_en', 'quote_ar', 'rating', 'website_url',
            'excerpt_en', 'excerpt_ar', 'body_en', 'body_ar', 'author_name',
            'published_at', 'email', 'linkedin_url', 'icon',
            'image_path', 'logo_path', 'cover_image_path',
        ] as $field) {
            $value = $model->getAttribute($field);

            if ($value !== null) {
                $data[$field] = $value;
            }
        }

        foreach (['image_path', 'logo_path', 'cover_image_path'] as $field) {
            $path = $model->getAttribute($field);

            if ($path) {
                $data[str_replace('_path', '_url', $field)] = $this->mediaUrl($path);
            }
        }

        return $data;
    }

    private function mediaUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return url($path);
        }

        return url(Storage::disk('public')->url($path));
    }
}
