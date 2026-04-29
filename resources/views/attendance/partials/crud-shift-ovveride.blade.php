<div class="offcanvas offcanvas-end" id="offcanvasOvverideEnd">
    <form id="form-crud-ovveride" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">Crud Education</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">ID</label>
                    <div class="col">
                        <input type="text" name="id_ovveride" id="id_ovveride" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Group Shift</label>
                    <div class="col">
                        <select class="form-control" name="shift_group_id_ovveride" id="shift_group_id_ovveride">
                            <option value="C">CUTI</option>
                            <option value="H">HADIR</option>
                            <option value="I">IZIN</option>
                            <option value="S">SAKIT</option>
                            <option value="M">MANGKIR</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Shift</label>
                    <div class="col">
                        <select class="form-control" name="shift_id_ovveride" id="shift_id_ovveride">
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Work Date</label>
                    <div class="col">
                        <input type="text" name="work_date" id="work_date" class="form-control date_picker" aria-describedby="educationHelp" placeholder="Enter Start Date">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col d-flex gap-3">
                        <label class="form-check form-switch">
                            <input name="is_work_ovveride" id="is_work_ovveride" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Working Day</span>
                        </label>
                    </div>
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

            <div id="shift-ovveride-table"></div>

            <div id="Crud-ErrorInfoOvveride"></div>
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="crud-action-ovveride" value="">

</div>

@push('scripts')
<script>
    function CrudShiftOvveride(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud-ovveride').reset();
        $('#form-crud-ovveride').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#id').attr('readonly', false); // ID biasanya selalu readonly

        $('#crud-action-ovveride').val(action);
        $('#Crud-ErrorInfoOvveride').html(''); // Reset error info
        $('#offcanvasOvverideEnd').offcanvas('show');
        if (id !== '*') {
            let data = table.getRow(id).getData();
            $('#id_ovveride').val(data.id);
        }
        tableDetail.replaceData();
        switch (action) {
            case 'create':
                $('#offcanvasEndLabel').text('Create Ovveride Shift');
                break;

            case 'update':
                $('#id_ovveride').attr('readonly', true); // ID tidak bisa diubah saat update
                $('#work_date').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#shift_id_ovveride').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#shift_group_id_ovveride').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndLabel').text('Edit Ovveride Shift');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Employee Shift');
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
                $('#form-crud-ovveride input').attr('disabled', true);
                $('#form-crud-ovveride select').attr('disabled', true);

                break;
        }
    }

    // Fungsi helper untuk mengecek apakah baris boleh diedit
    var editCheck = function(cell) {
        var data = cell.getRow().getData();
        // 🔥 Cek field edit_mode, bukan status HTML string
        return data.edit_mode === true;
    };
    var tableDetail = new Tabulator("#shift-ovveride-table", {
        ajaxURL: "{{ route('attendance.ShiftOvverideData') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 ajax param (filter support)
        ajaxParams: {},
        // 🔥 layout fix (penting)
        // layout: "fitColumns",
        layout: "fitData",
        responsiveLayout: false, // disable hide/collapse → pakai scroll
        height: "200px",
        // 🔥 pagination
        // pagination: "local",
        // paginationSize: 10,
        // paginationSizeSelector: [10, 25, 50, 100],
        index: "id",
        dataTree: true,
        dataTreeStartExpanded: false,
        columns: [{
                title: "Action",
                field: 'option',
                formatter: actionFormatterDetail,
                width: 120,
                frozen: true,
                hozAlign: "center",
            }, {
                title: "id",
                field: "id",
                visible: false
            }, {
                title: "shift_id",
                field: "shift_id",
                visible: false
            }, {
                title: "shift_group_id",
                field: "shift_group_id",
                visible: false
            },
            {
                title: "Status",
                field: "status",
                width: 100,
                formatter: "html",
                visible: false
            },
            {
                title: "action",
                field: "action",
                visible: false
            }, {
                title: "Group",
                field: "shift_group_name",
                width: 150,
            },
            {
                title: "Shift",
                field: "shift_name",
                width: 150,
            }, {
                title: "Working Day",
                field: "is_work",
                formatter: "tickCross",
                hozAlign: "center"
            },
            {
                title: "Work Date",
                field: "work_date",
                width: 150,
                editor: "date", // Ubah dari 'input' ke 'date' untuk date picker
                editable: editCheck, // Tambahkan ini
                formatter: "date",
                formatterParams: {
                    inputFormat: "yyyy-MM-dd",
                    outputFormat: "dd MMM yyyy",
                    invalidPlaceholder: "-"
                },
                hozAlign: "center"
            },

        ]
    });

    function actionFormatterDetail(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var id = rowData.id;
        return `
        <button type="button" 
            onclick="CrudDetail('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function reloadTableDetail() {
        const search = document.getElementById("search-input").value;

        tableDetail.setData("{{ route('attendance.ShiftOvverideData') }}", {
            search: search,
        });
    }

    function CrudDetail(action, id) {

        if (action === 'delete') {

            if (!confirm('Yakin mau hapus data ini?')) return;

            $.ajax({
                url: '{{ route("attendance.CrudOvveride") }}',
                method: 'POST',
                data: {
                    id: id,
                    action: 'delete',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, response.status);

                        // 🔥 reload table tanpa reset paging
                        tableDetail.replaceData();

                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert(xhr.responseJSON?.message || 'Terjadi kesalahan');
                }
            });
        }
    }

    $('#form-crud-ovveride').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crud-action-ovveride').val();
        let url = '{{ route("attendance.CrudOvveride") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            shift_group_id: $('#shift_group_id_ovveride').val(),
            work_date: $('#work_date').val(),
            shift_id: $('#shift_id_ovveride').val(),
            is_work: $('#is_work_ovveride').is(':checked') ? 1 : 0,
            action: action,
            _token: '{{ csrf_token() }}'
        };
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, response.status);
                    $('#offcanvasOvverideEnd').offcanvas('hide');
                } else {
                    $('#Crud-ErrorInfoOvveride').html(`<div class="col-md-12 p-1">
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
                $('#Crud-ErrorInfoOvveride').html(`<div class="col-md-12 p-1">
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