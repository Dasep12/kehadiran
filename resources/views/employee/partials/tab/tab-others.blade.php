<div class="row row-cards">
    <!-- Organization Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">PTKP Status</h3>
                <div class="card-actions">
                    <button class="btn btn-outline-primary btn-sm">
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

    <!-- Position Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Education</h3>
                <div class="card-actions">
                    <button class="btn btn-outline-primary btn-sm">
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

    <!-- Membership Table -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Overtime Group</h3>
                <div class="card-actions">
                    <button class="btn btn-outline-primary btn-sm">
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

</div>

@push("scripts")
<script>
    // 2. Definisi Kolom yang Berbeda-beda
    const colsPTKP = [{
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
        title: "Education ID",
        field: "education_id"
    }, {
        title: "Education Name",
        field: "education_name"
    }, {
        title: "Institution",
        field: "name_institution"
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
            title: "group_id",
            field: "group_id",
            visible: false
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


    // 3. Eksekusi Inisialisasi
    document.addEventListener("DOMContentLoaded", function() {
        // Panggil fungsi dengan kolom masing-masing
        initTable("#table-ptkp", "{{ route('employees.getDetailEmployee') }}", colsPTKP, {
            employee_id: 1,
            nameData: "ptkp"
        });
        initTable("#table-education", "{{ route('employees.getDetailEmployee') }}", colsEducation, {
            employee_id: 1,
            nameData: "education"
        });
        initTable("#table-overtime", "{{ route('employees.getDetailEmployee') }}", colsOvertime, {
            employee_id: 1,
            nameData: "overtime"
        });
        // Dan seterusnya...
    });
</script>
@endpush