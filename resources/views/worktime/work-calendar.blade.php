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
<div class="page-body">
    <div class="container-xl">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE BODY  -->

@endsection

@push("scripts")
<script>
    var calendar; // ⬅️ global
    document.addEventListener('DOMContentLoaded', function() {

        let calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            editable: true,
            height: 'auto',
            contentHeight: 500,
            showNonCurrentDates: false,
            dayCellDidMount: function(info) {
                let day = info.date.getDay(); // 0 = Minggu, 6 = Sabtu

                if (day === 0 || day === 6) {
                    info.el.style.backgroundColor = '#ffe5e5'; // merah soft
                }
            },
            dateClick: function(info) {
                CrudWorkCalendar('create', '*');

                // isi tanggal ke input
                $('#holiday_date').val(info.dateStr);
            },
            eventClick: function(info) {
                let event = info.event;

                CrudWorkCalendar('update', event.id);

                $('#holiday_id').val(event.id);
                $('#holiday_date').val(event.startStr);
                $('#holiday_name').val(event.title);

                // ambil dari extendedProps
                $('#holiday_type').val(event.extendedProps.type);
            },
            events: "{{ route('worktime.getWorkCalendarData') }}",
        });

        calendar.render();
    })

    function reloadCalendar() {
        // 🔥 REFRESH CALENDAR
        calendar.refetchEvents();
    }
</script>
@endpush

@include('worktime.partials.crud-work-calendar');