@extends('layouts.dashboard-layout')

@section('header')
  <h1>Dashboard</h1>
@endsection

@section('content')
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Users</h4>
                  </div>
                  <div class="card-body">
                    {{ $userCount }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Product</h4>
                  </div>
                  <div class="card-body">
                    {{ $productCount }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Transaksi Selesai</h4>
                  </div>
                  <div class="card-body">
                    {{ $trnsctCount }}
                  </div>
                </div>
              </div>
            </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Statistics Penjualan</h4>
              <div class="card-header-action">
                <a class="btn btn-primary">Monthly</a>
              </div>
            </div>
            <div class="card-body">
              <canvas id="statisticPenjualan" height="182"></canvas>
              <div class="statistic-details mt-sm-4">
                <div class="statistic-details-item">
                  <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                  <div class="detail-value">$243</div>
                  <div class="detail-name">Today's Sales</div>
                </div>
                <div class="statistic-details-item">
                  <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                  <div class="detail-value">$2,902</div>
                  <div class="detail-name">This Week's Sales</div>
                </div>
                <div class="statistic-details-item">
                  <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
                  <div class="detail-value">$12,821</div>
                  <div class="detail-name">This Month's Sales</div>
                </div>
                <div class="statistic-details-item">
                  <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
                  <div class="detail-value">$92,142</div>
                  <div class="detail-name">This Year's Sales</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection

@section('jq-script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script type="text/javascript">

"use strict";

var ctx = $('#statisticPenjualan');

var statisticPenjualan = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [],
    datasets: [{
      label: 'Statistics',
      data: [],
      borderWidth: 5,
      borderColor: '#6777ef',
      backgroundColor: 'transparent',
      pointBackgroundColor: '#fff',
      pointBorderColor: '#6777ef',
      pointRadius: 4
    }]
  },
  options: {
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          return tooltipItem.yLabel.toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
      }
    },
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        gridLines: {
          display: false,
          drawBorder: false,
        },
        ticks: {
          callbacks: function(value) {
            return addCommas(value);
          },
          beginAtZero: true
        }
      }],
      xAxes: [{
        gridLines: {
          color: '#fbfbfb',
          lineWidth: 2
        }
      }]
    },
  }
});
var updateChart = function() {
  $.ajax({
    url: "{{ route('grafiksatu') }}",
    type: 'GET',
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(data) {
      statisticPenjualan.data.labels = data.old_month_word;
      statisticPenjualan.data.datasets[0].data = data.total_transaksi;
      statisticPenjualan.update();
    },
    error: function(data){
      console.log(data);
    }
  });
}

updateChart();

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>

@endsection