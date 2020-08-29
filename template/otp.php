<?php $this->layout('template', ['title' => 'OTP']) ?>

<div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-sm-6">
        <form class="form" method="POST" autocomplete="off">
            <div class="card">
                <h5 class="card-header">OTP telah dikirimkan ke Whatsapp <?=$hp?></h5>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="text" class="form-control" readonly value="<?=$hp?>" autocomplete="off" placeholder="08xxxxxxxxx" name="nohp">
                    </div>
                    <div class="form-group">
                        <label>Kode OTP</label>
                        <input type="text" class="form-control" required autocomplete="off" name="otp">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-success" name="validasi" value="otp">Validasi</button>
                </div>
            </div>
        </form>
    </div>
</div>