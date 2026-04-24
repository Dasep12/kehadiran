<div class="offcanvas offcanvas-end offcanvas-narrow" id="offcanvasEnd">
    <form id="form-crud-work-calendar" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">Crud Shift Group</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">ID</label>
                    <div class="col">
                        <input type="text" name="holiday_id" id="holiday_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Event Name</label>
                    <div class="col">
                        <input type="text" name="holiday_name" id="holiday_name" class="form-control" aria-describedby="educationHelp" placeholder="Enter name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Type Event</label>
                    <div class="col">
                        <select type="text" name="holiday_type" id="holiday_type" class="form-control" aria-describedby="educationHelp" placeholder="Enter name">
                            <option value="NATIONAL">HOLIDAY NATIONAL</option>
                            <option value="COMPANY">HOLIDAY COMPANY</option>
                            <option value="MASS LEAVE">MASS LEAVE</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Date</label>
                    <div class="col">
                        <input type="text" name="holiday_date" id="holiday_date" class="form-control date_picker" aria-describedby="educationHelp" placeholder="Enter Date">
                    </div>
                </div>




                <div class="text-end">
                    <button type="button" class="btn btn-danger delete_btn" aria-label="Close">
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
    function CrudWorkCalendar(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud-work-calendar').reset();
        $('#form-crud-work-calendar').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#holiday_id').attr('readonly', true); // ID biasanya selalu readonly

        $('#crud-action').val(action);
        $('#Crud-ErrorInfo').html(''); // Reset error info
        $('#offcanvasEnd').offcanvas('show');
        if (id !== '*') {

        }
        $("#holiday_date").attr("disabled", true);
        switch (action) {
            case 'create':
                $('.delete_btn')
                    .off('click') // hapus event delete
                    .text('Cancel')
                    .attr('data-bs-dismiss', 'offcanvas') // ⬅️ ini kuncinya
                    .removeAttr('onclick')
                    .prop('disabled', false)
                    .show();
                $('#offcanvasEndLabel').text('Create Work Calendar');
                break;

            case 'update':
                $('.delete_btn')
                    .off('click') // reset dulu
                    .on('click', DeleteWorkCalendar)
                    .text('Delete')
                    .removeAttr('data-bs-dismiss') // ⬅️ biar nggak auto close
                    .prop('disabled', false)
                    .show();
                $('#holiday_id').attr('readonly', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndLabel').text('Edit Work Calendar');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Work Calendar');

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
                $('#form-crud-work-calendar input').attr('readonly', true);
                $('#form-crud-work-calendar select').attr('disabled', true);

                break;
        }


    }



    $('#form-crud-work-calendar').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crud-action').val();
        let url = '{{ route("worktime.CrudWorkCalendar") }}';
        let method = 'POST';

        let formData = {
            holiday_id: $('#holiday_id').val(),
            holiday_date: $('#holiday_date').val(),
            holiday_name: $('#holiday_name').val(),
            holiday_type: $('#holiday_type').val(),
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
                    $('#offcanvasEnd').offcanvas('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadCalendar();

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

    function DeleteWorkCalendar() {
        $("#crud-action").val("delete");
        let id = $('#holiday_id').val();

        if (!id) {
            alert('Data tidak ditemukan');
            return;
        }

        if (!confirm('Yakin mau hapus data ini?')) return;

        $.ajax({
            url: '{{ route("worktime.CrudWorkCalendar") }}',
            method: 'POST',
            data: {
                holiday_id: id,
                action: 'delete',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, response.status);

                    $('#offcanvasEnd').offcanvas('hide');

                    // 🔥 refresh calendar
                    calendar.refetchEvents();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Gagal delete data');
            }
        });
    }
</script>
@endpush