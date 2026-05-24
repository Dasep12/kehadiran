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

<div class="offcanvas offcanvas-end offcanvas-narrow" id="offcanvasShiftAllowanceEnd">
    <form id="form-shift-allowance-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasShiftAllowanceEndLabel">Crud Shift Allowance</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvasShiftAllowance" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div id="content-crud">



                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Shift</label>
                    <div class="col">
                        <select name="shift_id_allowance" id="shift_id_allowance" class="form-control" aria-describedby="emailHelp" placeholder="Enter Shift">
                            <option value="">Select Group Shift</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Allowance Shift</label>
                    <div class="col">
                        <select name="allowance_shift_id" id="allowance_shift_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter Group Shift">
                            <option value="">Select Group Shift</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Amount</label>
                    <div class="col">
                        <input type="text" name="amount" id="amount" class="form-control" aria-describedby="emailHelp" placeholder="Enter Pattern Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Start Date</label>
                    <div class="col">
                        <input type="text" name="allowance_shift_start_date" id="allowance_shift_start_date" class="form-control date_picker" aria-describedby="emailHelp" placeholder="Enter Start Date">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">End Date</label>
                    <div class="col">
                        <input type="text" name="allowance_shift_end_date" id="allowance_shift_end_date" class="form-control date_picker" aria-describedby="emailHelp" placeholder="Enter End Date">
                    </div>
                </div>




                <div class="mb-3 row">
                    <div id="allowance-shift-detail-crud" class="mb-3"></div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvasShiftAllowance" aria-label="Close">
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

            <div id="CrudShiftAllowance-ErrorInfo"></div>
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="CrudShiftAllowance-action" value="">

</div>

@push('scripts')
<script>
    function CrudShiftAllowance(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-shift-allowance-crud').reset();
        // $('#form-shift-allowance-crud').find('input, select').attr('readonly', false).attr('disabled', false);

        $('#CrudShiftAllowance-action').val(action);
        $('#CrudShiftAllowance-ErrorInfo').html(''); // Reset error info
        $('#offcanvasShiftAllowanceEnd').offcanvas('show');
        if (id !== '*') {
            var shift_id = id.split("__")[0];
            var allowance_id = id.split("__")[1];
            var start_date = id.split("__")[2];
            let rowComponent = tableShiftAllowance.getRows().find(r => {
                let d = r.getData();

                return d.shift_id == shift_id && d.allowance_id == allowance_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", work_status_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            // let data = tableShiftAllowance.getRow(id).getData();
            $("#shift_id_allowance").val(data.shift_id);
            $("#allowance_shift_id").val(data.allowance_id);
            $('#allowance_shift_start_date').val(data.start_date);
            $('#allowance_shift_end_date').val(data.end_date);
            $('#amount').val(data.amount);
        }

        switch (action) {
            case 'create':
                $('#shift_id_allowance').attr('disabled', false);
                $('#allowance_shift_id').attr('disabled', false);
                $('#offcanvasShiftAllowanceEndLabel').text('Create Shift Allowance');
                break;

            case 'update':
                $('#shift_id_allowance').attr('disabled', true);
                $('#allowance_shift_id').attr('disabled', true); // ID tidak bisa diubah saat update
                $('#offcanvasShiftAllowanceEndLabel').text('Edit Shift Allowance');
                break;

            case 'delete':
                $('#offcanvasShiftAllowanceEndLabel').text('Delete Shift Allowance');
                $('#CrudShiftAllowance-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#form-shift-allowance-crud input').attr('readonly', true);
                $('#form-shift-allowance-crud select').attr('disabled', true);

                break;
        }
    }



    $('#form-shift-allowance-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#CrudShiftAllowance-action').val();
        let url = '{{ route("worktime.CrudShiftAllowance") }}';
        let method = 'POST';

        let formData = {
            shift_id: $('#shift_id_allowance').val(),
            allowance_id: $('#allowance_shift_id').val(),
            start_date: $('#allowance_shift_start_date').val(),
            end_date: $('#allowance_shift_end_date').val(),
            amount: $('#amount').val(),
            action: action,
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
                    $('#offcanvasShiftAllowanceEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTableShiftAllowance();

                } else {
                    $('#CrudShiftAllowance-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudShiftAllowance-ErrorInfo').html(`<div class="col-md-12 p-1">
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