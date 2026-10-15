@extends('layouts.admin')
@section('title', 'Enquiries')
@section('heading', 'Enquiries')

@section('content')
<div class="card">
    <div class="card-header">
        <form class="d-flex gap-2" method="GET">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Name, email or phone...">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-admin table-hover mb-0">
            <thead><tr><th></th><th>Name</th><th>Contact</th><th>Product</th><th>Message</th><th>Received</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($items as $e)
                <tr class="{{ $e->is_read ? '' : 'table-warning' }}">
                    <td>@unless($e->is_read)<span class="badge text-bg-primary">New</span>@endunless</td>
                    <td><a href="{{ route('admin.enquiries.show', $e) }}">{{ $e->name }}</a></td>
                    <td>{{ $e->phone }}<br><small class="text-secondary">{{ $e->email }}</small></td>
                    <td>{{ $e->product?->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($e->message, 60) }}</td>
                    <td class="text-nowrap">{{ $e->created_at->format('d M Y, h:i A') }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.enquiries.show', $e) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <form class="d-inline" method="POST" action="{{ route('admin.enquiries.destroy', $e) }}" data-confirm="Delete this enquiry?">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">No enquiries yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($items->hasPages())<div class="card-footer bg-white">{{ $items->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
