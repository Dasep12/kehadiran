@extends('layouts.main')

@section('content')
<!--  BEGIN PAGE HEADER  -->
<!-- <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ $title }}</h2>
            </div>
        </div>
    </div>
</div> -->
<!-- END PAGE HEADER  -->
<!-- BEGIN PAGE BODY  -->
<div class="page-body">
    <div class="container-xl">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-shift-group" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Group Shift</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-shift" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Shift</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-shift-pattern" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Shift Pattern</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-shift-group" role="tabpanel">
                            @include('worktime.partials.shift-settings.grid-shift-group')
                        </div>
                        <div class="tab-pane" id="tabs-shift" role="tabpanel">
                            @include('worktime.partials.shift-settings.grid-shift')
                        </div>
                        <div class="tab-pane" id="tabs-shift-pattern" role="tabpanel">
                            @include('worktime.partials.shift-settings.grid-shift-pattern')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- END PAGE BODY  -->


@include('worktime.partials.crud-attendance-types');
@endsection