<?php $this->layout('template', ['title' => 'Registered']) ?>
<table class="table table-bordered table-sm  table-hover">
    <thead>
        <tr>
            <th scope="col">Nama</th>
            <th scope="col">Nomor HP</th>
            <th scope="col">Email</th>
            <th scope="col">Perusahaan</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Date Registered</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $path = "./data/registered/";
        $users = scandir($path);
        foreach($users as $user){
            if(is_file($path.$user)){
            $json = json_decode(file_get_contents($path.$user),true);
        ?>
        <tr>
            <td><?=$json['nama']?></td>
            <td><?=$json['nohp']?></td>
            <td><?=$json['email']?></td>
            <td><?=$json['perusahaan']?></td>
            <td><?=$json['jenisKelamin']?></td>
            <td><?=date("d M T H:i",filemtime($path.$user))?></td>
        </tr>
        <?php }
        }?>
    </tbody>
</table>