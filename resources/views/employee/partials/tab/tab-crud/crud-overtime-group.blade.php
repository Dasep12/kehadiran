<div class="modal modal-blur fade   py-6" id="modal-overtime" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-overtime">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Overtime</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Group Overtime </label>
                            <select id="group_overtime_id" name="group_overtime_id" class="form-control">
                                <option value="">Select Group Overtime</option>
                            </select>

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_overtime" name="start_date_overtime" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_overtime" name="end_date_overtime" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-overtime" id="crud-action-overtime">
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
    function CrudOvertimeGroup(action, id) {
        let form = document.getElementById('form-crud-overtime');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-overtime").val(action);
        $('#form-crud-overtime').find('input, select').attr('readonly', true).attr('disabled', true);


        var group_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableOvertime.getRows().find(r => {
                let d = r.getData();

                return d.group_id == group_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", group_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#group_overtime_id").val(data.group_id);
            $("#start_date_overtime").val(data.start_date);
            $("#end_date_overtime").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-overtime').find('input, select').attr('readonly', false).attr('disabled', false);
                break;
            case "update":

                $('#form-crud-overtime').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#end_date_overtime,#group_id").attr('disabled', false);
                $("#end_date_overtime,#group_id").attr('readonly', false);
                break;
            case "delete":
                $('#form-crud-overtime').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-overtime").modal("show");
    }
    $('#form-crud-overtime').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-overtime").val();
        var group_id = $("#group_overtime_id").val();
        var start_date = $("#start_date_overtime").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableOvertime.addRow({
                    group_id: $("#group_overtime_id").val(),
                    group_name: $("#group_overtime_id option:selected").text(),
                    start_date: $("#start_date_overtime").val(),
                    end_date: $("#end_date_overtime").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-overtime").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableOvertime.getRows().find(r => {
            let d = r.getData();

            return d.group_id == group_id &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", group_id, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                group_id: $("#group_overtime_id").val(),
                group_name: $("#group_overtime_id option:selected").text(),
                start_date: $("#start_date_overtime").val(),
                end_date: $("#end_date_overtime").val(),
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

        $("#modal-overtime").modal("hide");
    });
</script>
@endpush