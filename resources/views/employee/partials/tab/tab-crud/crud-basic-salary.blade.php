<div class="modal modal-blur fade   py-6" id="modal-basic-salary" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-basic-salary">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Basic Salary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Name Salary </label>
                            <select id="allowance_id" placeholder="Enter sallary id" class="form-control">
                                <option value="">Select Basic Salary Name</option>
                            </select>

                            <input type="text" hidden name="allowance_name" id="allowance_name">

                            <label class="form-label"> Group Salary </label>
                            <select id="group_id" placeholder="Enter grade id" class="form-control">
                                <option value="">Select Group Salary</option>
                            </select>
                            <input type="text" hidden name="name_group" id="name_group">
                            <input type="text" hidden name="basic_salary" id="basic_salary">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_basic_salary" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_basic_salary" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" name="crud-action-basic-salary" id="crud-action-basic-salary">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push("scripts")
<script>
    function CrudBasicSalary(action, id) {
        let form = document.getElementById('form-crud-basic-salary');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-basic-salary").val(action);
        $('#form-crud-basic-salary').find('input, select').attr('readonly', true).attr('disabled', true);


        var group_id = id.split("__")[0];
        var allowance_id = id.split("__")[1];
        var start_date = id.split("__")[2];
        if (id != '*') {
            let rowComponent = tableBasicSalary.getRows().find(r => {
                let d = r.getData();

                return d.group_id == group_id &&
                    d.emp_start_date == start_date &&
                    d.allowance_id == allowance_id;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", group_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#group_id").val(data.group_id);
            $("#name_group").val(data.name_group);
            $("#allowance_id").val(data.allowance_id);
            $("#basic_salary").val(data.basic_salary);
            $("#start_date_basic_salary").val(data.emp_start_date);
            $("#end_date_basic_salary").val(data.emp_end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-basic-salary').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#group_id").attr("disabled", false)
                break;
            case "update":

                $('#form-crud-basic-salary').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#group_id").attr("disabled", true)
                $("#end_date_basic-salary").attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-basic-salary').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-basic-salary").modal("show");
    }

    $("#group_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        let amount = selectedOption.data("amount");
        $("#name_group").val(name);
        $("#basic_salary").val(amount);
    });
    $("#allowance_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        $("#allowance_name").val(name);
    });


    $('#form-crud-basic-salary').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-basic-salary").val();
        var groupId = $("#group_id").val();
        var allowance_id = $("#allowance_id").val();
        var start_date = $("#start_date_basic_salary").val();

        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableBasicSalary.addRow({
                    group_id: $("#group_id").val(),
                    name_group: $("#name_group").val(),
                    allowance_name: $("#allowance_name").val(),
                    allowance_id: $("#allowance_id").val(),
                    basic_salary: $("#basic_salary").val(),
                    emp_start_date: $("#start_date_basic_salary").val(),
                    emp_end_date: $("#end_date_basic_salary").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-basic-salary").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableBasicSalary.getRows().find(r => {
            let d = r.getData();

            return d.group_id == groupId &&
                d.emp_start_date == start_date &&
                d.allowance_id == allowance_id;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", groupId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                end_date: $("#end_date_basic_salary").val(),
                action: 'update',
                status: "<span class='badge bg-primary text-white'>update</span>"
            }).then(function() {
                // ✅ Dijamin edit_mode sudah true sebelum edit() dipanggil
                // try {
                //     rowComponent.getCell("calculation_type").edit(true);
                // } catch (e) {
                //     console.warn("Fallback ke value:", e.message);
                //     try {
                //         rowComponent.getCell("value").edit(true);
                //     } catch (e2) {}
                // }
            });

        } else if (action === 'delete') {
            rowComponent.update({
                edit_mode: false,
                action: 'delete',
                status: "<span class='badge bg-danger text-white'>remove</span>"
            });
        }

        $("#modal-basic-salary").modal("hide")
    });
</script>
@endpush