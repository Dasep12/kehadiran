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

<div class="offcanvas offcanvas-end" id="offcanvasShiftPatternEnd">
    <form id="form-shift-pattern-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasShiftPatternEndLabel">Crud Education</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvasShiftPattern" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Pattern ID</label>
                    <div class="col">
                        <input type="text" name="pattern_id" id="pattern_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Group Shift</label>
                    <div class="col">
                        <select name="shift_group_id_pattern" id="shift_group_id_pattern" class="form-control" aria-describedby="emailHelp" placeholder="Enter Group Shift">
                            <option value="">Select Group Shift</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Pattern Name</label>
                    <div class="col">
                        <input type="text" name="pattern_name" id="pattern_name" class="form-control" aria-describedby="emailHelp" placeholder="Enter Pattern Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Pattern Start Date</label>
                    <div class="col">
                        <input type="text" name="pattern_start_date" id="pattern_start_date" class="form-control date_picker" aria-describedby="emailHelp" placeholder="Enter Pattern Date">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Cycle Days</label>
                    <div class="col">
                        <input type="number" name="cycle_days" id="cycle_days" class="form-control" aria-describedby="emailHelp" placeholder="Enter Cycle Days">
                    </div>
                </div>




                <div class="mb-3 row">
                    <div id="pattern-shift-detail-crud" class="mb-3"></div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvasShiftPattern" aria-label="Close">
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
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="crudShiftPattern-action" value="">
    <div id="CrudShiftPattern-ErrorInfo"></div>
</div>

@push('scripts')
<script>
    function CrudShiftPattern(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-shift-pattern-crud').reset();
        $('#form-shift-pattern-crud').find('input, select').attr('readonly', false).attr('disabled', false);

        $('#crudShiftPattern-action').val(action);
        $('#CrudShiftPattern-ErrorInfo').html(''); // Reset error info
        $('#offcanvasShiftPatternEnd').offcanvas('show');
        if (id !== '*') {
            let data = tableShiftPattern.getRow(id).getData();
            $("#pattern_id").val(data.pattern_id);
            $("#shift_group_id_pattern").val(data.shift_group_id);
            $('#pattern_name').val(data.pattern_name);
            $('#cycle_days').val(data.cycle_days);
            $('#pattern_start_date').val(data.pattern_start_date);
        }
        $('#pattern_id').attr('disabled', true);
        reloadTableDetailPattern();
        switch (action) {
            case 'create':
                $('#offcanvasShiftPatternEndLabel').text('Create Shift Pattern');
                break;

            case 'update':
                $('#pattern_id').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#offcanvasShiftPatternEndLabel').text('Edit Shift Pattern');
                break;

            case 'delete':
                $('#offcanvasShiftPatternEndLabel').text('Delete Shift Pattern');
                $('#CrudShiftPattern-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#form-shift-pattern-crud input').attr('readonly', true);
                $('#form-shift-pattern-crud select').attr('disabled', true);

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

    let shiftOptions = {}; // format: {id: "nama"}

    function loadShiftOptions() {
        return $.ajax({
            url: "{{ route('worktime.getShiftData') }}",
            method: "GET",
            success: function(response) {
                // asumsi response array
                // [{shift_id:1, shift_name:"Pagi"}, ...]
                shiftOptions = {};

                response.forEach(function(item) {
                    shiftOptions[item.shift_id] = item.shift_name;
                });
            }
        });
    }
    $(document).ready(function() {
        loadGroupShift();
        loadShiftOptions()
    });



    // Fungsi helper untuk mengecek apakah baris boleh diedit
    var editCheck = function(cell) {
        var data = cell.getRow().getData();
        // 🔥 Cek field edit_mode, bukan status HTML string
        return data.edit_mode === true;
    };
    var tableDetailPattern = new Tabulator("#pattern-shift-detail-crud", {
        ajaxURL: "{{ route('worktime.getShiftPatternDetailData') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 ajax param (filter support)
        ajaxParams: {
            pattern_id: $("#pattern_id").val() // kirim membership_id untuk filter data detail,
        },
        // 🔥 layout fix (penting)
        layout: "fitColumns",
        // layout: "fitData",
        responsiveLayout: false, // disable hide/collapse → pakai scroll
        height: "200px",
        // 🔥 pagination
        // pagination: "local",
        // paginationSize: 10,
        // paginationSizeSelector: [10, 25, 50, 100],
        index: "pattern_detail_id",
        dataTree: true,
        dataTreeStartExpanded: false,
        columns: [{
                title: "Action",
                field: 'option',
                formatter: actionFormatterDetailPattern,
                width: 120,
                frozen: true,
                hozAlign: "center",
            }, {
                title: "pattern_detail_id",
                field: "pattern_detail_id",
                visible: false
            }, {
                title: "pattern_id",
                field: "pattern_id",
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
                title: "Shift",
                field: "shift_id",
                editor: "list",
                editable: editCheck,
                editorParams: function(cell) {
                    return {
                        values: shiftOptions // ⬅️ dari AJAX
                    };
                },
                formatter: function(cell) {
                    let value = cell.getValue();
                    return shiftOptions[value] || "";
                }
            },
            {
                title: "Day Seq",
                field: "day_sequence",
                width: 110,
                editor: "input", // 🔥 WAJIB ada, sebelumnya tidak ada
                editable: editCheck,
                hozAlign: "center",
            }

        ]
    });

    function actionFormatterDetailPattern(cell) {
        var rowData = cell.getRow().getData();

        // Encode composite key sebagai JSON string (aman untuk HTML attribute)
        var pattern_detail_id = rowData.pattern_detail_id;
        return `<button type="button" 
            onclick="CrudDetailPatternShift('update', '${pattern_detail_id}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudDetailPatternShift('delete','${pattern_detail_id}')" 
            class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>`;
    }

    function reloadTableDetailPattern() {
        const search = document.getElementById("search-input").value;

        tableDetailPattern.setData("{{ route('worktime.getShiftPatternDetailData') }}", {
            // search: search,
            pattern_id: $("#pattern_id").val()
        });
    }

    function CrudDetailPatternShift(action, pattern_detail_id) {


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableDetailPattern.addRow({
                    pattern_id: $("#pattern_id").val(), // ambil group_id dari form
                    start_date: '',
                    end_date: null,
                    max_amount: 0,
                    value: 0,
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

        let rowComponent = tableDetailPattern.getRows().find(r => {
            let d = r.getData();
            return d.pattern_detail_id == pattern_detail_id;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", pattern_detail_id);
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

    $("#cycle_days").on("change", function() {
        var count = parseInt($(this).val()) || 0;

        // 🔥 optional: clear dulu biar tidak numpuk
        tableDetailPattern.clearData();

        for (let i = 0; i < count; i++) {
            tableDetailPattern.addRow({
                pattern_id: $("#pattern_id").val(),
                shift_id: '',
                day_sequence: i + 1,
                status: "<span class='badge bg-success text-white'>new</span>",
                action: 'create',
                edit_mode: true,
            });
        }
    });

    $('#form-shift-pattern-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crudShiftPattern-action').val();
        let url = '{{ route("worktime.CrudShiftPattern") }}';
        let method = 'POST';

        let formData = {
            pattern_id: $('#pattern_id').val(),
            shift_group_id: $('#shift_group_id_pattern').val(),
            pattern_name: $('#pattern_name').val(),
            cycle_days: $('#cycle_days').val(),
            pattern_start_date: $('#pattern_start_date').val(),
            action: action,
            detail: JSON.stringify(tableDetailPattern.getData()),
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
                    $('#offcanvasShiftPatternEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTablePatternShift();

                } else {
                    $('#CrudShiftPattern-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudShiftPattern-ErrorInfo').html(`<div class="col-md-12 p-1">
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