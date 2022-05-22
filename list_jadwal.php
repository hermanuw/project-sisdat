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
$ch         = "";
$sch        = "";
$ca         = "";
$sca        = "";
$stadion    = "";
$week       = "";
$date       = "";

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
                            <th scope="col">Liga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select match_schedule.*, league.league_name from match_schedule inner join league on match_schedule.league_id = league.league_id order by match_schedule_id desc";
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
                            $name       = $r2['league_name'];

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
                                <td scope="row"><?php echo $name ?></td>
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
