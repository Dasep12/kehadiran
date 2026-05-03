<!-- Employment Details Card -->
<div class="row row-cards">

    <!-- Kolom Kiri -->
    <div class="col-md-6 space-y">
        <div>
            <label class="form-label">Employee Code</label>
            <input type="text" name="employee_code" id="employee_code" placeholder="EX: EMP-001" class="form-control">
            <input type="text" hidden name="employee_id" id="employee_id">
        </div>

        <div>
            <label class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="employee_name" name="employee_name" placeholder="Enter full name" class="form-control" required>
        </div>

        <div>
            <label class="form-label">Email Address</label>
            <input type="email" name="email" id="email" placeholder="name@company.com" class="form-control">
        </div>

        <div>
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" placeholder="08123xxx" class="form-control">
        </div>

        <div>
            <label class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-select form-control">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div>
            <label class="form-label">Join Date</label>
            <input type="date" id="join_date" name="join_date" class="form-control date_picker">
        </div>
    </div>

    <!-- Kolom Kanan -->
    <div class="col-md-6 space-y">
        <div>
            <label class="form-label">ID Card (NIK) <span class="text-danger">*</span></label>
            <input type="text" id="id_card" name="id_card" placeholder="Enter 16 digit NIK" class="form-control" required>
        </div>

        <div>
            <label class="form-label">NPWP</label>
            <input type="text" id="npwp" name="npwp" placeholder="00.000.000.0-000.000" class="form-control">
        </div>


        <div>
            <label class="form-label">Employee Photo</label>
            <input type="file" id="file" name="photo" class="form-control" accept="image/*">
            <small class="text-muted">Max file size: 2MB (JPG, PNG)</small>
        </div>

    </div>

</div>