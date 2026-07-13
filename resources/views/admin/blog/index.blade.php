@extends('layouts.admin')

@section('content')
<section class="content-header">
    <div class="page-heading">
        <div>
            <h1 class="page-title mb-1">Pages</h1>
            <p class="text-muted mb-0">Manage site pages and published content.</p>
        </div>
    </div>
</section>

<section class="content">
    <div class="card page-list-card">
        <div class="page-card-header">
            <h2 class="page-card-title">Post List</h2>
            <a class="page-add-btn" href="{{ route('admin.new-post') }}">
                <i class="fa-solid fa-plus"></i> Add Page
            </a>
        </div>

        <div class="page-card-body">
            <form action="{{ route('admin.blog-posts.bulk') }}" method="POST" id="bulk-action-form">
                @csrf
                <div class="bulk-actions">
                    <select name="action" class="bulk-select">
                        <option value="">Bulk actions</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="submit" class="bulk-apply">Apply</button>
                </div>

                <div class="table-wrap">
                    <table class="pages-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="number-cell">No.</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Alt Text</th>
                                <th>Type</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="checkbox-cell">
                                        <input type="checkbox" name="ids[]" value="{{ $post->id }}" class="select-item">
                                    </td>
                                    <td class="number-cell">{{ $posts->firstItem() + $loop->index }}</td>
                                    <td>
                                        @if ($post->cover_image)
                                            <img class="post-thumb" src="{{ asset('storage/'.$post->cover_image) }}" alt="{{ $post->image_alt_text ?: $post->title }}">
                                        @else
                                            <div class="post-thumb post-thumb-empty">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="post-title">{{ $post->title }}</div>
                                        <div class="post-slug">{{ $post->slug }}</div>
                                    </td>
                                    <td>{{ $post->image_alt_text ?: 'No alt text' }}</td>
                                    <td>{{ $post->content_type ?: 'Post' }}</td>
                                    <td class="action-cell">
                                        @if($post->status === 'published')
                                            <a href="{{ url('/blog/'.$post->slug) }}" target="_blank" class="action-btn action-preview">
                                                <i class="fa-solid fa-eye"></i> Preview
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.blog-posts.edit', $post) }}" class="action-btn action-update">
                                            <i class="fa-solid fa-pen-to-square"></i> Update
                                        </a>
                                        <button type="button" class="action-btn action-delete" data-delete-target="delete-form-{{ $post->id }}">
                                            <i class="fa-solid fa-trash-can"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-row">No posts yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            @foreach ($posts as $post)
                <form id="delete-form-{{ $post->id }}" action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach

            <div class="pagination-wrap">{{ $posts->links() }}</div>
        </div>
    </div>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .page-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
    }

    .text-muted {
        color: #64748b;
        font-size: 0.92rem;
    }

    .page-list-card {
        overflow: hidden;
        border-radius: 12px;
    }

    .page-card-header {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 18px;
    }

    .page-card-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 600;
        color: #0f172a;
    }

    .page-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 6px;
        background: #ffffff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 7px 12px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
    }

    .page-card-body {
        padding: 18px;
        background: #ffffff;
    }

    .bulk-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
    }

    .bulk-select {
        min-width: 150px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #ffffff;
        color: #334155;
        padding: 7px 10px;
        font-size: 0.86rem;
    }

    .bulk-apply {
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
        border-radius: 6px;
        padding: 7px 12px;
        font-weight: 600;
        font-size: 0.86rem;
    }

    .table-wrap {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }

    .pages-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 920px;
        color: #334155;
    }

    .pages-table thead {
        background: #212529;
        color: #ffffff;
    }

    .pages-table th,
    .pages-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        text-align: left;
    }

    .pages-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .pages-table tbody tr:hover {
        background: #eef2ff;
    }

    .checkbox-cell {
        width: 42px;
        text-align: center;
    }

    .number-cell {
        width: 64px;
    }

    .post-thumb {
        width: 150px;
        height: 86px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .post-thumb-empty {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1.4rem;
    }

    .post-title {
        font-weight: 600;
        color: #0f172a;
    }

    .post-slug {
        color: #94a3b8;
        font-size: 0.78rem;
        margin-top: 3px;
    }

    .action-cell {
        text-align: center;
        white-space: nowrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        margin: 2px;
        background: #ffffff;
    }

    .action-preview {
        border: 1px solid #38bdf8;
        color: #0284c7;
    }

    .action-update {
        border: 1px solid #f59e0b;
        color: #b45309;
    }

    .action-delete {
        border: 1px solid #f43f5e;
        color: #be123c;
    }

    .empty-row {
        color: #64748b;
        text-align: center;
        padding: 28px;
    }

    .pagination-wrap {
        margin-top: 16px;
    }

    @media (max-width: 640px) {
        .page-card-header,
        .page-heading,
        .bulk-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .page-add-btn,
        .bulk-apply {
            justify-content: center;
        }
    }
</style>

<script>
    document.getElementById('select-all')?.addEventListener('change', function () {
        document.querySelectorAll('.select-item').forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });

    document.querySelectorAll('[data-delete-target]').forEach((button) => {
        button.addEventListener('click', () => {
            if (window.confirm('Are you sure you want to delete this page?')) {
                document.getElementById(button.dataset.deleteTarget)?.submit();
            }
        });
    });
</script>
@endsection
