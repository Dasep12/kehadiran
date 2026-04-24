<div class="offcanvas offcanvas-end" id="offcanvasEndShift">
    <form id="form-crud-shift" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndShiftLabel">Crud Shift</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">ID</label>
                    <div class="col">
                        <input type="text" name="shift_group_id" id="shift_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Shift Name</label>
                    <div class="col">
                        <input type="text" name="shift_name" id="shift_name" class="form-control" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Time In</label>
                    <div class="col">
                        <input type="text" name="time_in" id="time_in" class="time_picker form-control" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Time Out</label>
                    <div class="col">
                        <input type="text" name="time_out" id="time_out" class="form-control time_picker" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Break Start</label>
                    <div class="col">
                        <input type="text" name="break_start" id="break_start" class="form-control time_picker" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Break End</label>
                    <div class="col">
                        <input type="text" name="break_end" id="break_end" class="form-control time_picker" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Late Tolerance</label>
                    <div class="col">
                        <input type="text" name="late_tolerance" id="late_tolerance" class="form-control" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col d-flex gap-3">
                        <label class="form-check form-switch">
                            <input name="is_night_shift" id="is_night_shift" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Night Shift</span>
                        </label>

                        <label class="form-check form-switch">
                            <input name="workday" id="workday" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Work Day</span>
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
            <div id="CrudShift-ErrorInfo"></div>
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="crudShift-action" value="">

</div>

@push('scripts')
<script>
    function CrudShift(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud-shift').reset();
        $('#form-crud-shift').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#shift_id').attr('readonly', true); // ID biasanya selalu readonly

        $('#crudShift-action').val(action);
        $('#CrudShift-ErrorInfo').html(''); // Reset error info
        $('#offcanvasEndShift').offcanvas('show');
        if (id !== '*') {
            let data = tableShift.getRow(id).getData();
            $('#shift_id').val(data.shift_id);
            $('#shift_name').val(data.shift_name);
            $('#time_in').val(data.time_in);
            $('#time_out').val(data.time_out);
            $('#break_start').val(data.break_start);
            $('#break_end').val(data.break_end);
            $('#late_tolerance').val(data.late_tolerance);
            $("#is_night_shift").attr("checked", data.is_night_shift === 1)
            $("#workday").attr("checked", data.workday === 1)
        }

        switch (action) {
            case 'create':
                $('#offcanvasEndShiftLabel').text('Create Shift');
                break;

            case 'update':
                $('#shift_id').attr('readonly', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndShiftLabel').text('Edit Shift');
                break;

            case 'delete':
                $('#offcanvasEndShiftLabel').text('Delete Shift');
                $('#CrudShift-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#form-crud-shift input').attr('readonly', true);
                $('#form-crud-shift select').attr('disabled', true);

                break;
        }
    }



    $('#form-crud-shift').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crudShift-action').val();
        let url = '{{ route("worktime.CrudShift") }}';
        let method = 'POST';

        let formData = {
            shift_id: $('#shift_id').val(),
            shift_name: $('#shift_name').val(),
            time_in: $('#time_in').val(),
            time_out: $('#time_out').val(),
            break_start: $('#break_start').val(),
            break_end: $('#break_end').val(),
            late_tolerance: $('#late_tolerance').val(),
            is_night_shift: $('#is_night_shift').is(':checked') ? 1 : 0,
            workday: $('#workday').is(':checked') ? 1 : 0,
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
                    $('#offcanvasEndShift').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTableShift();

                } else {
                    $('#CrudShift-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudShift-ErrorInfo').html(`<div class="col-md-12 p-1">
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