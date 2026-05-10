 <div class="card-body">
     <div class="row w-full">
         <div class="col">
             <h3 class="card-title mb-0">Employee</h3>
             <p class="text-secondary m-0">Table description.</p>
         </div>
         <div class="col-md-auto col-sm-12">
             <div class="ms-auto d-flex flex-wrap btn-list">
                 <div class="input-group input-group-flat w-auto">
                     <span class="input-group-text">
                         <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                             <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                             <path d="M21 21l-6 -6"></path>
                         </svg>
                     </span>
                     <input placeholder="Search Here..." id="search-input-history" type="text" class="form-control" autocomplete="off">
                 </div>
                 <button type="button" onclick="reloadTableSalaryImportHistory()" class="btn btn-icon" aria-label="Button">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pointer-search">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14.778 12.222l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093" />
                         <path d="M15 18a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                         <path d="M20.2 20.2l1.8 1.8" />
                     </svg>
                 </button>
                 <div class="dropdown">
                     <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Export</a>
                     <div class="dropdown-menu" style="">
                         <a class="dropdown-item" href="#">CSV</a>
                         <a class="dropdown-item" href="#">PDF</a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Your education content here -->
     <div id="table-salary-import-history"></div>
 </div>


 @push('scripts')
 <script>
     var tableGroupShift = new Tabulator("#table-salary-import-history", {
         ajaxURL: "{{ route('payroll.getSalaryImportHistory') }}", // endpoint Laravel
         ajaxConfig: "GET",
         // 🔥 layout fix (penting)
         //  layout: "fitData",
         layout: "fitColumns",
         responsiveLayout: true, // disable hide/collapse → pakai scroll
         height: "450px",
         // 🔥 pagination
         pagination: "local",
         paginationSize: 10,
         paginationSizeSelector: [10, 25, 50, 100],
         index: 'id',
         columns: [{
                 title: "ID",
                 field: "id",
                 width: 150,
                 visible: false
             },
             {
                 title: "No",
                 formatter: "rownum",
                 hozAlign: "center",
                 width: 60
             },
             {
                 title: "Period Name",
                 field: "period_name",
             },
             {
                 title: "Employee Name",
                 field: "employee_name",
             },
             {
                 title: "Allowance Name",
                 field: "allowance_name",
             },
             {
                 title: "Amount",
                 field: "amount",
                 formatter: "money",
                 formatterParams: {
                     decimal: ".",
                     thousand: "",
                     symbol: "Rp ",
                     precision: 0,
                 },
             },
             {
                 title: "Created By",
                 field: "created_by",
             },
             {
                 title: "Created At",
                 field: "created_at",
                 formatter: "datetime",
                 formatterParams: {
                     inputFormat: "yyyy-MM-dd HH:mm:ss", // sesuai format dari Laravel
                     outputFormat: "dd MMM yyyy HH:mm", // tampilan yang diinginkan
                     invalidPlaceholder: "-"
                 },
                 hozAlign: "center"
             }
         ],
     });


     function reloadTableSalaryImportHistory() {
         const search = document.getElementById("search-input-history").value;
         console.log("Search Input:", search); // Debugging: cek nilai search
         tableGroupShift.setData("{{ route('payroll.getSalaryImportHistory') }}", {
             search: search
         });
     }
 </script>
 @endpush