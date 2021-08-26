<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'FilterPedia') }}</title>
        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans&family=Nunito:wght@400;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">

        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-shims.min.css" media="all">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free-v4-font-face.min.css" media="all">
        <link rel="stylesheet" href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all">
        <!-- Scripts -->
        <script defer src="{{ asset('vendor/alpine.js') }}"></script>
    </head>
    <body class="antialiased">
        <div id="app">
            <div class="main-wrapper">
                @include('layouts.navbar')
                @include('layouts.sidebar')
                <!-- Main Content -->
                <div class="main-content">
                    <section class="section">
                      <div class="section-header">
                        @yield('header')
                      </div>

                      <div class="section-body">
                        <div id="warning"></div>
                        @yield('content')
                      </div>
                    </section>
                  </div>
            </div>
        </div>

        @yield('formodal')

        <!-- General JS Scripts -->
        <script src="{{ asset('stisla/js/modules/jquery.min.js') }}"></script>
        <script src="{{ asset('stisla/js/modules/popper.js') }}"></script>
        <script src="{{ asset('stisla/js/modules/bootstrap.min.js') }}"></script>
        <script defer async src="{{ asset('stisla/js/modules/tooltip.js') }}"></script>
        <script defer async src="{{ asset('stisla/js/modules/jquery.nicescroll.min.js') }}"></script>
        <script defer src="{{ asset('stisla/js/modules/moment.min.js') }}"></script>
        <script defer src="{{ asset('stisla/js/modules/marked.min.js') }}"></script>
        <script defer src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
        <script defer src="{{ asset('vendor/select2/select2.min.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

        <script src="{{ asset('stisla/js/stisla.js') }}"></script>
        <script src="{{ asset('stisla/js/scripts.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ asset('js/jquery.fancybox.min.js') }}" defer></script>
        <script type="text/javascript">
            $(function() {
                cekNeedVerify();
            });

            function cekNeedVerify() {
                $.get({
                    url: '{{ route("checkNeedFerify") }}',
                    dataType: 'JSON'
                })
                .done(data => {
                    if(data.countTransaksi > 0) {
                        $('#warning').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>PERHATIAN!</strong> Ada <b>${data.countTransaksi}</b> transaksi yang butuh di verifikasi. <a href="{{ route('transactions.index') }}" class="text-decoration-none font-italic">Lihat Transaksi</a>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `);
                    }
                })
                .fail(response => {
                    console.log(response);
                })
            }
        </script>
        @yield('jq-script')

    </body>
</html>
