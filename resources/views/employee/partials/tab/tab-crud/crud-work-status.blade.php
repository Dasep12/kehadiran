<div class="modal modal-blur fade   py-6" id="modal-work-status" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-work-status">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud work-status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Working Status </label>
                            <select id="working_id" placeholder="Enter Work Status id" class="form-control">
                                <option value="">Select Work Status</option>
                            </select>

                            <input type="text" hidden name="working_name" id="working_name">
                            <input type="text" hidden name="working_code" id="working_code">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_work-status" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_work-status" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-work-status" id="crud-action-work-status">
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
    function CrudWorkStatus(action, id) {
        let form = document.getElementById('form-crud-work-status');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-work-status").val(action);
        $('#form-crud-work-status').find('input, select').attr('readonly', true).attr('disabled', true);


        var work_status_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableWorkingStatus.getRows().find(r => {
                let d = r.getData();

                return d.working_id == work_status_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", work_status_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#working_id").val(data.working_id);
            $("#working_name").val(data.working_name);
            $("#working_code").val(data.working_code);
            $("#start_date_work-status").val(data.start_date);
            $("#end_date_work-status").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-work-status').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#working_id").attr("disabled", false)
                break;
            case "update":

                $('#form-crud-work-status').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#working_id").attr("disabled", true)
                $("#end_date_work-status").attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-work-status').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-work-status").modal("show");
    }

    $("#working_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        let code = selectedOption.data("code");
        $("#working_name").val(name);
        $("#working_code").val(code);
    });
    $('#form-crud-work-status').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-work-status").val();
        var workStatusId = $("#working_id").val();
        var start_date = $("#start_date_work-status").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableWorkingStatus.addRow({
                    working_id: $("#working_id").val(),
                    working_name: $("#working_name").val(),
                    working_code: $("#working_code").val(),
                    start_date: $("#start_date_work-status").val(),
                    end_date: $("#end_date_work-status").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-work-status").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableWorkingStatus.getRows().find(r => {
            let d = r.getData();

            return d.working_id == workStatusId &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", workStatusId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                end_date: $("#end_date_work-status").val(),
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

        $("#modal-work-status").modal("hide")
    });
</script>
@endpush