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

    .tabulator-row .tabulator-cell {
        /* height: 40px !important; */
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

                                <label class="form-check form-switch form-switch-3">
                                    <input id="toggle-overtime" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">Overtime</span>
                                </label>
                                <label class="form-check form-switch form-switch-3">
                                    <input class="form-check-input" type="checkbox" id="toggle-allowance">
                                    <span class="form-check-label">Allowance</span>
                                </label>

                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        Filter
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 300px;">

                                        <!-- RANGE DATE -->
                                        <label class="form-label">Date Range</label>
                                        <input type="text" id="date_range" class="form-control range_date_picker mb-3" placeholder="Select date range">

                                        <!-- SEARCH -->
                                        <label class="form-label">Search</label>
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

                                        <!-- ACTION -->
                                        <div class="mt-2 d-flex justify-content-end gap-2">
                                            <button type="button" onclick="reloadTable()" class="btn btn-icon btn-outline-primary w-100" aria-label="Button">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pointer-search">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14.778 12.222l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093" />
                                                    <path d="M15 18a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M20.2 20.2l1.8 1.8" />
                                                </svg>
                                            </button>
                                        </div>

                                    </div>
                                </div>



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
                    <!-- Your education content here -->
                    <div id="attendance-employee"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->
@push('scripts')
<script>
    // $(document).ready(function() {
    //     $("#toggle-overtime").prop("checked", false)
    //     $("#toggle-allowance").prop("checked", false)
    // })
    // document.getElementById("toggle-overtime").addEventListener("change", function() {
    //     toggleColumnsByPrefix("overtime_", this.checked);
    //     // tambahan field lain
    //     toggleColumnsByPrefix("total_hours", this.checked);
    //     toggleColumnsByPrefix("total_hours_actual", this.checked);
    //     toggleColumnsByPrefix("overtime_index", this.checked);
    // });

    // document.getElementById("toggle-allowance").addEventListener("change", function() {
    //     toggleColumnsByPrefix("allowance_", this.checked);
    // });

    function loadTable() {

        let range = $(".range_date_picker").val();
        let start = "",
            end = "";

        if (range) {
            let separator = range.includes(" s/d ") ? " s/d " : " to ";

            if (range.includes(separator)) {
                [start, end] = range.split(separator);
            } else {
                start = range;
                end = range; // 🔥 otomatis samakan
            }
        }

        $.get("{{ route('attendance.getEmployeeAttendanceAllowanceData') }}", {
            start_date: start,
            end_date: end
        }, function(allowances) {
            initTable(allowances);
        });
    }

    function generateAllowanceColumns(allowances) {
        const unique = {};

        allowances.forEach(a => {
            unique[a.allowance_id] = a;
        });

        return Object.values(unique).map(a => ({
            title: a.allowance_name,
            field: "allowance_" + a.allowance_id,
            hozAlign: "right",
            width: 150,
            visible: false, // 🔥 default hidden
            formatter: function(cell) {
                let val = cell.getValue();
                return val ? "Rp " + Number(val).toLocaleString("id-ID") : "-";
            },
            bottomCalc: "sum",
            bottomCalcFormatter: function(cell) {
                let val = cell.getValue();
                return "Rp " + Number(val).toLocaleString("id-ID");
            }
        }));
    }
    var table;

    function initTable(allowances) {

        const allowanceCols = generateAllowanceColumns(allowances);
        table = new Tabulator("#attendance-employee", {
            ajaxURL: "{{ route('attendance.getEmployeeAttendanceData') }}",
            ajaxConfig: "GET",
            // ajaxParams: {
            //     search: document.getElementById("search-input").value,
            //     start_date: start,
            //     end_date: end
            // },
            ajaxParams: function() {
                let range = $(".range_date_picker").val();
                let start = "",
                    end = "";

                if (range) {
                    let separator = range.includes(" s/d ") ? " s/d " : " to ";

                    if (range.includes(separator)) {
                        [start, end] = range.split(separator);
                    } else {
                        start = range;
                        end = range; // 🔥 otomatis samakan
                    }
                }

                return {
                    search: $("#search-input").val(),
                    start_date: start,
                    end_date: end
                };
            },

            layout: "fitData",
            columnDefaults: {
                vertAlign: "middle",
                headerHozAlign: "center" // 🔥 global
            },

            responsiveLayout: false,
            height: "450px",

            pagination: "remote",
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            index: 'id',

            columns: [{
                    title: "ID",
                    field: "id",
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
                },
                {
                    title: "No. Registrasi",
                    field: "employee_code",
                },
                {
                    title: "Schedule", // 🔥 parent header
                    headerHozAlign: "center",
                    columns: [{
                            title: "Work Date",
                            field: "work_date",
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd",
                                outputFormat: "dd MMM yyyy",
                                invalidPlaceholder: "-"
                            },
                            hozAlign: "center"
                        },
                        {
                            title: "Shift",
                            field: "shift_name",

                        }
                    ],
                },
                {
                    title: "Attendance", // 🔥 parent header
                    headerHozAlign: "center",
                    columns: [{
                            title: "Check In",
                            field: "check_in",
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                            hozAlign: "center"
                        },
                        {
                            title: "Checkout",
                            field: "check_out",
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                            hozAlign: "center"
                        },
                        {
                            title: "Late",
                            field: "late_minutes",
                        },
                        {
                            title: "Early",
                            field: "early_leave_minutes",
                        },
                        {
                            title: "Status",
                            field: "attendance_status",
                        }

                    ]
                },
                {
                    title: "Overtime", // 🔥 parent header
                    headerHozAlign: "center",
                    columns: [{
                            title: "OT Type",
                            field: "overtime_type",
                            visible: false
                        },
                        {
                            title: "OT First Start",
                            field: "overtime_first_start",
                            visible: false,
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                        },
                        {
                            title: "OT First End",
                            field: "overtime_first_end",
                            visible: false,
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                        },
                        {
                            title: "OT Last Start",
                            field: "overtime_last_start",
                            visible: false,
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                        },
                        {
                            title: "OT Last End",
                            field: "overtime_last_end",
                            visible: false,
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                        },
                        {
                            title: "OT Holiday Start",
                            field: "overtime_holiday_start",
                            visible: false,
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                        },
                        {
                            title: "OT Holiday End",
                            field: "overtime_holiday_end",
                            visible: false,
                            formatter: "datetime",
                            formatterParams: {
                                inputFormat: "yyyy-MM-dd HH:mm:ss",
                                outputFormat: "HH:mm:ss",
                                invalidPlaceholder: "-"
                            },
                        },
                        {
                            title: "OT Hours Act",
                            field: "total_hours_actual",
                            visible: false
                        },
                        {
                            title: "OT Hours",
                            field: "total_hours",
                            visible: false
                        },
                        {
                            title: "OT Index",
                            field: "overtime_index",
                            visible: false
                        },
                    ]
                },
                // 🔥 INI YANG PENTING
                // ...allowanceCols
                // 🔥 GROUP HEADER DI SINI
                ...(allowanceCols.length > 0 ? [{
                    title: "Allowance",
                    headerHozAlign: "center",
                    columns: allowanceCols
                }] : [])
            ],
        });

        // 🔥 APPLY STATE SETELAH TABLE READY
        table.on("tableBuilt", function() {
            applyToggleState();
        });
    }

    loadTable();

    // ===============================
    // HELPER: TOGGLE COLUMN
    // ===============================
    function toggleColumnsByPrefix(prefix, show) {
        table.getColumns().forEach(col => {
            const field = col.getField();
            if (field && field.startsWith(prefix)) {
                show ? col.show() : col.hide();
            }
        });
    }


    // ===============================
    // APPLY STATE DARI LOCAL STORAGE
    // ===============================
    function applyToggleState() {
        const overtime = localStorage.getItem("toggle_overtime") === "true";
        const allowance = localStorage.getItem("toggle_allowance") === "true";

        // set checkbox
        $("#toggle-overtime").prop("checked", overtime);
        $("#toggle-allowance").prop("checked", allowance);

        // apply ke column
        toggleColumnsByPrefix("overtime_", overtime);
        toggleColumnsByPrefix("total_hours", overtime);
        toggleColumnsByPrefix("total_hours_actual", overtime);
        toggleColumnsByPrefix("overtime_index", overtime);

        toggleColumnsByPrefix("allowance_", allowance);
    }

    // ===============================
    // EVENT TOGGLE
    // ===============================
    $("#toggle-overtime").on("change", function() {
        const val = this.checked;

        toggleColumnsByPrefix("overtime_", val);
        toggleColumnsByPrefix("total_hours", val);
        toggleColumnsByPrefix("total_hours_actual", val);
        toggleColumnsByPrefix("overtime_index", val);

        localStorage.setItem("toggle_overtime", val);
    });

    $("#toggle-allowance").on("change", function() {
        const val = this.checked;

        toggleColumnsByPrefix("allowance_", val);

        localStorage.setItem("toggle_allowance", val);
    });

    function actionFormatter(cell) {
        return `<div class="d-flex gap-1"><button type="button" onclick="Crud('update', '${cell.getRow().getData().id}')" class="btn btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" onclick="Crud('delete', '${cell.getRow().getData().id}')" class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button></div>
        `;
    }

    function reloadTable() {
        loadTable();
    }

    function loadEmployee() {
        $.ajax({
            url: "{{ route('employees.getDataEmployee') }}",
            method: "GET",
            data: {

            },
            success: function(response) {
                let options = '<option value="">Select Employee</option>';
                response.forEach(function(employee) {
                    options += `<option value="${employee.employee_id}">${employee.employee_name + ' - ' +  employee.employee_code}</option>`;
                });
                $('#employee_id').html(options);
            }
        })
    }

    function loadGroupShift() {
        $.ajax({
            url: "{{ route('worktime.getShiftGroupData') }}",
            method: "GET",
            cache: false,
            data: {},
            success: function(response) {
                let options = '<option value="">Select Group Shift</option>';
                response.forEach(function(groupShift) {
                    options += `<option value="${groupShift.shift_group_id}">${groupShift.shift_group_name}</option>`;
                });
                $('#shift_group_id').html(options);
            }
        })
    }

    loadEmployee()
    loadGroupShift()
</script>
@endpush

@include('attendance.partials.crud-shift-employee');
@endsection