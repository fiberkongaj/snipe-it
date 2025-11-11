@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $group->name }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('groups.edit', ['group' => $group->id]) }}" class="btn btn-primary text-right">{{ trans('admin/groups/titles.update') }} </a>
    <a href="{{ route('groups.index') }}" class="btn btn-default pull-right">{{ trans('general.back') }}</a>
@stop



{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">


                                <table
                                    data-columns="{{  \App\Presenters\UserPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="groupsUsersTable"
                                    data-side-pagination="server"
                                    id="groupsUsersTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{ route('api.users.index',['group_id'=> $group->id]) }}"
                                    data-export-options='{
                                    "fileName": "export-{{ str_slug($group->name) }}-group-users-{{ date('Y-m-d') }}",
                                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                        }'>
                                </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <h3>{{ trans('general.permissions') }}</h3>
            @if (is_array($group->decodePermissions()))

                @foreach ($group->decodePermissions() as $permission_name => $permission)

                    <span class="label label-{{ ($permission == '1') ? 'success' : 'danger' }}" style="margin-left: 5px;">
                        <x-icon type="{{ ($permission == '1') ? 'checkmark' : 'x' }}" class="text-white" />
                        {{ trans('permissions.'.str_slug($permission_name).'.name') }}
                    </span>

                @endforeach

            @else
                <p>{{ trans('admin/groups/titles.no_permissions') }}</p>
            @endif

        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
