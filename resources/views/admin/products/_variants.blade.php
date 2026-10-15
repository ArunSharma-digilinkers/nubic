@php
    $rows = old('variants', $item->exists ? $item->variants->toArray() : []);
@endphp
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        Variants / SKUs <small class="text-secondary fw-normal">Code, rating, execution, packing and M.R.P. as in the catalogue</small>
        <button type="button" class="btn btn-sm btn-outline-primary" id="add-variant"><i class="bi bi-plus-lg"></i> Add Row</button>
    </div>
    <div class="table-responsive">
        <table class="table variants-table mb-0">
            <thead>
            <tr><th>Code</th><th>Rating</th><th>Execution / Spec</th><th>Packing Pc.</th><th>M.R.P.</th><th>M.R.P. with Enclosure</th><th></th></tr>
            </thead>
            <tbody id="variants-body">
            @foreach ($rows as $i => $r)
                <tr>
                    @foreach (['code', 'rating', 'spec', 'packing', 'mrp', 'mrp_enclosure'] as $col)
                        <td><input class="form-control form-control-sm" name="variants[{{ $i }}][{{ $col }}]" value="{{ $r[$col] ?? '' }}"></td>
                    @endforeach
                    <td><button type="button" class="btn btn-sm btn-outline-danger remove-variant"><i class="bi bi-x-lg"></i></button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<template id="variant-row-tpl">
    <tr>
        @foreach (['code', 'rating', 'spec', 'packing', 'mrp', 'mrp_enclosure'] as $col)
            <td><input class="form-control form-control-sm" name="variants[__i__][{{ $col }}]"></td>
        @endforeach
        <td><button type="button" class="btn btn-sm btn-outline-danger remove-variant"><i class="bi bi-x-lg"></i></button></td>
    </tr>
</template>
