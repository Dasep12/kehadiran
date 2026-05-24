<div class="modal modal-blur fade   py-6" id="modal-employee-resign" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-employee-resign">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Resign Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <input type="text" hidden name="employee_id_resign" id="employee_id_resign">
                            <label class="form-label"> Select Resign </label>
                            <select id="resign_id" placeholder="Enter sallary id" class="form-control">
                                <option value="">Select Resign</option>
                            </select>

                            <label class="form-label"> Resign Date </label>
                            <input type="text" id="resign_date" placeholder="Enter Resign Date" class="form-control date_picker">

                            <label class="form-label"> Reasons </label>
                            <textarea id="remark" placeholder="Enter Reasons" class="form-control"></textarea>

                            <input type="text" hidden name="crud-action-employee-resign" id="crud-action-employee-resign">

                            <div id="CrudEmployeeResign-ErrorInfo"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-resign btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push("scripts")
<script>
    function loadResign() {

        $.ajax({
            url: "{{ route('employees.getResignData') }}",
            method: "GET",
            cache: false,
            data: {},
            success: function(response) {
                let options = '<option value="">Select Resign</option>';
                response.forEach(function(resign) {
                    options += `<option value="${resign.id}">${resign.name}</option>`;
                });
                $('#resign_id').html(options);
            }
        })
    }
    loadResign();

    function CrudEmployeeResign(action, id) {
        let form = document.getElementById('form-crud-employee-resign');
        form.reset();
        $("#crud-action-employee-resign").val(action);
        if (id != '*') {
            let data = table.getRow(id).getData();
            $('#employee_id_resign').val(data.employee_id);
            $('#resign_date').val(data.resign_date);
            $('#resign_id').val(data.resign_id);
            $('#remark').val(data.reasons_resign);
        }
        switch (action) {
            case "create":
                $(".btn-resign").removeClass('btn-danger').addClass('btn-primary')
                $('#form-crud-employee-resign').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#remark").attr("disabled", false)
                $(".btn-resign").html('Create Resign')
                break;
            case "update":

                break;
            case "delete":
                $(".btn-resign").removeClass('btn-primary').addClass('btn-danger')
                $('#form-crud-employee-resign').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#remark").attr("disabled", true)
                $(".btn-resign").html('Delete Resign')
                break;
        }

        $("#modal-employee-resign").modal("show");
    }




    $('#form-crud-employee-resign').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crud-action-employee-resign').val();
        let url = '{{ route("employees.CrudResign") }}';
        let method = 'POST';

        let formData = {
            employee_id_resign: $('#employee_id_resign').val(),
            resign_id: $('#resign_id').val(),
            resign_date: $('#resign_date').val(),
            remark: $('#remark').val(),
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
                    $("#modal-employee-resign").modal('hide');
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTable();

                } else {
                    $('#CrudEmployeeResign-ErrorInfo').html(`<div class="col-md-12 p-1">
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
                $('#CrudEmployeeResign-ErrorInfo').html(`<div class="col-md-12 p-1">
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