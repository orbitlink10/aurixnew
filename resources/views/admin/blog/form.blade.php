@extends('layouts.admin')

@section('content')
@php
    $isEditing = isset($post) && $post->exists;
@endphp

<section class="content-header">
    <div class="form-heading">
        <div>
            <h1 class="page-title mb-1">{{ $isEditing ? 'Edit Post' : 'Add New Post' }}</h1>
            <p class="text-muted mb-0">Create SEO-ready posts and pages with rich content.</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>
</section>

<section class="content">
    <div class="post-form-wrap">
        <div class="card post-form-card">
            <div class="post-form-header">
                <h2 class="post-form-title">{{ $isEditing ? 'Update Post' : 'Add New Post' }}</h2>
            </div>

            <div class="post-form-body">
                <form id="blog-post-form" method="POST" action="{{ $isEditing ? route('admin.blog-posts.update', $post) : route('admin.blog-posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($isEditing)
                        @method('PUT')
                    @endif
                    <input type="hidden" name="status" value="{{ old('status', $post->status ?? 'published') }}">

                    <div class="form-group">
                        <label for="seo_title">Meta Title</label>
                        <input type="text" class="form-control" name="seo_title" value="{{ old('seo_title', $post->seo_title ?? '') }}" id="seo_title" placeholder="Enter Meta Title">
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description', $post->meta_description ?? '') }}" id="meta_description" placeholder="Enter Meta Description">
                    </div>

                    <div class="form-group">
                        <label for="title">Page Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $post->title ?? '') }}" id="title" placeholder="Enter Keyword Title" required>
                    </div>

                    <div class="form-group">
                        <label for="image_alt_text">Image Alt Text</label>
                        <input type="text" class="form-control" name="image_alt_text" value="{{ old('image_alt_text', $post->image_alt_text ?? '') }}" id="image_alt_text" placeholder="Enter Image Alt Text">
                    </div>

                    <div class="form-group">
                        <label for="heading">Heading 2</label>
                        <input type="text" class="form-control" name="heading" value="{{ old('heading', $post->heading ?? '') }}" id="heading" placeholder="Enter Heading 2">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="content_type">Type</label>
                            <select class="form-control" name="content_type" id="content_type">
                                @foreach(['Post', 'Page'] as $type)
                                    <option value="{{ $type }}" @selected(old('content_type', $post->content_type ?? 'Post') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id', $post->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="blog-body-editor">Page Description:</label>
                        <textarea id="blog-body-editor" name="body" rows="12" class="form-control editor-field">{{ old('body', $post->body ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="photo">Upload Image (optional, only for Posts)</label>
                        <label class="file-control" for="photo">
                            <span id="file-label">{{ $post->cover_image ?? 'Choose file' }}</span>
                            <input type="file" id="photo" name="photo" accept="image/*">
                        </label>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.pages.index') }}" class="btn-danger-soft">Cancel</a>
                        <button type="submit" class="btn-primary-soft">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .form-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .text-muted {
        color: #64748b;
        font-size: 0.92rem;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        color: #475569;
        background: #ffffff;
        padding: 8px 14px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.86rem;
    }

    .post-form-wrap {
        max-width: 980px;
    }

    .post-form-card {
        border-radius: 12px;
        overflow: hidden;
    }

    .post-form-header {
        background: #2563eb;
        color: #ffffff;
        padding: 14px 18px;
    }

    .post-form-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
    }

    .post-form-body {
        padding: 20px;
        background: #ffffff;
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

    select.form-control[multiple] {
        min-height: 108px;
    }

    .form-help {
        display: block;
        color: #64748b;
        margin-top: 5px;
        font-size: 0.78rem;
    }

    .editor-field {
        border-radius: 8px;
        min-height: 240px;
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

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-danger-soft,
    .btn-primary-soft {
        border: 0;
        border-radius: 6px;
        padding: 10px 16px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-danger-soft {
        background: #dc2626;
        color: #ffffff;
    }

    .btn-primary-soft {
        background: #2563eb;
        color: #ffffff;
    }

    @media (max-width: 700px) {
        .form-heading,
        .form-grid {
            grid-template-columns: 1fr;
            flex-direction: column;
        }

        .back-btn,
        .form-actions a,
        .form-actions button {
            justify-content: center;
            width: 100%;
        }

        .form-actions {
            flex-direction: column-reverse;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#blog-body-editor',
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

    document.getElementById('photo')?.addEventListener('change', function () {
        document.getElementById('file-label').textContent = this.files[0]?.name || 'Choose file';
    });

    document.getElementById('blog-post-form')?.addEventListener('submit', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }
    });
</script>
@endsection
