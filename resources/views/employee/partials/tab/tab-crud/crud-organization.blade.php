<div class="modal modal-blur fade   py-6" id="modal-organization" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" method="" id="form-crud-organization">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crud Organization</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="tree-organization"></div>
                        </div>
                        <div class="col-md-6 p-5">
                            <label class="form-label"> Organization </label>
                            <input type="text" id="organization_name" placeholder="Enter organization name" class="form-control">
                            <input type="text" hidden id="company_name" placeholder="Enter company name" class="form-control">
                            <input type="text" hidden id="organization_id" placeholder="Enter organization id" class="form-control">

                            <label class="form-label"> Start Date </label>
                            <input type="text" id="start_date_organization" placeholder="Enter Start Date" class="form-control date_picker">

                            <label class="form-label"> End Date </label>
                            <input type="text" id="end_date_organization" placeholder="Enter End Date" class="form-control date_picker">

                            <input type="text" hidden name="crud-action-organization" id="crud-action-organization">
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
    $('#tree-organization').jstree({
        core: {
            data: {
                url: '{{ route("coredata.organizationTree") }}',
                dataType: 'json'
            }
        },
        plugins: ["types"], // Aktifkan plugin types
        types: {
            "default": {
                "icon": "ti ti-users" // Icon default (contoh pakai Tabler Icons)
            },
        },
        types: {
            "default": {
                "icon": "ti ti-folder"
            },
            "company": {
                "icon": "ti ti-building" // icon khusus company
            },
            "organization": {
                "icon": "ti ti-sitemap" // icon untuk struktur organisasi
            }
        }

    });

    // Inisialisasi jsTree (Hanya satu kali saja!)
    $('#tree-organization')
        .on('loaded.jstree', function() {
            $(this).jstree('open_all');
        })
        .on('changed.jstree', function(e, data) {
            // Cek apakah ada node yang dipilih
            if (data.selected.length) {
                if ($("#crud-action-organization").val() == "create") {
                    var selectedNode = data.instance.get_node(data.selected[0]);
                    var nodeID = selectedNode.id; // Ambil ID dari database (primary key)
                    // console.log(selectedNode);
                    // console.log("ID yang dipilih: " + nodeID);
                    let companyId = selectedNode.parents
                        .filter(p => p !== "#")
                        .pop();

                    let companyName = data.instance.get_node(companyId).text;
                    // 2. Simpan ID ke input hidden atau variable global (opsional)
                    $('#organization_id').val(nodeID);
                    $('#organization_name').val(selectedNode.text);
                    $('#company_name').val(companyName);
                }
            } else {

            }
        })
        .jstree({
            core: {
                data: {
                    url: '{{ route("coredata.organizationTree") }}',
                    dataType: 'json'
                },
                multiple: false // Set false jika hanya boleh pilih satu jabatan
            },
            plugins: ["types"],
            types: {
                "default": {
                    "icon": "ti ti-users"
                }
            }
        });






    function CrudOrganization(action, id) {
        let form = document.getElementById('form-crud-organization');

        if (form) {
            form.reset();
        } else {
            console.warn("Form tidak ditemukan");
        }
        form.reset();
        $("#crud-action-organization").val(action);
        $('#form-crud-organization').find('input, select').attr('readonly', true).attr('disabled', true);
        var orgId = id.split("__")[0];
        var start_date = id.split("__")[1];
        if (id != '*') {
            let rowComponent = tableOrganization.getRows().find(r => {
                let d = r.getData();

                return d.organization_id == orgId &&
                    d.start_date == start_date;
            });
            if (!rowComponent) {
                console.warn("Row tidak ditemukan:", orgId, start_date);
                return;
            }

            let data = rowComponent.getData();
            // console.log(data);
            $("#organization_id").val(data.organization_id);
            $("#organization_name").val(data.organization_name);
            $("#start_date_organization").val(data.start_date);
            $("#end_date_organization").val(data.end_date);
        }
        switch (action) {
            case "create":
                $('#form-crud-organization').find('input, select').attr('readonly', false).attr('disabled', false);
                $("#organization_id").attr("disabled", true)
                $("#organization_name").attr("disabled", true)
                break;
            case "update":

                $('#form-crud-organization').find('input, select').attr('readonly', true).attr('disabled', true);
                $("#end_date_organization").attr('disabled', false);
                break;
            case "delete":
                $('#form-crud-organization').find('input, select').attr('readonly', true).attr('disabled', true);
                break;
        }

        $("#modal-organization").modal("show");
    }

    $('#form-crud-organization').on('submit', function(e) {
        e.preventDefault();
        var action = $("#crud-action-organization").val();
        var orgId = $("#organization_id").val();
        var start_date = $("#start_date_organization").val();


        if (action === 'create') {
            // 🔥 Tambah row baru di bawah tabel
            tableOrganization.addRow({
                    organization_id: $("#organization_id").val(),
                    organization_name: $("#organization_name").val(),
                    company_name: $("#company_name").val(),
                    start_date: $("#start_date_organization").val(),
                    end_date: $("#end_date_organization").val(),
                    status: "<span class='badge bg-success text-white'>new</span>",
                    action: 'create', // 🔥 langsung set action create
                    edit_mode: true // 🔥 langsung masuk mode edit
                }, true) // false = tambah di bawah, true = tambah di atas
                .then(function(row) {

                });
            $("#modal-organization").modal("hide");
            return; // stop disini, tidak perlu cari rowComponent
        }

        let rowComponent = tableOrganization.getRows().find(r => {
            let d = r.getData();

            return d.organization_id == orgId &&
                d.start_date == start_date;
        });
        if (!rowComponent) {
            console.warn("Row tidak ditemukan:", orgId, start_date);
            return;
        }
        if (action === 'update') {
            rowComponent.update({
                edit_mode: true,
                end_date: $("#end_date_organization").val(),
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

        $("#modal-organization").modal("hide")
    });
</script>
@endpush