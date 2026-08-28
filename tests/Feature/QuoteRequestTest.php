<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_quote_page_renders_with_product_prefill(): void
    {
        $response = $this->get('/quote?product=Embroidered%20Polo');

        $response->assertOk();
        $response->assertSee('Embroidered Polo');
        $response->assertSee('Product / service');
    }

    public function test_quote_submission_stores_a_lead(): void
    {
        $response = $this->post('/quote', [
            'name' => 'Jane Doe',
            'company' => 'Acme Ltd',
            'phone' => '0700123456',
            'email' => 'jane@example.com',
            'product' => 'Corporate Uniforms',
            'quantity' => '50 pieces',
            'customization' => 'Navy with logo on chest',
            'deadline' => '2 weeks',
            'delivery_location' => 'Nairobi CBD',
            'message' => 'Need uniforms for our team.',
            'started_at' => time() - 5,
        ]);

        $response->assertRedirect(route('public.quote'));
        $response->assertSessionHas('quote_success');

        $this->assertDatabaseHas('leads', [
            'name' => 'Jane Doe',
            'product_name' => 'Corporate Uniforms',
            'status' => 'new',
        ]);
    }

    public function test_quote_submission_uploads_artwork(): void
    {
        Storage::fake('uploads');

        $response = $this->post('/quote', [
            'name' => 'Jane Doe',
            'phone' => '0700123456',
            'product' => 'Signage',
            'started_at' => time() - 5,
            'artwork' => UploadedFile::fake()->create('logo.pdf', 100, 'application/pdf'),
        ]);

        $response->assertRedirect(route('public.quote'));

        $lead = Lead::firstOrFail();
        $this->assertNotNull($lead->file_path);
        Storage::disk('uploads')->assertExists($lead->file_path);
    }

    public function test_quote_rejects_disallowed_artwork_type(): void
    {
        $response = $this->from('/quote')->post('/quote', [
            'name' => 'Jane Doe',
            'phone' => '0700123456',
            'started_at' => time() - 5,
            'artwork' => UploadedFile::fake()->create('malware.exe', 100, 'application/octet-stream'),
        ]);

        $response->assertRedirect('/quote');
        $response->assertSessionHas('quote_error');
    }
}
