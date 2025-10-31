@extends('layouts/default')

{{-- Page title --}}
@section('title')
  @if ($item->id)
    {{ trans('admin/maintenances/form.update') }}
  @else
    {{ trans('admin/maintenances/form.create') }}
  @endif
  @parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">


  <!-- Inititate form component -->
  <x-form :$item update_route="maintenances.update" create_route="maintenances.store">

      <!-- Start box component -->
      <x-box :$item header_icon="maintenances">

        <!-- This is an existing maintenance -->
        @if ($item->id)

          @if ($item->asset)
              <x-form-row name="asset">
                  <x-form-label>{{ trans('general.asset') }}</x-form-label>
                  <x-form-input>
                      <x-input.static>
                            {{ $item->asset->display_name }}
                      </x-input.static>
                  </x-form-input>
              </x-form-row>

              @if ($item->asset->company)
                  <x-form-row name="company">
                      <x-form-label>{{ trans('general.company') }}</x-form-label>
                      <x-form-input>
                          <x-input.static>
                              {{ $item->asset->company->display_name }}
                          </x-input.static>
                      </x-form-input>
                  </x-form-row>

              @endif

              @if ($item->asset->location)
                  <x-form-row name="location">
                      <x-form-label>
                          {{ trans('general.location') }}
                      </x-form-label>
                      <x-form-input>
                          <x-input.static>
                              {{ $item->asset->location->display_name }}
                          </x-input.static>
                      </x-form-input>
                  </x-form-row>
              @endif

          @endif

        @endif

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

         @if (!$item->id)
          <!-- Assets (multiple select for new maintenance) -->
          <x-form-row name="selected_assets[]">
                  <x-form-label>{{ trans('general.assets') }}</x-form-label>
                  <x-form-input>
                      <x-input.select2-ajax
                          :item="$item->id ? $item->asset()->pluck('id')->toArray() : old('selected_assets')"
                          item_model="\App\Models\Asset"
                          :required="Helper::checkIfRequired($item, 'asset_id')"
                          multiple="true"
                          data_endpoint="hardware"
                          :selected="old('selected_assets[]', request('asset_id'))"
                          :data_placeholder="trans('general.select_asset')"
                      />
                  </x-form-input>
          </x-form-row>
         @endif

        <!-- Maintenance Type -->
          <x-form-row name="asset_maintenance_type">
              <x-form-label>{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</x-form-label>
              <x-form-input>
                  <x-input.select
                      :options="$maintenanceType"
                      :selected="old('asset_maintenance_type', $item->asset_maintenance_type)"
                      :required="Helper::checkIfRequired($item, 'asset_maintenance_type')"
                      data-placeholder="{{ trans('admin/maintenances/form.select_type')}}"
                      includeEmpty="true"
                      style="width:100%;"
                  />
              </x-form-input>
          </x-form-row>


        <!--- Start Date -->
          <x-form-row name="start_date">
                  <x-form-label>{{ trans('admin/maintenances/form.start_date') }}</x-form-label>
                  <x-form-input class="col-md-5">
                      <x-input.datepicker :value="old('start_date', $item->start_date)" required="true" />
                  </x-form-input>
          </x-form-row>


        <!--- Completion Date -->
          <x-form-row name="completion_date">
                  <x-form-label>{{ trans('admin/maintenances/form.completion_date') }}</x-form-label>
                  <x-form-input class="col-md-5">
                      <x-input.datepicker :value="old('completion_date', $item->completion_date)"
                      />
                  </x-form-input>
          </x-form-row>

          <!-- Cost -->
          <x-form-row name="cost">
              <x-form-label>{{ trans('admin/maintenances/form.cost') }}</x-form-label>
              <x-form-input class="col-md-5">
                  <x-input.text
                          type="number"
                          :input_group_text="$snipeSettings->default_currency"
                          :value="old('cost', $item->cost)"
                          input_group_addon="left"
                          input_max="99999999999999999.000"
                          input_min="0"
                          input_min="0.00"
                          input_step="0.001"
                          maxlength="25"
                  />
              </x-form-input>
          </x-form-row>


        <!-- URL -->
          <x-form-row name="url">
              <x-form-label>{{ trans('general.url') }}</x-form-label>
              <x-form-input>
                  <x-input.text
                          name="url"
                          type="url"
                          :value="old('url', $item->url)"
                          input_icon="link"
                          input_group_addon="left"
                          placeholder="https://example.com"
                  />
              </x-form-input>
          </x-form-row>

        <!-- Supplier -->
          <x-form-row name="supplier_id">

                  <x-form-label>{{ trans('general.supplier') }}</x-form-label>

                  <x-form-input>
                      <x-input.select2-ajax
                              item="$item->supplier"
                              item_model="\App\Models\Supplier"
                              name="supplier_id"
                              :selected="old('supplier_id', $item->supplier_id)"
                              data_endpoint="suppliers"
                              :data_placeholder="trans('general.select_supplier')"
                      />
                  </x-form-input>
          </x-form-row>

        <!-- Warranty? -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
              <label class="form-control">
                <input type="checkbox" value="1" name="is_warranty" id="is_warranty" @checked(old('is_warranty', $item->is_warranty))>
                {{ trans('admin/maintenances/form.is_warranty') }}
              </label>
          </div>
        </div>


        @include ('partials.forms.edit.image-upload', ['image_path' => app('maintenances_path')])

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



        <!-- End box component -->
  </x-box>
    <!-- Start form component -->
</x-form>

</div>
@stop
