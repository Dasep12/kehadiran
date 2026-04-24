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

<div class="offcanvas offcanvas-end" id="offcanvasOvertimeRuleEnd">
    <form id="form-overtime-rule-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasOvertimeRuleEndLabel">Crud Education</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="overflow-y: auto; max-height: 250vh;">
            <div id="content-crud">

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">ID</label>
                    <div class="col">
                        <input type="text" name="id" id="id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>


                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Rule Name</label>
                    <div class="col">
                        <input type="text" name="rule_name" id="rule_name" class="form-control" aria-describedby="emailHelp" placeholder="Enter Rule Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Min Overtime</label>
                    <div class="col">
                        <input type="number" name="min_minutes" id="min_minutes" class="form-control" aria-describedby="emailHelp" placeholder="Enter Max Overtime (Minutes)">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Max Overtime</label>
                    <div class="col">
                        <input type="number" name="max_minutes" id="max_minutes" class="form-control" aria-describedby="emailHelp" placeholder="Enter Max Overtime (Minutes)">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Allowance</label>
                    <div class="col">
                        <select name="salary_allowance_id" id="salary_allowance_id" class="form-control" aria-describedby="typeHelp" placeholder="Enter type for">
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Fixed Amount</label>
                    <div class="col">
                        <input type="text" name="fixed_amount" id="fixed_amount" class="form-control" aria-describedby="emailHelp" placeholder="Enter Fixed Amount">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Type</label>
                    <div class="col">
                        <select name="overtime_type" id="overtime_type" class="form-control" aria-describedby="typeHelp" placeholder="Enter type for">
                            <option value="">Select Type</option>
                            <option value="REGULAR">REGULAR</option>
                            <option value="FIXED">FIXED</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Category</label>
                    <div class="col">
                        <select name="overtime_category" id="overtime_category" class="form-control" aria-describedby="typeHelp" placeholder="Enter type for">
                            <option value="">Select Type</option>
                            <option>HOLIDAY</option>
                            <option>WORKDAY</option>
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
                    <a href="#" onclick="CrudDetailOvertimeRate('create','','')" class="text-primary mb-2">Add New <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-library-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18.333 2a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667 -3.667zm-4.333 4a1 1 0 0 0 -1 1v2h-2a1 1 0 0 0 0 2h2v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 0 0 -2h-2v-2a1 1 0 0 0 -1 -1" />
                            <path d="M3.517 6.391a1 1 0 0 1 .99 1.738c-.313 .178 -.506 .51 -.507 .868v10c0 .548 .452 1 1 1h10c.284 0 .405 -.088 .626 -.486a1 1 0 0 1 1.748 .972c-.546 .98 -1.28 1.514 -2.374 1.514h-10c-1.652 0 -3 -1.348 -3 -3v-10.002a3 3 0 0 1 1.517 -2.605" />
                        </svg></a>
                    <div id="workingtime-overtime-rate-crud" class="mb-3"></div>
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
            <div id="CrudOvertimeRule-ErrorInfo"></div>
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="CrudOvertimeRule-action" value="">

</div>

@push('scripts')
<script>
    function CrudOvertimeRule(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-overtime-rule-crud').reset();
        $('#form-overtime-rule-crud').find('input, select').attr('readonly', false).attr('disabled', false);

        $('#CrudOvertimeRule-action').val(action);
        $('#CrudOvertimeRule-ErrorInfo').html(''); // Reset error info
        $('#offcanvasOvertimeRuleEnd').offcanvas('show');
        if (id !== '*') {
            let data = tableOvertimeRule.getRow(id).getData();
            $("#id").val(data.id);
            $("#rule_name").val(data.rule_name);
            $('#overtime_type').val(data.overtime_type);
            $('#overtime_category').val(data.overtime_category);
            $('#min_minutes').val(data.min_minutes);
            $('#max_minutes').val(data.max_minutes);
            $('#fixed_amount').val(data.fixed_amount);
            $('#salary_allowance_id').val(data.salary_allowance_id);
            $('#is_active').prop('checked', data.is_active === 1);
        }
        $('#id').attr('disabled', true);
        reloadtableDetailOvertimeRate();
        switch (action) {
            case 'create':
                $('#offcanvasOvertimeRuleEndLabel').text('Create Shift Pattern');
                break;

            case 'update':
                $('#id').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#offcanvasOvertimeRuleEndLabel').text('Edit Shift Pattern');
                break;

            case 'delete':
                $('#offcanvasOvertimeRuleEndLabel').text('Delete Shift Pattern');
                $('#CrudOvertimeRule-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#form-overtime-rule-crud input').attr('readonly', true);
                $('#form-overtime-rule-crud select').attr('disabled', true);

                break;
        }
    }

    function loadAllowance() {
        $.ajax({
            url: "{{ route('sallaryTax.getAllowancesData') }}",
            method: "GET",
            cache: false,
            data: {},
            success: function(response) {
                let options = '<option value="">Select Group Shift</option>';
                response.forEach(function(allowance) {
                    options += `<option value="${allowance.id}">${allowance.allowance_name}</option>`;
                });
                $('#salary_allowance_id').html(options);
            }
        })
    }

    let overtimeRuleOptions = {}; // format: {id: "nama"}

    function loadOvertimeRuleOptions() {
        return $.ajax({
            url: "{{ route('worktime.getOvertimeRuleData') }}",
            method: "GET",
            success: function(response) {
                // asumsi response array
                // [{shift_id:1, shift_name:"Pagi"}, ...]
                overtimeRuleOptions = {};

                response.forEach(function(item) {
                    overtimeRuleOptions[item.id] = item.rule_name;
                });
            }
        });
    }
    $(document).ready(function() {
        loadAllowance();
        loadOvertimeRuleOptions()
    });



    // Fungsi helper untuk mengecek apakah baris boleh diedit
    var editCheck = function(cell) {
        var data = cell.getRow().getData();
        // 🔥 Cek field edit_mode, bukan status HTML string
        return data.edit_mode === true;
    };
    var tableDetailOvertimeRate = new Tabulator("#workingtime-overtime-rate-crud", {
        ajaxURL: "{{ route('worktime.getOvertimeRateData') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 ajax param (filter support)
        ajaxParams: {
            rule_id: $("#id").val() // kirim membership_id untuk filter data detail,
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
        index: "id",
        dataTree: true,
        dataTreeStartExpanded: false,
        columns: [{
                title: "Action",
                field: 'option',
                formatter: actionFormatterOvertimeRate,
                width: 120,
                frozen: true,
                hozAlign: "center",
            }, {
                title: "id",
                field: "id",
                visible: false
            }, {
                title: "rule_id",
                field: "rule_id",
                visible: false
            },
            {
                title: "Status",
                field: "status",
                width: 100,
                formatter: "html",
            },
            {
                title: "action",
                field: "action",
                visible: false
            },
            {
                title: "Rule",
                field: "rule_id",
                visible: false
                // editor: "list",
                // editable: editCheck,
                // editorParams: function(cell) {
                //     return {
                //         values: overtimeRuleOptions // ⬅️ dari AJAX
                //     };
                // },
                // formatter: function(cell) {
                //     let value = cell.getValue();
                //     return overtimeRuleOptions[value] || "";
                // }
            },
            {
                title: "FROM",
                field: "hour_from",
                editor: "input", // 🔥 WAJIB ada, sebelumnya tidak ada
                editable: editCheck,
                hozAlign: "center",
            },
            {
                title: "TO",
                field: "hour_to",
                editor: "input", // 🔥 WAJIB ada, sebelumnya tidak ada
                editable: editCheck,
                hozAlign: "center",
            },
            {
                title: "MULTIPLIER",
                field: "multiplier",
                editor: "input", // 🔥 WAJIB ada, sebelumnya tidak ada
                editable: editCheck,
                hozAlign: "center",
            }

        ]
    });

    function actionFormatterOvertimeRate(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var id = rowData.id;
        return `<button type="button" 
            onclick="CrudDetailOvertimeRate('update', '${id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudDetailOvertimeRate('delete','${id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function reloadtableDetailOvertimeRate() {
        const search = document.getElementById("search-input").value;

        tableDetailOvertimeRate.setData("{{ route('worktime.getOvertimeRateData') }}", {
            // search: search,
            rule_id: $("#id").val()
        });
    }

    function CrudDetailOvertimeRate(action, id) {


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableDetailOvertimeRate.addRow({
                    rule_id: $("#rule_id").val(), // ambil group_id dari form
                    hour_from: '',
                    hour_to: 0,
                    multiplier: 0,
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

        let rowComponent = tableDetailOvertimeRate.getRows().find(r => {
            let d = r.getData();
            return d.id == id;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", rule_id);
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



    $('#form-overtime-rule-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#CrudOvertimeRule-action').val();
        let url = '{{ route("worktime.CrudOvertimeRule") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            rule_name: $('#rule_name').val(),
            overtime_type: $('#overtime_type').val(),
            overtime_category: $('#overtime_category').val(),
            min_minutes: $('#min_minutes').val(),
            max_minutes: $('#max_minutes').val(),
            fixed_amount: $('#fixed_amount').val(),
            is_active: $('#is_active').is(':checked') ? 1 : 0,
            action: action,
            detail: JSON.stringify(tableDetailOvertimeRate.getData()),
            _token: '{{ csrf_token() }}'
        };

        console.log(formData);
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    showAlert(response.message, response.status);
                    $('#offcanvasOvertimeRuleEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTableOvertimeRule();

                } else {
                    $('#CrudOvertimeRule-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudOvertimeRule-ErrorInfo').html(`<div class="col-md-12 p-1">
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