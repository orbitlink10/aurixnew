@extends('layouts.admin')

@section('content')
<section class="content-header">
    <div class="category-show-heading">
        <div>
            <h1 class="page-title">{{ $category->name }}</h1>
            <p class="text-muted">{{ $category->slug }}</p>
        </div>
        <div class="heading-actions">
            <a href="{{ route('admin.categories.edit', $category) }}" class="action-link action-edit">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.categories.index') }}" class="action-link action-back">Back</a>
        </div>
    </div>
</section>

<section class="category-show-grid">
    <div class="card category-media">
        @if($category->image_url)
            <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
        @else
            <div class="empty-media">No category photo</div>
        @endif
    </div>

    <div class="card category-summary">
        <h2>Category Details</h2>
        <dl>
            <div>
                <dt>ID</dt>
                <dd>{{ $category->id }}</dd>
            </div>
            <div>
                <dt>Parent</dt>
                <dd>{{ $category->parent?->name ?: 'Top level' }}</dd>
            </div>
            <div>
                <dt>Subcategories</dt>
                <dd>{{ $category->children()->count() }}</dd>
            </div>
            <div>
                <dt>Products</dt>
                <dd>{{ $category->products_count ?? $category->products()->count() }}</dd>
            </div>
            <div>
                <dt>Meta Description</dt>
                <dd>{{ $category->meta_description ?: 'Not set' }}</dd>
            </div>
        </dl>
    </div>

    <div class="card category-description">
        <h2>Description</h2>
        @if($category->description)
            {!! $category->description !!}
        @else
            <p class="text-muted">No description added.</p>
        @endif
    </div>

    <div class="card linked-products">
        <h2>Products</h2>
        @if($category->children()->count())
            <div class="subcategory-list">
                @foreach($category->children as $child)
                    <a href="{{ route('admin.categories.show', $child) }}">{{ $child->name }}</a>
                @endforeach
            </div>
        @endif
        <div class="product-list">
            @forelse($products as $product)
                <a href="{{ route('admin.products.edit', $product) }}" class="product-row">
                    <span>{{ $product->name }}</span>
                    <strong>KES {{ number_format((float) $product->price, 2) }}</strong>
                </a>
            @empty
                <p class="text-muted">No products linked to this category.</p>
            @endforelse
        </div>
        <div class="pagination-wrap">{{ $products->links() }}</div>
    </div>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .category-show-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .text-muted {
        color: #64748b;
        margin: 4px 0 0;
    }

    .heading-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 6px;
        padding: 8px 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .action-edit {
        border: 1px solid #f59e0b;
        color: #b45309;
        background: #ffffff;
    }

    .action-back {
        border: 1px solid #cbd5e1;
        color: #475569;
        background: #ffffff;
    }

    .category-show-grid {
        display: grid;
        grid-template-columns: minmax(0, 0.8fr) minmax(320px, 1fr);
        gap: 18px;
    }

    .category-media,
    .category-summary,
    .category-description,
    .linked-products {
        padding: 20px;
        border-radius: 12px;
    }

    .category-media {
        display: grid;
        place-items: center;
        min-height: 260px;
    }

    .category-media img {
        width: 100%;
        max-height: 360px;
        object-fit: contain;
        border-radius: 10px;
    }

    .empty-media {
        width: 100%;
        min-height: 220px;
        display: grid;
        place-items: center;
        color: #94a3b8;
        background: #f8fafc;
        border-radius: 10px;
        font-weight: 600;
    }

    .category-summary h2,
    .category-description h2,
    .linked-products h2 {
        margin: 0 0 14px;
        color: #0f172a;
        font-size: 1.1rem;
        font-weight: 700;
    }

    dl {
        display: grid;
        gap: 12px;
        margin: 0;
    }

    dl div {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px dashed #e2e8f0;
        padding-bottom: 10px;
    }

    dt {
        color: #64748b;
        font-weight: 600;
    }

    dd {
        margin: 0;
        color: #0f172a;
        font-weight: 600;
        text-align: right;
    }

    .category-description,
    .linked-products {
        grid-column: 1 / -1;
    }

    .category-description {
        color: #334155;
        line-height: 1.7;
    }

    .product-list {
        display: grid;
        gap: 8px;
    }

    .subcategory-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
    }

    .subcategory-list a {
        border: 1px solid #dbe3ef;
        border-radius: 999px;
        color: #2563eb;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 6px 10px;
        text-decoration: none;
    }

    .product-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 14px;
        color: #0f172a;
        text-decoration: none;
    }

    .product-row:hover {
        background: #f8fafc;
    }

    .pagination-wrap {
        margin-top: 14px;
    }

    @media (max-width: 860px) {
        .category-show-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
