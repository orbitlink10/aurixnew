<form class="quote-form" action="{{ route('public.quote.store') }}" method="POST" enctype="multipart/form-data" data-quote-form novalidate>
    @csrf
    <input type="hidden" name="started_at" value="{{ time() }}">
    <input type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;">

    @if(session('quote_success'))
        <div class="alert alert-success" role="status">{{ session('quote_success') }}</div>
    @endif
    @if(session('quote_error'))
        <div class="alert alert-error" role="alert">{{ session('quote_error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error" role="alert">
            Please review the highlighted fields and try again.
        </div>
    @endif

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <label class="field">
            <span class="field-label">Full name <span class="text-red-600">*</span></span>
            <input class="field-control" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
            @error('name')<span class="field-hint text-red-600">{{ $message }}</span>@enderror
        </label>

        <label class="field">
            <span class="field-label">Company name</span>
            <input class="field-control" type="text" name="company" value="{{ old('company') }}" autocomplete="organization">
        </label>

        <label class="field">
            <span class="field-label">Phone number <span class="text-red-600">*</span></span>
            <input class="field-control" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" required>
            @error('phone')<span class="field-hint text-red-600">{{ $message }}</span>@enderror
        </label>

        <label class="field">
            <span class="field-label">Email address</span>
            <input class="field-control" type="email" name="email" value="{{ old('email') }}" autocomplete="email">
            @error('email')<span class="field-hint text-red-600">{{ $message }}</span>@enderror
        </label>

        <label class="field sm:col-span-2">
            <span class="field-label">Product / service</span>
            <input class="field-control" type="text" name="product" value="{{ old('product', $product ?? '') }}" placeholder="e.g. Embroidered polo shirts">
        </label>

        <label class="field">
            <span class="field-label">Quantity</span>
            <input class="field-control" type="text" name="quantity" value="{{ old('quantity') }}" placeholder="e.g. 50 pieces">
        </label>

        <label class="field">
            <span class="field-label">Deadline / date required</span>
            <input class="field-control" type="text" name="deadline" value="{{ old('deadline') }}" placeholder="e.g. 2 weeks">
        </label>

        <label class="field sm:col-span-2">
            <span class="field-label">Delivery location</span>
            <input class="field-control" type="text" name="delivery_location" value="{{ old('delivery_location') }}" placeholder="e.g. Nairobi CBD">
        </label>

        <label class="field sm:col-span-2">
            <span class="field-label">Preferred customization</span>
            <textarea class="field-control" name="customization" placeholder="Colours, materials, printing method, finishing, sizes, or any other requirements.">{{ old('customization') }}</textarea>
        </label>

        <label class="field sm:col-span-2">
            <span class="field-label">Message / project description</span>
            <textarea class="field-control" name="message" placeholder="Tell us more about your project.">{{ old('message') }}</textarea>
        </label>

        <label class="field sm:col-span-2">
            <span class="field-label">Artwork / logo upload <small>(optional — PDF, PNG, JPG, SVG, AI up to 10MB)</small></span>
            <input class="field-control" type="file" name="artwork" accept=".pdf,.png,.jpg,.jpeg,.svg,.ai">
            @error('artwork')<span class="field-hint text-red-600">{{ $message }}</span>@enderror
        </label>
    </div>

    <button class="btn btn-primary btn-lg mt-7" type="submit">Send Quote Request</button>
</form>
