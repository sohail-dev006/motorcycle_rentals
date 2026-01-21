@extends('layouts.admin')

@section('title','Calendar')
@section('page-title','Company Calendar')

@section('content')

<div class="row">
    <!-- Calendar Column -->
    <div class="col-12 col-lg-12">
        <div class="d-flex justify-content-between mb-3">
            <h4 class="fw-bold">Company Calendar</h4>

            @role('Super Admin')
            <button class="btn btn-warning" id="addEventBtn">
                <i class="fa fa-plus"></i> Add Event / Holiday
            </button>
            @endrole
        </div>

        <div class="mb-3">
            <div class="btn-group">
                <button class="btn btn-outline-primary" onclick="setFilter('all')">
                    <i class="fa fa-calendar"></i> All
                </button>
                <button class="btn btn-outline-danger" onclick="setFilter('holiday')">
                    <i class="fa fa-ban"></i> Holidays
                </button>
                <button class="btn btn-outline-info" onclick="setFilter('event')">
                    <i class="fa fa-bell"></i> Events
                </button>
            </div>
        </div>

    </div>
    
</div>
<div class="row">
    <!-- Sidebar Column -->
    <div class="col-lg-3 col-md-8">
        <h5 class="mb-3">List of Holidays & Events</h5>
        <div id="eventList" class="list-group" style="max-height: 600px; overflow-y: auto;">
            <!-- Dynamic list will be appended here -->
        </div>
    </div>
    <div class="col-lg-9 col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

@role('Super Admin')
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="eventForm" class="modal-content">
            @csrf
            <input type="hidden" id="event_id">

            <div class="modal-header">
                <h5 class="modal-title">Event / Holiday</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Title</label>
                    <input class="form-control" name="title" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Start Date</label>
                    <input class="form-control" type="date" name="start" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">End Date</label>
                    <input class="form-control" type="date" name="end">
                </div>
                <div class="form-check mt-2">
                    <input type="checkbox" name="is_holiday" id="holidayCheck" class="form-check-input">
                    <label for="holidayCheck" class="form-check-label">Holiday</label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="deleteEvent" class="btn btn-outline-danger me-auto">
                    <i class="fa fa-trash"></i> Delete
                </button>
                <button class="btn btn-success">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>
@endrole

@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let currentFilter = 'all';
    const isAdmin = @json(auth()->user()->hasRole('Super Admin'));
    const modalEl = document.getElementById('eventModal');
    const eventModal = modalEl ? new bootstrap.Modal(modalEl) : null;
    const calendarEl = document.getElementById('calendar');
    const eventListEl = document.getElementById('eventList');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        displayEventTime: false,
        editable: isAdmin,
        height: 'auto',
        weekends: true,
        events: fetchEvents,
        eventClick: handleEventClick,
        eventDrop: handleEventDrag,
        eventResize: handleEventDrag,
        dayCellClassNames: function(arg) {
            if (arg.date.getDay() === 0 || arg.date.getDay() === 6) {
                return ['weekend-day'];
            }
            return [];
        }
    });

    calendar.render();

    function fetchEvents(fetchInfo, successCallback) {
        fetch(`{{ route('calendar.fetch') }}?filter=${currentFilter}&_=${new Date().getTime()}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(event => event.can_edit = isAdmin);
                renderEventList(data);
                successCallback(data);
            });
    }

    function renderEventList(events) {
        eventListEl.innerHTML = '';
        if (events.length === 0) {
            eventListEl.innerHTML = '<div class="text-muted">No events found.</div>';
            return;
        }

        events.sort((a,b) => new Date(a.start) - new Date(b.start));

        events.forEach(event => {
            const div = document.createElement('div');
            div.className = 'list-group-item d-flex justify-content-between align-items-start';
            div.style.cursor = 'pointer';
            div.innerHTML = `
                <div>
                    <strong>${event.title}</strong><br>
                    <small>${event.start}${event.end ? ' to '+event.end : ''} - ${event.extendedProps.is_holiday ? 'Holiday' : 'Event'}</small>
                </div>
                <span class="badge ${event.extendedProps.is_holiday ? 'bg-danger' : 'bg-primary'} rounded-pill">
                    ${event.extendedProps.is_holiday ? 'H' : 'E'}
                </span>
            `;
            div.addEventListener('click', () => {
                const fcEvent = calendar.getEventById(event.id);
                if (fcEvent) fcEvent.setProp('color', fcEvent.backgroundColor); // refresh color
                fcEvent && fcEvent.click();
            });
            eventListEl.appendChild(div);
        });
    }

    function handleEventClick(info) {
        if (!info.event.extendedProps.can_edit) {
            alert(info.event.title);
            return;
        }

        document.querySelector('[name=title]').value = info.event.title;
        document.querySelector('[name=start]').value = info.event.startStr;
        document.querySelector('[name=end]').value = info.event.endStr ?? '';
        document.getElementById('holidayCheck').checked = info.event.extendedProps.is_holiday;
        document.getElementById('event_id').value = info.event.id;

        document.getElementById('deleteEvent').style.display = 'inline-block';
        eventModal.show();
    }

    function handleEventDrag(info) {
        if (!info.event.extendedProps.can_edit) return;
        fetch(`/calendar/drag/${info.event.id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                start: info.event.startStr,
                end: info.event.endStr
            })
        }).then(() => calendar.refetchEvents());
    }

    document.getElementById('addEventBtn')?.addEventListener('click', () => {
        document.getElementById('eventForm').reset();
        document.getElementById('event_id').value = '';
        document.getElementById('deleteEvent').style.display = 'none';
        eventModal.show();
    });

    document.getElementById('eventForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('event_id').value;
        const url = id ? `/calendar/update/${id}` : `{{ route('calendar.store') }}`;

        fetch(url, {
            method: id ? 'PUT' : 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: new FormData(this)
        })
        .then(() => calendar.refetchEvents())
        .then(() => eventModal.hide());
    });

    document.getElementById('deleteEvent')?.addEventListener('click', () => {
        const id = document.getElementById('event_id').value;
        if (!id || !confirm('Delete this event?')) return;

        fetch(`/calendar/delete/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(() => {
            eventModal.hide();
            calendar.refetchEvents();
        });
    });

    window.setFilter = function(type) {
        currentFilter = type;
        calendar.refetchEvents();
    }

});
</script>
@endpush

<style>
#calendar .fc-col-header-cell-cushion,
#calendar th {
    color: #212529 !important;
    font-weight: 600;
}
.weekend-day {
    background-color: #195086 !important;
}
</style>
