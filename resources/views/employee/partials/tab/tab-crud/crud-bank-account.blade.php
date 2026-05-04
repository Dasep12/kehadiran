<div class="modal modal-blur fade   py-6" id="modal-bank-account" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-bank-account">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 p-5">
                            <label class="form-label"> Bank Account </label>
                            <select id="bank_id" placeholder="Enter Bank id" class="form-control">
                                <option value="">Select Bank</option>
                            </select>

                            <input type="text" hidden name="bank_name" id="bank_name">

                            <label class="form-label"> Account Name </label>
                            <input type="text" id="account_name" placeholder="Enter Account Name" class="form-control">

                            <label class="form-label"> Account Number </label>
                            <input type="text" id="account_number" placeholder="Enter Account Number" class="form-control">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_bank_account" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_bank_account" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-bank-account" id="crud-action-bank-account">
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
    function CrudBankAccount(action, id) {
        let form = document.getElementById('form-crud-bank-account');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-bank-account").val(action);
        $('#form-crud-bank-account').find('input, select').attr('readonly', true).attr('disabled', true);


        var bank_id = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableBankAccount.getRows().find(r => {
                let d = r.getData();

                return d.bank_id == bank_id &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", bank_id, start_date);
                return;
            }

            let data = rowComponent.getData();
            $("#bank_id").val(data.bank_id);
            $("#bank_name").val(data.bank_name);
            $("#start_date_bank_account").val(data.start_date);
            $("#end_date_bank_account").val(data.end_date);
            $("#account_name").val(data.account_name);
            $("#account_number").val(data.account_number);
            console.log(data)
        }
        switch (action) {
            case "create":
                $('#form-crud-bank-account').find('input, select').attr('readonly', false).attr('disabled', false);
                break;
            case "update":

                $('#form-crud-bank-account').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#end_date_bank_account,#account_name,#account_number").attr('disabled', false);
                $("#end_date_bank_account,#account_name,#account_number").attr('readonly', false);
                break;
            case "delete":
                $('#form-crud-bank-account').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-bank-account").modal("show");
    }

    $("#bank_id").on("change", function() {
        let selectedOption = $(this).find(":selected");
        let name = selectedOption.data("name");
        $("#bank_name").val(name);
    });
    $('#form-crud-bank-account').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-bank-account").val();
        var bankId = $("#bank_id").val();
        var start_date = $("#start_date_bank_account").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableBankAccount.addRow({
                    bank_id: $("#bank_id").val(),
                    bank_name: $("#bank_name").val(),
                    account_name: $("#account_name").val(),
                    account_number: $("#account_number").val(),
                    start_date: $("#start_date_bank_account").val(),
                    end_date: $("#end_date_bank_account").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-bank-account").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableBankAccount.getRows().find(r => {
            let d = r.getData();

            return d.bank_id == bankId &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", bankId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                account_name: $("#account_name").val(),
                account_number: $("#account_number").val(),
                end_date: $("#end_date_bank_account").val(),
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

        $("#modal-bank-account").modal("hide");
    });
</script>
@endpush