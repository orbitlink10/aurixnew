@extends('layouts.admin')

@section('content')
<section class="content-header">
    <div class="categories-heading">
        <h1 class="page-title">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="category-create-btn">
            <i class="fa-solid fa-plus"></i> Create New Category
        </a>
    </div>
</section>

<section class="content">
    <div class="card category-list-card">
        <div class="table-wrap">
            <table class="categories-table">
                <thead>
                    <tr>
                        <th class="id-cell">ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Photo</th>
                        <th class="products-cell">Products</th>
                        <th class="actions-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="id-cell">{{ $category->id }}</td>
                            <td class="category-name">{{ $category->name }}</td>
                            <td class="category-slug">{{ $category->slug }}</td>
                            <td>
                                @if($category->image_url)
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="category-thumb">
                                @else
                                    <div class="category-thumb category-thumb-empty">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="products-cell">{{ $category->products_count }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.categories.show', $category) }}" class="action-btn action-show">
                                    <i class="fa-solid fa-eye"></i> Show
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn action-edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-delete">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-row">No categories created.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">{{ $categories->links() }}</div>
    </div>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .categories-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .category-create-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
        border-radius: 6px;
        padding: 9px 14px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.16);
    }

    .category-list-card {
        border-radius: 12px;
        overflow: hidden;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .categories-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
        color: #334155;
    }

    .categories-table thead {
        background: #212529;
        color: #ffffff;
    }

    .categories-table th,
    .categories-table td {
        border: 1px solid #e2e8f0;
        padding: 12px 14px;
        text-align: left;
        vertical-align: middle;
    }

    .categories-table tbody tr:hover {
        background: #f8fafc;
    }

    .id-cell {
        width: 70px;
    }

    .products-cell {
        width: 100px;
        text-align: center;
    }

    .category-name {
        color: #0f172a;
        font-weight: 600;
    }

    .category-slug {
        color: #64748b;
    }

    .category-thumb {
        width: 100px;
        height: 68px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .category-thumb-empty {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1.25rem;
    }

    .actions-cell {
        width: 260px;
        white-space: nowrap;
    }

    .inline-form {
        display: inline;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        margin: 2px;
        background: #ffffff;
    }

    .action-show {
        border: 1px solid #38bdf8;
        color: #0284c7;
    }

    .action-edit {
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
        padding: 16px 18px;
        border-top: 1px solid #e2e8f0;
        background: #ffffff;
    }

    @media (max-width: 640px) {
        .categories-heading,
        .category-create-btn {
            align-items: stretch;
            width: 100%;
        }
    }
</style>
@endsection
