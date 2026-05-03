<div class="modal modal-blur fade   py-6" id="modal-grade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-grade">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Grade </label>
                            <select id="grade_id" placeholder="Enter grade id" class="form-control">
                                <option value="">Select grade</option>
                            </select>

                            <input type="text" hidden name="grade_name" id="grade_name">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_grade" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_grade" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-grade" id="crud-action-grade">
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
    function CrudGrade(action, id) {
        let form = document.getElementById('form-crud-grade');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-grade").val(action);
        $('#form-crud-grade').find('input, select').attr('readonly', true).attr('disabled', true);


        var grade_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableGrade.getRows().find(r => {
                let d = r.getData();

                return d.grade_id == grade_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", grade_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#grade_id").val(data.grade_id);
            $("#grade_name").val(data.grade_name);
            $("#start_date_grade").val(data.start_date);
            $("#end_date_grade").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-grade').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#grade_id").attr("disabled", false)
                break;
            case "update":

                $('#form-crud-grade').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#grade_id").attr("disabled", true)
                $("#end_date_grade").attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-grade').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-grade").modal("show");
    }

    $("#grade_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        $("#grade_name").val(name);
    });
    $('#form-crud-grade').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-grade").val();
        var gradeId = $("#grade_id").val();
        var start_date = $("#start_date_grade").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableGrade.addRow({
                    grade_id: $("#grade_id").val(),
                    grade_name: $("#grade_name").val(),
                    start_date: $("#start_date_grade").val(),
                    end_date: $("#end_date_grade").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-grade").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableGrade.getRows().find(r => {
            let d = r.getData();

            return d.grade_id == gradeId &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", gradeId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                end_date: $("#end_date_grade").val(),
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

        $("#modal-grade").modal("hide")
    });
</script>
@endpush