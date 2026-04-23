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
                 <button type="button" onclick="reloadTableOvertimeGroup()" class="btn btn-icon" aria-label="Button">
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
                 <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" type="button" onclick="CrudOvertimeGroup('create','*')" data-bs-target="#offcanvasEnd" role="button" aria-controls="offcanvasEnd"> Create </button>
             </div>
         </div>
     </div>
     <!-- Your education content here -->
     <div id="worktime-overtime-group"></div>
 </div>


 <!-- END PAGE BODY  -->
 @push('scripts')
 <script>
     var tableOvertimeGroup = new Tabulator("#worktime-overtime-group", {
         ajaxURL: "{{ route('worktime.getOvertimeGroupData') }}", // endpoint Laravel
         ajaxConfig: "GET",
         // 🔥 ajax param (filter support)
         ajaxParams: {
             search: "",
         },

         // 🔥 layout fix (penting)
         // layout: "fitData",
         layout: "fitColumns",
         responsiveLayout: true, // disable hide/collapse → pakai scroll
         height: "450px",
         // 🔥 pagination
         pagination: "local",
         paginationSize: 10,
         paginationSizeSelector: [10, 25, 50, 100],

         dataTree: true,
         dataTreeStartExpanded: false,

         index: "id", // gunakan pattern_id sebagai index untuk memudahkan pencarian data
         columns: [{
                 formatter: function() {
                     return "<b>+<b>";
                 },
                 width: 50,
                 hozAlign: "center",
                 cellClick: function(e, cell) {
                     var row = cell.getRow();
                     var rowEl = row.getElement();
                     var data = row.getData();

                     // remove kalau sudah ada
                     if (rowEl.nextSibling && rowEl.nextSibling.classList.contains("sub-table")) {
                         rowEl.nextSibling.remove();
                         cell.getElement().innerHTML = "<b>+</b>";
                         return;
                     }

                     var holder = document.createElement("div");
                     holder.classList.add("sub-table");

                     holder.style.padding = "0px";
                     holder.style.background = "#f8f9fa";

                     // 🔥 INI KUNCINYA
                     holder.style.marginLeft = "50px";

                     var tableEl = document.createElement("div");
                     holder.appendChild(tableEl);

                     rowEl.parentNode.insertBefore(holder, rowEl.nextSibling);

                     // 🔥 INI KUNCINYA → table baru = punya HEADER sendiri
                     new Tabulator(tableEl, {
                         ajaxURL: "{{ route('worktime.getOvertimeGroupDetailData') }}",
                         layout: "fitData",
                         ajaxParams: {
                             group_id: data.id,
                         },
                         height: "200px",
                         columns: [{
                                 title: "ID",
                                 field: "id",
                                 visible: false,
                             }, {
                                 title: "Rule Id",
                                 field: "rule_id",
                                 visible: false,
                             }, {
                                 title: "Rule Name",
                                 field: "rule_name"
                             },
                             {
                                 title: "Overtime Type",
                                 field: "overtime_type"
                             }, {
                                 title: "Day Type",
                                 field: "working_day_type",
                                 hozAlign: "center"
                             }, {
                                 title: "Min Overtime",
                                 field: "min_minutes",
                                 hozAlign: "center"
                             }, {
                                 title: "Max Overtime",
                                 field: "max_minutes"
                             }, {
                                 title: "Amount",
                                 field: "fixed_amount",
                                 formatter: "money",
                                 formatterParams: {
                                     decimal: ".",
                                     thousand: "",
                                     symbol: "Rp ",
                                     precision: 0,
                                 },
                             }

                         ],
                     });

                     cell.getElement().innerHTML = "<b> - </b>";
                 }
             },

             {
                 title: "Group ID",
                 field: "id",
                 visible: false
             },
             {
                 title: "No",
                 formatter: "rownum",
                 hozAlign: "center",
                 width: 60
             },
             {
                 title: "Group Name",
                 field: "group_name",
             }, {
                 title: "Created At",
                 field: "created_at",
                 formatter: "datetime",
                 formatterParams: {
                     inputFormat: "yyyy-MM-dd HH:mm:ss", // sesuai format dari Laravel
                     outputFormat: "dd MMM yyyy HH:mm", // tampilan yang diinginkan
                     invalidPlaceholder: "-"
                 },
                 hozAlign: "center"
             },
             {
                 title: "Action",
                 formatter: actionFormatterOvertimeGruop,
                 width: 100,
                 freeze: true,
                 hozAlign: "center",
             }
         ]
     });

     function actionFormatterOvertimeGruop(cell) {
         return `<button type="button" onclick="CrudOvertimeGroup('update', '${cell.getRow().getData().id}')" class="btn btn-sm btn-outline-primary me-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <path d="M12 20h9"></path>
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
            </svg>
        </button>
        <button type="button" onclick="CrudOvertimeGroup('delete', '${cell.getRow().getData().id}')" class="btn btn-sm btn-outline-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        `;
     }

     function reloadTableOvertimeGroup() {
         const search = document.getElementById("search-input").value;

         tableOvertimeGroup.setData("{{ route('worktime.getOvertimeGroupData') }}", {
             search: search
         });
     }
 </script>
 @endpush

 @include('worktime.partials.crud-overtime-group');