@extends('layouts.app-auth')

@section('title')
Reset Password - FILTERPEDIA
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="text-center my-2">
                    <img src="{{ asset('logo.png') }}" alt="logo" width="50%">
                </div>
                <div class="card card-primary">
                    <div class="card-header"><h4>Reset Password</h4></div>
                    <div class="card-body">
                        @if(Session::has('elert'))
                        <code>{{ Session::get('alert') }}</code>
                        @endif
                        <div class="pesanError"></div>
                        <div class="isi-form">
                            <form method="POST" action="{{ route('forgetpassword.resetPassword') }}" class="needs-validation form-reset" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') == '' ? $reset->email : '' }}" tabindex="1" placeholder="Email yang terdaftar" required>
                                    <div id="invalid-email"></div>
                                </div>
                                <div class="form-group">
                                    <label for="token">Token</label>
                                    <input id="token" type="token" class="form-control" name="token" value="{{ old('token') }}" tabindex="1" placeholder="Secret Token" required autofocus>
                                    <div id="invalid-token"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="1" placeholder="Password Baru" required>
                                    <div id="invalid-password"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="1" placeholder="Konfirm Password Baru" required>
                                    <div id="invalid-password_confirmation"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Request Token
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="simple-footer">
                    Copyright &copy; Stisla 2018
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jq-script')

<script>

$(function() {
    $('.form-reset').on('submit', function(e) {
        e.preventDefault();

        var sendRequest = resetPassword();
        sendRequest.done(function(data) {
            Swal.fire('Success', data.message, 'success');
            resetForm();
            window.location.href = '{{ route("login") }}';
        });
        sendRequest.fail(function(response) {
            Swal.fire('Error', 'Gagal mengubah password. Silahkan perhatikan error yang muncul.', 'error');
            console.log(response);
        });
    })
})

// reset password
function resetPassword() {
    return $.ajax({
        url: '{{ route("forgetpassword.resetPassword") }}',
        type: 'POST',
        data: $('.isi-form form').serialize()
    });
}

function resetForm() {
    $('#email').val('');
    $('#token').val('');
    $('#password').val('');
    $('#password_confirmation').val('');
}

function resetErrorForm() {
    $('#invalid-email').text('');
    $('#invalid-token').text('');
    $('#invalid-password').text('');
    $('#invalid-password_confirmation').text('');
}
</script>

@endsection