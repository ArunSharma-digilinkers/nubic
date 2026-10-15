@extends('layouts.admin')
@php $editing = $item->exists; @endphp
@section('title', ($editing ? 'Edit ' : 'Add ').$meta['singular'])
@section('heading', ($editing ? 'Edit ' : 'Add ').$meta['singular'])

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $editing ? route("admin.{$meta['route']}.update", $item->id) : route("admin.{$meta['route']}.store") }}">
    @csrf
    @if ($editing) @method('PUT') @endif

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                @foreach ($fields as $f)
                    @php
                        $name = $f['name'];
                        $value = old($name, $item->{$name} ?? ($editing ? null : ($f['default'] ?? ($f['type'] === 'checkbox' ? true : null))));
                    @endphp
                    <div class="col-md-{{ $f['col'] ?? 12 }}">
                        @if ($f['type'] === 'checkbox')
                            <div class="form-check form-switch mt-md-4">
                                <input type="checkbox" class="form-check-input" id="f_{{ $name }}" name="{{ $name }}" value="1" @checked($value)>
                                <label class="form-check-label" for="f_{{ $name }}">{{ $f['label'] }}</label>
                            </div>
                        @else
                            <label class="form-label fw-semibold" for="f_{{ $name }}">{{ $f['label'] }}</label>
                            @switch($f['type'])
                                @case('textarea')
                                    <textarea id="f_{{ $name }}" name="{{ $name }}" rows="4" class="form-control @error($name) is-invalid @enderror">{{ $value }}</textarea>
                                    @break
                                @case('editor')
                                    <textarea id="f_{{ $name }}" name="{{ $name }}" class="js-editor">{{ $value }}</textarea>
                                    @break
                                @case('select')
                                    <select id="f_{{ $name }}" name="{{ $name }}" class="form-select @error($name) is-invalid @enderror">
                                        <option value="">— Select —</option>
                                        @foreach ($f['options'] as $k => $label)
                                            <option value="{{ $k }}" @selected((string) $value === (string) $k)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @break
                                @case('image')
                                    <input type="file" id="f_{{ $name }}" name="{{ $name }}" accept="image/*" class="form-control" data-preview="#prev_{{ $name }}">
                                    <div class="mt-2">
                                        <img id="prev_{{ $name }}" class="img-preview {{ $value ? '' : 'd-none' }}" src="{{ $value ? asset('storage/'.$value) : '' }}" alt="">
                                    </div>
                                    @if ($value)
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="remove_{{ $name }}" value="1" id="rm_{{ $name }}">
                                            <label class="form-check-label small" for="rm_{{ $name }}">Remove current image</label>
                                        </div>
                                    @endif
                                    @break
                                @default
                                    <input type="{{ $f['type'] === 'number' ? 'number' : 'text' }}" id="f_{{ $name }}" name="{{ $name }}" value="{{ $value }}" class="form-control @error($name) is-invalid @enderror">
                            @endswitch
                            @error($name)<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @isset($extra) @include($extra, ['item' => $item]) @endisset

    <div class="d-flex gap-2">
        <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save</button>
        <a href="{{ route("admin.{$meta['route']}.index") }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection
