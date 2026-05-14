<div class="modal modal-blur fade   py-6" id="modal-ptkp" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-ptkp">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud PTKP Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> PTKP Status </label>
                            <select id="ptkp_code" class="form-control">
                                <option value="">Select PTKP Status</option>
                            </select>

                            <input type="text" hidden name="ptkp_code" id="ptkp_code">



                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_ptkp" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_ptkp" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-ptkp" id="crud-action-ptkp">
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
    function CrudPTKP(action, id) {
        let form = document.getElementById('form-crud-ptkp');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-ptkp").val(action);
        $('#form-crud-ptkp').find('input, select').attr('readonly', true).attr('disabled', true);


        var ptkp_code = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tablePTKP.getRows().find(r => {
                let d = r.getData();

                return d.ptkp_code == ptkp_code &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", ptkp_code, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#ptkp_code").val(data.ptkp_code);
            $("#start_date_ptkp").val(data.start_date);
            $("#end_date_ptkp").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-ptkp').find('input, select').attr('readonly', false).attr('disabled', false);
                break;
            case "update":

                $('#form-crud-ptkp').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#end_date_ptkp").attr('disabled', false);
                $("#end_date_ptkp").attr('readonly', false);
                break;
            case "delete":
                $('#form-crud-ptkp').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-ptkp").modal("show");
    }

    $("#ptkp_code").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        $("#ptkp_name").val(name);
    });
    $('#form-crud-ptkp').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-ptkp").val();
        var ptkp_code = $("#ptkp_code").val();
        var start_date = $("#start_date_ptkp").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tablePTKP.addRow({
                    ptkp_code: $("#ptkp_code").val(),
                    start_date: $("#start_date_ptkp").val(),
                    end_date: $("#end_date_ptkp").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-ptkp").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tablePTKP.getRows().find(r => {
            let d = r.getData();

            return d.ptkp_code == ptkp_code &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", ptkp_code, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                ptkp_code: $("#ptkp_code").val(),
                start_date: $("#start_date_ptkp").val(),
                end_date: $("#end_date_ptkp").val(),
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

        $("#modal-ptkp").modal("hide");
    });
</script>
@endpush