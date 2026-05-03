<div class="row row-cards">
    <!-- Organization Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Organization</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudOrganization('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-organization"></div>
        </div>
    </div>

    <!-- Position Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Position</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudPosition('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-position"></div>
        </div>
    </div>

    <!-- Working Status Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Working Status</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudWorkStatus('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-working-status"></div>
        </div>
    </div>

    <!-- Grade Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grade</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudGrade('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-grade"></div>
        </div>
    </div>
</div>

@push("scripts")
<script>
    // 2. Definisi Kolom yang Berbeda-beda
    const colsOrg = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailOrganization,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "Code",
            field: "organization_id",
            width: 100,
            visible: false,
        }, {
            title: "Code",
            field: "company_id",
            width: 100,
            visible: false,
        },
        {
            title: "Comp Name",
            field: "company_name"
        },
        {
            title: "Org Name",
            field: "organization_name"
        }, {
            title: "Start Date",
            field: "start_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        }, {
            title: "End Date",
            field: "end_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        },
    ];

    const colsPosition = [{
        title: "Action",
        field: 'option',
        formatter: actionFormatterDetailPosition,
        width: 120,
        frozen: true,
        hozAlign: "center",
    }, {
        title: "Status",
        field: "status",
        width: 100,
        formatter: "html",
    }, {
        title: "Position",
        field: "position_name"
    }, {
        title: "Position",
        field: "position_id",
        visible: false
    }, {
        title: "Start Date",
        field: "start_date",
        formatter: "datetime",
        formatterParams: {
            inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
            outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
            invalidPlaceholder: "-"
        },
        hozAlign: "center"
    }, {
        title: "End Date",
        field: "end_date",
        formatter: "datetime",
        formatterParams: {
            inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
            outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
            invalidPlaceholder: "-"
        },
        hozAlign: "center"
    }, ];

    const colsWorkingStatus = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailWorkingStatus,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "Working Name",
            field: "working_id",
            visible: false
        }, {
            title: "Working Name",
            field: "working_name"
        },
        {
            title: "Code",
            field: "working_code",
        },
        {
            title: "Start Date",
            field: "start_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        }, {
            title: "End Date",
            field: "end_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        },
    ];
    const colsGrade = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailGrade,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "Grade",
            field: "grade_name"
        },
        {
            title: "grade_id",
            field: "grade_id",
            visible: false
        },
        {
            title: "Start Date",
            field: "start_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        }, {
            title: "End Date",
            field: "end_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        },
    ];

    function actionFormatterDetailOrganization(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var organization_id = rowData.organization_id;
        var start_date = rowData.start_date;
        var id = organization_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudOrganization('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudOrganization('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailPosition(cell) {
        var rowData = cell.getRow().getData();

        var position_id = rowData.position_id;
        var start_date = rowData.start_date;
        var id = position_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudPosition('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudPosition('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailWorkingStatus(cell) {
        var rowData = cell.getRow().getData();

        var working_id = rowData.working_id;
        var start_date = rowData.start_date;
        var id = working_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudWorkStatus('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudWorkStatus('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailGrade(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var grade_id = rowData.grade_id;
        var start_date = rowData.start_date;
        var id = grade_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudGrade('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudGrade('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    let tableOrganization;
    let tablePosition;
    let tableGrade;
    let tableWorkingStatus;

    document.addEventListener("DOMContentLoaded", function() {
        tableOrganization = initTable("#table-organization", "{{ route('employees.getDetailEmployee') }}", colsOrg, {
            employee_id: $("#employee_id").val(),
            nameData: "organization"
        });

        tablePosition = initTable("#table-position", "{{ route('employees.getDetailEmployee') }}", colsPosition, {
            employee_id: $("#employee_id").val(),
            nameData: "position"
        });

        tableGrade = initTable("#table-grade", "{{ route('employees.getDetailEmployee') }}", colsGrade, {
            employee_id: $("#employee_id").val(),
            nameData: "grade"
        });

        tableWorkingStatus = initTable("#table-working-status", "{{ route('employees.getDetailEmployee') }}", colsWorkingStatus, {
            employee_id: $("#employee_id").val(),
            nameData: "working_status"
        });
    });
</script>
@endpush