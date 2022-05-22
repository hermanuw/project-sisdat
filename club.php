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
$address    = "";
$phone      = "";
$error      = "";
$sukses    = "";

if (isset($_GET['fk'])) {
    $fk = $_GET['fk'];
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from club where club_id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from club where club_id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $name       = $r1['club_name'];
    $address    = $r1['address'];
    $phone      = $r1['phone_number'];
    $fk         = $r1['league_id'];

    if ($name == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $name       = $_POST['club_name'];
    $address    = $_POST['address'];
    $phone      = $_POST['phone_number'];
    $fk         = $_POST['fk'];

    if ($name && $address && $phone ) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update club set club_name = '$name', address='$address',phone_number = '$phone' where club_id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into club(club_name, address, phone_number, league_id) values ('$name','$address','$phone', '$fk')";
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
        <a href="index.php" class="btn btn-success">kembali</a>
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
                    header("refresh:1;url=index.php");// : detik
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
                    <input type="hidden" name='fk' value="<?php echo $fk?>">
                    <div class="mb-3 row">
                        <label for="club_name" class="col-sm-2 col-form-label">Club</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="club_name" name="club_name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone_number" class="col-sm-2 col-form-label">No. Telpon</label>
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
                            <th scope="col">Club</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No. Telpon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from club where league_id='$fk' order by club_id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['club_id'];
                            $name       = $r2['club_name'];
                            $address    = $r2['address'];
                            $phone      = $r2['phone_number'];
                            $fk         = $r2['league_id'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $address ?></td>
                                <td scope="row"><?php echo $phone ?></td>
                                <td scope="row">
                                    <a href="club.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="club.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    <a href="player.php?fk=<?php echo $id?>"><button type="button" class="btn btn-info">Pemain</button></a>           
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
