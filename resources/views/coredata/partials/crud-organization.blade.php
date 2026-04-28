<div class="offcanvas offcanvas-end" id="offcanvasEnd">
    <form id="form-crud" method="POST" action="">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">Crud organization</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="content-crud">
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">ID</label>
                    <div class="col">
                        <input type="text" name="organization_id" id="organization_id" class="form-control" aria-describedby="emailHelp" placeholder="Enter ID">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Company Name</label>
                    <div class="col">
                        <select name="company_id" id="company_id" class="form-control" aria-describedby="parentHelp" placeholder="Enter parent organization">
                            <option value="">Select Company</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Level</label>
                    <div class="col">
                        <input type="number" name="level" id="level" class="form-control" aria-describedby="levelHelp" placeholder="Enter level">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Parent</label>
                    <div class="col">
                        <select name="parent_id" id="parent_id" class="form-control" aria-describedby="parentHelp" placeholder="Enter parent organization">
                            <option value="">Select Parent Organization</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Organization Name</label>
                    <div class="col">
                        <input type="text" name="organization_name" id="organization_name" class="form-control" aria-describedby="organizationHelp" placeholder="Enter Organization Name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Initial Name</label>
                    <div class="col">
                        <input type="text" name="initial" id="initial" class="form-control" aria-describedby="organizationHelp" placeholder="Enter Initial name">
                    </div>
                </div>


                <div class="mb-3 row">
                    <label class="col-3 col-form-label required">Sort</label>
                    <div class="col">
                        <input type="number" name="sort" id="sort" class="form-control" aria-describedby="levelHelp" placeholder="Enter Sort">
                    </div>
                </div>



                <div class="text-end">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x-mark">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 16l3.644 3.644a1.21 1.21 0 0 0 1.712 0l2.288 -2.288a1.21 1.21 0 0 0 0 -1.712l-3.644 -3.644l3.644 -3.644a1.21 1.21 0 0 0 0 -1.712l-2.288 -2.288a1.21 1.21 0 0 0 -1.712 0l-3.644 3.644l-3.644 -3.644a1.21 1.21 0 0 0 -1.712 0l-2.288 2.288a1.21 1.21 0 0 0 0 1.712l3.644 3.644l-3.644 3.644a1.21 1.21 0 0 0 0 1.712l2.288 2.288a1.21 1.21 0 0 0 1.712 0m3.644 -3.644" />
                        </svg>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-send">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M21.864 3.549l-6.454 17.868a1.55 1.55 0 0 1 -1.41 .903a1.54 1.54 0 0 1 -1.394 -.874l-2.88 -5.759zm-1.414 -1.414l-12.139 12.138l-5.728 -2.864a1.55 1.55 0 0 1 -.903 -1.409c0 -.606 .353 -1.157 .981 -1.44z" />
                        </svg>
                        Submit
                    </button>
                </div>
            </div>
            <div id="Crud-ErrorInfo"></div>

        </div>

    </form>



    <!-- Menyimpan ID posisi yang dipilih -->
    <input type="text" hidden id="selected-organization-id" value="">
    <!-- Menyimpan aksi CRUD saat ini -->
    <input type="text" hidden id="crud-action" value="">
</div>

@push('scripts')
<script>
    function Crud(action, id) {
        // Reset state form setiap kali buka
        document.getElementById('form-crud').reset();
        $('#form-crud').find('input, select').attr('readonly', false).attr('disabled', false);
        $('#organization_id').attr('disabled', false); // ID biasanya selalu readonly

        $('#crud-action').val(action);
        $('#selected-organization-id').val(id ? id : '');
        $('#Crud-ErrorInfo').html(''); // Reset error info
        switch (action) {
            case 'create':
                $('#form-crud')[0].reset();
                $('#offcanvasEndLabel').text('Create Organization');
                // $('#parent_id').empty().append('<option value="">Select Parent Organization</option>');
                // $('#company_id').empty().append('<option value="">Select Parent Organization</option>');
                break;

            case 'update':
                $('#offcanvasEndLabel').text('Edit Organization');
                $('#organization_id').attr('disabled', false);
                loadOrganizationDetail(id)
                break;

            case 'delete':
                loadOrganizationDetail(id)
                $('#offcanvasEndLabel').text('Delete organization');
                $('#Crud-ErrorInfo').html(`<div class="col-md-12 p-1">
                    <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                <path d="M12 9v4"></path>
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="alert-heading">Warning !</h4>
                            <div class="alert-description">Data will be deleted permanently.</div>
                        </div>
                    </div>
                </div>`);
                // Matikan semua input untuk konfirmasi hapus
                $('#form-crud input').attr('readonly', true);
                $('#form-crud select').attr('disabled', true);

                break;
        }
    }

    function loadCompany() {
        // Return promise agar bisa di-await
        $.ajax({
            url: '{{ route("coredata.getCompanyData") }}',
            method: 'GET',
            data: {}
        }).done(function(response) {
            let $parentSelect = $('#company_id');
            $parentSelect.empty().append('<option value="">Select Company</option>');

            if (response && response.length > 0) {
                response.forEach(function(company) {
                    $parentSelect.append(`<option value="${company.company_id}">${company.company_name}</option>`);
                });
            }
        }).fail(function(xhr) {
            console.error('Error fetching parent positions:', xhr);
        });
    }
    loadCompany();

    async function loadOrganizationDetail(id) {
        try {
            const response = await $.ajax({
                url: '{{ route("coredata.OrganizationTreeDetail") }}',
                method: 'GET',
                data: {
                    id: id
                }
            });
            console.log(response);
            // Isi field utama
            $('#company_id').val(response.company_id);
            $('#organization_id').val(response.organization_id);
            $('#organization_name').val(response.organization_name);
            $('#level').val(response.level);
            $('#sort').val(response.sort);
            $('#initial').val(response.initial);

            // TUNGGU load parent selesai berdasarkan level data yang ditarik
            await loadOrganizationParent(response.level);

            setTimeout(function() {
                // Setelah list parent tersedia, baru set valuenya
                $('#parent_id').val(response.parent_id);
            }, 100)

        } catch (error) {
            console.error('Error loading detail:', error);
        }
    }

    $('#level').on('change', function() {
        var level = $(this).val();
        loadOrganizationParent(level);
    });

    function loadOrganizationParent(level) {
        // Return promise agar bisa di-await
        return $.ajax({
            url: '{{ route("coredata.getParentOrganizationLevel") }}',
            method: 'GET',
            data: {
                level: level - 1,
                company_id: $("#company_id").val()
            }
        }).done(function(response) {
            let $parentSelect = $('#parent_id');
            $parentSelect.empty().append('<option value="">Select Parent Organization</option>');

            if (response && response.length > 0) {
                response.forEach(function(org) {
                    $parentSelect.append(`<option value="${org.organization_id}">${org.organization_name}</option>`);
                });
            }
        }).fail(function(xhr) {
            console.error('Error fetching parent positions:', xhr);
        });
    }

    $('#form-crud').on('submit', function(e) {
        e.preventDefault();
        let action = $('#crud-action').val();
        let id = $('#selected-organization-id').val();
        let url = '{{ route("coredata.CrudOrganization") }}';
        let method = 'POST';

        let formData = {
            organization_id: $('#organization_id').val(),
            organization_name: $('#organization_name').val(),
            level: $('#level').val(),
            parent_id: $('#parent_id').val(),
            company_id: $('#company_id').val(),
            initial: $('#initial').val(),
            sort: $('#sort').val(),
            action: action,
            _token: '{{ csrf_token() }}'
        };
        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                console.log(response);
                if (response.success) {
                    showAlert(response.message, response.status);

                    $('#offcanvasEnd').offcanvas('hide');
                    // REFRESH JSTREE
                    $('#tree-organization').jstree(true).refresh();
                    // Refresh data table atau lakukan aksi lain setelah sukses
                    reloadTable();

                } else {
                    $('#Crud-ErrorInfo').html(`<div class="col-md-12 p-1">
                        <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                            <div class="alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M12 9v4"></path>
                                    <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-heading">Error !</h4>
                                <div class="alert-description">${response.message}</div>
                            </div>
                        </div>
                    </div>`);
                }
            },
            error: function(xhr) {
                console.error('Error submitting form:', xhr.responseJSON);
                $('#Crud-ErrorInfo').html(`<div class="col-md-12 p-1">
                    <div class="alert alert-important alert-danger alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                <path d="M12 9v4"></path>
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="alert-heading">Error !</h4>
                            <div class="alert-description">${xhr.responseJSON.message}</div>
                        </div>
                    </div>
                </div>`);
            }
        });
    });
</script>
@endpush