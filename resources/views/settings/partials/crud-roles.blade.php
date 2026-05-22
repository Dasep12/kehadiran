<div class="offcanvas offcanvas-end" id="offcanvasEnd">
    <form id="form-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">Crud Education</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">
                <input type="text" hidden name="id" id="id">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Role Name</label>
                    <div class="col">
                        <input type="text" name="role_name" id="role_name" class="form-control" aria-describedby="educationHelp" placeholder="Enter name">
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
                <div id="permissions-menu"></div>
                <div class="text-end mt-1">
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

@push('scripts')
<script>
    var tableMenuPermissions = new Tabulator("#permissions-menu", {
        ajaxURL: "{{ route('settings.MenuPermissions') }}", // endpoint Laravel
        ajaxConfig: "GET",
        layout: "fitColumns",
        responsiveLayout: "hide",
        // pagination: "local",
        responsiveLayout: "collapse",
        responsiveLayoutCollapseStartOpen: false,
        // pagination: "remote",
        height: '420',
        index: 'id',
        columns: [{
                title: "ID",
                field: "id",
                width: 150,
                visible: false
            },
            {
                title: "Name",
                field: "menu_name",
                headerSort: false,
                width: 230,
                formatter: function(cell) {
                    let row = cell.getRow().getData();
                    let level = row.level || 0;
                    let indent = '';
                    for (let i = 0; i < level; i++) {
                        indent += '&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    let icon = row.menu_icon ?
                        `<i class="${row.menu_icon}"></i>` :
                        `<i class="ti ti-folder"></i>`;
                    return `
                        ${indent}
                        ${level > 0 ? '└ ' : ''}
                        ${icon}
                        ${row.menu_name}
                    `;
                }
            },
            {
                title: "C",
                field: "can_create",
                formatter: "tickCross",
                editor: true,
                hozAlign: "center",
                width: 90,
                headerSort: false,
                titleFormatter: function() {
                    return `<div class="d-flex justify-content-center">C<input type="checkbox" class="form-check-input check-all-create"></div> `;
                },
                headerClick: function(e, column) {
                    let checked = column.getCells().every(c => c.getValue());
                    let newValue = !checked;
                    column.getCells().forEach(cell => {
                        cell.setValue(newValue);
                    });
                    setTimeout(() => {
                        document.querySelector(".check-all-create").checked = newValue;
                    }, 10);
                }
            },
            {
                title: "R",
                field: "can_view",
                headerSort: false,
                formatter: "tickCross",
                editor: true,
                titleFormatter: function() {
                    return `<div class="d-flex justify-content-center">R<input type="checkbox" class="form-check-input check-all-view"></div> `;
                },
                headerClick: function(e, column) {
                    let checked = column.getCells().every(c => c.getValue());
                    let newValue = !checked;
                    column.getCells().forEach(cell => {
                        cell.setValue(newValue);
                    });
                    setTimeout(() => {
                        document.querySelector(".check-all-view").checked = newValue;
                    }, 10);
                }
            },
            {
                title: "U",
                field: "can_edit",
                formatter: "tickCross",
                editor: true,
                headerSort: false,
                titleFormatter: function() {
                    return `<div class="d-flex justify-content-center">U<input type="checkbox" class="form-check-input check-all-edit"></div> `;
                },
                headerClick: function(e, column) {
                    let checked = column.getCells().every(c => c.getValue());
                    let newValue = !checked;
                    column.getCells().forEach(cell => {
                        cell.setValue(newValue);
                    });
                    setTimeout(() => {
                        document.querySelector(".check-all-edit").checked = newValue;
                    }, 10);
                }
            },
            {
                title: "D",
                field: "can_delete",
                formatter: "tickCross",
                editor: true,
                headerSort: false,
                titleFormatter: function() {
                    return `<div class="d-flex justify-content-center">D<input type="checkbox" class="form-check-input check-all-delete"></div> `;
                },
                headerClick: function(e, column) {
                    let checked = column.getCells().every(c => c.getValue());
                    let newValue = !checked;
                    column.getCells().forEach(cell => {
                        cell.setValue(newValue);
                    });
                    setTimeout(() => {
                        document.querySelector(".check-all-delete").checked = newValue;
                    }, 10);
                }
            }
        ],
    });

    function reloadTablePermissions() {
        const id = document.getElementById("id").value;

        tableMenuPermissions.setData("{{ route('settings.MenuPermissions') }}", {
            formAction: $("#crud-action").val(),
            id: id
        });
    }

    function Crud(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud').reset();
        $('#form-crud').find('input, select').attr('readonly', false).attr('disabled', false);

        $('#crud-action').val(action);
        $('#Crud-ErrorInfo').html(''); // Reset error info
        $('#offcanvasEnd').offcanvas('show');
        if (id !== '*') {
            let data = table.getRow(id).getData();
            $('#id').val(data.id);
            $('#role_name').val(data.role_name);
            $('#is_active').prop('checked', data.is_active === 1);
        }
        reloadTablePermissions()
        switch (action) {
            case 'create':
                $('#offcanvasEndLabel').text('Create Role');
                break;

            case 'update':
                $('#offcanvasEndLabel').text('Edit Role');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Role');
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



    $('#form-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crud-action').val();
        let url = '{{ route("settings.CrudRoles") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            role_name: $('#role_name').val(),
            is_active: $('#is_active').is(':checked') ? 1 : 0,
            action: action,
            permissions: JSON.stringify(tableMenuPermissions.getData()),
            _token: '{{ csrf_token() }}'
        };
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
                console.error('Error submitting form:', xhr.responseJSON);
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