@extends('layouts.admin')

@section('content')
@php
    $isEditing = $product->exists;
@endphp

<section class="content-header">
    <div class="product-form-heading">
        <div>
            <h1 class="page-title">{{ $isEditing ? 'Edit Product' : 'Add Product' }}</h1>
            <p class="text-muted">{{ $isEditing ? 'Update product details below' : 'Fill in the product details below to add a new item' }}</p>
        </div>
    </div>
</section>

<section class="content">
    <div class="card product-form-card">
        <div class="product-form-body">
            <form action="{{ $isEditing ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($isEditing)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" id="productName" placeholder="Enter product name" required>
                </div>

                <div class="form-group">
                    <label for="productPrice">Price (KES)</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="price" value="{{ old('price', $product->price) }}" id="productPrice" placeholder="Enter product price">
                </div>

                <div class="form-group">
                    <label for="markedPrice">Marked Price (KES)</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="marked_price" value="{{ old('marked_price', $product->marked_price) }}" id="markedPrice" placeholder="Enter marked price">
                </div>

                <div class="form-group">
                    <label for="productQuantity">Quantity</label>
                    <input type="number" min="0" class="form-control" name="quantity" value="{{ old('quantity', $product->quantity ?? 0) }}" id="productQuantity" placeholder="Enter product quantity">
                </div>

                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select class="form-control" name="product_category_id" id="productCategory">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('product_category_id', $product->product_category_id) == $category->id)>{{ $category->name }}</option>
                            @foreach($category->children as $child)
                                <option value="{{ $child->id }}" @selected(old('product_category_id', $product->product_category_id) == $child->id)>&nbsp;&nbsp;-- {{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    <input type="hidden" name="category_name" value="{{ old('category_name', $product->category_name) }}">
                </div>

                <div class="form-group">
                    <label for="productSubCategory">Subcategory</label>
                    <input type="text" class="form-control" name="subcategory_name" value="{{ old('subcategory_name', $product->subcategory_name) }}" id="productSubCategory" placeholder="Enter subcategory">
                </div>

                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <textarea id="productDescription" name="description" class="form-control editor-field">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-grid">
                    <label class="toggle-row">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                        <span>Active</span>
                    </label>

                    <label class="toggle-row">
                        <input type="checkbox" name="google_merchant" value="1" {{ old('google_merchant', $product->google_merchant ?? false) ? 'checked' : '' }}>
                        <span>Google Merchant</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="productImages">Product Images (optional)</label>
                    <label class="file-control" for="productImages">
                        <span id="file-label">Choose one or more images</span>
                        <input type="file" id="productImages" name="images[]" accept="image/*" multiple>
                    </label>
                    <p class="field-help">The first image is used as the main product image. Additional images appear as clickable thumbnails on the product page.</p>

                    @if($isEditing && ($product->image_path || $product->images->count()))
                        <div class="current-gallery">
                            @if($product->image_path && $product->image_url)
                                <label class="gallery-image-card">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    <span>Main image</span>
                                    <span class="remove-option">
                                        <input type="checkbox" name="remove_primary_image" value="1">
                                        Remove
                                    </span>
                                </label>
                            @endif

                            @foreach($product->images as $image)
                                @if($image->image_url)
                                    <label class="gallery-image-card">
                                        <img src="{{ $image->image_url }}" alt="{{ $product->name }} gallery image">
                                        <span>Gallery image</span>
                                        <span class="remove-option">
                                            <input type="checkbox" name="remove_product_images[]" value="{{ $image->id }}">
                                            Remove
                                        </span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="form-footer">
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary-soft">Cancel</a>
                    <button type="submit" class="btn-primary-soft">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .product-form-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .text-muted {
        color: #64748b;
        font-size: 0.92rem;
        margin: 4px 0 0;
    }

    .product-form-card {
        border-radius: 12px;
        overflow: hidden;
    }

    .product-form-body {
        background: #ffffff;
        padding: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        color: #334155;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .form-control {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        color: #0f172a;
        padding: 10px 12px;
        outline: none;
        transition: border 0.15s ease, box-shadow 0.15s ease;
    }

    .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .field-help {
        color: #64748b;
        font-size: 0.84rem;
        margin: 6px 0 0;
    }

    .editor-field {
        min-height: 260px;
        border-radius: 8px;
    }

    .toggle-row {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        padding: 12px 14px;
        color: #334155;
        font-weight: 600;
    }

    .toggle-row input {
        accent-color: #2563eb;
    }

    .file-control {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        color: #64748b;
        padding: 10px 12px;
        cursor: pointer;
    }

    .file-control::after {
        content: "Browse";
        background: #e2e8f0;
        color: #334155;
        padding: 6px 10px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 0.82rem;
    }

    .file-control input {
        display: none;
    }

    .current-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
        margin-top: 12px;
    }

    .gallery-image-card {
        display: grid;
        gap: 7px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        padding: 10px;
        color: #334155;
        font-size: 0.82rem;
        font-weight: 700;
    }

    .gallery-image-card img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .remove-option {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #be123c;
        font-weight: 700;
    }

    .remove-option input {
        accent-color: #e11d48;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-secondary-soft,
    .btn-primary-soft {
        border: 0;
        border-radius: 6px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-secondary-soft {
        background: #64748b;
        color: #ffffff;
    }

    .btn-primary-soft {
        background: #2563eb;
        color: #ffffff;
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .btn-secondary-soft,
        .btn-primary-soft {
            width: 100%;
            text-align: center;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#productDescription',
            height: 400,
            license_key: 'gpl',
            plugins: 'image advcode link lists media table code wordcount fullscreen',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen',
            menubar: 'file edit view insert format tools table help',
            image_title: true,
            automatic_uploads: true,
            promotion: false,
            branding: false,
            convert_urls: false,
            file_picker_types: 'image',
            file_picker_callback: function (cb) {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    const file = this.files[0];
                    const reader = new FileReader();
                    reader.onload = function () {
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
        });
    }

    document.getElementById('productImages')?.addEventListener('change', function () {
        const files = Array.from(this.files || []);
        document.getElementById('file-label').textContent = files.length
            ? `${files.length} ${files.length === 1 ? 'image' : 'images'} selected`
            : 'Choose one or more images';
    });
</script>
@endsection
