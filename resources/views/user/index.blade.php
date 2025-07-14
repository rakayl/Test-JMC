@extends('admin.layouts.master')

@push('css')
<style>
    .table-area {
        background: #fff;
        border-radius: 5px;
        padding: 20px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-btn-area {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .search-wrapper {
        position: relative;
        width: 250px;
    }

    .search-wrapper input {
        width: 100%;
        height: 40px;
        padding: 8px 15px 8px 40px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        outline: none;
        font-size: 14px;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        pointer-events: none;
    }

    .btn-add-default {
        height: 40px;
        padding: 0 20px;
        background: #c91b1b;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .btn-add-default:hover {
        background: #a51616;
        color: white;
    }

    .entry-wrapper {
        margin-bottom: 15px;
    }

    .entry-wrapper select {
        width: auto;
        margin: 0 5px;
    }

    .custom-table td, 
    .custom-table th {
        text-align: left !important;
        padding: 12px;
    }
</style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',[
        'breadcrumbs' => [
            [
                'name' => __("Dashboard"),
                'url' => setRoute("home"),
            ]
        ], 
        'active' => __("User")
    ])
@endsection

@section('content')
<div class="table-area">
    <div class="table-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="title mb-0">{{ __("All User") }}</h5>
            <div class="d-flex gap-3 align-items-center">
                <div class="search-wrapper">
                     <select class="form--control select2-auto-tokenize"
                             name="roles" 
                             onchange="handleRole(this.value)">
                                <option value="">Select Role</option>
                                <option value="admin" @if(request('roles') == 'admin') selected @endif >Admin</option>
                                <option value="operator" @if(request('roles')== 'operator') selected @endif>Operator</option>
                        </select>
                </div>
                <div class="search-wrapper">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Search" 
                           value="{{ request('search') }}"
                           oninput="handleSearch(this.value)">
                </div>
                @include('admin.components.link.add-default',[
                    'href' => "#admin-add",
                    'class' => "modal-btn",
                    'text' => __('Add User'),
                    'permission' => "user.store"
                ])
            </div>
        </div>

        <div class="table-responsive">
            <div class="entry-wrapper d-flex align-items-center">
                <form action="{{ Route('user.index') }}" method="GET" class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="search" value="{{ request('roles') }}">
                    Show 
                    <select name="length" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                        <option value="10" {{ request('length') == '10' ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('length') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('length') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('length') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                    entries
                </form>
            </div>
            @include('user.table',compact("data"))
        </div>
        {{ get_paginate($data) }}
    </div>
</div>

{{-- Admin Add Modal --}}
@include('user.add-admin')

{{-- Admin Edit Modal --}}
@include('user.edit-admin')
@endsection

@push('script')
<script>
    var role = '';
    var search='';
function handleSearch(value) {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        const currentUrl = new URL(window.location.href);
        search = value;
        currentUrl.searchParams.set('search', search);
        currentUrl.searchParams.set('roles', role);
        window.location.href = currentUrl.toString();
    }, 500);
}
function handleRole(value) {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        const currentUrl = new URL(window.location.href);
        role = value;
        currentUrl.searchParams.set('roles', role);
        currentUrl.searchParams.set('search', search);
        window.location.href = currentUrl.toString();
    }, 500);
}
$(document).on("click",".delete-modal-button",function() {
    var oldData = $(this).parents("tr").attr("data-item");
    var actionRoute = "{{ setRoute('user.delete') }}";
    var target = oldData;
    var message = `{{ __("anda hendak menghapus ") }} <strong>${target}</strong>, apakah anda yakin ingin melakukannya ?`;
    var title = "ingin menghapus user ini ?"
    openDeleteModal(actionRoute,target,message,"Hapus","DELETE",title);
});

// Switcher
switcherAjax("{{ route('user.status') }}");
</script>
@endpush
