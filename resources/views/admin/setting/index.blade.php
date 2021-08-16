@extends('layouts.dashboard-layout')

@section('header')
  <h1>Website Settings</h1>
@endsection

@section('content')
  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6 align-self-center">
              <div style="font-size:24px; font-weight: bold;">Website Settings</div>
                <p>Penggantian untuk Website Title dan juga Website Image.</p>
              </div>
              <div class="col-md-12 col-lg-6">
              <div id="formsetting">
                <form class="form-setting" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="website_title">Website Title</label>
                    <input type="text" name="website_title" class="form-control" id="website_title" value="{{ $general->website_title }}" placeholder="Keywords Settings">
                    <div class="alert-message">
                      <code id="website_titleError"></code>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="website_logo">Website Logo</label>
                    <input type="file" name="website_logo" class="form-control" rows="10" id="website_logo" placeholder="Website Logo">
                    <div class="alert-message">
                      <code id="website_logoError"></code>
                    </div>
                  </div>
                  <div class="form-group">
                    <a href="{{ $general->imageurl }}" id="logo_image" data-fancybox class="btn btn-sm btn-primary">
                      <i class="fa fa-eye"></i> Lihat Logo Website
                    </a>
                  </div>
                  <div class="my-4"></div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary" id="btnSavePassword">
                      <i class="fa fa-save"></i> Simpan
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6 align-self-center">
              <div style="font-size:24px; font-weight: bold;">S.E.O Settings</div>
                <p>Silahkan masukan settingan untuk membantu menaikan rank pada Search Engine.</p>
              </div>
              <div class="col-md-12 col-lg-6">
                <div id="formseo">
                <form class="form-seo" method="POST">
                  <div class="form-group">
                    <label for="keywords">Keywords</label>
                    <input type="text" name="keywords" class="form-control" id="keywords" value="{{ $general->keywords }}" placeholder="Keywords Settings">
                    <div class="alert-message">
                      <code id="keywordsError"></code>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="website_description">Website Description</label>
                    <textarea name="website_description" class="form-control" rows="10" id="website_description" placeholder="Website Description SEO">{{ $general->website_description }}</textarea>
                    <div class="alert-message">
                      <code id="website_descriptionError"></code>
                    </div>
                  </div>
                  <div class="my-4"></div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary" id="btnSavePassword">
                      <i class="fa fa-save"></i> Simpan
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6 align-self-center">
              <div style="font-size:24px; font-weight: bold;">Payment Gateaway</div>
                <p>Setting Payment Gateaway menggunakan Midtrans. (Apabila dibutuhkan)</p>
              </div>
              <div class="col-md-12 col-lg-6">
                <div id="formmidtrans">
                <form class="form-midtrans" method="POST">
                  <div class="form-group">
                    <label for="midtrans_client_token">Midtrans Client Token</label>
                    <input type="text" name="midtrans_client_token" class="form-control" id="midtrans_client_token" value="{{ $general->midtrans_client_token }}" placeholder="Midtrans Client Token">
                    <div class="alert-message">
                      <code id="midtrans_client_tokenError"></code>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="midtrans_server_token">Midtrans Server Token</label>
                    <input type="text" name="midtrans_server_token" class="form-control" id="midtrans_server_token" value="{{ $general->midtrans_server_token }}" placeholder="Midtrans Server Token">
                    <div class="alert-message">
                      <code id="midtrans_server_tokenError"></code>
                    </div>
                  </div>
                  <div class="my-4"></div>
                  <div class="float-right">
                    <button type="submit" class="btn btn-primary" id="btnSavePassword">
                      <i class="fa fa-save"></i> Simpan
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('jq-script')
<script type="text/javascript">

$(function() {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })

  $('.form-setting').on('submit', function(e) {
    e.preventDefault();
    simpanSetting();
  });

  $('.form-seo').on('submit', function(e) {
    e.preventDefault();
    simpanSeo();
  });

  $('.form-midtrans').on('submit', function(e) {
    e.preventDefault();
    simpanMidtrans();
  });
});

function simpanSetting(data) {
  $.post({
    url: '{{ route("general-settings.simpanSetting") }}',
    data: new FormData($('#formsetting form')[0]),
    contentType: false,
    processData: false,
  })
  .done(data => {
    Swal.fire('Success!', data.message, 'success');
    $('#website_logo').val('');
    $('#logo_image').attr('href', data.data.imageurl);
  })
  .fail(response => {
    Swal.fire('Error!', 'Gagal menyimpan data Setting Website. Perhatikan pesan error.', 'error');
    $('#website_titleError').text(response.responseJSON.message.website_title);
    $('#website_logoError').text(response.responseJSON.message.website_logo);
  });
}

function simpanSeo() {
  $.post({
    url: '{{ route("general-settings.simpanSeo") }}',
    data: $('#formseo form').serialize()
  })
  .done(data => {
    Swal.fire('Success!', data.message, 'success');
  })
  .fail(response => {
    Swal.fire('Error!', 'Gagal menyimpan data Setting Website. Perhatikan pesan error.', 'error');
    $('#keywordsError').text(response.responseJSON.message.keywords);
    $('#website_descriptionError').text(response.responseJSON.message.website_description);
  });
}

function simpanMidtrans() {
  $.post({
    url: '{{ route("general-settings.simpanMidtrans") }}',
    data: $('#formmidtrans form').serialize()
  })
  .done(data => {
    Swal.fire('Success!', data.message, 'success');
  })
  .fail(response => {
    Swal.fire('Error!', 'Gagal menyimpan data Setting Website. Perhatikan pesan error.', 'error');
    $('#midtrans_client_tokenError').text(response.responseJSON.message.midtrans_client_token);
    $('#midtrans_server_tokenError').text(response.responseJSON.message.midtrans_server_token);
  });
}

</script>
@endsection