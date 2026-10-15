@extends('layouts.admin')
@section('title', 'Site Settings')
@section('heading', 'Site Settings')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @foreach ($groups as $group => $fields)
        <div class="card mb-3">
            <div class="card-header">{{ $group }}</div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($fields as $key => [$label, $type])
                        @php $val = old($key, $values[$key] ?? ''); @endphp
                        <div class="col-md-{{ $type === 'textarea' ? 12 : 6 }}">
                            @if ($type === 'checkbox')
                                <div class="form-check form-switch mt-4">
                                    <input type="checkbox" class="form-check-input" name="{{ $key }}" id="s_{{ $key }}" value="1" @checked($val === '1')>
                                    <label class="form-check-label" for="s_{{ $key }}">{{ $label }}</label>
                                </div>
                            @else
                                <label class="form-label fw-semibold" for="s_{{ $key }}">{{ $label }}</label>
                                @if ($type === 'textarea')
                                    <textarea class="form-control" rows="3" name="{{ $key }}" id="s_{{ $key }}">{{ $val }}</textarea>
                                @elseif ($type === 'image' || $type === 'file')
                                    <input type="file" class="form-control" name="{{ $key }}" id="s_{{ $key }}" @if($type === 'image') accept="image/*" data-preview="#prev_{{ $key }}" @else accept="application/pdf" @endif>
                                    @if ($type === 'image')
                                        <img id="prev_{{ $key }}" class="img-preview mt-2 {{ $val ? '' : 'd-none' }}" src="{{ $val ? asset('storage/'.$val) : '' }}" alt="">
                                    @elseif ($val)
                                        <a href="{{ asset('storage/'.$val) }}" target="_blank" class="small d-block mt-1"><i class="bi bi-file-earmark-pdf"></i> Current file</a>
                                    @endif
                                @else
                                    <input type="text" class="form-control" name="{{ $key }}" id="s_{{ $key }}" value="{{ $val }}">
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
    <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Settings</button>
</form>
@endsection
