@extends('layouts/edit-form', [
    'createText' => trans('admin/components/general.create') ,
    'updateText' => trans('admin/components/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.components'),
    'formAction' => (isset($item->id)) ? route('components.update', ['component' => $item->id]) : route('components.store'),
    'container_classes' => 'col-lg-6 col-lg-offset-3 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0',
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
    <x-form-row name="name">
        <x-form-label>{{ trans('general.name') }}</x-form-label>
        <x-form-input>
            <x-input.text
                    required="true"
                    :value="old('name', $item->name)"
            />
        </x-form-input>
    </x-form-row>


    <!-- Category -->
    <x-form-row name="category_id">
        <x-form-label>{{ trans('general.category') }}</x-form-label>
        <x-form-input modal_type="category" modal_id="category_select_id" category_type="component" new_model="\App\Models\Category::class">
            <x-input.select2-ajax
                    id="category_select_id"
                    :data_placeholder="trans('general.select_asset')"
                    :item="old('category_id', $item->category_id)"
                    :new_button="true"
                    :required="Helper::checkIfRequired($item, 'category_id')"
                    :selected="old('category_id', $item->category_id)"
                    data_endpoint="categories/component"
                    item_model="\App\Models\Category"
            />
        </x-form-input>
    </x-form-row>


<!-- QTY -->
<x-form-row name="qty">
    <x-form-label>{{ trans('general.quantity') }}</x-form-label>
    <x-form-input>
        <x-input.text
                type="number"
                :value="old('qty', $item->qty)"
                input_min="1"
                required="true"
        />
    </x-form-input>
</x-form-row>

<!-- Minimum QTY -->
<x-form-row name="min_amt">
    <x-form-label>{{ trans('general.min_amt') }}</x-form-label>
    <x-form-input>
        <x-input.text
                type="number"
                :value="old('min_amt', $item->min_amt)"
                input_min="0"
        />
    </x-form-input>
    <x-form-inline-tooltip>
        {{ trans('general.min_amt_help') }}
    </x-form-inline-tooltip>
</x-form-row>

@include ('partials.forms.edit.serial', ['fieldname' => 'serial'])

    <!-- Manufacturer -->
    <x-form-row name="manufacturer_id">
        <x-form-label>{{ trans('general.manufacturer') }}</x-form-label>
        <x-form-input modal_type="manufacturer" modal_id="manufacturer_select_id" new_model="\App\Models\Manufacturer::class">
            <x-input.select2-ajax
                    id="manufacturer_select_id"
                    :data_placeholder="trans('general.manufacturer')"
                    :item="old('manufacturer_id', $item->manufacturer_id)"
                    :new_button="true"
                    :required="Helper::checkIfRequired($item, 'manufacturer_id')"
                    :selected="old('manufacturer_id', $item->manufacturer_id)"
                    data_endpoint="manufacturers"
                    item_model="\App\Models\Manufacturer"
            />
        </x-form-input>
    </x-form-row>

@include ('partials.forms.edit.model_number')
@include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
@include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
@include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
@include ('partials.forms.edit.order_number')

<!--- Purchase Date -->
<x-form-row name="purchase_date">
    <x-form-label>{{ trans('general.purchase_date') }}</x-form-label>
    <x-form-input>
        <x-input.datepicker :value="old('purchase_date', $item->purchase_date_for_datepicker)" />
    </x-form-input>
</x-form-row>


<!-- Purchase Cost -->
<x-form-row name="purchase_cost">
    <x-form-label>{{ trans('general.unit_cost') }}</x-form-label>
    <x-form-input>
        <x-input.text
                type="number"
                :input_group_text="$snipeSettings->default_currency"
                :value="old('purchase_cost', $item->purchase_cost)"
                input_group_addon="left"
                input_max="99999999999999999.000"
                input_min="0"
                input_min="0.00"
                input_step="0.001"
                maxlength="25"
        />
    </x-form-input>
</x-form-row>

<!-- Notes -->
<x-form-row name="notes">
    <x-form-label>{{ trans('general.notes') }}</x-form-label>
    <x-form-input>
        <x-input.textarea
                :value="old('notes', $item->notes)"
                placeholder="{{ trans('general.placeholders.notes') }}"
        />
    </x-form-input>
</x-form-row>

@include ('partials.forms.edit.image-upload', ['image_path' => app('components_upload_path')])


@stop
