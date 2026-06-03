<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $module = $this->route('module');

        $common = [
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
        ];

        return match ($module) {
            'services' => $common + [
                'slug' => ['nullable', 'string', 'max:255'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['nullable', 'string', 'max:255'],
                'summary_en' => ['nullable', 'string'],
                'summary_ar' => ['nullable', 'string'],
                'description_en' => ['nullable', 'string'],
                'description_ar' => ['nullable', 'string'],
                'icon' => ['nullable', 'string', 'max:255'],
            ],
            'projects' => $common + [
                'slug' => ['nullable', 'string', 'max:255'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['nullable', 'string', 'max:255'],
                'client_name' => ['nullable', 'string', 'max:255'],
                'industry_en' => ['nullable', 'string', 'max:255'],
                'industry_ar' => ['nullable', 'string', 'max:255'],
                'summary_en' => ['nullable', 'string'],
                'summary_ar' => ['nullable', 'string'],
                'description_en' => ['nullable', 'string'],
                'description_ar' => ['nullable', 'string'],
                'results_en' => ['nullable', 'string'],
                'results_ar' => ['nullable', 'string'],
                'project_url' => ['nullable', 'string', 'max:2048'],
                'image_path' => ['nullable', 'string', 'max:2048'],
                'image_path_file' => ['nullable', 'image', 'max:4096'],
            ],
            'case-studies' => $common + [
                'project_id' => ['nullable', 'integer', 'exists:projects,id'],
                'slug' => ['nullable', 'string', 'max:255'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['nullable', 'string', 'max:255'],
                'client_name' => ['nullable', 'string', 'max:255'],
                'summary_en' => ['nullable', 'string'],
                'summary_ar' => ['nullable', 'string'],
                'challenge_en' => ['nullable', 'string'],
                'challenge_ar' => ['nullable', 'string'],
                'solution_en' => ['nullable', 'string'],
                'solution_ar' => ['nullable', 'string'],
                'results_en' => ['nullable', 'string'],
                'results_ar' => ['nullable', 'string'],
                'published_at' => ['nullable', 'date'],
            ],
            'team' => [
                'name_en' => ['required', 'string', 'max:255'],
                'name_ar' => ['nullable', 'string', 'max:255'],
                'role_en' => ['nullable', 'string', 'max:255'],
                'role_ar' => ['nullable', 'string', 'max:255'],
                'bio_en' => ['nullable', 'string'],
                'bio_ar' => ['nullable', 'string'],
                'image_path' => ['nullable', 'string', 'max:2048'],
                'image_path_file' => ['nullable', 'image', 'max:4096'],
                'email' => ['nullable', 'email', 'max:255'],
                'linkedin_url' => ['nullable', 'string', 'max:2048'],
                'is_active' => ['nullable', 'boolean'],
                'order' => ['nullable', 'integer'],
            ],
            'testimonials' => $common + [
                'client_name_en' => ['required', 'string', 'max:255'],
                'client_name_ar' => ['nullable', 'string', 'max:255'],
                'client_title_en' => ['nullable', 'string', 'max:255'],
                'client_title_ar' => ['nullable', 'string', 'max:255'],
                'company' => ['nullable', 'string', 'max:255'],
                'quote_en' => ['required', 'string'],
                'quote_ar' => ['nullable', 'string'],
                'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
                'image_path' => ['nullable', 'string', 'max:2048'],
                'image_path_file' => ['nullable', 'image', 'max:4096'],
            ],
            'clients' => $common + [
                'name' => ['required', 'string', 'max:255'],
                'logo_path' => ['nullable', 'string', 'max:2048'],
                'logo_path_file' => ['nullable', 'image', 'max:4096'],
                'website_url' => ['nullable', 'string', 'max:2048'],
                'industry_en' => ['nullable', 'string', 'max:255'],
                'industry_ar' => ['nullable', 'string', 'max:255'],
            ],
            'blog' => $common + [
                'slug' => ['nullable', 'string', 'max:255'],
                'title_en' => ['required', 'string', 'max:255'],
                'title_ar' => ['nullable', 'string', 'max:255'],
                'excerpt_en' => ['nullable', 'string'],
                'excerpt_ar' => ['nullable', 'string'],
                'body_en' => ['nullable', 'string'],
                'body_ar' => ['nullable', 'string'],
                'cover_image_path' => ['nullable', 'string', 'max:2048'],
                'cover_image_path_file' => ['nullable', 'image', 'max:4096'],
                'author_name' => ['nullable', 'string', 'max:255'],
                'published_at' => ['nullable', 'date'],
            ],
            default => [],
        };
    }
}
