@extends('layouts.admin')

@section('content')
<section class="content-header">
    <div class="menu-heading">
        <div>
            <h1 class="page-title">Store Menu</h1>
            <p class="text-muted">Control which product categories appear in the storefront navigation.</p>
        </div>
        <div class="menu-actions">
            <a href="{{ route('admin.categories.create') }}" class="menu-btn menu-btn-primary">
                <i class="fa-solid fa-plus"></i> Add Menu Item
            </a>
            <a href="{{ route('public.products.index') }}" target="_blank" class="menu-btn menu-btn-outline">
                <i class="fa-solid fa-eye"></i> View Products
            </a>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('admin.store-menu.update') }}" method="POST" class="card menu-card">
        @csrf
        <div class="table-wrap">
            <table class="menu-table">
                <thead>
                    <tr>
                        <th>Menu item</th>
                        <th>Parent</th>
                        <th class="center-cell">Visible</th>
                        <th class="sort-cell">Order</th>
                        <th class="center-cell">Products</th>
                        <th class="actions-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="menu-name">
                                <span class="menu-level parent-level">Main</span>
                                {{ $category->name }}
                            </td>
                            <td>Top level</td>
                            <td class="center-cell">
                                <input type="hidden" name="items[{{ $category->id }}][show_in_menu]" value="0">
                                <input type="checkbox" name="items[{{ $category->id }}][show_in_menu]" value="1" @checked($category->show_in_menu ?? true)>
                            </td>
                            <td class="sort-cell">
                                <input type="number" name="items[{{ $category->id }}][menu_sort_order]" value="{{ $category->menu_sort_order ?? 0 }}" min="0" max="9999" class="sort-input">
                            </td>
                            <td class="center-cell">{{ $category->products_count }}</td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn action-edit">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                            </td>
                        </tr>

                        @foreach($category->children as $child)
                            <tr class="menu-child-row">
                                <td class="menu-name">
                                    <span class="menu-level child-level">Sub</span>
                                    {{ $child->name }}
                                </td>
                                <td>{{ $category->name }}</td>
                                <td class="center-cell">
                                    <input type="hidden" name="items[{{ $child->id }}][show_in_menu]" value="0">
                                    <input type="checkbox" name="items[{{ $child->id }}][show_in_menu]" value="1" @checked($child->show_in_menu ?? true)>
                                </td>
                                <td class="sort-cell">
                                    <input type="number" name="items[{{ $child->id }}][menu_sort_order]" value="{{ $child->menu_sort_order ?? 0 }}" min="0" max="9999" class="sort-input">
                                </td>
                                <td class="center-cell">{{ $child->products_count }}</td>
                                <td class="actions-cell">
                                    <a href="{{ route('admin.categories.edit', $child) }}" class="action-btn action-edit">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="empty-row">No product categories created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="menu-footer">
            <a href="{{ route('admin.categories.index') }}" class="menu-btn menu-btn-outline">Manage Categories</a>
            <button type="submit" class="menu-btn menu-btn-primary">Save Menu</button>
        </div>
    </form>
</section>

<style>
    .content-header {
        margin-bottom: 18px;
    }

    .menu-heading {
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

    .menu-actions,
    .menu-footer {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .menu-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 6px;
        padding: 9px 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .menu-btn-primary {
        border: 1px solid #2563eb;
        background: #2563eb;
        color: #ffffff;
    }

    .menu-btn-outline {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
    }

    .menu-card {
        overflow: hidden;
        border-radius: 12px;
    }

    .table-wrap {
        overflow-x: auto;
    }

    .menu-table {
        width: 100%;
        min-width: 880px;
        border-collapse: collapse;
        color: #334155;
    }

    .menu-table thead {
        background: #0f172a;
        color: #ffffff;
    }

    .menu-table th,
    .menu-table td {
        border: 1px solid #e2e8f0;
        padding: 12px 14px;
        text-align: left;
        vertical-align: middle;
    }

    .menu-table tbody tr:hover {
        background: #f8fafc;
    }

    .menu-child-row {
        background: #fbfdff;
    }

    .menu-name {
        color: #0f172a;
        font-weight: 700;
    }

    .menu-level {
        display: inline-flex;
        min-width: 46px;
        justify-content: center;
        margin-right: 10px;
        border-radius: 999px;
        padding: 4px 8px;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .parent-level {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .child-level {
        background: #dcfce7;
        color: #15803d;
    }

    .center-cell {
        text-align: center;
    }

    .sort-cell {
        width: 130px;
    }

    .sort-input {
        width: 86px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 8px 10px;
        text-align: center;
    }

    .actions-cell {
        width: 120px;
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
        background: #ffffff;
    }

    .action-edit {
        border: 1px solid #2563eb;
        color: #1d4ed8;
    }

    .empty-row {
        color: #64748b;
        text-align: center;
        padding: 28px;
    }

    .menu-footer {
        justify-content: flex-end;
        border-top: 1px solid #e2e8f0;
        background: #ffffff;
        padding: 16px 18px;
    }

    @media (max-width: 640px) {
        .menu-actions,
        .menu-footer,
        .menu-btn {
            align-items: stretch;
            width: 100%;
        }
    }
</style>
@endsection
