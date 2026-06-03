<?php

namespace Tests\Feature;

use App\Models\LandingPage;
use App\Models\ProblemSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSectionUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_nested_section_items_are_updated_by_id_without_full_replacement(): void
    {
        $user = User::factory()->create();
        $page = LandingPage::create(['slug' => 'oms', 'name' => 'OMS']);
        $section = ProblemSection::create([
            'landing_page_id' => $page->id,
            'title_en' => 'Old',
            'title_ar' => 'Old AR',
            'description_en' => 'Old description',
            'description_ar' => 'Old description AR',
            'is_active' => true,
        ]);
        $item = $section->items()->create([
            'title_en' => 'Old item',
            'title_ar' => 'Old item AR',
            'description_en' => 'Old item description',
            'description_ar' => 'Old item description AR',
            'order' => 0,
        ]);

        $response = $this->actingAs($user)->put(route('admin.problem.update'), [
            'title_en' => 'Updated',
            'title_ar' => 'Updated AR',
            'description_en' => 'Updated description',
            'description_ar' => 'Updated description AR',
            'items' => [
                [
                    'id' => $item->id,
                    'title_en' => 'Updated item',
                    'title_ar' => 'Updated item AR',
                    'description_en' => 'Updated item description',
                    'description_ar' => 'Updated item description AR',
                ],
            ],
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('problem_items', [
            'id' => $item->id,
            'title_en' => 'Updated item',
        ]);
        $this->assertDatabaseHas('problem_sections', [
            'id' => $section->id,
            'is_active' => false,
        ]);
    }
}
