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
                            <div class="d-flex  gap-3 justify-content-center">
                                <select name="company_id" id="company_id" class="form-control mb-2 w-100">
                                    <option value="">Select Company</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <select name="period_id" id="period_id" class="form-control mb-2 w-100">
                                    <option value="">Select Period</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                            <div class="ms-auto d-flex flex-wrap btn-list">
                                <div class="input-group input-group-flat w-auto">
                                    <span class="input-group-text">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <input placeholder="Search Here..." id="search-input" type="text" class="form-control" autocomplete="off">
                                </div>

                                <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="reloadTable()" data-bs-target="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"> Refresh </button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Your allowances content here -->
                    <div class="grid-tables-tabulator" id="process-payroll-table"></div>

                    <div class="row">
                        <div class="col-12 mt-3 d-flex justify-content-start gap-2">
                            <button class="btn btn-primary" type="button" onclick="CrudCalucaltion()"><i class="ti ti-refresh"></i> Process Calculation </button>
                            <div class="dropdown">
                                <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">More Process</a>
                                <div class="dropdown-menu">
                                    <a id="btnExportExcel" class="dropdown-item" href="#">Close Payroll</a>
                                    <a id="btnExportExcel" class="dropdown-item" href="#">Export Data</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->
@push('scripts')
<script>
    function loadPeriod() {
        $.ajax({
            url: "{{ route('sallaryTax.getPayPeriodsData') }}",
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Period</option>';
                response.forEach(function(period) {
                    options += `<option value="${period.period_id}">${period.period_name}</option>`;
                });
                $('#period_id').html(options);
                $('#period_process_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching periods:', xhr);
            }
        });
    }

    function loadCompany() {
        $.ajax({
            url: "{{ route('coredata.getSubCompanyData') }}",
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Company</option>';
                response.forEach(function(company) {
                    options += `<option value="${company.company_id}">${company.company_name}</option>`;
                });
                $('#company_id').html(options);
                $('#company_process_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching companies:', xhr);
            }
        });
    }

    // Load periods when the page loads
    $(document).ready(function() {
        loadPeriod();
        loadCompany();
    });

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    var table = new Tabulator("#process-payroll-table", {
        ajaxURL: "{{ route('payroll.getPayrollProcessData') }}",
        ajaxConfig: "GET",
        layout: "fitColumns",
        responsiveLayout: false,
        height: "450px",
        ajaxParams: {
            search: "",
        },
        // WAJIB ADA
        groupBy: "employee_code",
        groupStartOpen: true,
        groupHeader: function(value, count, data, group) {
            let employeeName = data[0].employee_name;
            let gross = 0;
            let netIncome = 0;
            let deduction = 0;
            data.forEach(item => {
                let amount = parseFloat(item.amount) || 0;
                // GROSS INCOME (emp + comp income)
                if (
                    item.type == '+' &&
                    (item.calc_for == 'emp' || item.calc_for == 'comp')
                ) {
                    gross += amount;
                }

                // NET INCOME (hanya emp income)
                if (
                    item.type == '+' &&
                    item.calc_for == 'emp'
                ) {
                    netIncome += amount;
                }

                // DEDUCTION
                if (
                    item.type == '-' &&
                    item.calc_for == 'emp'
                ) {
                    deduction += amount;
                }
            });

            let takeHomePay = netIncome - deduction;
            return `<div style="padding:10px; background:#f8f9fa;
            border-radius:6px;width:100%;">

            <div class="fw-bold mb-1">
                ${value} - ${employeeName}
                <span class="text-muted">
                    (${count} items)
                </span>
            </div>

            <div style="display:flex;gap:30px;font-size:13px;margin-top:5px;
                flex-wrap:wrap;">

                <div>
                    <span class="fw-bold text-dark">
                        Gross :
                    </span>
                    Rp ${formatRupiah(gross)}
                </div>

                <div>
                    <span class="fw-bold text-success">
                        Net Income :
                    </span>
                    Rp ${formatRupiah(netIncome)}
                </div>

                <div>
                    <span class="fw-bold text-danger">
                        Deduction :
                    </span>

                    Rp ${formatRupiah(deduction)}
                </div>

                <div>
                    <span class="fw-bold text-primary">
                        Take Home Pay :
                    </span>

                    Rp ${formatRupiah(takeHomePay)}
                </div>
            </div>
        </div>`;
        },

        columns: [{
                title: "Employee Code",
                field: "employee_code",
                width: 150,
            },
            {
                title: "Employee Name",
                field: "employee_name",
                minWidth: 220,
            },
            {
                title: "Salary Name",
                field: "allowance_name",
                minWidth: 220,
            },

            {
                title: "Amount",
                field: "amount",
                formatter: "money",
                formatterParams: {
                    decimal: ".",
                    thousand: ",",
                    symbol: "Rp ",
                    precision: 0,
                },
                hozAlign: "right"
            },
            {
                title: "Type",
                field: "type",
                width: 100,
                hozAlign: "center",
                formatter: function(cell, formatterParams) {
                    let value = cell.getValue();
                    if (value === '+') {
                        return `<span class="badge text-white bg-success">Income</span>`;
                    } else if (value === '-') {
                        return `<span class="badge text-white bg-danger">Deduction</span>`;
                    } else {
                        return value;
                    }
                }
            },
            {
                title: "For",
                field: "calc_for",
                width: 100,
            }
        ]
    });

    function formatRupiah(number) {

        return new Intl.NumberFormat('id-ID').format(number);
    }

    function reloadTable() {
        const search = document.getElementById("search-input").value;
        const company_id = document.getElementById("company_id").value;
        const period_id = document.getElementById("period_id").value;
        table.setData("{{ route('payroll.getPayrollProcessData') }}", {
            search: search,
            company_id: company_id,
            period_id: period_id,
        });
    }
</script>
@endpush

@include('payroll.partials.crud-payroll-process');
@endsection