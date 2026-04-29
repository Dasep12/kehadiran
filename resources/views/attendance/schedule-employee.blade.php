@extends('layouts.main')

@section('content')
<!--  BEGIN PAGE HEADER  -->
<!-- <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ $title }}</h2>
            </div>
        </div>
    </div>
</div> -->
<!-- END PAGE HEADER  -->
<!-- BEGIN PAGE BODY  -->

<style>
    .avatar {
        border-radius: 90px !important;

    }

    .tabulator-row .tabulator-cell {
        /* height: 40px !important; */
    }
</style>
<div class="page-body">
    <div class="container-xl">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row w-full">
                        <div class="col">
                            <h3 class="card-title mb-0">Employee</h3>
                            <p class="text-secondary m-0">Table description.</p>
                        </div>
                        <div class="col-md-auto col-sm-12">
                            <div class="ms-auto d-flex flex-wrap btn-list">


                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        Filter
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 300px;">

                                        <!-- RANGE DATE -->
                                        <label class="form-label">Date Range</label>
                                        <input type="text" id="date_range" class="form-control range_date_picker_schedule mb-3" placeholder="Select date range">

                                        <!-- SEARCH -->
                                        <label class="form-label">Search</label>
                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">
                                                <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                            </span>
                                            <input placeholder="Search Here..." id="search-input" type="text" class="form-control" autocomplete="off">
                                        </div>

                                        <!-- ACTION -->
                                        <div class="mt-2 d-flex justify-content-end gap-2">
                                            <button type="button" onclick="reloadTable()" class="btn btn-icon btn-outline-primary w-100" aria-label="Button">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pointer-search">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14.778 12.222l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093" />
                                                    <path d="M15 18a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                    <path d="M20.2 20.2l1.8 1.8" />
                                                </svg>
                                            </button>
                                        </div>

                                    </div>
                                </div>



                                <div class="dropdown">
                                    <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Export</a>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="#">CSV</a>
                                        <a class="dropdown-item" href="#">PDF</a>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="Crud('create','*')" data-bs-target="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"> Create Schedule</button>

                                <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="CrudShiftOvveride('create','*')" data-bs-target="#offcanvasEndOvveride" role="button" aria-controls="offcanvasEnd"> Create Shift Override</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Your education content here -->
                    <div id="schedule-table"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->
@push('scripts')
<script>
    let table;

    function loadSchedule() {
        let range = $(".range_date_picker_schedule").val();
        let search = $("#search-input").val()
        let start = "",
            end = "";

        if (range) {
            let separator = range.includes(" s/d ") ? " s/d " : " to ";

            if (range.includes(separator)) {
                [start, end] = range.split(separator);
            } else {
                start = range;
                end = range; // 🔥 otomatis samakan
            }
        }

        // Pastikan tanggal tidak kosong
        if (!start || !end) return alert("Pilih rentang tanggal!");

        fetch(`{{ route('attendance.EmployeeScheduleData') }}/?start_date=${start}&end_date=${end}&search${search}`)
            .then(response => response.json())
            .then(res => {
                // Definisikan Kolom Statis
                let columns = [{
                    title: "Karyawan",
                    field: "name",
                    width: 180,
                    frozen: true,
                    formatter: function(cell) {
                        let d = cell.getData();
                        return `<div style="display:flex; align-items:center; gap:10px; padding:5px;">
                            <img src="{{ asset('assets/images/employee') }}/${d.photo}" 
                                style="width:35px; height:35px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                            <div style="display:flex; flex-direction:column; line-height:1.2;">
                                <span style="font-weight:bold; font-size:13px; color:#333;">${d.name}</span>
                                <span style="font-size:11px; color:#777;">${d.code}</span>
                            </div>
                        </div>`;
                    }
                }];

                // Tambahkan Kolom Tanggal Dinamis
                res.dateLabels.forEach(date => {
                    columns.push({
                        title: date.label,
                        field: date.field,
                        hozAlign: "center",
                        width: 100, // Lebar ditambah sedikit agar teks "No Schedule" tidak terpotong
                        formatter: function(cell) {
                            let cellData = cell.getValue();

                            // 1. Cek jika datanya kosong atau null
                            if (!cellData || !cellData.name) {
                                return `<span style="color:#bdc3c7; font-size:10px; font-style:italic;">No Schedule</span>`;
                            }

                            // 2. Logic pewarnaan jika ada datanya
                            let color = "#2c3e50";
                            let fontWeight = "normal";

                            if (cellData.type === "HOLIDAY" || cellData.type === "OFF") {
                                color = "#e74c3c"; // Merah untuk Libur/Off
                                fontWeight = "bold";
                            }

                            return `<span style="color:${color}; font-weight:${fontWeight};">${cellData.name}</span>`;
                        }
                    });
                });

                // Hancurkan tabel lama jika sudah ada (agar kolom bisa ter-reset)
                if (table) table.destroy();

                // Inisialisasi ulang Tabulator
                table = new Tabulator("#schedule-table", {
                    // 🔥 default column behavior
                    columnDefaults: {
                        resizable: true,
                        headerSort: true,
                        vertAlign: "middle",
                    },
                    data: res.data,
                    columns: columns,
                    layout: "fitDataFill", // Menggunakan fitData agar kolom tidak gepeng saat range sedikit
                    height: "550px",
                });
            })
            .catch(err => console.error("Error loading data:", err));
    }

    // Jalankan saat tombol diklik
    function reloadTable() {
        loadSchedule();
    }
    // Jalankan pertama kali saat halaman dibuka
    document.addEventListener('DOMContentLoaded', loadSchedule);
</script>
@endpush


@include('attendance.partials.crud-schedule-employee');
@include('attendance.partials.crud-shift-ovveride');
@endsection