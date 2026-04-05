@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />

        {{-- Stats Row --}}
        <div class="row g-3 mt-2 mb-4">
            <div class="col-6 col-md-3">
                <div class="border rounded p-3 text-center">
                    <div class="text-muted small text-uppercase fw-semibold">Total Menus</div>
                    <div class="fs-4 fw-semibold">{{ $$module_name->total() }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="border rounded p-3 text-center">
                    <div class="text-muted small text-uppercase fw-semibold">Active</div>
                    <div class="fs-4 fw-semibold text-success">{{ $$module_name->where('is_active', true)->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="border rounded p-3 text-center">
                    <div class="text-muted small text-uppercase fw-semibold">Public</div>
                    <div class="fs-4 fw-semibold text-info">{{ $$module_name->where('is_public', true)->count() }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="border rounded p-3 text-center">
                    <div class="text-muted small text-uppercase fw-semibold">Locations</div>
                    <div class="fs-4 fw-semibold">{{ $$module_name->pluck('location')->unique()->count() }}</div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang("menu::text.name")</th>
                            <th>Location</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>@lang("menu::text.updated_at")</th>
                            <th>@lang("menu::text.created_by")</th>
                            <th class="text-end">@lang("menu::text.action")</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($$module_name as $module_name_singular)
                        <tr>
                            <td>{{ $module_name_singular->id }}</td>
                            <td>
                                <a href="{{ url("admin/$module_name", $module_name_singular->id) }}" class="fw-semibold">
                                    {{ $module_name_singular->name }}
                                </a>
                                <div class="small text-muted font-monospace">{{ $module_name_singular->slug }}</div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $module_name_singular->location }}</span></td>
                            <td>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $module_name_singular->allItems()->count() }}
                                </span>
                            </td>
                            <td>
                                @if($module_name_singular->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning text-dark">Inactive</span>
                                @endif
                                @if($module_name_singular->is_public)
                                    <span class="badge bg-info text-dark">Public</span>
                                @else
                                    <span class="badge bg-secondary">Private</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $module_name_singular->updated_at->diffForHumans() }}</td>
                            <td class="text-muted small">{{ $module_name_singular->created_by }}</td>
                            <td class="text-end">
                                <a href='{!!route("backend.$module_name.show", $module_name_singular)!!}'
                                   class='btn btn-sm btn-success mt-1'
                                   data-bs-toggle="tooltip" title="View & Manage Items">
                                    <i class="fas fa-layer-group"></i> Manage
                                </a>
                                <a href='{!!route("backend.$module_name.edit", $module_name_singular)!!}'
                                   class='btn btn-sm btn-primary mt-1'
                                   data-bs-toggle="tooltip" title="Edit Menu Settings">
                                    <i class="fas fa-wrench"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-start">
                    Total {{ $$module_name->total() }} {{ ucwords($module_name) }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
