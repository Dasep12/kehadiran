<style>
    /* Memberi warna latar belakang tipis pada cell yang sedang dalam mode update */
    .tabulator-cell[aria-editing="true"] {
        background-color: #fff9c4 !important;
    }

    /* Opsional: memberi tanda visual pada cell yang bisa diedit */
    .tabulator-row[data-status="update"] .tabulator-cell[tabulator-field="amount"] {
        border-bottom: 2px dashed #007bff;
    }
</style>

<div class="offcanvas offcanvas-end scroll" id="offcanvasEnd">
    <form id="form-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">Crud Education</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">ID</label>
                    <div class="col">
                        <input type="text" name="id" id="id" class="form-control">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Workflow Name</label>
                    <div class="col">
                        <input type="text" name="workflow_name" id="workflow_name" class="form-control" aria-describedby="emailHelp" placeholder="Enter Group Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Module Type</label>
                    <div class="col">
                        <select name="module_type" id="module_type" class="form-control" aria-describedby="emailHelp" placeholder="Enter Membership ID">
                            <option value="">Select Module Type</option>
                            <option value="OVERTIME">OVERTIME</option>
                            <option value="LEAVE">LEAVE</option>
                            <option value="PERMIT">PERMIT</option>
                        </select>
                    </div>
                </div>


                <div class="mb-3 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col d-flex gap-3">
                        <label class="form-check form-switch">
                            <input name="is_active" id="is_active" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Actived</span>
                        </label>
                    </div>
                </div>


                <div class="mb-3 row">
                    <a href="#" onclick="CrudDetail('create','','')" class="text-primary mb-2">Add New <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-library-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18.333 2a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667 -3.667zm-4.333 4a1 1 0 0 0 -1 1v2h-2a1 1 0 0 0 0 2h2v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 0 0 -2h-2v-2a1 1 0 0 0 -1 -1" />
                            <path d="M3.517 6.391a1 1 0 0 1 .99 1.738c-.313 .178 -.506 .51 -.507 .868v10c0 .548 .452 1 1 1h10c.284 0 .405 -.088 .626 -.486a1 1 0 0 1 1.748 .972c-.546 .98 -1.28 1.514 -2.374 1.514h-10c-1.652 0 -3 -1.348 -3 -3v-10.002a3 3 0 0 1 1.517 -2.605" />
                        </svg></a>
                    <div id="workflow-approval-detail" class="mb-3"></div>
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
            <div id="Crud-ErrorInfo"></div>
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="crud-action" value="">

</div>

@include('coredata.partials.modal-workflow');
@push('scripts')

<script>
    function Crud(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud').reset();
        $('#form-crud').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#id').attr('readonly', false); // ID biasanya selalu readonly
        $('#is_active').prop('disabled', true);
        $('#crud-action').val(action);
        $('#Crud-ErrorInfo').html(''); // Reset error info
        $('#offcanvasEnd').offcanvas('show');
        if (id !== '*') {
            let data = table.getRow(id).getData();
            $("#id").val(data.id);
            $("#module_type").val(data.module_type);
            $('#workflow_name').val(data.workflow_name);
            $("#is_active").attr("checked", data.is_active === 1)
        }
        reloadTableDetail();
        switch (action) {
            case 'create':
                $('#id').attr('readonly', true);
                $('#offcanvasEndLabel').text('Create Workflow Approval');
                break;

            case 'update':
                $('#is_active').prop('disabled', false);
                $('#id').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndLabel').text('Edit Workflow Approval');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Workflow Approval');
                $('#Crud-ErrorInfo').html(`<div class="col-md-12 p-1">
                    <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                <path d="M12 9v4"></path>
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="alert-heading">Warning !</h4>
                            <div class="alert-description">Data will be deleted permanently.</div>
                        </div>
                    </div>
                </div>`);
                // Matikan semua input untuk konfirmasi hapus
                $('#form-crud input').attr('readonly', true);
                $('#form-crud select').attr('disabled', true);

                break;
        }
    }

    function loadMembership() {
        $.ajax({
            url: "{{ route('sallaryTax.ListMemberhsipJson') }}",
            method: "GET",
            cache: false,
            data: {
                is_membership: 1
            },
            success: function(response) {
                let options = '<option value="">Select Memberhsip</option>';
                response.forEach(function(membership) {
                    options += `<option data-code="${membership.allowance_code}" data-calc_for="${membership.calc_for}" value="${membership.id}">${membership.allowance_name}</option>`;
                });
                $('#membership_id').html(options);
            }
        })
    }
    loadMembership();



    var activeCell = null;

    function isEditableRow(data) {
        return data.edit_mode === true && data.action !== "delete";
    }

    function canEditEmployee(cell) {
        let data = cell.getRow().getData();
        return isEditableRow(data) && ["SPECIFIC_EMPLOYEE", "ORGANIZATION_HEAD", "DIRECT_MANAGER"].includes(data.approver_type);
    }

    function canEditOrgPos(cell) {
        let data = cell.getRow().getData();
        return isEditableRow(data) &&
            data.approver_type === "SAME_DEPT_POSITION";
    }

    function statusFormatter(cell) {
        let val = cell.getValue();

        switch (val) {
            case "new":
                return "<span class='badge bg-success text-white'>NEW</span>";
            case "update":
                return "<span class='badge bg-primary text-white'>UPDATE</span>";
            case "delete":
                return "<span class='badge bg-danger text-white'>REMOVE</span>";
            default:
                return "";
        }
    }

    function approverFormatter(cell) {
        let val = cell.getValue();

        const map = {
            DIRECT_MANAGER: "<span class='badge bg-info text-white'>DIRECT MANAGER</span>",
            ORGANIZATION_HEAD: "<span class='badge bg-secondary text-white'>ORGANIZATION HEAD</span>",
            SPECIFIC_EMPLOYEE: "<span class='badge bg-success text-white'>SPECIFIC EMPLOYEE</span>",
            SAME_DEPT_POSITION: "<span class='badge bg-warning text-dark'>SAME DEPT POSITION</span>"
        };

        return map[val] || "-";
    }

    function actionFormatterDetail(cell) {
        let rowData = cell.getRow().getData();

        if (rowData.action === "delete") {
            return `
            <button type="button"
                class="btn btn-sm btn-outline-secondary"
                onclick="CrudDetail('undo','${rowData.id}')">
                Undo
            </button>
        `;
        }

        return `
        <button type="button"
            class="btn btn-sm btn-outline-danger"
            onclick="CrudDetail('delete','${rowData.id}')">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    `;
    }

    var tableDetail = new Tabulator("#workflow-approval-detail", {
        ajaxURL: "{{ route('coredata.getWorkflowApprovalDetail') }}",
        ajaxConfig: "GET",
        ajaxParams: {
            workflow_id: $("#workflow_id").val()
        },
        layout: "fitColumns",
        responsiveLayout: false,
        height: "250px",
        index: "id",
        dataTree: true,
        dataTreeStartExpanded: false,

        columns: [{
                title: "Action",
                field: "option",
                formatter: actionFormatterDetail,
                width: 100,
                frozen: true,
                hozAlign: "center",
                headerSort: false
            },
            {
                title: "Status",
                field: "status",
                width: 100,
                formatter: statusFormatter,
                headerSort: false
            },
            {
                title: "action",
                field: "action",
                visible: false
            },
            {
                title: "id",
                field: "id",
                visible: false
            },
            {
                title: "Type",
                field: "approver_type",
                width: 220,
                editor: "list",
                editable: function(cell) {
                    return isEditableRow(cell.getRow().getData());
                },
                editorParams: {
                    values: [
                        "DIRECT_MANAGER",
                        "ORGANIZATION_HEAD",
                        "SPECIFIC_EMPLOYEE",
                        "SAME_DEPT_POSITION"
                    ],
                    clearable: true
                },
                headerSort: false,
                formatter: approverFormatter,
                cellEdited: function(cell) {
                    cell.getRow().update({
                        employee_name: "",
                        target_employee_id: "",
                        organization_name: "",
                        target_organization_id: "",
                        position_name: "",
                        target_position_id: ""
                    });
                }
            },
            {
                title: "Step",
                field: "step_level",
                editor: "number",
                editable: function(cell) {
                    return isEditableRow(cell.getRow().getData());
                },
                width: 60,
                headerSort: false
                // visible: false
            },
            {
                title: "Employee",
                field: "target_employee_id",
                visible: false
            },
            {
                title: "Position",
                field: "target_position_id",
                visible: false
            },
            {
                title: "Organization",
                field: "target_organization_id",
                visible: false
            },
            {
                title: "Employee",
                field: "employee_name",
                headerSort: false,
                width: 150,
                cellClick: function(e, cell) {
                    if (!canEditEmployee(cell)) return;
                    activeCell = cell;
                    let rowData = cell.getRow().getData();
                    $("#employee_id_workflow").val(rowData.id || "");
                    $("#modal-employee").modal("show");
                }
            },
            {
                title: "Organization",
                field: "organization_name",
                headerSort: false,
                width: 150,
                cellClick: function(e, cell) {
                    if (!canEditOrgPos(cell)) return;
                    activeCell = cell;
                    $("#modal-organization").modal("show");
                },
                visible: false
            },
            {
                title: "Position",
                field: "position_name",
                headerSort: false,
                width: 150,
                cellClick: function(e, cell) {
                    if (!canEditOrgPos(cell)) return;
                    activeCell = cell;
                    $("#modal-position").modal("show");
                },
                visible: false
            }
        ]
    });

    function reloadTableDetail() {
        tableDetail.setData(
            "{{ route('coredata.getWorkflowApprovalDetail') }}", {
                workflow_id: $("#id").val(),
                search: $("#search-input").val()
            }
        );
    }

    function CrudDetail(action, id) {

        if (action === "create") {

            tableDetail.addRow({
                id: "NEW_" + Date.now(),
                workflow_id: $("#id").val(),
                step_level: "",
                approver_type: "",
                target_employee_id: "",
                target_position_id: "",
                target_organization_id: "",
                employee_name: "",
                position_name: "",
                organization_name: "",
                status: "new",
                action: "create",
                edit_mode: true
            });

            return;
        }

        let row = tableDetail.getRow(id);

        if (!row) {
            console.warn("Row tidak ditemukan :", id);
            return;
        }

        if (action === "update") {

            let data = row.getData();

            row.update({
                edit_mode: true,
                action: data.action === "create" ? "create" : "update",
                status: data.status === "new" ? "new" : "update"
            });

            setTimeout(function() {
                try {
                    row.getCell("approver_type").edit(true);
                } catch (e) {
                    console.log(e);
                }
            }, 100);
        }

        if (action === "delete") {

            row.update({
                edit_mode: false,
                action: "delete",
                status: "delete"
            });
        }

        if (action === "undo") {

            let data = row.getData();

            row.update({
                edit_mode: true,
                action: data.id.toString().startsWith("NEW_") ? "create" : "update",
                status: data.id.toString().startsWith("NEW_") ? "new" : "update"
            });
        }
    }

    function selectEmployee(empId, empName) {

        if (!activeCell) return;

        let row = activeCell.getRow();

        row.update({
            target_employee_id: empId,
            employee_name: empName
        });

        $("#modal-cari-karyawan").modal("hide");
        activeCell = null;
    }

    function selectOrganization(orgId, orgName) {

        if (!activeCell) return;

        let row = activeCell.getRow();

        row.update({
            target_organization_id: orgId,
            organization_name: orgName
        });

        $("#modal-cari-org").modal("hide");
        activeCell = null;
    }

    function selectPosition(posId, posName) {

        if (!activeCell) return;

        let row = activeCell.getRow();

        row.update({
            target_position_id: posId,
            position_name: posName
        });

        $("#modal-cari-pos").modal("hide");
        activeCell = null;
    }



    $('#form-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crud-action').val();
        let url = '{{ route("coredata.CrudWorkflowApproval") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            workflow_name: $('#workflow_name').val(),
            module_type: $('#module_type').val(),
            is_active: $('#is_active').is(':checked') ? 1 : 0,
            action: action,
            detail: JSON.stringify(tableDetail.getData()),
            _token: '{{ csrf_token() }}'
        };

        // console.log(formData);
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, response.status);
                    $('#offcanvasEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTable();

                } else {
                    $('#Crud-ErrorInfo').html(`<div class="col-md-12 p-1">
                        <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M12 9v4"></path>
                                    <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-heading">Error !</h4>
                                <div class="alert-description">${response.message}</div>
                            </div>
                        </div>
                    </div>`);
                }
            },
            error: function(xhr) {
                $('#Crud-ErrorInfo').html(`<div class="col-md-12 p-1">
                    <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                <path d="M12 9v4"></path>
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="alert-heading">Error !</h4>
                            <div class="alert-description">${xhr.responseJSON.message}</div>
                        </div>
                    </div>
                </div>`);
            }
        });
    });
</script>
@endpush