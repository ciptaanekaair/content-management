@extends('layouts.dashboard-layout')

@section('header')
  <h1>My Profile</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-12 col-lg-6 align-self-center">
						<div style="font-size:24px; font-weight: bold;">Mengganti Password</div>
							<p>Perubahan Password dapat di lakukan menggunakan form disamping ini.</p>
						</div>
						<div class="col-md-12 col-lg-6">
						<form class="form-password">
							<div class="form-group">
								<label for="Password">Password</label>
								<input type="password" name="password" class="form-control" id="password" placeholder="Password Baru">
								<div class="alert-message">
									<code id="passwordError"></code>
								</div>
							</div>
							<div class="form-group">
								<label for="password_confirmation">Confirm Password</label>
								<input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password Baru">
								<div class="alert-message">
									<code id="password_confirmationError"></code>
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

		<div class="card">
      <div class="card-body">
      	<div class="row justify-content-center">
      		<div class="col-md-12 col-lg-6 align-self-center">
    				<div style="font-size:24px; font-weight: bold;">Informasi Account</div>
      			<p>
      				Untuk merubah data akun Anda, dapat di lakukan dengan menggunakan form di samping ini. Untuk dapat merubah email, Anda wajib melakukannya dengan cara melakukan permintaan perubahan email kepada Atasan.
      			</p>
      			<p>
      				<table class="table table-borderless">
      					<tr>
      						<td>Level Akun</td>
      						<td width="10">:</td>
      						<td>
      							<div class="badge badge-pill badge-primary">
      								{{ auth()->user()->Level->nama_level }}
      							</div>
      						</td>
      					</tr>
      					<tr>
      						<td>Status Akun</td>
      						<td width="10">:</td>
      						<td>
      							<div class="badge badge-pill badge-{{ auth()->user() }}">
      								{{ auth()->user()->status == 1 ? 'Terverifikasi' : 'Belum diverifikasi' }}
      							</div>
      						</td>
      					</tr>
      				</table>
      			</p>
        	</div>
	        <div class="col-md-12 col-lg-6" id="edit-profile">
					<form class="form-profile" enctype="multipart/form-data">
      			<div class="form-group">
      				<label for="email">Email</label>
      				<input type="text" name="email" class="form-control" id="email" placeholder="Email" value="{{ auth()->user()->email }}" readonly>
							<div class="alert-message">
								<code id="emailError"></code>
							</div>
      			</div>
      			<div class="form-group">
      				<label for="name">Name</label>
							<input type="text" name="name" class="form-control" id="name" placeholder="Nama Lengkap" value="{{ auth()->user()->name }}">
							<div class="alert-message">
								<code id="nameError"></code>
							</div>
						</div>
      			<div class="form-group">
      				<label for="profile_photo_path">Profile Photo</label>
							<input type="file" name="profile_photo_path" class="form-control" id="profile_photo_path" placeholder="Profile Photo">
							<div class="alert-message">
								<code id="profile_photo_pathError"></code>
							</div>
						</div>
						<div class="my-4"></div>
						<div class="float-right">
							<button class="btn btn-primary" id="btnSaveProfile">
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
@endsection


@section('jq-script')
<script type="text/javascript">
var url;

$(function() {
	$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

	$('.form-password').on('submit', function(e){
		e.preventDefault();
		resetErrorForm();
		var updatePass = updatePassword();
		updatePass.done(function(data) {
			Swal.fire('Success', data.message, 'success');
			$('#password').val('');
			$('#password_confirmation').val('');
		});
		updatePass.fail(function(response) {
			Swal.fire('Error', 'Gagal mengubah password. Silahkan perhatikan error yang muncul.', 'error');
			$('#passwordError').text(response.responseJSON.message.password);
			$('#password_confirmationError').text(response.responseJSON.message.password_confirmation);
		});
	});

	$('.form-profile').on('submit', function(e) {
		e.preventDefault();
		resetErrorForm();

		var uProfile = updateProfile();
		uProfile.done(function(data) {
			Swal.fire('Success', data.message, 'success');
			$('#profile_photo_path').val('');
		});
		uProfile.fail(function(response) {
			Swal.fire('Error', 'Gagal mengubah data profile. Silahkan perhatikan error yang muncul.', 'error');
			$('#nameError').text(response.responseJSON.message.name);
			$('#emailError').text(response.responseJSON.message.email);
			$('#profile_photo_pathError').text(response.responseJSON.message.profile_photo_path);
		});
	});
});

function resetErrorForm() {
	$('#passwordError').text('');
	$('#password_confirmationError').text('');
	$('#nameError').text('');
	$('#emailError').text('');
	$('#profile_photo_pathError').text('');
}

// update password
function updatePassword() {
	return $.ajax({
		url: '{{ route("profile.update.password") }}',
		type: 'POST',
		data: { password: $('#password').val(), password_confirmation: $('#password_confirmation').val() }
	});
}

// Update Profile
function updateProfile() {
	return $.ajax({
		url: '{{ route("profile.update.profile") }}',
		type: 'POST',
		data: new FormData($('#edit-profile form')[0]),
		contentType: false,
		processData: false,
	});
}

// Update Detail
function updateDetail() {
	return $.ajax({
		url: '{{ route("profile.update.detail") }}',
		type: 'POST',
		data: { 
			password: $('#password').val(),
			password_confirmation: $('#password_confirmation').val()
		}
	});
}
</script>

@endsection