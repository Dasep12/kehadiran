<div class="modal modal-blur fade   py-6" id="modal-family" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-family">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud family</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Relation </label>
                            <select id="family_id" placeholder="Enter family id" class="form-control">
                                <option value="">Select family</option>
                            </select>
                            <label class="form-label"> Full Name </label>
                            <input type="text" id="name_family" placeholder="Enter full name" class="form-control">

                            <label class="form-label"> Born Place </label>
                            <input type="text" id="born_place" placeholder="Enter born place" class="form-control">

                            <label class="form-label"> Born Date </label>
                            <input type="text" id="born_date" placeholder="Enter born date" class="form-control date_picker">

                            <label class="form-label"> Gender </label>
                            <select id="gender" placeholder="Enter gender" class="form-control">
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                            <label class="form-label"> ID Card </label>
                            <input type="text" id="id_identity" placeholder="Enter ID Card" class="form-control">

                            <label class="form-label"> Contact </label>
                            <input type="text" id="contact" placeholder="Enter contact" class="form-control">

                            <label class="form-label"> Address </label>
                            <textarea id="address" placeholder="Enter address" class="form-control"></textarea>



                            <input type="text" hidden name="crud-action-family" id="crud-action-family">
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
    function CrudFamily(action, id) {
        let form = document.getElementById('form-crud-family');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-family").val(action);
        $('#form-crud-family').find('input, select').attr('readonly', true).attr('disabled', true);


        var family_id = id;
        if (id != '*') {
            let rowComponent = tableFamily.getRows().find(r => {
                let d = r.getData();

                return d.family_id == family_id;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan: ", family_id);
                return;
            }

            let data = rowComponent.getData();
            $("#family_id").val(data.family_id);
            $("#name_family").val(data.name_family);
            $("#gender").val(data.gender);
            $("#born_date").val(data.born_date);
            $("#born_place").val(data.born_place);
            $("#contact").val(data.contact);
            $("#address").val(data.address);
            $("#id_identity").val(data.id_card);
        }
        switch (action) {
            case "create":
                $('#form-crud-family').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#family_id").attr("disabled", false)
                break;
            case "update":

                $('#form-crud-family').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#family_id").attr("disabled", true)
                $("#id_identity,#contact,#address,#gender,#born_date,#born_place,#name_family").attr('disabled', false);
                $("#id_identity,#contact,#address,#gender,#born_date,#born_place,#name_family").attr('readonly', false);
                break;
            case "delete":
                $('#form-crud-family').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-family").modal("show");
    }

    $('#form-crud-family').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-family").val();
        var familyId = $("#family_id").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableFamily.addRow({
                    family_id: $("#family_id").val(),
                    relation_name: $("#family_id option:selected").text(),
                    name_family: $("#name_family").val(),
                    born_place: $("#born_place").val(),
                    born_date: $("#born_date").val(),
                    id_card: $("#id_identity").val(),
                    gender: $("#gender").val(),
                    contact: $("#contact").val(),
                    address: $("#address").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-family").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableFamily.getRows().find(r => {
            let d = r.getData();

            return d.family_id == familyId;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", familyId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                relation_name: $("#family_id option:selected").text(),
                name_family: $("#name_family").val(),
                gender: $("#gender").val(),
                born_date: $("#born_date").val(),
                born_place: $("#born_place").val(),
                contact: $("#contact").val(),
                address: $("#address").val(),
                id_card: $("#id_identity").val(),
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

        $("#modal-family").modal("hide")
    });
</script>
@endpush