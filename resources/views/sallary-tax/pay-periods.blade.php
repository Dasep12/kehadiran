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
                    <div class="row w-full">
                        <div class="col">
                            <h3 class="card-title mb-0">Employee</h3>
                            <p class="text-secondary m-0">Table description.</p>
                        </div>
                        <div class="col-md-auto col-sm-12">
                            <div class="ms-auto d-flex flex-wrap btn-list">
                                <div class="input-group input-group-flat w-auto">
                                    <span class="input-group-text">
                                        <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </span>
                                    <input placeholder="Search Here..." id="search-input" type="text" class="form-control" autocomplete="off">
                                </div>
                                <button type="button" onclick="reloadTable()" class="btn btn-icon" aria-label="Button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pointer-search">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14.778 12.222l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093" />
                                        <path d="M15 18a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M20.2 20.2l1.8 1.8" />
                                    </svg>
                                </button>
                                <div class="dropdown">
                                    <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Export</a>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="#">CSV</a>
                                        <a class="dropdown-item" href="#">PDF</a>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="Crud('create','*')" data-bs-target="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"> Create </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Your allowances content here -->
                    <div id="pay-periods-master"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->
@push('scripts')
<script>
    var table = new Tabulator("#pay-periods-master", {
        ajaxURL: "{{ route('sallaryTax.getPayPeriodsData') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 layout fix (penting)
        // layout: "fitData",
        layout: "fitColumns",
        responsiveLayout: false, // disable hide/collapse → pakai scroll
        height: "450px",
        // 🔥 pagination
        pagination: "local",
        paginationSize: 10,
        paginationSizeSelector: [10, 25, 50, 100],

        // 🔥 ajax param (filter support)
        ajaxParams: {
            search: "",
        },
        index: "period_id", // pastikan ini sesuai dengan primary key dari data Laravel
        columns: [{
                title: "ID",
                field: "period_id",
                width: 150
            },
            {
                title: "Pay Period ",
                field: "period_name",
            },

            {
                title: "Start Date",
                field: "start_date",
                formatter: "date",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                    outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            },
            {
                title: "End Date",
                field: "end_date",
                formatter: "date",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                    outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            },
            {
                title: "Pay Date",
                field: "pay_date",
                formatter: "date",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                    outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            }, {
                title: "Closed",
                field: "is_closed",
                formatter: "tickCross",
                hozAlign: "center"
            }, {
                title: "Created At",
                field: "created_at",
                formatter: "datetime",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd HH:mm:ss", // sesuai format dari Laravel
                    outputFormat: "dd MMM yyyy HH:mm", // tampilan yang diinginkan
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            }, {
                title: "Action",
                formatter: actionFormatter,
                width: 100,
                hozAlign: "center",
            }
        ],
    });

    function actionFormatter(cell) {
        return `<button type="button" onclick="Crud('update', '${cell.getRow().getData().period_id}')" class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" onclick="Crud('delete', '${cell.getRow().getData().period_id}')" class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        `;
    }

    function reloadTable() {
        const search = document.getElementById("search-input").value;

        table.setData("{{ route('sallaryTax.getPayPeriodsData') }}", {
            search: search
        });
    }
</script>
@endpush

@include('sallary-tax.partials.crud-pay-periods');
@endsection