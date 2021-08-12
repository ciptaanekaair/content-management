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
						<form action="">
							<div class="form-group">
								<label for="Password">Password</label>
								<input type="password" class="form-control" id="password" placeholder="Password Baru">
							</div>
							<div class="form-group">
								<label for="password_confirmation">Confirm Password</label>
								<input type="password" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password Baru">
							</div>
							<div class="my-4"></div>
							<div class="float-right">
								<button class="btn btn-primary" id="btnSavePassword">
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
	        <div class="col-md-12 col-lg-6">
					<form action="">
      			<div class="form-group">
      				<label for="email">Email</label>
      				<input type="text" class="form-control" id="email" placeholder="Email" value="{{ auth()->user()->email }}" readonly>
      			</div>
      			<div class="form-group">
      				<label for="name">Name</label>
							<input type="text" class="form-control" id="name" placeholder="Nama Lengkap" value="{{ auth()->user()->name }}">
						</div>
      			<div class="form-group">
      				<label for="profile_photo_path">Profile Photo</label>
							<input type="file" class="form-control" id="profile_photo_path" placeholder="Profile Photo">
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
const btnSavePassword = document.getElementById('btnSavePassword');
const btnSaveProfile = document.getElementById('btnSaveProfile');
const btnSavePassword = document.getElementById('btnSavePassword');

// Update Password
function savePassword () {
	let formData = {
		password: document.getElementById('password').value,
		password_confirmation: document.getElementById('password_confirmation').value
	}

	fetch('{{ route("profile.update.password") }}', {
		method: 'POST'
		body: JSON.stringify(formData),
		headers: {
			'Content-type': 'application/json; charset=UTF-8',
			'X-CSRF-TOKEN': '{{ csrf_token() }}'
		}
	})
	.then(response => response.json())
	.then(data => {
		Swal.fire('Success!', data.message, 'success');
	})
	.catch(err => {
		Swal.fire('Error!', err.message, 'error')
	});
}

// Update Profile

// Update User Detail
</script>

@endsection