<?php
    require './appcode/globals.inc.php';
    require_once './include/website_common.inc.php';
    include 'include/header.inc.php';
?>

<div id="wrapper">
    <?php include 'include/topmain.inc.php'; ?>
    <div id="container-body" style="min-height:560px;">
        <div class="container sitemap">
            <?php //include('include/urlpath.inc.php'); ?>
        </div>

        <div class="container">
            <div class="pull-right smallfont">Date: <?= (new DateTime())->format('d-m-Y'); ?></div>
            <div class="clearfix"></div>

            <div class="row" style="padding-left:21px;">
                <h3>Event Calender</h3>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Event Calendar</li>
                </ol>
            </nav>

            <div class="row">
                <div id='calendar' class='ecp'></div>
            </div>

            <div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true" style="z-index: 100000;">
                <div class="modal-dialog modal-lg" style="margin-top: 30px;">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header" style="background-color: #1f5692!important; color: #fff!important;">
                            <h5 class="modal-title text-white" id="eventModalLabel"><i class="fa fa-info-circle me-2" style="color: #fff!important;"></i> Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3 id="modalEventTitle" style="color: #1f5692; margin-bottom: 20px; font-weight: 700;"></h3>
                            <div class="col-md-6 mb-2 mb-md-0">
                                <p class="mb-0"><strong><i class="fa fa-calendar-alt text-primary me-2"></i> Start Date:</strong> <span id="modalEventStart"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0"><strong><i class="fa fa-calendar-check text-success me-2"></i> End Date:</strong> <span id="modalEventEnd"></span></p>
                            </div>
                            <div id="modalEventDesc" style="line-height: 1.8; font-size: 1.1em; color: #333; padding: 5px;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn text-white" style="background-color: #1f5692;" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>


        
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listMonth'
                },
                events: 'event_calendar_fetch.php',
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    
                    document.getElementById('modalEventTitle').innerText = info.event.title;
                    document.getElementById('modalEventStart').innerText = info.event.extendedProps.start_date;
                    document.getElementById('modalEventEnd').innerText = info.event.extendedProps.end_date;
                    document.getElementById('modalEventDesc').innerHTML = info.event.extendedProps.description || 'No additional details provided.';
                    
                    var myModal = new bootstrap.Modal(document.getElementById('eventModal'));
                    myModal.show();
                },
                eventDidMount: function(info) {
                    tippy(info.el, {
                        content: info.event.extendedProps.tooltip,
                        placement: 'top',
                        allowHTML: true,
                        theme: 'light-border',
                    });
                    
                    if (info.event.textColor) {
                        info.el.style.color = info.event.textColor;
                        var titleEl = info.el.querySelector('.fc-event-title');
                        if (titleEl) titleEl.style.color = info.event.textColor;
                    }
                },
                displayEventTime: false,
                eventDisplay: 'block',
                height: 'auto'
            });
            calendar.render();
        });
        </script>
        <?php include('include/footer_main.inc.php'); ?>
                    <script src="https://unpkg.com/@popperjs/core@2"></script>
            <script src="https://unpkg.com/tippy.js@6"></script>
        
    </body>
</html>
