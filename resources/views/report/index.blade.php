@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="report-summary col-xl-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">REPORT SUMMARY</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Daily</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Monthly</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Yearly</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent" style="text-align: center; ">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-daily-tab" style="text-align: center;">
                        <div style="margin-bottom: 1rem;">
                            <div class="row">
                                <div class="col-xl-5 col-sm-12">
                                    <input class="form-control" type="DATE" value="" id="select-date-income-daily-chart">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="report-chart col-xl-12">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                        <div class="row detail-cards" style="margin-top: 1rem;">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Income</p>
                                        <p class="text-success" id="incomes_total_of_month">+ Rp.0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Unpaid</p>
                                        <p class="text-danger" id="unpaid_total_of_month">Rp.0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-monthly-tab">
                        <div style="margin-bottom: 1rem;">
                            <div class="row">
                                <div class="col-xl-5 col-sm-12">
                                    <input class="form-control" type="month" value="" id="select-month-income-monthly-chart">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="report-chart col-xl-12">
                                <canvas id="lineChart2"></canvas>
                            </div>
                        </div>
                        <div class="row detail-cards" style="margin-top: 1rem;">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Income</p>
                                        <p class="text-success" id="incomes_total_of_year">+ Rp.0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Unpaid</p>
                                        <p class="text-danger" id="unpaid_total_of_year">Rp.0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-yearly-tab">
                        <div style="margin-bottom: 1rem;">
                            <div class="row">
                                <div class="datePicker col-xl-5 col-sm-12">
                                    <form action="">
                                        <select name="start_year" class="form-control" value="" id="start-year">
                                            <?php
                                            $now_year = date('Y');
                                            ?>
                                            @for ($year = $now_year; $year >= 2010; $year--)
                                            <option value="{{$year}}">{{$year}}</option>
                                            @endfor
                                        </select>
                                        <select name="end_year" class="form-control" value="" id="end-year">
                                            <?php
                                            $now_year = date('Y');
                                            ?>
                                            @for ($year = $now_year; $year >= 2010; $year--)
                                            <option value="{{$year}}">{{$year}}</option>
                                            @endfor
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="report-chart col-xl-12">
                                <canvas id="yearlyChart"></canvas>
                            </div>
                        </div>
                        <div class="row detail-cards" style="margin-top: 1rem;">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Income</p>
                                        <p class="text-success" id="incomes_total_of_range_year">+ Rp.0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <p>Unpaid</p>
                                        <p class="text-danger" id="unpaid_total_of_range_year">Rp.0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-xl-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ALL UNPAID RENT</h6>
            </div>
            <div class="card-body" style="text-align: center;">
                <h3 class="text-danger">Rp. {{number_format($total_unpaid)}}</h3>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">ALL INCOME</h6>
            </div>
            <div class="card-body" style="text-align: center;">
                <h3 class="text-success">Rp. {{number_format($total_income)}}</h3>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">INCOME BY TYPE</h6>
            </div>
            <canvas class="col-mb-12" id="doughnutChart"></canvas>
            </a>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">INCOME ACTIVITY</h6>
            </div>
            <div class="card-body">
                <div class="row input-daterange">
                    <div class="col-md-4">
                        <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                    </div>
                    <div class="col-md-4">
                        <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                        <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                    </div>
                </div>
                <br>
                <div class="row no-gutters align-items-center table-responsive">
                    <div class="col mr-2" style="overflow-x:auto;">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Booking Number</th>

                                    <th scope="col">Booking Date</th>
                                    <th scope="col">Tenant</th>
                                    <th scope="col">Room</th>

                                    <th scope="col">Invoice Date</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- datatable --}}
<script src="{{asset('datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatables/buttons.flash.min.js')}}"></script>
<script src="{{asset('datatables/jszip.min.js')}}"></script>
<script src="{{asset('datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('datatables/buttons.print.min.js')}}"></script>
{{-- <script src="{{asset('js/demo/datatables-demo.js')}}"></script> --}}
{{-- format number --}}
<script src="{{asset('js/format-number.js')}}"></script>
<script>
    //menampilkan value date saat ini
    today = new Date();

    //Menampilkan value Date saat ini
    document.getElementById('select-date-income-daily-chart').valueAsDate = today;
    document.getElementById('select-month-income-monthly-chart').valueAsDate = today;
    document.getElementById('start-year').valueAsDate = today;
    document.getElementById('end-year').valueAsDate = today;


    //selected date dari daily chart
    selected_day = $("#select-date-income-daily-chart").val();
    selected_month = $("#select-month-income-monthly-chart").val();
    start_year = $("#start-year").val();
    end_year = $("#end-year").val();


    //url api
    url_daily_chart = "{{ url('api/v1/daily-income-data') }}/" + selected_day;
    url_monthly_chart = "{{ url('api/v1/monthly-income-data') }}/" + selected_month;
    url_yearly_chart = "{{ url('api/v1/yearly-income-data') }}/" + start_year + "/" + end_year;
    url_incomeByType_chart = "{{ url('api/v1/income-by-type') }}";
    //datatable income
    url_daterange_income = "{{ url('api/v1/income-datatable') }}";

    $(document).ready(function() {
        load_data();

        function load_data(from_date = '', to_date = '') {
            table_income = $('#dataTable').DataTable({
                ajax: {
                    url: url_daterange_income,
                    data: {
                        from_date: from_date,
                        to_date: to_date
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'booking_id',
                        name: 'booking_id'
                    },
                    //
                    {
                        data: 'booking_date',
                        name: 'booking_date'
                    },
                    {
                        data: 'tenant',
                        name: 'tenant',
                    },
                    {
                        data: 'room',
                        name: 'room',
                    },
                    //
                    {
                        data: 'invoice_date',
                        name: 'invoice_date'
                    },
                    {
                        data: 'total_payment',
                        name: 'total_payment',
                        defaultContent: '0',
                        render: function(data, type, row) {
                            return "Rp " + data;
                        },
                    },
                    {
                        data: 'is_paid',
                        name: 'is_paid',
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        sortable: false,
                        exportable: false,
                        printable: false,
                    },
                ],
                dom: 'lBfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        }

        // Date and time checking
        today = new Date();
        document.getElementById('from_date').valueAsDate = today;
        document.getElementById('to_date').valueAsDate = today;

        var temp_from_date;
        var temp_to_date;
        temp_from_date = $('#from_date').val();
        temp_to_date = $('#to_date').val();

        $('#from_date').change(function() {
            if ($('#from_date').val() > $('#to_date').val()) {
                alert("Start Date can't be more than the End Date");
                $('#from_date').val(temp_from_date);
            } else {
                temp_from_date = $('#from_date').val();
            }
        });

        $('#to_date').change(function() {
            if ($('#from_date').val() > $('#to_date').val()) {
                alert("End Date can't be less than the Start Date");
                $('#to_date').val(temp_to_date);
            } else {
                temp_to_date = $('#to_date').val();
            }
        });

        $('#filter').click(function() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $('#dataTable').DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                alert('Both Date is required');
            }
        });

        $('#refresh').click(function() {
            today = new Date();
            document.getElementById('from_date').valueAsDate = today;
            document.getElementById('to_date').valueAsDate = today;
            $('#dataTable').DataTable().destroy();
            load_data();
        });


    })


    // select date and update -- Daily Income Chart
    $("#select-date-income-daily-chart").change(function() {
        selected_day = $("#select-date-income-daily-chart").val();
        url_daily_chart = "{{ url('api/v1/daily-income-data') }}/" + selected_day;
        updateDailyIncomeChart();
    });

    // select month and update -- Monthly Income Chart
    $("#select-month-income-monthly-chart").change(function() {
        selected_month = $("#select-month-income-monthly-chart").val();
        url_monthly_chart = "{{ url('api/v1/monthly-income-data') }}/" + selected_month;
        updateMonthlyIncomeChart();
    });

    // select year and update -- Yearly Income Chart
    $("#start-year").change(function() {
        if ($('#start-year').val() > $('#end-year').val()) {
            alert("Start Year can't be more than the End Year");
            $("#start-year").val(today.getFullYear());
            $("#end-year").val(today.getFullYear());
        }
        start_year = $("#start-year").val();
        end_year = $("#end-year").val();
        url_yearly_chart = "{{ url('api/v1/yearly-income-data') }}/" + start_year + "/" + end_year;
        updateYearlyIncomeChart();
    });

    $("#end-year").change(function() {
        if ($('#end-year').val() < $('#start-year').val()) {
            alert("End Year can't be less than the Start Year");
            $("#start-year").val(today.getFullYear());
            $("#end-year").val(today.getFullYear());
        }
        start_year = $("#start-year").val();
        end_year = $("#end-year").val();
        url_yearly_chart = "{{ url('api/v1/yearly-income-data') }}/" + start_year + "/" + end_year;
        updateYearlyIncomeChart();
    });


    //line -- DAILY INCOME REPORT CHART
    var ctxL = document.getElementById("lineChart").getContext('2d');
    var myLineChart = new Chart(ctxL, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: "Income",
                data: [],
                backgroundColor: [
                    'rgba(0, 137, 132, .2)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .7)',
                ],
                borderWidth: 2
            }, {
                label: "Unpaid",
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return addCommas(value); // panggil function addComas di format-number.js
                        }
                    }
                }]
            }
        }
    });

    var updateDailyIncomeChart = function() {
        $.ajax({
            url: url_daily_chart,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                myLineChart.data.labels = data.days;
                myLineChart.data.datasets[0].data = data.daily_income_count_data;
                myLineChart.data.datasets[1].data = data.daily_unpaid_count_data;
                myLineChart.update();
                incomes_total_of_month.innerHTML = "+ Rp. " + data.incomes_total_of_month;
                unpaid_total_of_month.innerHTML = "Rp. " + data.unpaid_total_of_month;
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //update data daily chart
    updateDailyIncomeChart();


    //MONTHLY INCOME CHART
    var ctxL2 = document.getElementById("lineChart2").getContext('2d');
    var myLineChart2 = new Chart(ctxL2, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: "Income",
                data: [],
                backgroundColor: [
                    'rgba(0, 137, 132, .2)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .7)',
                ],
                borderWidth: 2
            }, {
                label: "Unpaid",
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return addCommas(value); //! panggil function addComas di format-number.js
                        }
                    }
                }]
            }
        }
    });

    var updateMonthlyIncomeChart = function() {
        $.ajax({
            url: url_monthly_chart,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                myLineChart2.data.labels = data.months;
                myLineChart2.data.datasets[0].data = data.monthly_income_count_data;
                myLineChart2.data.datasets[1].data = data.monthly_unpaid_count_data;
                incomes_total_of_year.innerHTML = "+ Rp. " + data.incomes_total_of_year;
                unpaid_total_of_year.innerHTML = "Rp. " + data.unpaid_total_of_year;
                myLineChart2.update();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //update data monthly chart
    updateMonthlyIncomeChart();

    //YEARLY INCOME CHART
    var ctxL3 = document.getElementById("yearlyChart").getContext('2d');
    var yearlyChart = new Chart(ctxL3, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: "Income",
                data: [],
                backgroundColor: [
                    'rgba(0, 137, 132, .2)',
                ],
                borderColor: [
                    'rgba(0, 10, 130, .7)',
                ],
                borderWidth: 2
            }, {
                label: "Unpaid",
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return addCommas(value); //! panggil function addComas di format-number.js
                        }
                    }
                }]
            }
        }
    });

    var updateYearlyIncomeChart = function() {
        $.ajax({
            url: url_yearly_chart,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                yearlyChart.data.labels = data.years;
                yearlyChart.data.datasets[0].data = data.yearly_income_count_data;
                yearlyChart.data.datasets[1].data = data.yearly_unpaid_count_data;
                incomes_total_of_range_year.innerHTML = "+ Rp. " + data.incomes_total_between_year;
                unpaid_total_of_range_year.innerHTML = "Rp. " + data.unpaid_total_between_year;
                yearlyChart.update();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //update data monthly chart
    updateYearlyIncomeChart();

    //INCOME BY TYPE
    var ctxD = document.getElementById("doughnutChart").getContext('2d');
    var myLineChart3 = new Chart(ctxD, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
            }]
        },
        options: {
            responsive: true
        }
    });

    //data income by type chart
    var updateIncomeByTypeChart = function() {
        $.ajax({
            url: url_incomeByType_chart,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                myLineChart3.data.labels = data.types;
                myLineChart3.data.datasets[0].data = data.total_income_by_type;
                myLineChart3.update();
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //update data income by type chart
    updateIncomeByTypeChart();
</script>
@endsection
