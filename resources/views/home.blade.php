@extends('layouts.layout')

@section('content')
<!-- Cards -->
<div class="status-cards row" id="graph" class="tab-pane fade in active">
    <!-- Current Tenants Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Current Tenants</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span id="tmp">{{$active_tenant}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Available Rooms Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Available Rooms
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span id="kel">{{$available_room}}</span><span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booked Rooms Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Booked Rooms</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <span id="tek">{{$booked_room}}</span><span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Monthly Income Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">This Month Income</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <span id="arah">Rp. {{number_format($income)}}</span>
                        </div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div>
    <div class="row" id="charts">
        <!-- Income Chart -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-dark text-uppercase mb-1">Income Report</div>
                            <input class="form-control" hidden type="DATE" value="" id="select-month-income-monthly-chart">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenants Chart -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-dark text-uppercase mb-1">Total Booking</div>
                            <input class="form-control" hidden type="DATE" value="" id="select-month-booking-monthly-chart">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Details -->
<div class="row" id="details">
    <!-- Room Details -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2" style="overflow-x:auto;">
                        <div class="text-s font-weight-bold text-dark text-uppercase mb-1">Current Update Rooms</div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Room Number</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Capacity</th>
                                    <th scope="col">Rent</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($rooms as $room)
                                    <tr>
                                        <th>{{$no++}}</th>
                                        <td>{{$room->no_room}}</td>
                                        <td>{{$room->types->type_name}}</td>
                                        <td>{{$room->types->capacity}}</td>
                                        <td>Rp. {{number_format($room->types->rent_price)}}</td>
                                        @if ($room->status == 'available')
                                        <td class="text-success">{{$room->status}}</td>
                                        @elseif($room->status == 'booked')
                                        <td class="text-warning">{{$room->status}}</td>
                                        @else
                                        <td class="text-danger">{{$room->status}}</td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenants List -->
    <div class="current-tenants col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2" style="overflow-x:auto;">
                        <div class="text-s font-weight-bold text-dark text-uppercase mb-1">Current Tenant List</div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach ( $tenants as $tenant)
                                <tr>
                                    <th scope="row">{{$no++}}</th>
                                    <td>{{$tenant->tenant_name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script src="{{asset('js/format-number.js')}}"></script>
<script>

        //menampilkan value date saat ini
        today = new Date();

        //Menampilkan value tahun saat ini dari monthly chart
        document.getElementById('select-month-income-monthly-chart').valueAsDate = today;
        document.getElementById('select-month-booking-monthly-chart').valueAsDate = today;

        //selected date dari daily chart
        selected_month_income = $("#select-month-income-monthly-chart").val();
        selected_month_booking = $("#select-month-booking-monthly-chart").val();

        //url api
        url_income_monthly_chart = "{{ url('api/v1/monthly-income-data') }}/"+selected_month_income;
        url_booking_monthly_chart = "{{ url('api/v1/booking-data') }}/"+selected_month_booking;
        console.log(selected_month_booking);
        //line MONTHLY INCOME CHART REPORT
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
                    },{
                        label: "Unpaid",
                        data: [],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value, index, values) {
                                return addCommas(value); //! panggil function addComas di format-number.js
                            }
                        }
                    }]
                }
            }
        });

        var updateMonthlyIncomeChart = function() {
        $.ajax({
                url: url_income_monthly_chart,
                type: 'GET',
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                myLineChart.data.labels = data.months;
                myLineChart.data.datasets[0].data = data.monthly_income_count_data;
                myLineChart.data.datasets[1].data = data.monthly_unpaid_count_data;
                myLineChart.update();
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    //update monthly income chart
    updateMonthlyIncomeChart();

    //bar booking chart
    var ctxB = document.getElementById("barChart").getContext('2d');
    var myBarChart = new Chart(ctxB, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: '# of Bookings',
                data: [],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var updateMonthlyBookingChart = function() {
    $.ajax({
      url: url_booking_monthly_chart,
      type: 'GET',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        myBarChart.data.labels = data.months;
        myBarChart.data.datasets[0].data = data.monthly_booking_count_data;
        myBarChart.update();
      },
      error: function(data){
        console.log(data);
      }
    });
  }
    //update monthly income chart
    updateMonthlyBookingChart();



</script>
@endsection
