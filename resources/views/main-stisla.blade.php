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
                    <h4>Total Customer</h4>
                  </div>
                  <div class="card-body">
                    {{ $userCount }}
                    @if($userCount > 0)
                      <small>
                        <a href="{{ route('pengguna.index') }}" class="text-primary">
                          Lihat User
                        </a>
                      </small>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Product</h4>
                  </div>
                  <div class="card-body">
                    {{ $productCount }}
                    @if($productCount > 0)
                      <small>
                        <a href="{{ route('products.index') }}" class="text-primary">
                          Lihat Product
                        </a>
                      </small>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Transaksi Selesai</h4>
                  </div>
                  <div class="card-body">
                    {{ $trnsctCount }}
                    @if($trnsctCount > 0)
                      <small>
                        <a href="{{ route('transactions.index') }}" class="text-primary">
                          Lihat Transaksi
                        </a>
                      </small>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon {{ $verifikasiBayar == 0 ? 'bg-primary' : 'bg-warning' }}">
                  <i class="fas fa-info-circle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Verifikasi Pembayaran</h4>
                  </div>
                  <div class="card-body">
                    {{ $verifikasiBayar }}
                    @if($verifikasiBayar > 0)
                      <small>
                        <a href="{{ route('transactions.index') }}" class="text-warning">
                          Lihat Transaksi
                        </a>
                      </small>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon {{ $pengemasan == 0 ? 'bg-primary' : 'bg-warning' }}">
                  <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Pengemasan</h4>
                  </div>
                  <div class="card-body">
                    {{ $pengemasan }}
                    @if($pengemasan > 0)
                      <small>
                        <a href="{{ route('shippings.index') }}" class="text-primary">
                          Lihat Shipping
                        </a>
                      </small>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon {{ $pengiriman == 0 ? 'bg-primary' : 'bg-warning' }}">
                  <i class="fas fa-truck"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Sedang Dikirim</h4>
                  </div>
                  <div class="card-body">
                    {{ $pengiriman }}
                    @if($pengemasan > 0)
                      <small>
                        <a href="{{ route('shippings.index') }}" class="text-primary">
                          Lihat Shipping
                        </a>
                      </small>
                    @endif
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
                      <span class="text-muted">Total</span>
                      <div class="detail-value" id="detail-value-1"></div>
                      <div class="detail-name" id="detail-name-1"></div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted">Total</span>
                      <div class="detail-value" id="detail-value-2"></div>
                      <div class="detail-name" id="detail-name-2"></div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted">Total</span>
                      <div class="detail-value" id="detail-value-3"></div>
                      <div class="detail-name" id="detail-name-3"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Statistics Visitors</h4>
                  <div class="card-header-action">
                    <a class="btn btn-primary">Weekly</a>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="statisticVisitor" height="182"></canvas>
                  <div class="statistic-details mt-sm-4">
                    <div class="statistic-details-item">
                      <span class="text-muted">Minggu 1</span>
                      <div class="detail-value" id="visitor-value-1"></div>
                      <div class="detail-name">Visitors</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted">Minggu 2</span>
                      <div class="detail-value" id="visitor-value-2"></div>
                      <div class="detail-name">Visitors</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted">Minggu 3</span>
                      <div class="detail-value" id="visitor-value-3"></div>
                      <div class="detail-name">Visitors</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted">Minggu Ini</span>
                      <div class="detail-value" id="visitor-value-4"></div>
                      <div class="detail-name">Visitors</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Most Visited in 7 Days.</h4>
                  <div class="card-header-action">
                    <a class="btn btn-primary">Weekly</a>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th width="10">Visitor</th>
                      </tr>
                    </thead>
                    <tbody id="mostvisitor-table">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('jq-script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script type="text/javascript">

"use strict";

getTopArtikel();
getAnalyticsData();

let ctx = $('#statisticPenjualan');

let statisticPenjualan = new Chart(ctx, {
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
            return numberWithCommas(value);
          },
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

let ctr = document.getElementById('statisticVisitor').getContext('2d');
let statisticVisitors = new Chart(ctr, {
  type: 'pie',
  data: {
    datasets: [{
      data: [],
      backgroundColor: [
        '#FFDAB9',
        '#FA8072',
        '#0F52BA',
        '#002366'
      ],
      label: 'Dataset 1'
    }],
    labels: [
      'Week 1',
      'Week 2',
      'Week 3',
      'This Week'
    ],
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom',
    },
  }
});

let updateChart = function() {
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
      $('#detail-name-1').text(data.old_month_word[0]);
      $('#detail-value-1').text('Rp. '+numberWithCommas(data.total_transaksi[0]));
      $('#detail-name-2').text(data.old_month_word[1]);
      $('#detail-value-2').text('Rp. '+numberWithCommas(data.total_transaksi[1]));
      $('#detail-name-3').text(data.old_month_word[2]);
      $('#detail-value-3').text('Rp. '+numberWithCommas(data.total_transaksi[2]));
    },
    error: function(data){
      Swal.fire('Gagal!', 'Gagal mengambil data analytics transaksi.', 'error');
    }
  });
}

function getAnalyticsData() {
  $.ajax({
    url: '{{ url("analytics-grafik-visitors") }}',
    type: 'GET',
    dataType: 'JSON'
  })
  .done(data => {
      statisticVisitors.data.datasets[0].data = data.data;
      statisticVisitors.update();
      $('#visitor-value-1').text(data.data[0]);
      $('#visitor-value-2').text(data.data[1]);
      $('#visitor-value-3').text(data.data[2]);
      $('#visitor-value-4').text(data.data[3]);
  })
  .fail(response => {
    Swal.fire('Gagal!', 'Gagal mengambil data analytics visitor.', 'error');
  })
}

updateChart();

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getTopArtikel() {
  $.ajax({
    url: '{{ url("analytics-top-article") }}',
    type: 'GET',
    dataType: 'JSON'
  })
  .done(data => {
    let html = '';
    $.each(data, function(i, item) {
      $('#mostvisitor-table').append(
        `
          <tr>
            <td>${item.pageTitle}</td>
            <td align="center">${item.pageViews}</td>
          </tr>
        `
      );
    })
  })
  .fail(response => {
    Swal.fire('Gagal!', 'Gagal mengambil data analytics 5 halaman paling banyak di kunjungi.', 'error');
  })
}
</script>

@endsection