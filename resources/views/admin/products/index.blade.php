@extends('layouts.admin')

@section('content')
<section class="content-header">
    <div class="products-heading">
        <div>
            <h1 class="page-title">Products</h1>
            <p class="text-muted">Manage and view all products available in the system</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="add-product-btn">
            <i class="fa-solid fa-plus"></i> Add Product
        </a>
    </div>
</section>

<section class="content">
    <div class="card product-list-card">
        <div class="product-card-header">
            <h2 class="product-card-title">Product List</h2>
            <form action="{{ route('admin.products.index') }}" method="GET" class="product-search">
                <input type="text" name="query" class="search-input" placeholder="Search by product name..." value="{{ request('query') }}">
                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-search"></i> Search
                </button>
            </form>
        </div>

        <div class="product-card-body">
            <div class="table-wrap">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th class="number-cell">#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Price (KES)</th>
                            <th>Google Merchant</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="number-cell">{{ $products->firstItem() + $loop->index }}</td>
                                <td>
                                    @if($product->image_url)
                                        <img class="product-thumb" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="product-thumb product-thumb-empty">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="product-name">{{ $product->name }}</td>
                                <td class="product-slug">{{ $product->slug }}</td>
                                <td>
                                    <div>KES {{ number_format((float) $product->price, 2) }}</div>
                                    @if((float) $product->price > 0)
                                        <small class="price-note">has price</small>
                                    @endif
                                </td>
                                <td>{{ $product->google_merchant ? 'Yes' : 'No' }}</td>
                                <td>{{ $product->category_name ?: 'Unassigned' }}</td>
                                <td class="action-cell">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="action-btn action-update">
                                        <i class="fa-solid fa-pen-to-square"></i> Update
                                    </a>
                                    <button type="button" class="action-btn action-delete" data-delete-target="delete-product-{{ $product->id }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-row">No products created.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @foreach ($products as $product)
                <form id="delete-product-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach

            <div class="pagination-wrap">{{ $products->links() }}</div>
        </div>
    </div>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .products-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .text-muted {
        color: #64748b;
        font-size: 0.92rem;
        margin: 4px 0 0;
    }

    .add-product-btn,
    .search-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
        border-radius: 6px;
        padding: 9px 14px;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.88rem;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.16);
    }

    .product-list-card {
        border-radius: 12px;
        overflow: hidden;
    }

    .product-card-header {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        padding: 14px 18px;
    }

    .product-card-title {
        margin: 0;
        color: #0f172a;
        font-size: 1.08rem;
        font-weight: 700;
    }

    .product-search {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .search-input {
        min-width: 260px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        color: #0f172a;
        padding: 9px 11px;
        outline: none;
    }

    .search-input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .product-card-body {
        background: #ffffff;
        padding: 0;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .products-table {
        width: 100%;
        min-width: 1040px;
        border-collapse: collapse;
        color: #334155;
        font-size: 0.9rem;
    }

    .products-table thead {
        background: #f8fafc;
        color: #334155;
    }

    .products-table th,
    .products-table td {
        padding: 12px 14px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        text-align: left;
    }

    .products-table tbody tr:hover {
        background: #f8fafc;
    }

    .number-cell {
        width: 52px;
    }

    .product-thumb {
        width: 150px;
        height: 86px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .product-thumb-empty {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1.35rem;
    }

    .product-name {
        color: #0f172a;
        font-weight: 600;
    }

    .product-slug {
        color: #64748b;
    }

    .price-note {
        display: inline-block;
        color: #64748b;
        margin-top: 2px;
    }

    .action-cell {
        white-space: nowrap;
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

    .action-update {
        border: 1px solid #2563eb;
        color: #1d4ed8;
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
    }

    @media (max-width: 700px) {
        .products-heading,
        .product-card-header,
        .product-search {
            flex-direction: column;
            align-items: stretch;
        }

        .search-input,
        .add-product-btn,
        .search-btn {
            width: 100%;
        }
    }
</style>

<script>
    document.querySelectorAll('[data-delete-target]').forEach((button) => {
        button.addEventListener('click', () => {
            if (window.confirm('Are you sure you want to delete this product?')) {
                document.getElementById(button.dataset.deleteTarget)?.submit();
            }
        });
    });
</script>
@endsection
