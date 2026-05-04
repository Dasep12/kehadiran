<div class="row row-cards">
    <!-- Organization Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Sallary</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudBasicSalary('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-basic-sallary"></div>
        </div>
    </div>

    <!-- Position Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bank Account</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudBankAccount('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-bank-account"></div>
        </div>
    </div>

    <!-- Membership Table -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Membership</h3>
                <div class="card-actions">
                    <button type="button" onclick="CrudMembership('create','*')" class="btn btn-outline-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Add New
                    </button>
                </div>
            </div>
            <div id="table-membership"></div>
        </div>
    </div>

</div>

@push("scripts")
<script>
    // 2. Definisi Kolom yang Berbeda-beda
    const colsBasicSallary = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailBasicSallary,
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
            width: 100,
            visible: false,
        }, {
            title: "employee_id",
            field: "employee_id",
            width: 100,
            visible: false,
        },
        {
            title: "allowance_id",
            field: "allowance_id",
            width: 100,
            visible: false,
        },
        {
            title: "Group Sallary",
            field: "name_group"
        },
        {
            title: "Amount",
            field: "basic_salary",
            formatter: "money"
        },
        {
            title: "Name",
            field: "allowance_name"
        }, {
            title: "Start Date",
            field: "emp_start_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        }, {
            title: "End Date",
            field: "emp_end_date",
            formatter: "datetime",
            formatterParams: {
                inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                invalidPlaceholder: "-"
            },
            hozAlign: "center"
        },
    ];

    const colsBankAccount = [{
        title: "Action",
        field: 'option',
        formatter: actionFormatterDetailBankAccount,
        width: 120,
        frozen: true,
        hozAlign: "center",
    }, {
        title: "Status",
        field: "status",
        width: 100,
        formatter: "html",
    }, {
        title: "Bank ID",
        field: "bank_id"
    }, {
        title: "Bank Name",
        field: "bank_name"
    }, {
        title: "Account Name",
        field: "account_name"
    }, {
        title: "Account Number",
        field: "account_number"
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

    const colsMembership = [{
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetailMembership,
            width: 120,
            frozen: true,
            hozAlign: "center",
        }, {
            title: "Status",
            field: "status",
            width: 100,
            formatter: "html",
        }, {
            title: "membership_id",
            field: "membership_id",
            visible: false
        }, {
            title: "Name",
            field: "allowance_name"
        },
        {
            title: "Code",
            field: "membership_code",
        },
        {
            title: "Calc Type",
            field: "calculation_type",
        },
        {
            title: "Rate",
            field: "rate_value",
            hozAlign: "center",
            formatter: function(cell) {
                var data = cell.getData();
                var rate = Number(data.rate_value) || 0;
                return parseFloat(rate.toFixed(1));
            }
        },
        {
            title: "Emp Share",
            field: "employee_share",
            hozAlign: "center",
            formatter: "tickCross",
        },
        {
            title: "Comp Share",
            field: "company_share",
            hozAlign: "center",
            formatter: "tickCross",
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

    function actionFormatterDetailBasicSallary(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var group_id = rowData.group_id;
        var allowance_id = rowData.allowance_id;
        var start_date = rowData.emp_start_date;
        var id = group_id + '__' + allowance_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudBasicSalary('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudBasicSalary('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailBankAccount(cell) {
        var rowData = cell.getRow().getData();

        var bank_id = rowData.bank_id;
        var start_date = rowData.start_date;
        var id = bank_id + '__' + start_date;
        return `<button type="button" 
            onclick="CrudBankAccount('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudBankAccount('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function actionFormatterDetailMembership(cell) {
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


    let tableBasicSalary;
    let tableBankAccount;
    let tableMembership;
    // 3. Eksekusi Inisialisasi
    document.addEventListener("DOMContentLoaded", function() {
        // Panggil fungsi dengan kolom masing-masing
        tableBasicSalary = initTable("#table-basic-sallary", "{{ route('employees.getDetailEmployee') }}", colsBasicSallary, {
            employee_id: $("#employee_id").val(),
            nameData: "basic_sallary"
        });
        tableBankAccount = initTable("#table-bank-account", "{{ route('employees.getDetailEmployee') }}", colsBankAccount, {
            employee_id: $("#employee_id").val(),
            nameData: "bank_account"
        });
        tableMembership = initTable("#table-membership", "{{ route('employees.getDetailEmployee') }}", colsMembership, {
            employee_id: $("#employee_id").val(),
            nameData: "membership"
        });
        // Dan seterusnya...
    });
</script>
@endpush