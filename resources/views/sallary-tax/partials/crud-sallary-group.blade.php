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
                    <label class="col-3 col-form-label required">Group ID</label>
                    <div class="col">
                        <input type="text" name="group_id" id="group_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter Group ID">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Group Name</label>
                    <div class="col">
                        <input type="text" name="name_group" id="name_group" class="form-control" aria-describedby="emailHelp" placeholder="Enter Group Name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <a href="#" onclick="CrudDetail('create','','')" class="text-primary mb-2">Add New <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-library-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18.333 2a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667 -3.667zm-4.333 4a1 1 0 0 0 -1 1v2h-2a1 1 0 0 0 0 2h2v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 0 0 -2h-2v-2a1 1 0 0 0 -1 -1" />
                            <path d="M3.517 6.391a1 1 0 0 1 .99 1.738c-.313 .178 -.506 .51 -.507 .868v10c0 .548 .452 1 1 1h10c.284 0 .405 -.088 .626 -.486a1 1 0 0 1 1.748 .972c-.546 .98 -1.28 1.514 -2.374 1.514h-10c-1.652 0 -3 -1.348 -3 -3v-10.002a3 3 0 0 1 1.517 -2.605" />
                        </svg></a>
                    <div id="sallary-group-master-detail" class="mb-3"></div>
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

@push('scripts')
<script>
    function Crud(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud').reset();
        $('#form-crud').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#group_id').attr('readonly', false); // ID biasanya selalu readonly

        $('#crud-action').val(action);
        $('#Crud-ErrorInfo').html(''); // Reset error info
        $('#offcanvasEnd').offcanvas('show');
        if (id !== '*') {
            let data = table.getRow(id).getData();
            $("#group_id").val(data.group_id);
            $('#name_group').val(data.name_group);
        }
        reloadTableDetail();
        switch (action) {
            case 'create':
                $('#offcanvasEndLabel').text('Create Sallary Group');
                break;

            case 'update':
                $('#group_id').attr('readonly', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndLabel').text('Edit Sallary Group');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Sallary Group');
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
        let url = '{{ route("sallaryTax.CrudSallaryGroup") }}';
        let method = 'POST';

        let formData = {
            group_id: $('#group_id').val(),
            name_group: $('#name_group').val(),
            action: action,
            detail: JSON.stringify(tableDetail.getData()),
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
                    $('#offcanvasEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTable();
                    reloadTableDetail();

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

    // Fungsi helper untuk mengecek apakah baris boleh diedit
    var editCheck = function(cell) {
        var data = cell.getRow().getData();
        // 🔥 Cek field edit_mode, bukan status HTML string
        return data.edit_mode === true;
    };
    var tableDetail = new Tabulator("#sallary-group-master-detail", {
        ajaxURL: "{{ route('sallaryTax.getSallaryGroupDataDetail') }}", // endpoint Laravel
        ajaxConfig: "GET",
        // 🔥 ajax param (filter support)
        ajaxParams: {
            group_id: $("#group_id").val() // kirim group_id untuk filter data detail,
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

        dataTree: true,
        dataTreeStartExpanded: false,
        columns: [{
                title: "Action",
                field: 'option',
                formatter: actionFormatterDetail,
                width: 120,
                freeze: true,
                hozAlign: "center",
            }, {
                title: "Group ID",
                field: "group_id",
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
                title: "Amount",
                field: "amount",
                editor: "number",
                width: 150,
                editable: editCheck, // Tambahkan ini
                formatter: "money",
                formatterParams: {
                    decimal: ",",
                    thousand: ".",
                    symbol: "Rp ",
                    precision: 0,
                },
            },
            {
                title: "Start",
                field: "start_date",
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
            {
                title: "End",
                field: "end_date",
                width: 150,
                editor: "date", // Ubah ke 'date'
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
        var group_id = rowData.group_id;
        var start_date = rowData.start_date;
        return `<button type="button" 
            onclick="CrudDetail('update', '${group_id}', '${start_date}')" 
            class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" 
            onclick="CrudDetail('delete','${group_id}','${start_date}')" 
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

        tableDetail.setData("{{ route('sallaryTax.getSallaryGroupDataDetail') }}", {
            search: search,
            group_id: $("#group_id").val()
        });
    }

    function CrudDetail(action, group_id, start_date) {


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableDetail.addRow({
                    group_id: $("#group_id").val(), // ambil group_id dari form
                    start_date: '',
                    end_date: null,
                    amount: 0,
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {
                    // 🔥 Setelah row ditambah, langsung fokus ke cell amount
                    setTimeout(() => {
                        row.getCell("amount").edit();
                    }, 50);
                });
            // return; // stop disini, tidak perlu cari rowComponent
        }


        let rowComponent = tableDetail.getRows().find(r => {
            let d = r.getData();
            return d.group_id === group_id && d.start_date === start_date;
        });

        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", group_id, start_date);
            return;
        }

        if (action === 'update') {
            // 🔥 Set edit_mode = true agar editCheck return true
            rowComponent.update({
                edit_mode: true,
                action: 'update',
                status: "<span class='badge bg-primary text-white'>update</span>"
            });

            // Delay sedikit agar update selesai dulu baru fokus edit
            setTimeout(() => {
                rowComponent.getCell("amount").edit();
            }, 50);

        } else if (action === 'delete') {
            rowComponent.update({
                edit_mode: false,
                action: 'delete',
                status: "<span class='badge bg-danger text-white'>remove</span>"
            });
        }
    }
</script>
@endpush