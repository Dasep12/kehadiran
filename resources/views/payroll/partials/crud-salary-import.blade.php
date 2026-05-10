<div class="offcanvas offcanvas-end" id="offcanvasSalaryImportEnd">
    <form id="form-crud-salary-import" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasSalaryImportEndLabel">Crud Salary Import</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Employee</label>
                    <div class="col">
                        <select class="form-control" name="employee_id" id="employee_id">
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Salary Component</label>
                    <div class="col">
                        <select class="form-control" name="allowance_id" id="allowance_id">
                            <option value="">Select Salary Component</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Amount</label>
                    <div class="col">
                        <input type="text" name="amount" id="amount" class="form-control" aria-describedby="educationHelp" placeholder="Enter amount">
                    </div>
                </div>
                </select>
            </div>

            <div class="text-end">
                <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x-mark">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 16l3.644 3.644a1.21 1.21 0 0 0 1.712 0l2.288 -2.288a1.21 1.21 0 0 0 0 -1.712l-3.644 -3.644l3.644 -3.644a1.21 1.21 0 0 0 0 -1.712l-2.288 -2.288a1.21 1.21 0 0 0 -1.712 0l-3.644 3.644l-3.644 -3.644a1.21 1.21 0 0 0 -1.712 0l-2.288 2.288a1.21 1.21 0 0 0 0 1.712l3.644 3.644l-3.644 3.644a1.21 1.21 0 0 0 0 1.712l2.288 2.288a1.21 1.21 0 0 0 1.712 0m3.644 -3.644" />
                    </svg>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21.864 3.549l-6.454 17.868a1.55 1.55 0 0 1 -1.41 .903a1.54 1.54 0 0 1 -1.394 -.874l-2.88 -5.759zm-1.414 -1.414l-12.139 12.138l-5.728 -2.864a1.55 1.55 0 0 1 -.903 -1.409c0 -.606 .353 -1.157 .981 -1.44z" />
                    </svg>
                    Submit
                </button>
            </div>
        </div>
        <div id="CrudSalaryImport-ErrorInfo"></div>
    </form>
    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" id="CrudSalaryImport-action" value="">
</div>




</div>
@push('scripts')
<script>
    function loadAllowance() {
        $.ajax({
            url: '{{ route("sallaryTax.getAllowancesData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Allowance</option>';
                response.forEach(function(allowance) {
                    options += `<option value="${allowance.id}">${allowance.allowance_name}</option>`;
                    allowanceColumns.push({
                        allowance_id: allowance.id,
                        allowance_name: allowance.allowance_name
                    });
                });
                $('#allowance_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching allowance data:', xhr);
            }
        });
    }

    function loadEmployee() {
        $.ajax({
            url: '{{ route("employees.getDataEmployee") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Employee</option>';
                response.forEach(function(employee) {
                    options += `<option data-code="${employee.employee_code}" value="${employee.id}">${employee.employee_name}</option>`;

                    allowanceEmployee.push({
                        employee_id: employee.id,
                        employee_name: employee.employee_name,
                        employee_code: employee.employee_code
                    });
                });
                $('#employee_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching employee data:', xhr);
            }
        });
    }

    loadAllowance()
    loadEmployee();

    function CrudSalaryImport(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud-salary-import').reset();
        $('#form-crud-salary-import').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#CrudSalaryImport-action').val(action);
        $('#CrudSalaryImport-ErrorInfo').html(''); // Reset error info


        if (id !== '*') {
            // let data = tableSalaryImport.getRow(id).getData();
        }
        switch (action) {
            case 'create':
                $('#offcanvasSalaryImportEnd').offcanvas('show');
                $('#offcanvasSalaryImportEndLabel').text('Create Salary Import');
                break;
            case 'delete':
                tableSalaryImport.deleteRow(id);
                $('#offcanvasSalaryImportEndLabel').text('Delete Salary Import');

                break;
        }
    }

    function generateTable() {

        let pivotData = {};
        salaryData.forEach(item => {
            // unique employee key
            let employeeKey = item.employee_id + '_' + item.employee_name;
            // unique allowance field
            let fieldName = 'allowance_' + item.allowance_id;
            // create row employee
            if (!pivotData[employeeKey]) {
                pivotData[employeeKey] = {
                    employee_id: item.employee_id,
                    employee_name: item.employee_name,
                    employee_code: item.employee_code,
                };
            }
            // set amount
            pivotData[employeeKey][fieldName] = item.amount;
        });

        // object -> array
        let finalData = Object.values(pivotData);
        // unique allowance
        let allowanceColumns = [];
        salaryData.forEach(item => {
            let exists = allowanceColumns.find(x =>
                x.allowance_id == item.allowance_id
            );
            if (!exists) {

                allowanceColumns.push({
                    allowance_id: item.allowance_id,
                    allowance_name: item.allowance_name
                });
            }
        });

        // columns
        let columns = [{
            title: "EMPLOYEE",
            field: "employee_name",
            frozen: true
        }, {
            title: "EMPLOYEE CODE",
            field: "employee_code",
        }];

        // dynamic columns
        allowanceColumns.forEach(col => {
            columns.push({
                title: col.allowance_name,
                field: 'allowance_' + col.allowance_id,
                hozAlign: "right",
                editor: "input",
                formatter: "money",
                formatterParams: {
                    decimal: ".",
                    thousand: "",
                    symbol: "Rp ",
                    precision: 0,
                },
            });
        });

        columns.push({
            title: 'Status',
            field: 'status',
            formatter: "html",
        }, {
            title: "Action",
            field: 'option',
            formatter: actionFormatterDetail,
            width: 120,
            frozen: true,
            hozAlign: "center",
        });
        // render
        tableSalaryImport.setColumns(columns);
        tableSalaryImport.setData(finalData);
    }


    $('#btnExportExcel').click(function() {
        tableSalaryImport.download(
            "xlsx",
            "salary-import.xlsx", {
                sheetName: "Salary Import"
            }
        );
    });

    $('#importExcel').on('change', function(e) {
        let file = e.target.files[0];
        if (!file) return;
        let reader = new FileReader();
        reader.onload = function(event) {
            let data = new Uint8Array(event.target.result);
            let workbook = XLSX.read(data, {
                type: 'array'
            });
            let sheetName = workbook.SheetNames[0];
            let worksheet = workbook.Sheets[sheetName];
            let jsonData = XLSX.utils.sheet_to_json(worksheet);
            console.log(jsonData);
            importDynamicData(jsonData);
        };
        reader.readAsArrayBuffer(file);
        $(this).val(''); // Reset input file after upload
    });

    function importDynamicData(rows) {
        salaryData = [];
        rows.forEach(row => {
            let employeeName = row['EMPLOYEE'];
            let employeeCode = row['EMPLOYEE CODE'];
            // loop semua kolom
            Object.keys(row).forEach(key => {
                // skip employee column
                if (key === 'EMPLOYEE') return;
                let amount = row[key];
                // skip kosong
                if (
                    amount === null ||
                    amount === undefined ||
                    amount === ''
                ) return;
                // cari allowance berdasarkan nama kolom
                let allowance = allowanceColumns.find(x =>
                    x.allowance_name === key
                );
                if (!allowance) return;
                salaryData.push({
                    employee_id: null, // nanti mapping employee
                    employee_name: employeeName,
                    employee_code: employeeCode,
                    allowance_id: allowance.allowance_id,
                    allowance_name: allowance.allowance_name,
                    amount: amount
                });
            });
        });

        generateTable();

    }

    $('#form-crud-salary-import').on('submit', function(e) {
        e.preventDefault();
        console.log('Form submitted');
        let action = $('#CrudSalaryImport-action').val();
        let employee_id = $('#employee_id').val();
        let employee_name = $('#employee_id option:selected').text();
        let employee_code = $('#employee_id option:selected').data('code');
        let allowance_id = $('#allowance_id').val();
        let allowance_name = $('#allowance_id option:selected').text();

        let amount = $('#amount').val();

        switch (action) {
            case 'create':
                // Logic untuk create
                // simpan data mentah
                let name_emp = employee_id === "" ? null : employee_name;
                salaryData.push({
                    employee_id,
                    employee_code,
                    name_emp,
                    allowance_id,
                    allowance_name,
                    amount
                });

                generateTable();
                break;

            case 'update':
                // Logic untuk update
                break;

            case 'delete':
                // Logic untuk delete
                break;
        }
    })

    async function SubmitSalaryImport() {
        let salaryData = tableSalaryImport.getData();
        let total = salaryData.length;
        let success = 0;
        // tampilkan progress area
        $("#importProgressWrapper").show();
        for (let i = 0; i < total; i++) {
            let item = salaryData[i];
            // update row jadi loading
            updateRowStatus(item.employee_code,
                "<span class='badge bg-warning text-dark'>Uploading...</span>"
            );
            try {
                await sendAjax(item);
                success++;
                updateRowStatus(item.employee_code,
                    "<span class='badge bg-success text-white'>Success</span>"
                );
            } catch (err) {
                let errorMessage = 'Unknown error';
                if (err.responseJSON && err.responseJSON.message) {
                    errorMessage = err.responseJSON.message;
                } else if (err.statusText) {
                    errorMessage = err.statusText;
                }
                updateRowStatus(
                    item.employee_code,
                    `<span class='badge bg-danger text-white'>Failed : ${errorMessage}</span>`
                );
                console.error(errorMessage);
            }
            // update progress
            let percent = Math.round(((i + 1) / total) * 100);
            $("#importProgressBar")
                .css("width", percent + "%")
                .text(percent + "%");
            $("#importProgressText").text(
                `Processed ${i + 1} of ${total} data`
            );
        }
        showAlert(`Import selesai. Success ${success}/${total}`, 'success');
    }

    function updateRowStatus(employeeCode, statusHtml) {
        let rowComponent = tableSalaryImport.getRows().find(r => {
            let d = r.getData();
            return d.employee_code === employeeCode;
        });
        if (rowComponent) {
            rowComponent.update({
                status: statusHtml
            });
        }
    }

    function sendAjax(salaryData) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("payroll.salary-import") }}',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    salary_data: salaryData
                }),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    resolve(response);
                },
                error: function(xhr) {
                    reject(xhr);
                }
            });

        });
    }
</script>
@endpush