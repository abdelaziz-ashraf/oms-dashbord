<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_message_can_be_submitted(): void
    {
        $response = $this->postJson('/api/contact-messages', [
            'full_name' => 'A Client',
            'email' => 'client@example.com',
            'company' => 'Client Co',
            'locale' => 'en',
            'source' => 'landing_contact',
        ]);

        $response->assertCreated()
            ->assertJson(['message' => 'Contact message received']);

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'client@example.com',
            'company' => 'Client Co',
            'status' => 'new',
        ]);
    }
}
