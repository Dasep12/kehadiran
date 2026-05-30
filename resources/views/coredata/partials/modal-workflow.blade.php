<div class="modal modal-blur fade py-5" id="modal-employee" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="post" id="form-crud-employee">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Employee Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-flat w-auto mb-2">
                        <span class="input-group-text">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                        </span>
                        <input placeholder="Search Here..." id="search-employee-id" type="text" class="form-control" autocomplete="off">
                        <button type="button" onclick="reloadTableEmployee()" class="btn btn-icon" aria-label="Button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pointer-search">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14.778 12.222l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093" />
                                <path d="M15 18a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M20.2 20.2l1.8 1.8" />
                            </svg>
                        </button>
                    </div>

                    <input type="text" hidden name="employee_id_workflow" id="employee_id_workflow">
                    <div id="employee-index"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    var tableEmployee = new Tabulator("#employee-index", {
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
            status: '1'
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
                },
                cellClick: function(e, cell) {
                    let idx = $("#employee_id_workflow").val()
                    let row = tableDetail.getRow(idx);
                    let data = row.getData();
                    let employee = cell.getData();
                    row.update({
                        target_employee_id: employee.employee_id,
                        employee_name: employee.employee_name
                    });
                    $("#modal-employee").modal("hide");
                }
            }, {
                title: "No Regis",
                field: "employee_code",
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
            }
        ],
    });

    function reloadTableEmployee() {
        const search = document.getElementById("search-employee-id").value;

        tableEmployee.setData("{{ route('employees.getDataEmployee') }}", {
            search: search,
        });
    }
</script>
@endpush