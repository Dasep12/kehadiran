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

<div class="offcanvas offcanvas-end" id="offcanvasOvertimeGroupEnd">
    <form id="form-overtime-group-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasOvertimeGroupEndLabel">Crud Education</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required"> ID</label>
                    <div class="col">
                        <input type="text" name="id" id="group_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Group Name</label>
                    <div class="col">
                        <input type="text" name="group_name" id="group_name" class="form-control" aria-describedby="emailHelp" placeholder="Enter Group Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <a href="#" onclick="CrudDetailOvertimeGroup('create','','')" class="text-primary mb-2">Add New <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-library-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18.333 2a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667 -3.667zm-4.333 4a1 1 0 0 0 -1 1v2h-2a1 1 0 0 0 0 2h2v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 0 0 -2h-2v-2a1 1 0 0 0 -1 -1" />
                            <path d="M3.517 6.391a1 1 0 0 1 .99 1.738c-.313 .178 -.506 .51 -.507 .868v10c0 .548 .452 1 1 1h10c.284 0 .405 -.088 .626 -.486a1 1 0 0 1 1.748 .972c-.546 .98 -1.28 1.514 -2.374 1.514h-10c-1.652 0 -3 -1.348 -3 -3v-10.002a3 3 0 0 1 1.517 -2.605" />
                        </svg></a>
                    <div id="grid-overtime-group-detail" class="mb-3"></div>
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
            <div id="CrudOvertimeGroup-ErrorInfo"></div>
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="CrudOvertimeGroup-action" value="">

</div>

@push('scripts')
<script>
    function CrudOvertimeGroup(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-overtime-group-crud').reset();
        $('#form-overtime-group-crud').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#CrudOvertimeGroup-action').val(action);
        $('#CrudOvertimeGroup-ErrorInfo').html(''); // Reset error info
        $('#offcanvasOvertimeGroupEnd').offcanvas('show');

        if (id !== '*') {
            let data = tableOvertimeGroup.getRow(id).getData();
            $("#group_id").val(data.id);
            $("#group_name").val(data.group_name);
        }
        $('#group_id').attr('disabled', true);
        reloadTableDetailOvertimeGroup();
        switch (action) {
            case 'create':
                $('#offcanvasOvertimeGroupEndLabel').text('Create Overtime Group');
                break;

            case 'update':
                $('#group_id').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#offcanvasOvertimeGroupEndLabel').text('Edit Overtime Group');
                break;

            case 'delete':
                $('#offcanvasOvertimeGroupEndLabel').text('Delete Overtime Group');
                $('#CrudOvertimeGroup-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#form-overtime-group-crud input').attr('readonly', true);
                $('#form-overtime-group-crud select').attr('disabled', true);

                break;
        }
    }

    function loadGroupShift() {
        $.ajax({
            url: "{{ route('worktime.getShiftGroupData') }}",
            method: "GET",
            cache: false,
            data: {},
            success: function(response) {
                let options = '<option value="">Select Group Shift</option>';
                response.forEach(function(groupShift) {
                    options += `<option value="${groupShift.shift_group_id}">${groupShift.shift_group_name}</option>`;
                });
                $('#shift_group_id_pattern').html(options);
            }
        })
    }

    let RuleOptions = {};

    function loadRuleOptions() {
        return $.ajax({
            url: "{{ route('worktime.getOvertimeRuleData') }}",
            method: "GET",
            success: function(response) {
                RuleOptions = {};

                response.forEach(function(item) {
                    RuleOptions[item.id] = {
                        label: item.rule_name,
                        overtime_type: item.overtime_type,
                        working_day_type: item.overtime_category
                    };
                });
            }
        });
    }
    $(document).ready(function() {
        loadGroupShift();
        loadRuleOptions()
    });



    // Fungsi helper untuk mengecek apakah baris boleh diedit
    var editCheck = function(cell) {
        var data = cell.getRow().getData();
        // 🔥 Cek field edit_mode, bukan status HTML string
        return data.edit_mode === true;
    };
    var tableDetailOvertimeGroup = new Tabulator("#grid-overtime-group-detail", {
        ajaxURL: "{{ route('worktime.getOvertimeGroupDetailData') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 ajax param (filter support)
        ajaxParams: {
            group_id: $("#group_id").val() // kirim membership_id untuk filter data detail,
        },
        // 🔥 layout fix (penting)
        // layout: "fitColumns",
        layout: "fitData",
        responsiveLayout: false, // disable hide/collapse → pakai scroll
        height: "200px",
        // 🔥 pagination
        // pagination: "local",
        // paginationSize: 10,
        // paginationSizeSelector: [10, 25, 50, 100],
        index: "detail_id",
        dataTree: true,
        dataTreeStartExpanded: false,
        columns: [{
                title: "Action",
                field: 'option',
                formatter: actionFormatterDetailOTGroup,
                width: 120,
                frozen: true,
                hozAlign: "center",
            }, {
                title: "id",
                field: "detail_id",
                visible: false
            }, {
                title: "group_id",
                field: "group_id",
                visible: false
            }, {
                title: "Status",
                field: "status",
                width: 100,
                formatter: "html",
            }, {
                title: "rule",
                field: "rule_id",
                editor: "list",
                editable: editCheck,
                editorParams: function(cell) {
                    return {
                        values: Object.fromEntries(
                            Object.entries(RuleOptions).map(([key, val]) => [key, val.label])
                        )
                    };
                },
                formatter: function(cell) {
                    let value = cell.getValue();
                    return RuleOptions[value]?.label || "";
                },
                cellEdited: function(cell) {
                    let value = cell.getValue();
                    let row = cell.getRow();

                    let rule = RuleOptions[value];

                    if (rule) {
                        row.update({
                            overtime_type: rule.overtime_type,
                            working_day_type: rule.working_day_type
                        });
                    }
                }
            },
            {
                title: "Overtime Type",
                field: "overtime_type"
            }, {
                title: "Day Type",
                field: "working_day_type",
                hozAlign: "center"
            },
            {
                title: "action",
                field: "action",
                visible: false
            }

        ]
    });

    function actionFormatterDetailOTGroup(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var detail_id = rowData.detail_id;
        return `<button type="button" 
            onclick="CrudDetailOvertimeGroup('update', '${detail_id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudDetailOvertimeGroup('delete','${detail_id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function reloadTableDetailOvertimeGroup() {
        const search = document.getElementById("search-input").value;
        tableDetailOvertimeGroup.setData("{{ route('worktime.getOvertimeGroupDetailData') }}", {
            // search: search,
            group_id: $("#group_id").val()
        });
    }

    function CrudDetailOvertimeGroup(action, id) {


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableDetailOvertimeGroup.addRow({
                    group_id: $("#group_id").val(), // ambil group_id dari form
                    rule_id: '',
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {
                    // 🔥 Setelah row ditambah, langsung fokus ke cell amount
                    setTimeout(() => {
                        // row.getCell(",max_amount").edit();
                    }, 50);
                });
            // return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableDetailOvertimeGroup.getRows().find(r => {
            let d = r.getData();
            return d.detail_id == id;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", id);
            return;
        }

        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                action: 'update',
                status: "<span class='badge bg-primary text-white'>update</span>"
            }).then(function() {
                // ✅ Dijamin edit_mode sudah true sebelum edit() dipanggil
                try {
                    rowComponent.getCell("calculation_type").edit(true);
                } catch (e) {
                    console.warn("Fallback ke value:", e.message);
                    try {
                        rowComponent.getCell("value").edit(true);
                    } catch (e2) {}
                }
            });

        } else if (action === 'delete') {
            rowComponent.update({
                edit_mode: false,
                action: 'delete',
                status: "<span class='badge bg-danger text-white'>remove</span>"
            });
        }
    }


    $('#form-overtime-group-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#CrudOvertimeGroup-action').val();
        let url = '{{ route("worktime.CrudOvertimeGroup") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            group_name: $('#group_name').val(),
            action: action,
            detail: JSON.stringify(tableDetailOvertimeGroup.getData()),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    showAlert(response.message, response.status);
                    $('#offcanvasOvertimeGroupEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTableOvertimeGroup();

                } else {
                    $('#CrudOvertimeGroup-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudOvertimeGroup-ErrorInfo').html(`<div class="col-md-12 p-1">
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