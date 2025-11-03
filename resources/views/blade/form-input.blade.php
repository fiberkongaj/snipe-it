@aware(['name'])

@props([
    'class' => null,
    'new_model' => false,
    'category_type' => null,
    'modal_type' => false,
    'modal_id' => false,
])

<?php

// Let's set some sane defaults here for smaller fields
// This uses the form name to determine the appropriate class
switch ($name) {
    case 'qty':
    case 'min_amt':
    case 'seats':
        $class_override = $new_model ? 'col-md-3' : 'col-md-4';
        break;
    case 'purchase_cost':
    case 'purchase_date':
    case 'termination_date':
    case 'expiration_date':
    case 'start_date':
    case 'end_date':
    $class_override = $new_model ? 'col-md-4' : 'col-md-5';
        break;
    case 'model_number':
    case 'item_no':
    case 'order_number':
    case 'purchase_order':
    $class_override = $new_model ? 'col-md-5' : 'col-md-6';
            break;
    default:
        $class_override = $new_model ? 'col-md-7' : 'col-md-8';
        break;
}

// Use the explicit override if one is set
if ($class) {
    $class_override = $class;
}
?>
<!-- form-input blade component -->
<div {{ $attributes->merge(['class' => $class_override]) }}>
    {{ $slot }}
</div>

@if ($new_model)
<div class="col-md-1 col-sm-1">
    @can('create', $new_model)
        <a href='{{ route('modal.show',[
            'type' => $modal_type ?? null,
            'category_type' => $category_type ?? null
            ]) }}' data-toggle="modal"  data-target="#createModal" data-select="{{ $modal_id }}" class="btn btn-sm btn-primary text-left">{{ trans('button.new') }}</a>
    @endcan
</div>
@endif


@error($name)
<div class="col-md-8 col-md-offset-3">
        <span class="alert-msg" aria-hidden="true">
            <x-icon type="x" />
            {{ $message }}
        </span>
</div>


@enderror
