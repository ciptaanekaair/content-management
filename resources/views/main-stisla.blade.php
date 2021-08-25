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
                      <span class="text-muted"></span>
                      <div class="detail-value-1"></div>
                      <div class="detail-name-1"></div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"></span>
                      <div class="detail-value-2"></div>
                      <div class="detail-name-2"></div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"></span>
                      <div class="detail-value-3"></div>
                      <div class="detail-name-3"></div>
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
                      <span class="text-muted"></span>
                      <div class="visitor-value-1"></div>
                      <div class="visitor-name-1">2 Minggu Lalu</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"></span>
                      <div class="visitor-value-2"></div>
                      <div class="visitor-name-2">1 Minggu Lalu</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"></span>
                      <div class="visitor-value-3"></div>
                      <div class="visitor-name-3">Minggu Ini</div>
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
                      <span class="text-muted"></span>
                      <div class="visitor-value-1"></div>
                      <div class="visitor-name-1">2 Minggu Lalu</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"></span>
                      <div class="visitor-value-2"></div>
                      <div class="visitor-name-2">1 Minggu Lalu</div>
                    </div>
                    <div class="statistic-details-item">
                      <span class="text-muted"></span>
                      <div class="visitor-value-3"></div>
                      <div class="visitor-name-3">Minggu Ini</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('jq-script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6DHNBQ2KFN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6DHNBQ2KFN');
</script>
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
      $('.detail-name-1').text(data.old_month_word[0]);
      $('.detail-value-1').text('Rp. '+numberWithCommas(data.total_transaksi[0]));
      $('.detail-name-2').text(data.old_month_word[1]);
      $('.detail-value-2').text('Rp. '+numberWithCommas(data.total_transaksi[1]));
      $('.detail-name-3').text(data.old_month_word[2]);
      $('.detail-value-3').text('Rp. '+numberWithCommas(data.total_transaksi[2]));
    },
    error: function(data){
      console.log(data);
    }
  });
}

updateChart();

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>

@endsection