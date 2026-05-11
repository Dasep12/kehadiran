<div class="modal modal-blur fade py-5" id="modal-calculation-process" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="post" id="form-crud-employee">
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Employee Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-auto col-sm-12 mb-3 d-flex flex-wrap gap-3 align-items-center justify-content-between">
                        <div class="d-flex  gap-3 justify-content-center">
                            <select name="company_id" id="company_process_id" class="form-control mb-2 w-100">
                                <option value="">Select Company</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                            <select name="period_id" id="period_process_id" class="form-control mb-2 w-100">
                                <option value="">Select Period</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div id="importProgressPayrollWrapper" style="display:none;">

                            <div class="progress mt-3">
                                <div id="importProgressPayrollBar"
                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar"
                                    style="width: 0%">
                                    0%
                                </div>
                            </div>

                            <small id="importProgressPayrollText">
                                Waiting...
                            </small>

                        </div>
                    </div>
                    <div class="grid-tables-tabulator mt-3" id="employee-payroll-table"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="SubmitCalculationProcess('unpost')" class="btn btn-danger">Unpost Calculation <i class="ti ti-trash mr-2"></i></button>
                    <button type="button" onclick="SubmitCalculationProcess('process')" class="btn btn-primary">Process Calculation <i class="ti ti-dot"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    function CrudCalucaltion() {
        $("#modal-calculation-process").modal('show');
    }

    var tableEmployeePayroll = new Tabulator("#employee-payroll-table", {
        ajaxURL: "{{ route('employees.getDataEmployee') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 layout fix (penting)
        layout: "fitData",
        responsiveLayout: false, // disable hide/collapse → pakai scroll
        height: "450px",
        index: "employee_id",
        columnDefaults: {
            resizable: true,
            headerSort: true,
            vertAlign: "middle",
        },
        selectableRows: true,
        columns: [{
                formatter: "rowSelection",
                titleFormatter: "rowSelection",
                // hozAlign: "center",
                headerSort: false,
                width: 60,
            }, {
                title: "ID",
                field: "employee_id",
                visible: false
            },
            {
                title: "Name",
                field: "employee_name",
                headerHozAlign: "center",
                headerFilter: "input", // 🔥 search di header
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
                headerFilter: "input", // 🔥 search di header
            }, {
                title: "Company",
                field: "company_name",
                headerFilter: "list",
                headerFilterParams: {
                    valuesLookup: true,
                    autocomplete: true,
                    clearable: true,
                }
            },
            {
                title: "Organization",
                field: "organization_name",
                visible: false
            }, {
                title: "Position",
                field: "position_name",
                visible: false
            },
            {
                title: "Working Status",
                field: "working_name",
            },
            {
                title: "Grade",
                field: "grade_name",
                visible: false
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
                title: "Resign Date",
                field: "resign_date",
                formatter: "datetime",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd", // sesuai format dari Laravel
                    outputFormat: "dd MMM yyyy", // tampilan yang diinginkan
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            }, {
                title: 'Status',
                formatter: 'html',
                field: 'status_process',
                hozAlign: 'center',
                width: 255,
            }
        ],
    });

    async function SubmitCalculationProcess(action) {

        if ($('#period_process_id').val() === '') {
            alert('Please select a period before submitting the import.');
            return;
        }

        if (action === 'unpost') {
            if (!confirm('Are you sure you want to unpost the calculation? This action cannot be undone.')) {
                return;
            }
        }
        // let EmployeeList = tableEmployeePayroll.getData();
        let employeeIds = tableEmployeePayroll.getSelectedRows().map(row => {
            return row.getData().employee_id;
        });

        if (employeeIds.length === 0) {
            alert('Please select at least one employee to process.');
            return;
        }

        let total = employeeIds.length;
        let success = 0;
        // tampilkan progress area
        $("#importProgressPayrollWrapper").show();
        for (let i = 0; i < total; i++) {
            let employee_id = employeeIds[i];
            // update row jadi loading
            updateRowStatus(employee_id,
                "<span class='badge bg-warning text-dark'>Uploading...</span>"
            );
            try {
                await sendAjaxCalculationProcess(employee_id, action);
                success++;
                updateRowStatus(employee_id,
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
                    item,
                    `<span class='badge bg-danger text-white'>Failed : ${errorMessage}</span>`
                );
                console.error(errorMessage);
            }
            // update progress
            let percent = Math.round(((i + 1) / total) * 100);
            $("#importProgressPayrollBar")
                .css("width", percent + "%")
                .text(percent + "%");
            $("#importProgressPayrollText").text(
                `Processed ${i + 1} of ${total} data`
            );
        }
        showAlert(`Import selesai. Success ${success}/${total}`, 'success');
    }

    function updateRowStatus(employeeData, statusHtml) {
        let rowComponent = tableEmployeePayroll.getRows().find(r => {
            let d = r.getData();
            return d.employee_id === employeeData;
        });
        if (rowComponent) {
            rowComponent.update({
                status_process: statusHtml
            });
        }
    }

    function sendAjaxCalculationProcess(employee_id, action) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("payroll.CrudProcessPayroll") }}',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    period_id: $('#period_process_id').val(),
                    employee_id: employee_id,
                    action: action
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