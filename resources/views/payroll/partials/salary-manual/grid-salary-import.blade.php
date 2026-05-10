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
                     <input placeholder="Search Here..." id="search-input" type="text" class="form-control" autocomplete="off">
                 </div>
                 <button type="button" onclick="reloadTableShift()" class="btn btn-icon" aria-label="Button">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pointer-search">
                         <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                         <path d="M14.778 12.222l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093" />
                         <path d="M15 18a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                         <path d="M20.2 20.2l1.8 1.8" />
                     </svg>
                 </button>
                 <div class="dropdown">
                     <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Download</a>
                     <div class="dropdown-menu">
                         <a id="btnExportExcel" class="dropdown-item" href="#">Format Import</a>
                     </div>
                 </div>
                 <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="CrudSalaryImport('create','*')" data-bs-target="#offcanvasSalaryImportEnd" role="button" aria-controls="offcanvasSalaryImportEnd"> Create </button>
             </div>
         </div>
     </div>
     <!-- Your education content here -->
     <div id="table-salary-import"></div>

     <div class="row">
         <div id="importProgressWrapper" style="display:none;">

             <div class="progress mt-3">
                 <div id="importProgressBar"
                     class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: 0%">
                     0%
                 </div>
             </div>

             <small id="importProgressText">
                 Waiting...
             </small>

         </div>
         <div class="col d-flex justify-content-start mt-3">
             <input type="file" class="form-control w-10" id="importExcel" accept=".xlsx,.xls,.csv">
             <button type="button" class="btn btn-outline-primary" onclick="SubmitSalaryImport()"><i class="ti ti-upload"></i> Submit</button>
         </div>
     </div>
 </div>




 @push('scripts')
 <script>
     let salaryData = [];
     let allowanceColumns = [];
     let allowanceEmployee = [];
     var tableSalaryImport = new Tabulator("#table-salary-import", {
         layout: "fitData",
         height: "450px",
         placeholder: "No Import Data Available",
         index: "employee_code",
         columns: [{
             title: "Employee",
             field: "employee_name"
         }, {
             title: "Employee Code",
             field: "employee_code"
         }, {
             title: 'Status',
             field: 'status',
             formatter: "html",
         }, {
             title: "Action",
             field: 'option',
             formatter: actionFormatterDetail,
             width: 120,
             frozen: true,
             hozAlign: "center",
         }]
     });

     function actionFormatterDetail(cell) {
         let data = cell.getRow().getData();
         console.log(data);
         let id = data.employee_code;
         return `
        <button type="button" onclick="CrudSalaryImport('delete', '${id}')" class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        `
     }
 </script>
 @endpush

 @include('payroll.partials.crud-salary-import')