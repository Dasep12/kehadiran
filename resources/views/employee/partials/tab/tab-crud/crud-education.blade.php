<div class="modal modal-blur fade   py-6" id="modal-education" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-education">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Education</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Education </label>
                            <select id="education_id" name="education_id" class="form-control">
                                <option value="">Select Education</option>
                            </select>

                            <label class="form-label"> Name Institution </label>
                            <input type="text" id="name_institution" name="name_institution" placeholder="Enter Name Institution" class="form-control">

                            <label class="form-label"> GPA </label>
                            <input type="text" id="gpa" name="gpa" placeholder="Enter GPA" class="form-control">

                            <label class="form-label"> Major </label>
                            <input type="text" id="major" name="major" placeholder="Enter Major" class="form-control">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_education" name="start_date_education" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_education" name="end_date_education" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-education" id="crud-action-education">
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
    function CrudEducation(action, id) {
        let form = document.getElementById('form-crud-education');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-education").val(action);
        $('#form-crud-education').find('input, select').attr('readonly', true).attr('disabled', true);


        var education_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableEducation.getRows().find(r => {
                let d = r.getData();

                return d.education_id == education_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", education_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#education_id").val(data.education_id);
            $("#name_institution").val(data.name_institution);
            $("#gpa").val(data.gpa);
            $("#major").val(data.major);
            $("#start_date_education").val(data.start_date);
            $("#end_date_education").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-education').find('input, select').attr('readonly', false).attr('disabled', false);
                break;
            case "update":

                $('#form-crud-education').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#end_date_education,#major,#gpa,#name_institution").attr('disabled', false);
                $("#end_date_education,#major,#gpa,#name_institution").attr('readonly', false);
                break;
            case "delete":
                $('#form-crud-education').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-education").modal("show");
    }

    $("#education_code").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        $("#education_name").val(name);
    });
    $('#form-crud-education').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-education").val();
        var education_id = $("#education_id").val();
        var start_date = $("#start_date_education").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableEducation.addRow({
                    education_id: $("#education_id").val(),
                    education_name: $("#education_id option:selected").text(),
                    name_institution: $("#name_institution").val(),
                    major: $("#major").val(),
                    gpa: $("#gpa").val(),
                    start_date: $("#start_date_education").val(),
                    end_date: $("#end_date_education").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-education").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableEducation.getRows().find(r => {
            let d = r.getData();

            return d.education_id == education_id &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", education_id, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                education_id: $("#education_id").val(),
                education_name: $("#education_id option:selected").text(),
                name_institution: $("#name_institution").val(),
                gpa: $("#gpa").val(),
                major: $("#major").val(),
                start_date: $("#start_date_education").val(),
                end_date: $("#end_date_education").val(),
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

        $("#modal-education").modal("hide");
    });
</script>
@endpush