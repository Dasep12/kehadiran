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

<style>
    .avatar {
        border-radius: 90px !important;
    }
</style>
<div class="page-body">
    <div class="container-xl">
        <div class="col-12">
            <h1>Dashboard</h1>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->
@push('scripts')
<script>

</script>
@endpush


@endsection