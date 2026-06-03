<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Client;
use App\Models\PortfolioSection;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request, string $module): View
    {
        $config = $this->moduleConfig($module);
        $modelClass = $config['model'];
        $settings = PortfolioSection::firstOrCreate(
            ['module' => $module],
            $this->defaultSectionSettings($module, $config)
        );

        $items = $modelClass::query()
            ->when($request->query('search'), function ($query, string $search) use ($config) {
                $query->where(function ($query) use ($config, $search) {
                    foreach ($config['search'] as $field) {
                        $query->orWhere($field, 'like', "%{$search}%");
                    }
                });
            })
            ->when($request->query('status') === 'active', fn ($query) => $query->where('is_active', true))
            ->when($request->query('status') === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when(
                $request->query('featured') === '1' && array_key_exists('is_featured', $config['fields']),
                fn ($query) => $query->where('is_featured', true)
            )
            ->orderBy('order')
            ->latest()
            ->paginate(12)
            ->withQueryString();
        $projects = Project::query()->orderBy('title_en')->get(['id', 'title_en']);

        return view('admin.portfolio.index', compact('module', 'config', 'items', 'projects', 'settings'));
    }

    public function updateSettings(Request $request, string $module): RedirectResponse
    {
        $config = $this->moduleConfig($module);
        $data = $request->validate([
            'title_en' => ['required', 'string'],
            'title_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:24'],
        ]);

        PortfolioSection::updateOrCreate(
            ['module' => $module],
            [
                ...$this->defaultSectionSettings($module, $config),
                ...Arr::only($data, ['title_en', 'title_ar', 'description_en', 'description_ar', 'order', 'limit']),
                'is_active' => $request->boolean('is_active'),
            ]
        );

        return back()->with('success', $config['title'].' settings updated.');
    }

    public function store(PortfolioRequest $request, string $module): RedirectResponse
    {
        $config = $this->moduleConfig($module);
        $payload = $this->payload($request, $config);

        $config['model']::create($payload);

        return back()->with('success', $config['singular'].' created.');
    }

    public function update(PortfolioRequest $request, string $module, int $id): RedirectResponse
    {
        $config = $this->moduleConfig($module);
        $model = $config['model']::query()->findOrFail($id);

        $model->fill($this->payload($request, $config, $model))->save();

        return back()->with('success', $config['singular'].' updated.');
    }

    public function destroy(string $module, int $id): RedirectResponse
    {
        $config = $this->moduleConfig($module);
        $config['model']::query()->findOrFail($id)->delete();

        return back()->with('success', $config['singular'].' deleted.');
    }

    private function payload(PortfolioRequest $request, array $config, ?Model $model = null): array
    {
        $payload = Arr::only($request->validated(), array_keys($config['fields']));

        foreach (['is_active', 'is_featured'] as $boolean) {
            if (array_key_exists($boolean, $config['fields'])) {
                $payload[$boolean] = $request->boolean($boolean);
            }
        }

        foreach ($this->fileFields($config) as $field) {
            if ($request->hasFile($field.'_file')) {
                $payload[$field] = $request->file($field.'_file')->store(
                    'portfolio/'.$config['module'],
                    'public'
                );
            }
        }

        if (array_key_exists('order', $config['fields'])) {
            $payload['order'] = (int) ($payload['order'] ?? 0);
        }

        if (array_key_exists('slug', $config['fields'])) {
            $base = $payload['slug'] ?? $payload['title_en'] ?? class_basename($config['model']);
            $payload['slug'] = $this->uniqueSlug($config['model'], $base, $model?->getKey());
        }

        return $payload;
    }

    private function uniqueSlug(string $modelClass, string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $counter = 2;

        while ($modelClass::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }

    private function moduleConfig(string $module): array
    {
        $modules = [
            'services' => [
                'title' => 'Services',
                'singular' => 'Service',
                'model' => Service::class,
                'primary' => 'title_en',
                'search' => ['title_en', 'title_ar', 'summary_en', 'summary_ar'],
                'fields' => $this->localizedContentFields(['icon' => 'Icon']),
            ],
            'projects' => [
                'title' => 'Projects',
                'singular' => 'Project',
                'model' => Project::class,
                'primary' => 'title_en',
                'search' => ['title_en', 'title_ar', 'client_name', 'industry_en', 'industry_ar', 'summary_en', 'summary_ar'],
                'fields' => [
                    'slug' => 'Slug',
                    'title_en' => 'Title EN',
                    'title_ar' => 'Title AR',
                    'client_name' => 'Client',
                    'industry_en' => 'Industry EN',
                    'industry_ar' => 'Industry AR',
                    'summary_en' => ['label' => 'Summary EN', 'type' => 'textarea'],
                    'summary_ar' => ['label' => 'Summary AR', 'type' => 'textarea'],
                    'description_en' => ['label' => 'Description EN', 'type' => 'textarea'],
                    'description_ar' => ['label' => 'Description AR', 'type' => 'textarea'],
                    'results_en' => ['label' => 'Results EN', 'type' => 'textarea'],
                    'results_ar' => ['label' => 'Results AR', 'type' => 'textarea'],
                    'project_url' => 'Project URL',
                    'image_path' => ['label' => 'Image', 'type' => 'file'],
                    'is_featured' => ['label' => 'Featured', 'type' => 'checkbox'],
                    'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
                    'order' => ['label' => 'Order', 'type' => 'number'],
                ],
            ],
            'case-studies' => [
                'title' => 'Case Studies',
                'singular' => 'Case Study',
                'model' => CaseStudy::class,
                'primary' => 'title_en',
                'search' => ['title_en', 'title_ar', 'client_name', 'summary_en', 'summary_ar'],
                'fields' => [
                    'project_id' => ['label' => 'Project', 'type' => 'project-select'],
                    'slug' => 'Slug',
                    'title_en' => 'Title EN',
                    'title_ar' => 'Title AR',
                    'client_name' => 'Client',
                    'summary_en' => ['label' => 'Summary EN', 'type' => 'textarea'],
                    'summary_ar' => ['label' => 'Summary AR', 'type' => 'textarea'],
                    'challenge_en' => ['label' => 'Challenge EN', 'type' => 'textarea'],
                    'challenge_ar' => ['label' => 'Challenge AR', 'type' => 'textarea'],
                    'solution_en' => ['label' => 'Solution EN', 'type' => 'textarea'],
                    'solution_ar' => ['label' => 'Solution AR', 'type' => 'textarea'],
                    'results_en' => ['label' => 'Results EN', 'type' => 'textarea'],
                    'results_ar' => ['label' => 'Results AR', 'type' => 'textarea'],
                    'published_at' => 'Published At',
                    'is_featured' => ['label' => 'Featured', 'type' => 'checkbox'],
                    'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
                    'order' => ['label' => 'Order', 'type' => 'number'],
                ],
            ],
            'team' => [
                'title' => 'Team',
                'singular' => 'Team Member',
                'model' => TeamMember::class,
                'primary' => 'name_en',
                'search' => ['name_en', 'name_ar', 'role_en', 'role_ar', 'email'],
                'fields' => [
                    'name_en' => 'Name EN',
                    'name_ar' => 'Name AR',
                    'role_en' => 'Role EN',
                    'role_ar' => 'Role AR',
                    'bio_en' => ['label' => 'Bio EN', 'type' => 'textarea'],
                    'bio_ar' => ['label' => 'Bio AR', 'type' => 'textarea'],
                    'image_path' => ['label' => 'Image', 'type' => 'file'],
                    'email' => 'Email',
                    'linkedin_url' => 'LinkedIn URL',
                    'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
                    'order' => ['label' => 'Order', 'type' => 'number'],
                ],
            ],
            'testimonials' => [
                'title' => 'Testimonials',
                'singular' => 'Testimonial',
                'model' => Testimonial::class,
                'primary' => 'client_name_en',
                'search' => ['client_name_en', 'client_name_ar', 'company', 'quote_en', 'quote_ar'],
                'fields' => [
                    'client_name_en' => 'Client Name EN',
                    'client_name_ar' => 'Client Name AR',
                    'client_title_en' => 'Client Title EN',
                    'client_title_ar' => 'Client Title AR',
                    'company' => 'Company',
                    'quote_en' => ['label' => 'Quote EN', 'type' => 'textarea'],
                    'quote_ar' => ['label' => 'Quote AR', 'type' => 'textarea'],
                    'rating' => ['label' => 'Rating', 'type' => 'number'],
                    'image_path' => ['label' => 'Image', 'type' => 'file'],
                    'is_featured' => ['label' => 'Featured', 'type' => 'checkbox'],
                    'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
                    'order' => ['label' => 'Order', 'type' => 'number'],
                ],
            ],
            'clients' => [
                'title' => 'Clients',
                'singular' => 'Client',
                'model' => Client::class,
                'primary' => 'name',
                'search' => ['name', 'industry_en', 'industry_ar'],
                'fields' => [
                    'name' => 'Name',
                    'logo_path' => ['label' => 'Logo', 'type' => 'file'],
                    'website_url' => 'Website URL',
                    'industry_en' => 'Industry EN',
                    'industry_ar' => 'Industry AR',
                    'is_featured' => ['label' => 'Featured', 'type' => 'checkbox'],
                    'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
                    'order' => ['label' => 'Order', 'type' => 'number'],
                ],
            ],
            'blog' => [
                'title' => 'Blog',
                'singular' => 'Blog Post',
                'model' => BlogPost::class,
                'primary' => 'title_en',
                'search' => ['title_en', 'title_ar', 'excerpt_en', 'excerpt_ar', 'author_name'],
                'fields' => [
                    'slug' => 'Slug',
                    'title_en' => 'Title EN',
                    'title_ar' => 'Title AR',
                    'excerpt_en' => ['label' => 'Excerpt EN', 'type' => 'textarea'],
                    'excerpt_ar' => ['label' => 'Excerpt AR', 'type' => 'textarea'],
                    'body_en' => ['label' => 'Body EN', 'type' => 'textarea'],
                    'body_ar' => ['label' => 'Body AR', 'type' => 'textarea'],
                    'cover_image_path' => ['label' => 'Cover Image', 'type' => 'file'],
                    'author_name' => 'Author',
                    'published_at' => 'Published At',
                    'is_featured' => ['label' => 'Featured', 'type' => 'checkbox'],
                    'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
                    'order' => ['label' => 'Order', 'type' => 'number'],
                ],
            ],
        ];

        abort_unless(isset($modules[$module]), 404);

        return ['module' => $module] + $modules[$module];
    }

    private function localizedContentFields(array $extra = []): array
    {
        return [
            'slug' => 'Slug',
            'title_en' => 'Title EN',
            'title_ar' => 'Title AR',
            'summary_en' => ['label' => 'Summary EN', 'type' => 'textarea'],
            'summary_ar' => ['label' => 'Summary AR', 'type' => 'textarea'],
            'description_en' => ['label' => 'Description EN', 'type' => 'textarea'],
            'description_ar' => ['label' => 'Description AR', 'type' => 'textarea'],
        ] + $extra + [
            'is_featured' => ['label' => 'Featured', 'type' => 'checkbox'],
            'is_active' => ['label' => 'Active', 'type' => 'checkbox', 'default' => true],
            'order' => ['label' => 'Order', 'type' => 'number'],
        ];
    }

    private function fileFields(array $config): array
    {
        return collect($config['fields'])
            ->filter(fn ($field) => is_array($field) && ($field['type'] ?? null) === 'file')
            ->keys()
            ->all();
    }

    private function defaultSectionSettings(string $module, array $config): array
    {
        $order = array_search($module, ['services', 'projects', 'case-studies', 'team', 'testimonials', 'clients', 'blog'], true);

        return [
            'module' => $module,
            'title_en' => $config['title'],
            'title_ar' => $config['title'],
            'description_en' => null,
            'description_ar' => null,
            'is_active' => true,
            'order' => $order === false ? 0 : $order,
            'limit' => 6,
        ];
    }
}
