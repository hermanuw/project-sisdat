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
$ch         = "";
$sch        = "";
$ca         = "";
$sca        = "";
$stadion    = "";
$week       = "";
$date       = "";
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
    $sql1       = "delete from match_schedule where match_schedule_id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from match_schedule where match_schedule_id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $ch         = $r1['club_home'];
    $sch        = $r1['score_club_home'];
    $ca         = $r1['club_away'];
    $sca        = $r1['score_club_away'];
    $stadion    = $r1['stadion'];
    $week       = $r1['week'];
    $date       = $r1['date_of_match'];
    $fk         = $r1['league_id'];

    if ($ch == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $ch         = $_POST['club_home'];
    $sch        = $_POST['score_club_home'];
    $ca         = $_POST['club_away'];
    $sca        = $_POST['score_club_away'];
    $stadion    = $_POST['stadion'];
    $week       = $_POST['week'];
    $date       = $_POST['date_of_match'];
    $fk         = $_POST['fk'];

    if ($ch && $ca && $stadion && $week && $date) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update match_schedule set club_home = '$ch', club_away='$ca',score_club_home = '$sch',score_club_away='$sca', stadion='$stadion', week='$week', date_of_match='$date' where match_schedule_id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into match_schedule(club_home,club_away,score_club_home,score_club_away, stadion, week, date_of_match, match_schedule.league_id) values ('$ch','$ca','$sch','$sca', '$stadion', '$week', '$date', '$fk')";
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
                    <input type="hidden" name='fk' value="<?php echo $fk?>">
                    <?php
                    $sql3   = "select * from club where club.league_id='$fk'order by club_id desc";
                    $q3     = mysqli_query($koneksi, $sql3);
                    while ($r3 = mysqli_fetch_array($q3)) {
                        $ch         = $r3['club_name'];
                        $ca         = $r3['club_name'];
                    ?>    
                            <div class="mb-3 row">
                                <label for="club_home" class="col-sm-2 col-form-label">Club Home</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="club_home" id="club_home">
                                        <option value="">- Pilih club -</option>
                                        <option value="<?php echo $ch ?>" <?php if ($ch == $ch) echo "selected" ?>><?php echo $ch ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="club_away" class="col-sm-2 col-form-label">Club Away</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="club_away" id="club_away">
                                        <option value="">- Pilih club -</option>
                                        <option value="<?php echo $ca ?>" <?php if ($ca == $ca) echo "selected" ?>><?php echo $ca ?></option>
                                    </select>
                                </div>
                            </div>
                    <?php
                    }
                    ?>
                    <div class="mb-3 row">
                        <label for="score_club_home" class="col-sm-2 col-form-label">Score Club Home</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="score_club_home" name="score_club_home" value="<?php echo $sch ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="score_club_away" class="col-sm-2 col-form-label">Score Club Away</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="score_club_away" name="score_club_away" value="<?php echo $sca ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="date_of_match" class="col-sm-2 col-form-label">Tanggal Pertandingan</label>
                        <div class="col-sm-10">
                            <input type='date' class="datepicker" id="date_of_match" name="date_of_match" value="<?php echo $date ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="stadion" class="col-sm-2 col-form-label">Stadion</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="stadion" name="stadion" value="<?php echo $stadion ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="week" class="col-sm-2 col-form-label">Minggu Ke-</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="week" name="week" value="<?php echo $week ?>">
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
                            <th scope="col">Club Home</th>
                            <th scope="col">Score Club Home</th>
                            <th scope="col">Score Club Away</th>
                            <th scope="col">Club Away</th>
                            <th scope="col">Stadion</th>
                            <th scope="col">Week</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from match_schedule where match_schedule.league_id='$fk'order by match_schedule_id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['match_schedule_id'];
                            $ch         = $r2['club_home'];
                            $ca         = $r2['club_away'];
                            $sch        = $r2['score_club_home'];
                            $sca        = $r2['score_club_away'];
                            $date       = $r2['date_of_match'];
                            $stadion    = $r2['stadion'];
                            $week       = $r2['week'];
                            $fk         = $r2['league_id'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $ch ?></td>
                                <td scope="row"><?php echo $sch ?></td>
                                <td scope="row"><?php echo $sca ?></td>
                                <td scope="row"><?php echo $ca ?></td>
                                <td scope="row"><?php echo $stadion ?></td>
                                <td scope="row"><?php echo $week ?></td>
                                <td scope="row"><?php echo $date ?></td>
                                <td scope="row">
                                    <a href="jadwal.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="jadwal.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>           
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
