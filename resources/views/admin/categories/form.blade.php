@extends('layouts.admin')

@section('content')
@php
    $isEditing = $category->exists;
@endphp

<section class="content-header">
    <h1 class="page-title">{{ $isEditing ? 'Edit Category' : 'Create Category' }}</h1>
</section>

<section class="content">
    <form action="{{ $isEditing ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="card category-form-card">
        @csrf
        @if($isEditing)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name <span class="required">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" placeholder="Enter category name" required>
        </div>

        <div class="form-group">
            <label for="parent_id">Parent Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">None - top level category</option>
                @foreach($parentOptions as $parent)
                    <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
                @endforeach
            </select>
            <p class="field-help">Choose a parent when this should be a subcategory.</p>
        </div>

        <div class="form-group">
            <label for="meta_description">Meta description</label>
            <textarea class="form-control" name="meta_description" id="meta_description" rows="3">{{ old('meta_description', $category->meta_description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="description">Description (Optional)</label>
            <textarea name="description" id="description" rows="5" class="form-control editor-field" placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="photo">Photo (Optional)</label>
            <label class="file-control" for="photo">
                <span id="file-label">{{ $category->image_path ? basename($category->image_path) : 'Choose file' }}</span>
                <input type="file" name="photo" id="photo" accept="image/*">
            </label>
            @if($isEditing && $category->image_url)
                <div class="current-image">
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                </div>
            @endif
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary-soft">Cancel</a>
            <button type="submit" class="btn-primary-soft">{{ $isEditing ? 'Update Category' : 'Create Category' }}</button>
        </div>
    </form>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .category-form-card {
        border-radius: 12px;
        padding: 22px;
        max-width: 980px;
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

    .required {
        color: #dc2626;
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

    .current-image {
        margin-top: 10px;
    }

    .current-image img {
        width: 120px;
        height: 82px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .form-actions {
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

    @media (max-width: 640px) {
        .form-actions {
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
            selector: '#description',
            height: 500,
            license_key: 'gpl',
            plugins: 'image link lists media table code wordcount fullscreen',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen',
            menubar: 'file edit view insert format tools table help',
            branding: false,
            promotion: false,
            automatic_uploads: true,
            image_title: true,
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

    document.getElementById('photo')?.addEventListener('change', function () {
        document.getElementById('file-label').textContent = this.files[0]?.name || 'Choose file';
    });
</script>
@endsection
