<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_returns_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->postJson('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => 'CLIENT_ID',
            'client_secret' => 'CLIENT_SECRET',
            'username' => $user->email,
            'password' => '12345678',
            'scope' => '*',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token']);
    }
}
