<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "soccer_league";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$fk         = "";
$name       = "";
$date       = "";
$position   = "";
$back       = "";
$phone      = "";
$sukses     = "";
$error      = "";

if (isset($_GET['fk'])) {
    $fk = $_GET['fk'];
} else {
    $fk = "";
}
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from player where player_id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from player where player_id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $name       = $r1['player_name'];
    $date       = $r1['date_of_birth'];
    $position   = $r1['position'];
    $back       = $r1['back_number'];
    $phone      = $r1['phone_number'];

    if ($name == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $name       = $_POST['player_name'];
    $date       = $_POST['date_of_birth'];
    $position   = $_POST['position'];
    $back       = $_POST['back_number'];
    $phone      = $_POST['phone_number'];

    if ($name && $date && $position && $back && $phone) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update player set player_name = '$name', date_of_birth='$date',position = '$position',back_number='$back', phone_number='$phone' where player_id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into player(player_name,date_of_birth,position,back_number, phone_number, club_id) values ('$name','$date','$position','$back', '$phone', '$fk')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 900px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <a href="club.php" class="btn btn-success">kembali</a>
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:1;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:1;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="player_name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="player_name" name="player_name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="date_of_birth" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type='date' class="datepicker" id="date_of_birth" name="date_of_birth" value="<?php echo $date ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="position" class="col-sm-2 col-form-label">Posisi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="position" id="position">
                                <option value="">- Pilih Posisi Pemain -</option>
                                <option value="CF" <?php if ($position == "CF") echo "selected" ?>>CF</option>
                                <option value="WF" <?php if ($position == "WF") echo "selected" ?>>WF</option>
                                <option value="LW" <?php if ($position == "LW") echo "selected" ?>>LW</option>
                                <option value="RW" <?php if ($position == "RW") echo "selected" ?>>RW</option>
                                <option value="AM" <?php if ($position == "AM") echo "selected" ?>>AM</option>
                                <option value="LM" <?php if ($position == "LM") echo "selected" ?>>LM</option>
                                <option value="CM" <?php if ($position == "CM") echo "selected" ?>>CM</option>
                                <option value="RM" <?php if ($position == "RM") echo "selected" ?>>RM</option>
                                <option value="DM" <?php if ($position == "DM") echo "selected" ?>>DM</option>
                                <option value="LWB" <?php if ($position == "LWB") echo "selected" ?>>LWB</option>
                                <option value="LB" <?php if ($position == "LB") echo "selected" ?>>LB</option>
                                <option value="CB" <?php if ($position == "CB") echo "selected" ?>>CB</option>
                                <option value="RB" <?php if ($position == "RB") echo "selected" ?>>RB</option>
                                <option value="RWB" <?php if ($position == "RWB") echo "selected" ?>>RWB</option>
                                <option value="SW" <?php if ($position == "SW") echo "selected" ?>>SW</option>
                                <option value="GK" <?php if ($position == "GK") echo "selected" ?>>GK</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="back_number" class="col-sm-2 col-form-label">Nomor Punggung</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="back_number" name="back_number" value="<?php echo $back ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone_number" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?php echo $phone ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Liga Sepak Bola
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Posisi</th>
                            <th scope="col">Nomor Punggung</th>
                            <th scope="col">No. Telepon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from player where club_id='$fk' order by player_id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['player_id'];
                            $name       = $r2['player_name'];
                            $date       = $r2['date_of_birth'];
                            $position   = $r2['position'];
                            $back       = $r2['back_number'];
                            $phone      = $r2['phone_number'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $date ?></td>
                                <td scope="row"><?php echo $position ?></td>
                                <td scope="row"><?php echo $back ?></td>
                                <td scope="row"><?php echo $phone ?></td>
                                <td scope="row">
                                    <a href="player.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="player.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>           
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
