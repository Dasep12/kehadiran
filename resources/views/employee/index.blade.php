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

                                    <select name="" onchange="reloadTable()" class="form-control" id="status_employee_filter">
                                        <option value="2">ALL</option>
                                        <option selected value="1">ACTIVE</option>
                                        <option value="0">RESIGN</option>
                                    </select>
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
                                @if($canCreate)
                                <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="Crud('create','*')" data-bs-target="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"> Create </button>
                                @else
                                <button disabled class="disabled btn btn-outline-primary" data-bs-toggle="offcanvas" type="button"> Create </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Your education content here -->
                    <div id="employee-index"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->
@push('scripts')
<script>
    const canEdit = "{{ $canEdit }}"
    const canDelete = "{{ $canDelete }}"
    var table = new Tabulator("#employee-index", {
        ajaxURL: "{{ route('employees.getDataEmployee') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 layout fix (penting)
        layout: "fitData",
        columnDefaults: {
            vertAlign: "middle",
        },
        responsiveLayout: false, // disable hide/collapse → pakai scroll
        height: "450px",
        // 🔥 pagination
        pagination: "local",
        paginationSize: 10,
        index: "employee_id",
        paginationSizeSelector: [10, 25, 50, 100],
        placeholder: "No Employee Data",
        // 🔥 ajax param (filter support)
        ajaxParams: {
            search: "",
            status: $("#status_employee_filter").val()
        },
        columns: [{
                title: "ID",
                field: "employee_id",
                visible: false
            },
            {
                title: "Name",
                field: "employee_name",
                headerHozAlign: "center",
                frozen: true,
                formatter: function(cell) {
                    var data = cell.getData();

                    return `<div style="display:flex; align-items:center; gap:10px;">
                        <span 
                            class="avatar avatar-sm"
                            style="
                                width:32px;
                                height:32px;
                                border-radius:50%;
                                background-image: url('../${data.photo_path}');
                                background-size: cover;
                                background-position: center;
                            ">
                        </span>
                        <span>${data.employee_name}</span>
                    </div>`;
                }
            }, {
                title: "No Regis",
                field: "employee_code",
            }, {
                title: "Email",
                field: "email",
            }, {
                title: "Company",
                field: "company_name",
            },
            {
                title: "Organization",
                field: "organization_name",
            }, {
                title: "Position",
                field: "position_name",
            },
            {
                title: "Working Status",
                field: "working_name",
            },
            {
                title: "Grade",
                field: "grade_name",
            },
            {
                title: "resign_id",
                field: "resign_id",
                visible: false
            },
            {
                title: "reasons_resign",
                field: "reasons_resign",
                visible: false
            },
            {
                title: "bpjs_jkn",
                field: "bpjs_jkn",
                visible: false
            },
            {
                title: "bpjs_tk",
                field: "bpjs_tk",
                visible: false
            },
            {
                title: "resign_date",
                field: "resign_date",
            },
            {
                title: "photo_path",
                field: "photo_path",
            },
            {
                title: "Join Date",
                field: "join_date",
                formatter: "datetime",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                    outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            },
            {
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
                width: 150,
                hozAlign: "center",
                frozen: true
            }
        ],
    });

    function actionFormatter(cell) {
        var resign_date = cell.getRow().getData().resign_date;
        console.log(resign_date);
        var actionResign = resign_date == null ? 'create' : 'delete';
        let clickEdit = canEdit == true ? `onclick="Crud('update', '${cell.getRow().getData().employee_id}')"` : '';
        let clickDelete = `onclick="Crud('delete', '${cell.getRow().getData().employee_id}')"`;
        let clickResign = `onclick="CrudEmployeeResign('${actionResign}', '${cell.getRow().getData().employee_id}')"`;
        let disabledEdit = canEdit == true ? "" : "disabled";
        let disabledDelete = canDelete == true ? "" : "disabled";
        let disabledResign = canEdit == true ? "" : "disabled";

        if (resign_date != null) {
            disabledDelete = "disabled";
            disabledEdit = "disabled";
            clickEdit = '';
            clickDelete = '';
        }

        return `<button data-bs-toggle="tooltip"  title="Edit" type="button" ${disabledEdit} ${clickEdit} class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button title="Delete" type="button" ${disabledDelete} ${clickDelete} class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <button title="Resign" type="button" ${disabledResign} ${clickResign} class="btn btn-sm btn-outline-warning ms-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-off">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 5h9a2 2 0 0 1 2 2v9m-.184 3.839a2 2 0 0 1 -1.816 1.161h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 1.158 -1.815" />
                    <path d="M16 3v4" />
                    <path d="M8 3v1" />
                    <path d="M4 11h7m4 0h5" />
                    <path d="M3 3l18 18" />
        </svg>
        </button>
        `;
    }

    function reloadTable() {
        const search = document.getElementById("search-input").value;

        table.setData("{{ route('employees.getDataEmployee') }}", {
            search: search,
            status: $("#status_employee_filter").val()
        });
    }

    function reloadAllTables() {
        let empId = $("#employee_id").val();

        tableOrganization.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "organization"
        });

        tablePosition.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "position"
        });

        tableGrade.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "grade"
        });

        tableWorkingStatus.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "working_status"
        });

        tableBasicSalary.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "basic_sallary"
        });
        tableBankAccount.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "bank_account"
        });
        tableMembership.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "membership"
        });

        tablePTKP.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "ptkp"
        });

        tableEducation.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "education"
        });

        tableOvertime.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "overtime"
        });

        tableFamily.setData("{{ route('employees.getDetailEmployee') }}", {
            employee_id: empId,
            nameData: "family"
        });
    }
</script>
@endpush


@include("employee.partials.crud-employee")
@include("employee.partials.crud-resign-employee")
@endsection