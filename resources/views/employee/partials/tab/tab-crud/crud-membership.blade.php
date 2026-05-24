<div class="modal modal-blur fade   py-6" id="modal-membership" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-membership">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Membership</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Membership Name </label>
                            <select id="membership_id" placeholder="Enter sallary id" class="form-control">
                                <option value="">Select Name</option>
                            </select>

                            <input type="text" hidden name="allowance_name_membership" id="allowance_name_membership">
                            <input type="text" hidden name="calc_for" id="calc_for">
                            <input type="text" hidden name="membership_code" id="membership_code">
                            <input type="text" hidden name="calculation_type" id="calculation_type">
                            <input type="text" hidden name="rate_value" id="rate_value">
                            <input type="text" hidden name="company_share" id="company_share">
                            <input type="text" hidden name="employee_share" id="employee_share">


                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_membership" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_membership" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-membership" id="crud-action-membership">
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
    function CrudMembership(action, id) {
        let form = document.getElementById('form-crud-membership');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-membership").val(action);
        $('#form-crud-membership').find('input, select').attr('readonly', true).attr('disabled', true);


        var membership_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableMembership.getRows().find(r => {
                let d = r.getData();
                return d.start_date == start_date &&
                    d.membership_id == membership_id;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", membership_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#membership_id").val(data.membership_id);
            $("#start_date_membership").val(data.start_date);
            $("#end_date_membership").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-membership').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#group_id").attr("disabled", false)
                break;
            case "update":

                $('#form-crud-membership').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#group_id").attr("disabled", true)
                $("#end_date_membership").attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-membership').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-membership").modal("show");
    }

    $("#membership_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let allowance_name = selectedOption.data("allowance_name");
        let calc_for = selectedOption.data("calc_for");
        let employee_share = selectedOption.data("employee_share");
        let company_share = selectedOption.data("company_share");
        let rate_value = selectedOption.data("rate_value");
        let calculation_type = selectedOption.data("calculation_type");
        let membership_code = selectedOption.data("membership_code");
        $("#allowance_name_membership").val(allowance_name);
        $("#calc_for").val(calc_for);
        $("#employee_share").val(employee_share);
        $("#company_share").val(company_share);
        $("#membership_code").val(membership_code);
        $("#rate_value").val(rate_value);
        $("#calculation_type").val(calculation_type);
    });


    $('#form-crud-membership').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-membership").val();
        var membership_id = $("#membership_id").val();
        var start_date = $("#start_date_membership").val();

        if (action === 'create') {
            let rowComponent = tableMembership.getRows().find(r => {
                let d = r.getData();

                return d.membership_id == membership_id &&
                    d.start_date == start_date;
            });
            if (rowComponent) {
                alert("data has been added");
                return;
            }
            // 🔥 Tambah row baru di bawah tabel
            tableMembership.addRow({
                    membership_id: $("#membership_id").val(),
                    employee_id: $("#employee_id").val(),
                    allowance_name: $("#allowance_name_membership").val(),
                    membership_code: $("#membership_code").val(),
                    employee_share: $("#employee_share").val(),
                    company_share: $("#company_share").val(),
                    rate_value: $("#rate_value").val(),
                    calculation_type: $("#calculation_type").val(),
                    start_date: $("#start_date_membership").val(),
                    end_date: $("#end_date_membership").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-membership").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableMembership.getRows().find(r => {
            let d = r.getData();

            return d.membership_id == membership_id &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", membership_id, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                end_date: $("#end_date_membership").val(),
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

        $("#modal-membership").modal("hide")
    });
</script>
@endpush