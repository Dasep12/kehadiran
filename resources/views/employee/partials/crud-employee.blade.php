<div class="modal modal-blur fade py-5" id="modal-full-width" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="post" id="form-crud-employee">
        <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Employee Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <!-- Profile Header -->
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <span class="avatar avatar-xl rounded-circle" style="background-image: url(https://i.pravatar.cc/150?u=hector)"></span>
                        </div>
                        <div class="col">
                            <h2 class="mb-0">Hector Mariano</h2>
                            <div class="text-muted">bancboy@me.com</div>
                        </div>
                        <!-- <div class="col-12 col-md-auto mt-3 mt-md-0">
                        <div class="row g-3">
                            <div class="col-6 col-md-auto">
                                <div class="text-uppercase text-muted fw-bold small">Designation</div>
                                <div>Software developer</div>
                            </div>
                            <div class="col-6 col-md-auto">
                                <div class="text-uppercase text-muted fw-bold small">Team</div>
                                <div><span class="badge badge-outline text-grey fw-normal">Management</span></div>
                            </div>
                            <div class="col-6 col-md-auto">
                                <div class="text-uppercase text-muted fw-bold small">Manager</div>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs rounded-circle me-2" style="background-image: url(https://i.pravatar.cc/150?u=stephen)"></span>
                                    Stephen Shaw
                                </div>
                            </div>
                            <div class="col-6 col-md-auto">
                                <div class="text-uppercase text-muted fw-bold small">Direct Reports</div>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs rounded-circle me-2" style="background-image: url(https://i.pravatar.cc/150?u=nado)"></span>
                                    Nado Husa
                                </div>
                            </div>
                            <div class="col-6 col-md-auto">
                                <div class="text-uppercase text-muted fw-bold small">Role</div>
                                <div>User</div>
                            </div>
                        </div>
                    </div> -->
                    </div>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-3" data-bs-toggle="tabs">
                        <li class="nav-item">
                            <a href="#tabs-profile" class="nav-link active" data-bs-toggle="tab">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-organization" class="nav-link" data-bs-toggle="tab">Organization</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-benefitSallary" class="nav-link" data-bs-toggle="tab">Benefit & Sallary</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-others" class="nav-link" data-bs-toggle="tab">Others</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-history" class="nav-link" data-bs-toggle="tab">Activity History</a>
                        </li>
                    </ul>

                    <div class="tab-content" style="min-height: 500px;">
                        <div class="tab-pane fade  active show" id="tabs-profile">
                            @include("employee.partials.tab.tab-profile")
                        </div>
                        <div class="tab-pane fade" id="tabs-organization">
                            @include("employee.partials.tab.tab-organization")
                        </div>
                        <div class="tab-pane fade" id="tabs-benefitSallary">
                            @include("employee.partials.tab.tab-benefit-sallary")
                        </div>
                        <div class="tab-pane fade" id="tabs-others">
                            @include("employee.partials.tab.tab-others")
                        </div>
                    </div>
                    <input type="text" id="CrudEmployee-action">

                    <div id="CrudEmployee-ErrorInfo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>


@include("employee.partials.tab.tab-crud.crud-organization")
@include("employee.partials.tab.tab-crud.crud-position")
@include("employee.partials.tab.tab-crud.crud-work-status")
@include("employee.partials.tab.tab-crud.crud-grade")

@push('scripts')
<script>
    function loadPosition() {
        $.ajax({
            url: '{{ route("coredata.getPositionData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Position</option>';
                response.forEach(function(position) {
                    options += `<option data-name="${position.position_name}" value="${position.id}">${position.position_name}</option>`;
                });
                console.log(response)
                $('#position_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching position data:', xhr);
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
                    options += `<option data-code="${status.working_code}" data-name="${status.working_name}" value="${status.id}">${status.working_name}</option>`;
                });
                $('#working_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching work status data:', xhr);
            }
        });
    }

    function loadGrade() {
        $.ajax({
            url: '{{ route("coredata.getJobGradeData") }}',
            method: 'GET',
            success: function(response) {
                let options = '<option value="">Select Grade</option>';
                response.forEach(function(grade) {
                    options += `<option data-name="${grade.grade_name}" value="${grade.id}">${grade.grade_name}</option>`;
                });
                $('#grade_id').html(options);
            },
            error: function(xhr) {
                console.error('Error fetching job grade data:', xhr);
            }
        });
    }

    loadPosition()
    loadWorkStatus()
    loadGrade()

    function Crud(action, id) {
        document.getElementById('form-crud-employee').reset();
        $("#CrudEmployee-ErrorInfo").html('');
        $("#CrudEmployee-action").val(action)
        if (id != '*') {
            let data = table.getRow(id).getData();
            $('#employee_id').val(data.employee_id);
            $('#employee_code').val(data.employee_code);
            $('#employee_name').val(data.employee_name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#gender').val(data.gender);
            $('#join_date').val(data.join_date);
            $('#npwp').val(data.npwp);
            $('#id_card').val(data.id_card);
        }

        reloadAllTables();
        switch (action) {
            case "create":
                $('#form-crud-employee').find('input, select').attr('readonly', false).attr('disabled', false);
                break;
            case "update":

                $('#form-crud-employee').find('input, select').attr('readonly', false).attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-employee').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-full-width").modal('show');
    }

    // 1. Fungsi Helper Utama
    function initTable(selector, url, columns, search) {
        return new Tabulator(selector, {
            ajaxURL: url,
            ajaxConfig: "GET",
            layout: "fitData",
            ajaxParams: search,
            height: "210px",
            placeholder: "No Data Found",
            columns: columns, // Menggunakan kolom yang dipassing
        });
    }

    $('#form-crud-employee').on('submit', function(e) {
        e.preventDefault();
        let action = $('#CrudEmployee-action').val();
        let url = '{{ route("employees.CrudEmployee") }}';
        let method = 'POST';

        let formData = {
            employee_id: $('#employee_id').val(),
            employee_code: $('#employee_code').val(),
            employee_name: $('#employee_name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            join_date: $('#join_date').val(),
            gender: $('#gender').val(),
            id_card: $('#id_card').val(),
            npwp: $('#npwp').val(),
            action: action,
            organization: JSON.stringify(tableOrganization.getData()),
            position: JSON.stringify(tablePosition.getData()),
            workingStatus: JSON.stringify(tableWorkingStatus.getData()),
            grade: JSON.stringify(tableGrade.getData()),
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
                    $("#modal-full-width").modal('hide');

                } else {
                    $('#CrudEmployee-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudEmployee-ErrorInfo').html(`<div class="col-md-12 p-1">
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