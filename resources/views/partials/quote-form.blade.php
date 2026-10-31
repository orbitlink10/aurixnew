<form class="taf-form" action="{{ route('public.quote.store') }}" method="POST" enctype="multipart/form-data" data-quote-form novalidate>
    @csrf
    <input type="hidden" name="started_at" value="{{ time() }}">
    <input type="text" name="website" value="" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px;">

    @if(session('quote_success'))
        <div class="taf-form-alert success" role="status">{{ session('quote_success') }}</div>
    @endif
    @if(session('quote_error'))
        <div class="taf-form-alert error" role="alert">{{ session('quote_error') }}</div>
    @endif
    @if($errors->any())
        <div class="taf-form-alert error" role="alert">Please review the highlighted fields and try again.</div>
    @endif

    <div class="taf-form-field">
        <label for="qf-name">Full name <span style="color:#dc2626">*</span></label>
        <input id="qf-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
        @error('name')<span class="taf-form-error">{{ $message }}</span>@enderror
    </div>

    <div class="taf-form-field">
        <label for="qf-company">Company name</label>
        <input id="qf-company" type="text" name="company" value="{{ old('company') }}" autocomplete="organization">
    </div>

    <div class="taf-form-field">
        <label for="qf-phone">Phone number <span style="color:#dc2626">*</span></label>
        <input id="qf-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" required>
        @error('phone')<span class="taf-form-error">{{ $message }}</span>@enderror
    </div>

    <div class="taf-form-field">
        <label for="qf-email">Email address</label>
        <input id="qf-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email">
        @error('email')<span class="taf-form-error">{{ $message }}</span>@enderror
    </div>

    <div class="taf-form-field full">
        <label for="qf-product">Product / service</label>
        <input id="qf-product" type="text" name="product" value="{{ old('product', $product ?? '') }}" placeholder="e.g. Embroidered polo shirts">
    </div>

    <div class="taf-form-field">
        <label for="qf-quantity">Quantity</label>
        <input id="qf-quantity" type="text" name="quantity" value="{{ old('quantity') }}" placeholder="e.g. 50 pieces">
    </div>

    <div class="taf-form-field">
        <label for="qf-deadline">Deadline / date required</label>
        <input id="qf-deadline" type="text" name="deadline" value="{{ old('deadline') }}" placeholder="e.g. 2 weeks">
    </div>

    <div class="taf-form-field full">
        <label for="qf-delivery">Delivery location</label>
        <input id="qf-delivery" type="text" name="delivery_location" value="{{ old('delivery_location') }}" placeholder="e.g. Nairobi CBD">
    </div>

    <div class="taf-form-field full">
        <label for="qf-customization">Preferred customization</label>
        <textarea id="qf-customization" name="customization" placeholder="Colours, materials, printing method, finishing, sizes, or any other requirements.">{{ old('customization') }}</textarea>
    </div>

    <div class="taf-form-field full">
        <label for="qf-message">Message / project description</label>
        <textarea id="qf-message" name="message" placeholder="Tell us more about your project.">{{ old('message') }}</textarea>
    </div>

    <div class="taf-form-field full">
        <label for="qf-artwork">Artwork / logo upload <small>(optional — PDF, PNG, JPG, SVG, AI up to 10MB)</small></label>
        <input id="qf-artwork" type="file" name="artwork" accept=".pdf,.png,.jpg,.jpeg,.svg,.ai">
        @error('artwork')<span class="taf-form-error">{{ $message }}</span>@enderror
    </div>

    <button class="taf-form-submit" type="submit">Send Quote Request</button>
</form>
