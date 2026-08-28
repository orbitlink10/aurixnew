<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    /**
     * Allowed artwork upload extensions and their expected MIME families.
     */
    private const ALLOWED_EXTENSIONS = ['pdf', 'png', 'jpg', 'jpeg', 'svg', 'ai'];

    private const MAX_UPLOAD_KB = 10240;

    public function show(Request $request)
    {
        $contact = Schema::hasTable('site_settings')
            ? SiteSetting::contactSettings()
            : SiteSetting::defaultContactSettings();

        $logoUrl = Schema::hasTable('site_settings')
            ? SiteSetting::logoUrl()
            : null;

        $product = trim((string) $request->query('product', ''));

        return view('quote', compact('contact', 'logoUrl', 'product'));
    }

    public function store(Request $request)
    {
        // Simple honeypot spam protection.
        if ($request->filled('website')) {
            return redirect()->route('public.quote')->with('quote_success', 'Thank you. Your request has been received.');
        }

        // Minimum time-to-submit protection.
        $startedAt = (int) $request->input('started_at', 0);
        if ($startedAt > 0 && (time() - $startedAt) < 3) {
            return redirect()->route('public.quote')->with('quote_success', 'Thank you. Your request has been received.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:160'],
            'product' => ['nullable', 'string', 'max:200'],
            'quantity' => ['nullable', 'string', 'max:80'],
            'customization' => ['nullable', 'string', 'max:2000'],
            'deadline' => ['nullable', 'string', 'max:80'],
            'delivery_location' => ['nullable', 'string', 'max:200'],
            'message' => ['nullable', 'string', 'max:5000'],
            'artwork' => ['nullable', 'file', 'max:'.self::MAX_UPLOAD_KB],
        ], [
            'artwork.max' => 'The artwork file may not be larger than 10MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('artwork')) {
            $file = $request->file('artwork');
            $extension = strtolower($file->getClientOriginalExtension());

            if (! in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
                return back()->withInput()->with('quote_error', 'Artwork must be a PDF, PNG, JPG, SVG, or AI file.');
            }

            $filePath = $this->storeArtwork($file);
        }

        $productName = trim($validated['product'] ?? '');
        $quantity = trim($validated['quantity'] ?? '');

        $description = $this->buildDescription($validated, $productName, $quantity, $filePath);

        if (Schema::hasTable('leads')) {
            $leadData = [
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'],
                'description' => $description,
                'status' => 'new',
            ];

            if (Schema::hasColumn('leads', 'company')) {
                $leadData['company'] = $validated['company'] ?? null;
            }
            if (Schema::hasColumn('leads', 'product_name')) {
                $leadData['product_name'] = $productName ?: null;
            }
            if (Schema::hasColumn('leads', 'quantity')) {
                $leadData['quantity'] = $quantity ?: null;
            }
            if (Schema::hasColumn('leads', 'customization')) {
                $leadData['customization'] = $validated['customization'] ?? null;
            }
            if (Schema::hasColumn('leads', 'deadline')) {
                $leadData['deadline'] = $validated['deadline'] ?? null;
            }
            if (Schema::hasColumn('leads', 'delivery_location')) {
                $leadData['delivery_location'] = $validated['delivery_location'] ?? null;
            }
            if (Schema::hasColumn('leads', 'file_path')) {
                $leadData['file_path'] = $filePath;
            }

            Lead::create($leadData);
        }

        $this->sendNotificationEmail($validated, $description, $filePath);

        return redirect()->route('public.quote')
            ->with('quote_success', 'Thank you, '.$validated['name'].'. Your quote request has been received. Our team will get back to you shortly.');
    }

    private function storeArtwork($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $name = Str::uuid().'.'.$extension;

        return $file->storeAs('quotes', $name, 'uploads');
    }

    private function buildDescription(array $data, string $product, string $quantity, ?string $filePath): string
    {
        $lines = [];

        if ($data['company'] ?? null) {
            $lines[] = 'Company: '.$data['company'];
        }
        if ($product !== '') {
            $lines[] = 'Product/Service: '.$product;
        }
        if ($quantity !== '') {
            $lines[] = 'Quantity: '.$quantity;
        }
        if ($data['customization'] ?? null) {
            $lines[] = 'Customization: '.$data['customization'];
        }
        if ($data['deadline'] ?? null) {
            $lines[] = 'Deadline: '.$data['deadline'];
        }
        if ($data['delivery_location'] ?? null) {
            $lines[] = 'Delivery location: '.$data['delivery_location'];
        }
        if ($data['message'] ?? null) {
            $lines[] = 'Project description: '.$data['message'];
        }
        if ($filePath) {
            $lines[] = 'Artwork: '.$filePath;
        }

        return implode("\n", $lines);
    }

    private function sendNotificationEmail(array $data, string $description, ?string $filePath): void
    {
        $contact = Schema::hasTable('site_settings')
            ? SiteSetting::contactSettings()
            : SiteSetting::defaultContactSettings();

        $to = $contact['email'] ?? 'info@aurixbranding.co.ke';
        $product = trim($data['product'] ?? '') ?: 'General quote request';
        $subject = 'New quote request: '.$product;

        $body = implode("\n", [
            'New Aurix Branding quote request',
            '',
            'Full name: '.$data['name'],
            'Company: '.($data['company'] ?? 'Not provided'),
            'Email: '.($data['email'] ?? 'Not provided'),
            'Phone: '.$data['phone'],
            '',
            $description,
            $filePath ? '' : '',
            $filePath ? 'Artwork uploaded: '.Storage::disk('uploads')->url($filePath) : '',
        ]);

        try {
            Mail::raw($body, function ($message) use ($to, $subject, $data) {
                $message->to($to)->subject($subject);

                if (! empty($data['email'])) {
                    $message->replyTo($data['email'], $data['name']);
                }
            });
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
