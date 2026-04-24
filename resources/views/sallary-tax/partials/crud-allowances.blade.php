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
                        <input type="text" name="id" id="id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Allowance Name</label>
                    <div class="col">
                        <input type="text" name="allowance_name" id="allowance_name" class="form-control" aria-describedby="allowanceHelp" placeholder="Enter allowance name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Allowance Code</label>
                    <div class="col">
                        <input type="text" name="allowance_code" id="allowance_code" class="form-control" aria-describedby="allowanceCodeHelp" placeholder="Enter allowance code">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Calc For</label>
                    <div class="col">
                        <select type="text" name="calc_for" id="calc_for" class="form-control" aria-describedby="calcForHelp" placeholder="Enter calc for">
                            <option value="">Select Calc For</option>
                            <option value="emp">Employee</option>
                            <option value="comp">Company</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Type</label>
                    <div class="col">
                        <select type="text" name="type" id="type" class="form-control" aria-describedby="typeHelp" placeholder="Enter type for">
                            <option value="">Select Type</option>
                            <option value="+">Earning</option>
                            <option value="-">Deduction</option>
                            <option value="tax">Tax</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col d-flex gap-3">
                        <label class="form-check form-switch">
                            <input name="daily" id="daily" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Daily</span>
                        </label>

                        <label class="form-check form-switch">
                            <input name="is_tax" id="is_tax" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Tax</span>
                        </label>

                        <label class="form-check form-switch">
                            <input name="is_gross" id="is_gross" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Gross</span>
                        </label>
                        <label class="form-check form-switch">
                            <input name="is_membership" id="is_membership" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Membership</span>
                        </label>

                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col d-flex gap-3">
                        <label class="form-check form-switch">
                            <input name="is_actived" id="is_actived" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Actived</span>
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
        $('#id').attr('readonly', false); // ID biasanya selalu readonly

        $('#crud-action').val(action);
        $('#Crud-ErrorInfo').html(''); // Reset error info
        $('#offcanvasEnd').offcanvas('show');
        if (id !== '*') {
            let data = table.getRow(id).getData();
            $('#id').val(data.id);
            $('#allowance_name').val(data.allowance_name);
            $('#allowance_code').val(data.allowance_code);
            $('#calc_for').val(data.calc_for);
            $('#type').val(data.type);
            $('#daily').prop('checked', data.daily === 1);
            $('#is_tax').prop('checked', data.is_tax === 1);
            $('#is_actived').prop('checked', data.is_actived === 1);
            $('#is_membership').prop('checked', data.is_membership === 1);
            $('#is_gross').prop('checked', data.is_gross === 1);
            console.log(data);

        }

        switch (action) {
            case 'create':
                $('#offcanvasEndLabel').text('Create Allowance');
                break;

            case 'update':
                $('#id').attr('readonly', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndLabel').text('Edit Allowance');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Allowance');
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
        let url = '{{ route("sallaryTax.CrudAllowances") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            allowance_name: $('#allowance_name').val(),
            allowance_code: $('#allowance_code').val(),
            calc_for: $('#calc_for').val(),
            type: $('#type').val(),
            daily: $('#daily').is(':checked') ? 1 : 0,
            is_tax: $('#is_tax').is(':checked') ? 1 : 0,
            is_actived: $('#is_actived').is(':checked') ? 1 : 0,
            is_gross: $('#is_gross').is(':checked') ? 1 : 0,
            is_membership: $('#is_membership').is(':checked') ? 1 : 0,
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