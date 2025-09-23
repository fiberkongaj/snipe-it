@extends('layouts/edit-form', [
    'createText' => trans('admin/components/general.create') ,
    'updateText' => trans('admin/components/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.components'),
    'formAction' => (isset($item->id)) ? route('components.update', ['component' => $item->id]) : route('components.store'),
    'index_route' => 'components.index',
    'options' => [
                'back' => trans('admin/hardware/form.redirect_to_type',['type' => trans('general.previous_page')]),
                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'components']),
                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.component')]),
               ]

])

{{-- Page content --}}
@section('inputFields')

    <!-- Name -->
    <x-form-row
            :label="trans('general.name')"
            :$item
            :$errors
            name="name"
    />

@include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'category_id','category_type' => 'component'])
    <!-- QTY -->
    <x-form-row
            :label="trans('general.quantity')"
            :$item
            :$errors
            name="qty"
            input_div_class="col-md-2"
            minlength="1"
            maxlength="5"
            type="number"
    />


    <!-- Min Amount -->
    <x-form-row
            :label="trans('general.min_amt')"
            :$item
            :$errors
            name="min_amt"
            input_div_class="col-md-2"
            minlength="1"
            maxlength="5"
            type="number"
            :info_tooltip_text="trans('general.min_amt_help')"
    />

    <x-form-row
            :label="trans('admin/hardware/form.serial')"
            :$item
            :$errors
            name="serial"
            type="text"
    />

    @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])

    <!-- Model Number -->
    <x-form-row
            :label="trans('general.model_no')"
            :$item
            :$errors
            name="model_number"
            input_div_class="col-md-5 col-sm-12"
    />

@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

    <!-- Order number -->
    <x-form-row
            :label="trans('general.order_number')"
            :$item
            :$errors
            name="order_number"
            input_div_class="col-md-5 col-sm-12"
    />

    <!-- Purchase date -->
    <x-form-row
            :label="trans('general.purchase_date')"
            :$item
            :$errors
            name="purchase_date"
            type="date"
            input_div_class="col-md-4 col-sm-12"
            :value="old('purchase_date', (($item->purchase_date && $item->purchase_date->format('Y-m-d')) ?? ''))"
    />

    <!-- Purchase cost -->
    <x-form-row
            :label="trans('general.unit_cost')"
            :$item
            :$errors
            name="purchase_cost"
            type="number"
            maxlength="25"
            min="0.00"
            max="99999999999999999.000"
            step="0.001"
            input_div_class="col-md-4 col-sm-12"
    />

    <!-- Notes -->
    <x-form-row
            :label="trans('general.notes')"
            :$item
            :$errors
            name="notes"
            type="textarea"
            maxlength="65000"
            placeholder="{{ trans('general.placeholders.notes') }}"
    />
@include ('partials.forms.edit.image-upload', ['image_path' => app('components_upload_path')])


@stop
