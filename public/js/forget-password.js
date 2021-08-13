
const isiForm = document.querySelector('.isi-form')
const forgetForm = document.getElementById('forget-form')
const invalidFeedback = document.querySelector('.invalid-feedback')
let urlSendToken = '{{ route("forgetpassword.sendToken") }}';

forgetForm.addEventListener('submit', (e) => {
    e.preventDefault();
    console.log('form forget password submitted');
    sendToken();
})

resetForm.addEventListener('submit', (e) => {
    e.preventDefault();
    // resetPassword();
    console.log('form reset submitted');
})

function sendToken() {
    fetch('{{ route("forgetpassword.sendToken") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // kirim sebagai json
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // csrf token jangan lupa
        },
        body: JSON.stringify({
            email : document.getElementById('email').value,
        })
    })
    .then(response => {
        // tangkap dan lempar ke catch untuk response apabila terjadi error
        if (!response.ok) {
            return Promise.reject(response);
        }
        // return sebagai json
        return response.json();
    })
    .then(data => {
        let html = "";
        if (data.data) {
            Swal.fire('Success!', data.message, 'success');
            html += `
                <form method="POST" action="{{ route('forgetpassword.resetPassword') }}" class="needs-validation reset-form" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="${data.data}" tabindex="1" required readonly>
                        <div class="invalid-feedback" id="emailError">
                            Please fill in your email
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="token">Token</label>
                        <input id="token" type="text" class="form-control" name="token" tabindex="1" placeholder="Isi dengan Token yang ada pada email">
                        <div class="invalid-feedback" id="tokenError">
                            Isi dengan Token Rahasia di email
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" class="form-control" name="password" tabindex="1" placeholder="Masukan Password Baru Anda">
                        <div class="invalid-feedback" id="passwordError">
                            Isi dengan Token Rahasia di email
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="1" placeholder="Konfirmasi Password Baru Anda">
                        <div class="invalid-feedback" id="password_confirmationError">
                            Isi dengan Token Rahasia di email
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Simpan
                        </button>
                    </div>
                </form>
            `;
            isiForm.innerHTML = html;
        }
    })
    .catch(error => {
        if (typeof error.json === "function"){
            error.json().then(jsonError => {
                console.log('JSON return error from API');
                if(jsonError.message.email){
                    Swal.fire('Error!', jsonError.message.email[0], 'error');
                }
            }).catch(genericError => {
                console.log('generic error from API');
                console.log(genericError);
            });
        } else {
            console.log('fetch error');
            console.log(error.message);
        }
    })
}

function resetPassword() {
    fetch('{{ route("forgetpassword.resetPassword") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // kirim sebagai json
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // csrf token jangan lupa
        },
        body: JSON.stringify({
            email : document.getElementById('email').value,
            token : document.getElementById('token').value,
            password : document.getElementById('password').value,
            password_confirmation : document.getElementById('password_confirmation').value
        })
    })
    .then(response => {
        if (!response.ok) {
            return Promise.reject(response);
        }
        return response.json();
    })
    .then(data => {
        if (data.data) {
            window.location.href = '{{ route("login") }}';
        }
    })
    .catch(error => {
        if(error.json === "function") {
            error.json().then(jsonError => {
                console.log(jsonError);
            }).catch(genericError => {
                console.log(genericError);
            })
        } else {
            Swal.fire('Error!', 'Ada error di dalam codingan. Mohon hubungi IT.', 'error');
        }
    })
}

const resetForm = document.querySelector('.reset-form')
