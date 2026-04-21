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
                    <label class="col-3 col-form-label required">Position</label>
                    <div class="col">
                        <select type="text" name="position_id" id="position_id" class="form-control" aria-describedby="positionHelp" placeholder="Enter position">
                            <option value="">Select Position</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Grade</label>
                    <div class="col">
                        <select type="text" name="grade_id" id="grade_id" class="form-control" aria-describedby="gradeHelp" placeholder="Enter grade">
                            <option value="">Select Grade</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Allowance</label>
                    <div class="col">
                        <select type="text" name="allowance_id" id="allowance_id" class="form-control" aria-describedby="allowanceHelp" placeholder="Enter allowance">
                            <option value="">Select Allowance</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Work Status</label>
                    <div class="col">
                        <select type="text" name="working_id" id="working_id" class="form-control" aria-describedby="workStatusHelp" placeholder="Enter work status">
                            <option value="">Select Work Status</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Education</label>
                    <div class="col">
                        <select type="text" name="education_id" id="education_id" class="form-control" aria-describedby="educationHelp" placeholder="Enter education">
                            <option value="">Select Education</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Start Date</label>
                    <div class="col">
                        <input type="date" name="start_date" id="start_date" class="form-control" aria-describedby="startDateHelp" placeholder="Enter start date">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">End Date</label>
                    <div class="col">
                        <input type="date" name="end_date" id="end_date" class="form-control" aria-describedby="endDateHelp" placeholder="Enter end date">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Amount</label>
                    <div class="col">
                        <input type="text" name="amount" id="amount" class="form-control" aria-describedby="amountHelp" placeholder="Enter amount">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label"></label>
                    <div class="col d-flex gap-3">
                        <label class="form-check form-switch">
                            <input name="is_daily" id="is_daily" class="form-check-input" type="checkbox" checked />
                            <span class="form-check-label">Daily</span>
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
        </div>

    </form>

    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="crud-action" value="">
    <div id="Crud-ErrorInfo"></div>
</div>

@push('scripts')
<script>
    function loadGrade() {
        $.ajax({
            url: '{{ route("coredata.getJobGradeData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Grade</option>';
                response.forEach(function(grade) {
                    options += `<option value="${grade.id}">${grade.grade_name}</option>`;
                });
                $('#grade_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching job grade data:', xhr);
            }
        });
    }

    function loadPosition() {
        $.ajax({
            url: '{{ route("coredata.getPositionData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Position</option>';
                response.forEach(function(position) {
                    options += `<option value="${position.id}">${position.position_name}</option>`;
                });
                $('#position_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching position data:', xhr);
            }
        });
    }

    function loadAllowance() {
        $.ajax({
            url: '{{ route("sallaryTax.getAllowancesData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Allowance</option>';
                response.forEach(function(allowance) {
                    options += `<option value="${allowance.id}">${allowance.allowance_name}</option>`;
                });
                $('#allowance_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching allowance data:', xhr);
            }
        });
    }

    function loadWorkStatus() {
        $.ajax({
            url: '{{ route("coredata.getWorkStatusData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Work Status</option>';
                response.forEach(function(status) {
                    options += `<option value="${status.id}">${status.working_name}</option>`;
                });
                $('#working_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching work status data:', xhr);
            }
        });
    }

    function loadEducation() {
        $.ajax({
            url: '{{ route("coredata.getEducationData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Education</option>';
                response.forEach(function(education) {
                    options += `<option value="${education.id}">${education.education_name}</option>`;
                });
                $('#education_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching education data:', xhr);
            }
        });
    }

    function loadAllComponents() {
        loadPosition();
        loadGrade();
        loadWorkStatus();
        loadEducation();
        loadAllowance();
    }

    loadAllComponents();

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
            $("#id").val(data.id);
            $('#position_id').val(data.position_id);
            $('#grade_id').val(data.grade_id);
            $('#working_id').val(data.working_id);
            $('#allowance_id').val(data.allowance_id);
            $('#education_id').val(data.education_id);
            $('#start_date').val(data.start_date);
            $('#end_date').val(data.end_date);
            $('#amount').val(data.amount);
            $("#is_daily").prop('checked', data.is_daily === 1);

        }

        switch (action) {
            case 'create':
                $('#offcanvasEndLabel').text('Create Allowance Position');
                break;

            case 'update':
                $('#id').attr('readonly', true); // ID tidak bisa diubah saat update
                $('#offcanvasEndLabel').text('Edit Allowance Position');
                break;

            case 'delete':
                $('#offcanvasEndLabel').text('Delete Allowance Position');
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
        let url = '{{ route("sallaryTax.CrudAllowancePosition") }}';
        let method = 'POST';

        let formData = {
            id: $('#id').val(),
            position_id: $('#position_id').val(),
            grade_id: $('#grade_id').val(),
            working_id: $('#working_id').val(),
            education_id: $('#education_id').val(),
            allowance_id: $('#allowance_id').val(),
            amount: $('#amount').val(),
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
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