@extends('layouts.admin')
@section('title', $meta['title'])
@section('heading', $meta['title'])

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <form class="d-flex gap-2" method="GET">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search...">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route("admin.{$meta['route']}.create") }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add {{ $meta['singular'] }}</a>
    </div>
    <div class="table-responsive">
        <table class="table table-admin table-hover mb-0">
            <thead>
            <tr>
                <th>#</th>
                @foreach ($columns as $c)<th>{{ $c['label'] }}</th>@endforeach
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    @foreach ($columns as $c)
                        @php $val = data_get($item, $c['name']); @endphp
                        <td>
                            @switch($c['type'] ?? 'text')
                                @case('image')
                                    @if ($val)<img class="thumb" src="{{ asset('storage/'.$val) }}" alt="">@else<span class="text-secondary">—</span>@endif
                                    @break
                                @case('status')
                                    <span class="badge {{ $val ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $val ? 'Yes' : 'No' }}</span>
                                    @break
                                @case('slug')
                                    <code>/page/{{ $val }}</code>
                                    @break
                                @default
                                    {{ $val }}
                            @endswitch
                        </td>
                    @endforeach
                    <td class="text-end text-nowrap">
                        <a href="{{ route("admin.{$meta['route']}.edit", $item->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form class="d-inline" method="POST" action="{{ route("admin.{$meta['route']}.destroy", $item->id) }}" data-confirm="Delete this {{ strtolower($meta['singular']) }}?">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($columns) + 2 }}" class="text-center text-secondary py-5">Nothing here yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($items->hasPages())<div class="card-footer bg-white">{{ $items->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
