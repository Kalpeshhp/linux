@extends('layouts.admin')

@section('content')
    <div class="content">
        <!-- Inner container -->
        <div class="d-flex align-items-start flex-column flex-md-row">

            <!-- Left content -->
            <div class="tab-content w-100 order-2 order-md-1">

                <div class="tab-pane fade active show" id="activity">

                    <!-- Timeline -->
                    <div class="timeline-left">
                        <div class="">
                            <!-- Invoices -->
                            <div class="">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card border-left-3 border-left-danger rounded-left-0">
                                            <div class="card-body">
                                                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                                                    <div>
                                                        <h6 class="font-weight-semibold">{{$package[0]->package->package_name}}</h6>
                                                        <ul class="list list-unstyled mb-0">
                                                            <li>Subscribed on: <span class="font-weight-semibold badge bg-warning">{{date('d-m-Y', strtotime($package[0]->created_at) )}}</span></li>
                                                            <li>Expires on: <span class="font-weight-semibold badge bg-warning">{{date('d-m-Y', strtotime($package[0]->expires_on) )}}</span></li>
                                                        </ul>
                                                    </div>

                                                    <div class="text-sm-right mb-0 mt-3 mt-sm-0 ml-auto">
                                                        <h6 class="font-weight-semibold">${{$package[0]->package->price}}</h6>
                                                        <ul class="list list-unstyled mb-0">
                                                            <li>Method: <span class="font-weight-semibold">SWIFT</span></li>
                                                            <li class="dropdown">
                                                                Status: <span class="font-weight-semibold badge bg-success">ACTIVE</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /invoices -->
                        </div>
                    </div>
                    <!-- /timeline -->

                </div>

                <div class="tab-pane fade" id="schedule">

                    <!-- Available hours -->
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title">Available hours</h6>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                    <a class="list-icons-item" data-action="reload"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="chart-container">
                                <div class="chart has-fixed-height" id="available_hours" _echarts_instance_="ec_1571896730068" style="-webkit-tap-highlight-color: transparent; user-select: none; position: relative;"><div style="position: relative; overflow: hidden; width: 100px; height: 400px; padding: 0px; margin: 0px; border-width: 0px;"><canvas data-zr-dom-id="zr_0" width="100" height="400" style="position: absolute; left: 0px; top: 0px; width: 100px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div></div></div>
                            </div>
                        </div>
                    </div>
                    <!-- /available hours -->


                    <!-- Schedule -->
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">My schedule</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                    <a class="list-icons-item" data-action="reload"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="my-schedule fc fc-ltr fc-unthemed" style=""><div class="fc-toolbar fc-header-toolbar"><div class="fc-left"><div class="fc-button-group"><button type="button" class="fc-prev-button fc-button fc-button-primary" aria-label="prev"><span class="fc-icon fc-icon-chevron-left"></span></button><button type="button" class="fc-next-button fc-button fc-button-primary" aria-label="next"><span class="fc-icon fc-icon-chevron-right"></span></button></div><button type="button" class="fc-today-button fc-button fc-button-primary">today</button></div><div class="fc-center"><h2>Nov 9 – 15, 2014</h2></div><div class="fc-right"><div class="fc-button-group"><button type="button" class="fc-dayGridMonth-button fc-button fc-button-primary">month</button><button type="button" class="fc-timeGridWeek-button fc-button fc-button-primary fc-button-active">week</button><button type="button" class="fc-timeGridDay-button fc-button fc-button-primary">day</button></div></div></div><div class="fc-view-container"><div class="fc-view fc-timeGridWeek-view fc-timeGrid-view" style=""><table class=""><thead class="fc-head"><tr><td class="fc-head-container fc-widget-header"><div class="fc-row fc-widget-header"><table class=""><thead><tr><th class="fc-axis fc-widget-header" style="width: 1px;"></th><th class="fc-day-header fc-widget-header fc-sun fc-past" data-date="2014-11-09"><span>Sun 11/9</span></th><th class="fc-day-header fc-widget-header fc-mon fc-past" data-date="2014-11-10"><span>Mon 11/10</span></th><th class="fc-day-header fc-widget-header fc-tue fc-past" data-date="2014-11-11"><span>Tue 11/11</span></th><th class="fc-day-header fc-widget-header fc-wed fc-past" data-date="2014-11-12"><span>Wed 11/12</span></th><th class="fc-day-header fc-widget-header fc-thu fc-past" data-date="2014-11-13"><span>Thu 11/13</span></th><th class="fc-day-header fc-widget-header fc-fri fc-past" data-date="2014-11-14"><span>Fri 11/14</span></th><th class="fc-day-header fc-widget-header fc-sat fc-past" data-date="2014-11-15"><span>Sat 11/15</span></th></tr></thead></table></div></td></tr></thead><tbody class="fc-body"><tr><td class="fc-widget-content"><div class="fc-day-grid"><div class="fc-row fc-week fc-widget-content"><div class="fc-bg"><table class=""><tbody><tr><td class="fc-axis fc-widget-content" style="width: 1px;"><span>all-day</span></td><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2014-11-09"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2014-11-10"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2014-11-11"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2014-11-12"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2014-11-13"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2014-11-14"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2014-11-15"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><tbody><tr><td class="fc-axis" style="width: 1px;"></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-not-start fc-end" style="background-color:#42A5F5;border-color:#42A5F5"><div class="fc-content"> <span class="fc-title">University</span></div></a></td><td></td><td class="fc-event-container" colspan="2"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end" style="background-color:#26A69A;border-color:#26A69A"><div class="fc-content"> <span class="fc-title">Conference</span></div></a></td><td></td><td></td><td></td></tr></tbody></table></div><div class="fc-bgevent-skeleton"><table><tbody><tr><td class="fc-axis" style="width: 1px;"></td><td class="fc-nonbusiness fc-bgevent" colspan="1"></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div><div class="fc-bgevent-skeleton"><table><tbody><tr><td class="fc-axis" style="width: 1px;"></td><td></td><td></td><td></td><td></td><td></td><td></td><td class="fc-nonbusiness fc-bgevent" colspan="1"></td></tr></tbody></table></div></div></div><hr class="fc-divider fc-widget-header"><div class="fc-scroller fc-time-grid-container" style="overflow: hidden; height: 0px;"><div class="fc-time-grid"><div class="fc-bg"><table class=""><tbody><tr><td class="fc-axis fc-widget-content" style="width: 1px;"></td><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2014-11-09"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2014-11-10"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2014-11-11"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2014-11-12"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2014-11-13"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2014-11-14"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2014-11-15"></td></tr></tbody></table></div><div class="fc-slats"><table class=""><tbody><tr data-time="00:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>12am</span></td><td class="fc-widget-content"></td></tr><tr data-time="00:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="01:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>1am</span></td><td class="fc-widget-content"></td></tr><tr data-time="01:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="02:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>2am</span></td><td class="fc-widget-content"></td></tr><tr data-time="02:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="03:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>3am</span></td><td class="fc-widget-content"></td></tr><tr data-time="03:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="04:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>4am</span></td><td class="fc-widget-content"></td></tr><tr data-time="04:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="05:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>5am</span></td><td class="fc-widget-content"></td></tr><tr data-time="05:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="06:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>6am</span></td><td class="fc-widget-content"></td></tr><tr data-time="06:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="07:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>7am</span></td><td class="fc-widget-content"></td></tr><tr data-time="07:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="08:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>8am</span></td><td class="fc-widget-content"></td></tr><tr data-time="08:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="09:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>9am</span></td><td class="fc-widget-content"></td></tr><tr data-time="09:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="10:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>10am</span></td><td class="fc-widget-content"></td></tr><tr data-time="10:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="11:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>11am</span></td><td class="fc-widget-content"></td></tr><tr data-time="11:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="12:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>12pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="12:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="13:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>1pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="13:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="14:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>2pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="14:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="15:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>3pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="15:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="16:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>4pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="16:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="17:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>5pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="17:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="18:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>6pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="18:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="19:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>7pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="19:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="20:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>8pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="20:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="21:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>9pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="21:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="22:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>10pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="22:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr><tr data-time="23:00:00"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"><span>11pm</span></td><td class="fc-widget-content"></td></tr><tr data-time="23:30:00" class="fc-minor"><td class="fc-axis fc-time fc-widget-content" style="width: 1px;"></td><td class="fc-widget-content"></td></tr></tbody></table></div><hr class="fc-divider fc-widget-header" style="display:none"><div class="fc-content-skeleton"><table><tbody><tr><td class="fc-axis" style="width: 1px;"></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(141, 110, 99); border-color: rgb(141, 110, 99); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="1:00" data-full="1:00 PM"><span>1:00</span></div><div class="fc-title">Shopping</div></div></a></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(120, 144, 156); border-color: rgb(120, 144, 156); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="9:30" data-full="9:30 AM"><span>9:30</span></div><div class="fc-title">Meeting</div></div></a></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(38, 166, 154); border-color: rgb(38, 166, 154); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="2:30" data-full="2:30 PM"><span>2:30</span></div><div class="fc-title">Happy Hour</div></div></a></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(76, 175, 80); border-color: rgb(76, 175, 80); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="3:00" data-full="3:00 AM"><span>3:00</span></div><div class="fc-title">Birthday Party</div></div></a><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(255, 112, 67); border-color: rgb(255, 112, 67); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="7:00" data-full="7:00 PM"><span>7:00</span></div><div class="fc-title">Dinner</div></div></a></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(121, 134, 203); border-color: rgb(121, 134, 203); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="8:30" data-full="8:30 AM - 12:30 PM"><span>8:30 - 12:30</span></div><div class="fc-title">Meeting</div></div></a></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td><td><div class="fc-content-col"><div class="fc-event-container fc-mirror-container"></div><div class="fc-event-container"><a class="fc-time-grid-event fc-event fc-start fc-end fc-short" style="background-color: rgb(0, 188, 212); border-color: rgb(0, 188, 212); top: 0px; bottom: 0px; z-index: 1; left: 0%; right: 0%;"><div class="fc-content"><div class="fc-time" data-start="4:00" data-full="4:00 PM"><span>4:00</span></div><div class="fc-title">Shopping</div></div></a></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"><div class="fc-nonbusiness fc-bgevent" style="top: 0px; bottom: 0px;"></div></div></div></td></tr></tbody></table></div></div></div></td></tr></tbody></table></div></div></div>
                        </div>
                    </div>
                    <!-- /schedule -->

                </div>

                <div class="tab-pane fade" id="settings">

                    <!-- Profile info -->
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Profile information</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                    <a class="list-icons-item" data-action="reload"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="#">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Username</label>
                                            <input type="text" value="Eugene" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Full name</label>
                                            <input type="text" value="Kopyov" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Address line 1</label>
                                            <input type="text" value="Ring street 12" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Address line 2</label>
                                            <input type="text" value="building D, flat #67" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>City</label>
                                            <input type="text" value="Munich" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>State/Province</label>
                                            <input type="text" value="Bayern" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label>ZIP code</label>
                                            <input type="text" value="1031" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="text" readonly="readonly" value="eugene@kopyov.com" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Your country</label>
                                            <select class="form-control form-control-select2 select2-hidden-accessible" data-fouc="" tabindex="-1" aria-hidden="true">
                                                <option value="germany" selected="">Germany</option> 
                                                <option value="france">France</option> 
                                                <option value="spain">Spain</option> 
                                                <option value="netherlands">Netherlands</option> 
                                                <option value="other">...</option> 
                                                <option value="uk">United Kingdom</option> 
                                            </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-ec4c-container"><span class="select2-selection__rendered" id="select2-ec4c-container" title="Germany">Germany</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Phone #</label>
                                            <input type="text" value="+99-99-9999-9999" class="form-control">
                                            <span class="form-text text-muted">+99-99-9999-9999</span>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Upload profile image</label>
                                            <div class="uniform-uploader"><input type="file" class="form-input-styled" data-fouc=""><span class="filename" style="user-select: none;">No file selected</span><span class="action btn bg-warning legitRipple" style="user-select: none;">Choose File</span></div>
                                            <span class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary legitRipple">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /profile info -->


                    <!-- Account settings -->
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">Account settings</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                    <a class="list-icons-item" data-action="reload"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="#">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Username</label>
                                            <input type="text" value="Kopyov" readonly="readonly" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Current password</label>
                                            <input type="password" value="password" readonly="readonly" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>New password</label>
                                            <input type="password" placeholder="Enter new password" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label>Repeat password</label>
                                            <input type="password" placeholder="Repeat new password" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Profile visibility</label>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-choice"><span class="checked"><input type="radio" name="visibility" class="form-input-styled" checked="" data-fouc=""></span></div>
                                                    Visible to everyone
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-choice"><span><input type="radio" name="visibility" class="form-input-styled" data-fouc=""></span></div>
                                                    Visible to friends only
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-choice"><span><input type="radio" name="visibility" class="form-input-styled" data-fouc=""></span></div>
                                                    Visible to my connections only
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-choice"><span><input type="radio" name="visibility" class="form-input-styled" data-fouc=""></span></div>
                                                    Visible to my colleagues only
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Notifications</label>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-input-styled" checked="" data-fouc=""></span></div>
                                                    Password expiration notification
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-input-styled" checked="" data-fouc=""></span></div>
                                                    New message notification
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-input-styled" checked="" data-fouc=""></span></div>
                                                    New task notification
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <div class="uniform-checker"><span><input type="checkbox" class="form-input-styled"></span></div>
                                                    New contact request notification
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary legitRipple">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /account settings -->

                </div>
            </div>
            <!-- /left content -->


            <!-- Right sidebar component -->
            <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-right wmin-300 border-0 shadow-0 order-1 order-md-2 sidebar-expand-md">

                <!-- Sidebar content -->
                <div class="sidebar-content">

                    <!-- User card -->
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid rounded-circle" src="{{URL::asset('/images/user.jpg')}}" width="170" height="170" alt="">
                                
                                <div class="card-img-actions-overlay card-img rounded-circle">
                                    <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round legitRipple">
                                        <i class="icon-plus3"></i>
                                    </a>
                                    <a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2 legitRipple">
                                        <i class="icon-link"></i>
                                    </a>
                                </div>
                            </div>

                            <h6 class="font-weight-semibold mb-0">{{auth()->user()->name}}</h6>
                            <span class="d-block text-muted">Tailori Vendor</span>
                        </div>
                    </div>
                    <!-- /user card -->


                    <!-- Navigation -->
                    <div class="card">
                        <div class="card-header bg-transparent header-elements-inline">
                            <span class="card-title font-weight-semibold">Navigation</span>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="nav nav-sidebar my-2">
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-user"></i>
                                            My profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-cash3"></i>
                                        Balance
                                        <span class="text-muted font-size-sm font-weight-normal ml-auto">$1,430</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-tree7"></i>
                                        Connections
                                        <span class="badge bg-danger badge-pill ml-auto">29</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-users"></i>
                                        Friends
                                    </a>
                                </li>

                                <li class="nav-item-divider"></li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-calendar3"></i>
                                        Events
                                        <span class="badge bg-teal-400 badge-pill ml-auto">48</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-cog3"></i>
                                        Account settings
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /navigation -->

                </div>
                <!-- /sidebar content -->

            </div>
            <!-- /right sidebar component -->

        </div>
        <!-- /inner container -->
	</div>
@endsection