<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_upload_file()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Passport::actingAs($user);

        $file = UploadedFile::fake()->create('arquivo.csv', 100, 'text/csv');

        $response = $this->postJson('/api/uploads', [
            'file' => $file,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'message',
                'file_name',
                'uuid',
                'status',
            ]
        ]);

        $this->assertTrue(Storage::disk('local')->exists('uploads/' . $file->getClientOriginalName()));
    }

    public function test_cannot_upload_duplicate_file()
    {
        Storage::fake('local');

        $user = User::factory()->create();
        Passport::actingAs($user);

        $file = UploadedFile::fake()->create('arquivo.csv', 100, 'text/csv');

        $response1 = $this->postJson('/api/uploads', [
            'file' => $file,
        ]);
        $response1->assertStatus(200);

        $response2 = $this->postJson('/api/uploads', [
            'file' => $file,
        ]);
        $response2->assertStatus(422);

        $response2->assertJson([
            'error' => 'Arquivo já enviado.'
        ]);
    }
}
