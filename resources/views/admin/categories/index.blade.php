@extends('layouts.admin')
@section('title', $meta['title'])
@section('heading', $meta['title'])

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span class="text-secondary small">{{ $tree->count() }} main {{ \Illuminate\Support\Str::plural('category', $tree->count()) }}, {{ $tree->sum(fn ($c) => $c->subs->count()) }} sub-{{ \Illuminate\Support\Str::plural('category', $tree->sum(fn ($c) => $c->subs->count())) }}</span>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add Category</a>
    </div>
    <div class="table-responsive">
        <table class="table table-admin table-hover mb-0 align-middle">
            <thead>
            <tr>
                <th>Image</th><th>Name</th><th>Products</th><th>Order</th><th>Status</th><th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($tree as $c)
                @foreach ([$c, ...$c->subs] as $item)
                    @php $isSub = $item->parent_id !== null; @endphp
                    <tr class="{{ $isSub ? '' : 'table-light' }}">
                        <td>@if ($item->image)<img class="thumb" src="{{ asset('storage/'.$item->image) }}" alt="">@else<span class="text-secondary">—</span>@endif</td>
                        <td class="{{ $isSub ? 'ps-5' : 'fw-semibold' }}">
                            @if ($isSub)<i class="bi bi-arrow-return-right text-secondary me-1"></i>@endif{{ $item->name }}
                        </td>
                        <td>{{ $item->products_count }}</td>
                        <td>{{ $item->sort_order }}</td>
                        <td><span class="badge {{ $item->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->is_active ? 'Yes' : 'No' }}</span></td>
                        <td class="text-end text-nowrap">
                            @unless ($isSub)
                                <a href="{{ route('admin.categories.create', ['parent' => $item->id]) }}" class="btn btn-sm btn-outline-secondary" title="Add sub-category"><i class="bi bi-plus-lg"></i> Sub</a>
                            @endunless
                            <a href="{{ route('admin.categories.edit', $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $item->id) }}" data-confirm="Delete this category?{{ $isSub ? '' : ' Its sub-categories will become main categories.' }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr><td colspan="6" class="text-center text-secondary py-5">Nothing here yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
