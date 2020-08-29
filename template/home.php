<?php $this->layout('template', ['title' => "Beranda"]) ?>
<br>
<div class="row">
    <div class="col-md-6">
        <form class="form" method="POST" autocomplete="off" action="/requestOTP">
            <div class="card">
                <div class="card-header">Registrasi</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" required class="form-control" autocomplete="off" name="nama">
                    </div>
                    <div class="form-group">
                        <label>Nomor HP Whatsapp</label>
                        <input type="text" required class="form-control" autocomplete="off" placeholder="08xxxxxxxxx" name="nohp">
                        <small class="form-text text-muted">OTP akan dikirimkan ke Whatsapp</small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" required class="form-control" autocomplete="off" name="email">
                    </div>
                    <div class="form-group">
                        <label>Perusahaan</label>
                        <input type="text" required class="form-control" autocomplete="off" name="perusahaan">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" autocomplete="off" name="jenisKelamin">
                            <option>Pria</option>
                            <option>Wanita</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" required class="form-control" placeholder="Gunakan password yang mudah minimal 6 karakter" autocomplete="off" name="password">
                        <small class="form-text text-muted">Password tidak dienkripsi, jangan gunakan password penting. Lupa kata sandi maka nomor tidak dapat dipakai lagi</small>
                    </div>
                </div>
                <div class="card-footer">
                <small class="form-text text-muted">Dengan mendaftar, anda akan menggunakan internet ini untuk hal baik, segala perilaku penggunaan internet anda akan disimpan dan akan digunakan untuk kepolisian jika ada tindak kejahatan</small>
                    <button type="submit" class="btn btn-block btn-primary" name="request" value="otp">Saya setuju, Request OTP</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form class="form" method="POST" autocomplete="off">
            <div class="card">
                <h5 class="card-header">Update Password</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nomor HP Whatsapp</label>
                        <input type="text" class="form-control" required autocomplete="off" placeholder="08xxxxxxxxx" name="nohp">
                    </div>
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="text" class="form-control" required autocomplete="off" name="oldpass">
                    </div>
                    <div class="form-group">
                        <label>Password baru</label>
                        <input type="text" class="form-control" required autocomplete="off" name="newpass">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-success" name="update" value="password">Update Password</button>
                </div>
            </div>
        </form>
    </div>
</div>