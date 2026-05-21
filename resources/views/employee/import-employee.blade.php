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
                                        <a class="dropdown-item" href="{{ route('employees.import.downloadFormat') }}">Format CSV</a>
                                        <!-- <a class="dropdown-item" href="#">PDF</a> -->
                                    </div>
                                </div>
                                <!-- <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="Crud('create','*')" data-bs-target="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"> Create </button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Your education content here -->
                    <div id="employee-import"></div>

                    <input type="file" class="mb-2 form-control form-control-sm" id="newEmployeeExcel">

                    <button type="button" class="btn btn-outline-primary" onclick="SubmitNewEmployeeImport()">Submit Data</button>

                    <div id="importProgressWrapper" style="display:none;">

                        <div class="progress mt-3">
                            <div id="importProgressBar"
                                class="progress-bar progress-bar-striped progress-bar-animated"
                                role="progressbar"
                                style="width: 0%">
                                0%
                            </div>
                        </div>

                        <small id="importProgressText">
                            Waiting...
                        </small>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- END PAGE BODY  -->
@push('scripts')
<script>
    let employeeTable = null;
    var tableNewEmployeeImport = new Tabulator("#employee-import", {
        layout: "fitData",
        height: "450px",
        placeholder: "No Import Data Available",
        columns: [{
            title: 'Status',
            field: 'status',
            formatter: "html",
        }, {
            title: "Employee Code",
            field: "employee_code"
        }, {
            title: "Employee Name",
            field: "employee_name"
        }, {
            title: "Email",
            field: "email"
        }, {
            title: "Phone",
            field: "phone"
        }, {
            title: "Gender",
            field: "gender"
        }, {
            title: "Join Date",
            field: "join_date"
        }, {
            title: "Company",
            field: "company_name"
        }, ]
    });

    $('#newEmployeeExcel').on('change', function(e) {
        const file = this.files[0];
        if (!file) {
            alert("Please select excel file");
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });

            const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
            let excelData = XLSX.utils.sheet_to_json(firstSheet);
            if (excelData.length === 0) {
                alert("Excel is empty");
                return;
            }

            // tambahkan row id manual
            excelData = excelData.map((item, index) => {
                return {
                    ...item,
                    __rowNum__: index + 1,
                    status: ""
                };
            });

            // generate dynamic columns
            let columns = [{
                title: "Status",
                field: "status",
                formatter: "html",
                width: 220
            }];

            Object.keys(excelData[0]).forEach(function(key) {
                if (key === "status" || key === "__rowNum__") return;
                columns.push({
                    title: key
                        .replaceAll("_", " ")
                        .replace(/\b\w/g, l => l.toUpperCase()),
                    field: key
                });
            });

            // destroy old table
            if (employeeTable) {
                employeeTable.destroy();
            }

            // create new table
            employeeTable = new Tabulator("#employee-import", {
                layout: "fitDataStretch",
                height: "450px",
                placeholder: "No Import Data Available",
                columns: columns,
                data: excelData
            });

            // console.log(excelData);
        };

        reader.readAsArrayBuffer(file);
        // reset input
        $(this).val('');
    });


    async function SubmitNewEmployeeImport() {

        if (!employeeTable) {
            alert("Please import excel first");
            return;
        }
        let employeeData = employeeTable.getData();
        if (employeeData.length === 0) {
            alert("No data available");
            return;
        }
        let total = employeeData.length;
        let success = 0;

        // reset progress
        $("#importProgressWrapper").show();
        $("#importProgressBar")
            .css("width", "0%")
            .text("0%");

        $("#importProgressText")
            .text(`Processed 0 of ${total} data`);
        for (let i = 0; i < total; i++) {
            let item = employeeData[i];
            updateRowStatus(
                item.__rowNum__,
                "<span class='badge bg-warning text-dark'>Uploading...</span>"
            );
            try {
                await sendAjax(item);
                success++;
                updateRowStatus(
                    item.__rowNum__,
                    "<span class='badge bg-success text-white'>Success</span>"
                );
            } catch (err) {
                let errorMessage = 'Unknown error';
                if (err.responseJSON) {
                    // ambil validation errors
                    if (err.responseJSON.errors) {
                        errorMessage = err.responseJSON.errors
                            .map(e => e.message)
                            .join(', ');
                    }
                    // fallback message
                    else if (err.responseJSON.message) {
                        errorMessage = err.responseJSON.message;
                    }

                } else if (err.statusText) {
                    errorMessage = err.statusText;
                }
                updateRowStatus(
                    item.__rowNum__,
                    `<span class='badge bg-danger text-white'>
                        Failed : ${errorMessage}
                    </span>`
                );
                console.error(errorMessage);
            }
            // update progress
            let percent = Math.round(((i + 1) / total) * 100);
            $("#importProgressBar")
                .css("width", percent + "%")
                .text(percent + "%");
            $("#importProgressText")
                .text(`Processed ${i + 1} of ${total} data`);
        }
        showAlert(`Import selesai. Success ${success}/${total}`, 'success');
    }


    function updateRowStatus(__rowNum__, statusHtml) {
        if (!employeeTable) return;
        let rowComponent = employeeTable.getRows().find(r => {
            let d = r.getData();
            return d.__rowNum__ === __rowNum__;
        });

        if (rowComponent) {
            rowComponent.update({
                status: statusHtml
            });
        }
    }


    function sendAjax(employeeData) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("employees.import.submit") }}',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    employee_data: employeeData
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


    function actionFormatter(cell) {
        return `<button type="button" onclick="Crud('update', '${cell.getRow().getData().employee_id}')" class="btn btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" onclick="Crud('delete', '${cell.getRow().getData().employee_id}')" class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        `;
    }
</script>
@endpush