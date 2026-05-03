<div class="modal modal-blur fade   py-6" id="modal-position" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-position">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Position </label>
                            <select id="position_id" placeholder="Enter position id" class="form-control">
                                <option value="">Select Position</option>
                            </select>

                            <input type="text" hidden name="position_name" id="position_name">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_position" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_position" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-position" id="crud-action-position">
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
    function CrudPosition(action, id) {
        let form = document.getElementById('form-crud-position');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-position").val(action);
        $('#form-crud-position').find('input, select').attr('readonly', true).attr('disabled', true);


        var position_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tablePosition.getRows().find(r => {
                let d = r.getData();

                return d.position_id == position_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", position_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#position_id").val(data.position_id);
            $("#position_name").val(data.position_name);
            $("#start_date_position").val(data.start_date);
            $("#end_date_position").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-position').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#position_id").attr("disabled", false)
                break;
            case "update":

                $('#form-crud-position').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#position_id").attr("disabled", true)
                $("#end_date_position").attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-position').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-position").modal("show");
    }

    $("#position_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        $("#position_name").val(name);
    });
    $('#form-crud-position').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-position").val();
        var positionId = $("#position_id").val();
        var start_date = $("#start_date_position").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tablePosition.addRow({
                    position_id: $("#position_id").val(),
                    position_name: $("#position_name").val(),
                    start_date: $("#start_date_position").val(),
                    end_date: $("#end_date_position").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-position").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tablePosition.getRows().find(r => {
            let d = r.getData();

            return d.position_id == positionId &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", positionId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                end_date: $("#end_date_position").val(),
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

        $("#modal-position").modal("hide")
    });
</script>
@endpush