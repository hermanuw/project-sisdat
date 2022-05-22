<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "soccer_league";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$name       = "";
$organizer  = "";
$number     = "";
$system     = "";
$year       = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from league where league_id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from league where league_id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $name       = $r1['league_name'];
    $organizer  = $r1['league_organizer'];
    $number     = $r1['number_of_club'];
    $system     = $r1['match_system'];
    $year       = $r1['year'];

    if ($name == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $name       = $_POST['league_name'];
    $organizer  = $_POST['league_organizer'];
    $number     = $_POST['number_of_club'];
    $system     = $_POST['match_system'];
    $year       = $_POST['year'];

    if ($name && $organizer && $number && $system && $year) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update league set league_name = '$name', league_organizer='$organizer',number_of_club = '$number',match_system='$system', year='$year' where league_id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into league(league_name,league_organizer,number_of_club,match_system, year) values ('$name','$organizer','$number','$system', '$year')";
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
            width: 1000px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <nav class="navbar navbar-expand-lg bg-warning">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">LIGA SEPAK BOLA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="listJadwal.php">Jadwal Pertandingan</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="listClub.php">Club</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="listPlayer.php">Pemain</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
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
                        <label for="league_name" class="col-sm-2 col-form-label">Liga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="league_name" name="league_name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="league_organizer" class="col-sm-2 col-form-label">Penyelenggara Liga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="league_organizer" name="league_organizer" value="<?php echo $organizer ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="number_of_club" class="col-sm-2 col-form-label">Jumlah Club</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="number_of_club" name="number_of_club" value="<?php echo $number ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="match_system" class="col-sm-2 col-form-label">Sistem Kompetisi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="match_system" id="match_system">
                                <option value="">- Pilih Sistem Pertandingan -</option>
                                <option value="Setengah Kompetisi" <?php if ($system == "Setengah Kompetisi") echo "selected" ?>>Setengah Kompetisi</option>
                                <option value="Kompetisi Penuh" <?php if ($system == "Kompetisi Penuh") echo "selected" ?>>Kompetisi Penuh</option>
                                <option value="Gugur Tunggal" <?php if ($system == "Gugur Tunggal") echo "selected" ?>>Gugur Tunggal</option>
                                <option value="Gugur rangkap" <?php if ($system == "Gugur rangkap") echo "selected" ?>>Gugur rangkap</option>
                                <option value="Consulation" <?php if ($system == "Consulation") echo "selected" ?>>Consulation</option>
                                <option value="Kombinasi" <?php if ($system == "Kombinasi") echo "selected" ?>>Kombinasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="year" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="year" name="year" value="<?php echo $year ?>">
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
                            <th scope="col">Liga</th>
                            <th scope="col">Penyelenggara Liga</th>
                            <th scope="col">Jumlah CLub</th>
                            <th scope="col">Sistem Kompetisi</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from league order by league_id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['league_id'];
                            $name       = $r2['league_name'];
                            $organizer  = $r2['league_organizer'];
                            $number     = $r2['number_of_club'];
                            $system     = $r2['match_system'];
                            $year       = $r2['year'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $organizer ?></td>
                                <td scope="row"><?php echo $number ?></td>
                                <td scope="row"><?php echo $system ?></td>
                                <td scope="row"><?php echo $year ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    <a href="jadwal.php?fk=<?php echo $id?>"><button type="button" class="btn btn-info">Jadwal</button></a>           
                                    <a href="club.php?fk=<?php echo $id?>"><button type="button" class="btn btn-success">club</button></a>           
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
