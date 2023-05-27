@extends('main')

@section('headers')

<link href="{{url('')}}/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css">

@endsection
@section('main_content')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">

            <div class="page-title-box">
                <div class="page-title-right">

                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">

                        @if( !is_null( $proprietario))
                          {{$proprietario->name}}
                        
                        @elseif ( app('request')->proprietario == -2)
                          Todos
                        @endif

                    </button>

                    @if (isset($proprietarios))
                    <div class="dropdown-menu dropdown-menu-end">
                        @foreach ($proprietarios as $proprietario_id => $value)
                        <a class="dropdown-item" target="_self"
                            href="{{route('agendamento.calendario', array('proprietario' =>  $proprietario_id) )}}">{{$value}}</a>
                        @endforeach

                        @if (Auth::user()->hasAnyRole( ['gerenciar_equipe']) )

                        <a class="dropdown-item" target="_self"
                            href="{{route('agendamento.calendario', array('proprietario' =>  '-2' ) )}}">Todos</a>
                        @endif

                    </div>
                    @endif
                </div>
                <h4 class="page-title">Calendar</h4>


            </div>

        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="d-grid text-end">
                                <button class="btn font-16 btn-danger" id="btn-new-event"><i
                                        class="mdi mdi-plus-circle-outline"></i> Criar Novo Evento</button>
                            </div>
                            <div id="external-events" class="m-t-20">

                            </div>

                        </div> <!-- end col-->

                        <div class="col-lg-12">
                            <div class="mt-4 mt-lg-0">
                                <div id="calendar"></div>
                            </div>
                        </div> <!-- end col -->

                    </div> <!-- end row -->
                </div> <!-- end card body-->
            </div> <!-- end card -->

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="needs-validation" name="event-form" id="form-event" novalidate="">
                            <div class="modal-header py-3 px-4 border-bottom-0">
                                <h5 class="modal-title" id="modal-title">Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4 pb-4 pt-0">
                                <div class="row">
                                <div class="col-12">
                                        <div class="mb-3">
                                            <label class="control-label form-label">Cliente</label>
                                            <a href="" class="form-control" id="event-negocio"></a>  
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="control-label form-label">Nome do Evento</label>
                                            <input class="form-control" placeholder="Insira Nome do Evento" type="text"
                                                name="title" id="event-title" required="">
                                            <div class="invalid-feedback">Please provide a valid event name</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="control-label form-label">Hora do Evento</label>
                                            <input class="form-control" placeholder="Insira Hora do Evento" type="text"
                                                name="title" id="event-hour" required="">
                                            <div class="invalid-feedback">Please provide a valid event name</div>
                                        </div>
                                    </div>
                                    <!--div class="col-12">
                                        <div class="mb-3">
                                            <label class="control-label form-label">Tipo</label>
                                            <select class="form-select" name="category" id="event-category" required="">
                                                <option value="bg-danger" selected="">Danger</option>
                                                <option value="bg-success">Success</option>
                                                <option value="bg-primary">Primary</option>
                                                <option value="bg-info">Info</option>
                                                <option value="bg-dark">Dark</option>
                                                <option value="bg-warning">Warning</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid event category</div>
                                        </div>
                                    </div-->
                                </div>
                                <!--div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger"
                                            id="btn-delete-event">Delete</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                    </div>
                                </div-->
                            </div>
                        </form>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->
        </div>
        <!-- end col-12 -->
    </div> <!-- end row -->
    <!-- end row -->
</div>
<!-- container -->




@endsection

@section('specific_scripts')

<script src="{{url('')}}/js/vendor/fullcalendar.min.js"></script>

<script>
!(function(l) {

    console.log(l);

    "use strict";

    function e() {
        (this.$body = l("body")),
        (this.$modal = new bootstrap.Modal(
            document.getElementById("event-modal"), {
                backdrop: "static"
            }
        )),
        (this.$calendar = l("#calendar")),
        (this.$formEvent = l("#form-event")),
        (this.$btnNewEvent = l("#btn-new-event")),
        (this.$btnDeleteEvent = l("#btn-delete-event")),
        (this.$btnSaveEvent = l("#btn-save-event")),
        (this.$modalTitle = l("#modal-title")),
        (this.$calendarObj = null),
        (this.$selectedEvent = null),
        (this.$newEventData = null);
    }
    (e.prototype.onEventClick = function(e) {
        this.$formEvent[0].reset(),
            this.$formEvent.removeClass("was-validated"),
            (this.$newEventData = null),
            this.$btnDeleteEvent.show(),
            this.$modalTitle.text("Agendamento"),
            this.$modal.show(),
            (this.$selectedEvent = e.event),
            l("#event-title").val(this.$selectedEvent.title),
            l("#event-negocio").text(this.$selectedEvent.extendedProps.negocio),
            l("#event-negocio").attr("href", this.$selectedEvent.extendedProps.href),
            l("#event-hour").val(this.$selectedEvent.start),
            l("#event-category").val(this.$selectedEvent.classNames[0]);
    }),
    

    (e.prototype.onSelect = function(e) {
        this.$formEvent[0].reset(),
            this.$formEvent.removeClass("was-validated"),
            (this.$selectedEvent = null),
            (this.$newEventData = e),
            this.$btnDeleteEvent.hide(),
            this.$modalTitle.text("Adicionar Novo Evento"),
            this.$modal.show(),
            this.$calendarObj.unselect();
    }),
    (e.prototype.init = function() {
        var e = new Date(l.now());
        new FullCalendar.Draggable(document.getElementById("external-events"), {
            itemSelector: ".external-event",
            eventData: function(e) {
                return {
                    title: e.innerText,
                    className: l(e).data("class")
                };
            }
        });

        
        var t = <?php echo json_encode($calendario);?>,
            a = this;

        (a.$calendarObj = new FullCalendar.Calendar(a.$calendar[0], {
            slotDuration: "00:15:00",
            slotMinTime: "09:00:00",
            slotMaxTime: "20:00:00",
            themeSystem: "bootstrap",
            bootstrapFontAwesome: !1,
            buttonText: {
                today: "Hoje",
                month: "Mês",
                week: "Semana",
                day: "Dia",
                list: "Lista",
                prev: "Anterior",
                next: "Próximo"
            },
            initialView: "dayGridMonth",
            handleWindowResize: !0,
            height: l(window).height() - 200,
            headerToolbar: {
                left: "prev,next,today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            initialEvents: t,
            editable: !0,
            droppable: !0,
            selectable: !0,
            dateClick: function(e) {
                a.onSelect(e);
            },
            eventClick: function(e) {
                a.onEventClick(e);
            }
        })),
        a.$calendarObj.render(),
            a.$btnNewEvent.on("click", function(e) {
                a.onSelect({
                    date: new Date(),
                    allDay: !0
                });
            }),
            a.$formEvent.on("submit", function(e) {
                e.preventDefault();
                var t,
                    n = a.$formEvent[0];
                n.checkValidity() ?
                    (a.$selectedEvent ?
                        (a.$selectedEvent.setProp("title", l("#event-title").val()),
                            a.$selectedEvent.setProp("classNames", [
                                l("#event-category").val()
                            ])) :
                        ((t = {
                                title: l("#event-title").val(),
                                start: a.$newEventData.date,
                                allDay: a.$newEventData.allDay,
                                className: l("#event-category").val()
                            }),
                            a.$calendarObj.addEvent(t)),
                        a.$modal.hide()) :
                    (e.stopPropagation(), n.classList.add("was-validated"));
            }),
            l(
                a.$btnDeleteEvent.on("click", function(e) {
                    a.$selectedEvent &&
                        (a.$selectedEvent.remove(),
                            (a.$selectedEvent = null),
                            a.$modal.hide());
                })
            );
    }),
    (l.CalendarApp = new e()),
    (l.CalendarApp.Constructor = e);

})(window.jQuery),
(function() {
    "use strict";
    window.jQuery.CalendarApp.init();
})();
</script>

@endsection