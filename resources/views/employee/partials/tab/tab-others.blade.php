<div class="row row-cards">
    <!-- PTKP Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PTKP Status</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudPTKP('create', '*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-ptkp"></div>
        </div>
    </div>

    <!-- Education Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Education</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudEducation('create', '*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-education"></div>
        </div>
    </div>

    <!-- Overtime Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Overtime Group</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudOvertimeGroup('create', '*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-overtime"></div>
        </div>
    </div>

    <!-- Family Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Family</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudFamily('create', '*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-family"></div>
        </div>
    </div>

</div>

@push("scripts")
<script>
    // 2. Definisi Kolom yang Berbeda-beda
    const colsPTKP = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailPTKP,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "employee_id",
            field: "employee_id",
            width: 100,
            visible: false,
        },
        {
            title: "PTKP",
            field: "ptkp_code"
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

    const colsEducation = [{
        title: "Action",
        field: 'option',
        formatter: actionFormatterDetailEducation,
        width: 120,
        frozen: true,
        hozAlign: "center",
    }, {
        title: "Status",
        field: "status",
        width: 100,
        formatter: "html",
    }, {
        title: "Education ID",
        field: "education_id",
    }, {
        title: "Education Name",
        field: "education_name"
    }, {
        title: "Institution",
        field: "name_institution"
    }, {
        title: "Major",
        field: "major"
    }, {
        title: "GPA",
        field: "gpa"
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

    const colsOvertime = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailOvertime,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "group_id",
            field: "group_id",
            // visible: false
        },
        {
            title: "Group Name",
            field: "group_name",
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

    const colsFamily = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailFamily,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "family_id",
            field: "family_id",
            visible: false
        },
        {
            title: "Relation Name",
            field: "relation_name",
        },
        {
            title: "Name",
            field: "name_family",
        }, {
            title: "Gender",
            field: "gender",
        }, {
            title: "Address",
            field: "address",
        }, {
            title: "ID Card",
            field: "id_card",
        }, {
            title: "Contact",
            field: "contact",
        }, {
            title: "Born Date",
            field: "born_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd",
                outputFormat: "dd MMM yyyy",
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        }
    ];

    function actionFormatterDetailPTKP(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var ptkp_code = rowData.ptkp_code;
        var start_date = rowData.start_date;
        var id = ptkp_code + '__' + start_date;
        return `<button type="button" 
            onclick="CrudPTKP('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudPTKP('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailEducation(cell) {
        var rowData = cell.getRow().getData();

        var education_id = rowData.education_id;
        var start_date = rowData.start_date;
        var id = education_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudEducation('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudEducation('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailOvertime(cell) {
        var rowData = cell.getRow().getData();

        var group_id = rowData.group_id;
        var start_date = rowData.start_date;
        var id = group_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudOvertimeGroup('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>  
        </button>
        <button type="button" 
            onclick="CrudOvertimeGroup('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailFamily(cell) {
        var rowData = cell.getRow().getData();

        var family_id = rowData.family_id;
        var id = family_id;
        return `<button type="button" 
            onclick="CrudFamily('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>  
        </button>
        <button type="button" 
            onclick="CrudFamily('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    let tablePTKP;
    let tableEducation;
    let tableOvertime;
    let tableFamily
    // 3. Eksekusi Inisialisasi
    document.addEventListener("DOMContentLoaded", function() {
        // Panggil fungsi dengan kolom masing-masing
        tablePTKP = initTable("#table-ptkp", "{{ route('employees.getDetailEmployee') }}", colsPTKP, {
            employee_id: $("#employee_id").val(),
            nameData: "ptkp"
        });
        tableEducation = initTable("#table-education", "{{ route('employees.getDetailEmployee') }}", colsEducation, {
            employee_id: $("#employee_id").val(),
            nameData: "education"
        });
        tableOvertime = initTable("#table-overtime", "{{ route('employees.getDetailEmployee') }}", colsOvertime, {
            employee_id: $("#employee_id").val(),
            nameData: "overtime"
        });
        tableFamily = initTable("#table-family", "{{ route('employees.getDetailEmployee') }}", colsFamily, {
            employee_id: $("#employee_id").val(),
            nameData: "family"
        });
        // Dan seterusnya...
    });
</script>
@endpush