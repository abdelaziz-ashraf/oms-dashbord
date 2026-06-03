<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_portfolio_api_returns_only_active_items(): void
    {
        Service::create([
            'slug' => 'active-service',
            'title_en' => 'Active Service',
            'is_active' => true,
            'order' => 2,
        ]);

        Service::create([
            'slug' => 'inactive-service',
            'title_en' => 'Inactive Service',
            'is_active' => false,
            'order' => 1,
        ]);

        $response = $this->getJson('/api/portfolio/services');

        $response->assertOk()
            ->assertJsonCount(1, 'items')
            ->assertJsonPath('module', 'services')
            ->assertJsonPath('items.0.slug', 'active-service');
    }
}
