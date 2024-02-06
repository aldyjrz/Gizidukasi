<?php
require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\JWK;

// Your Google Sign-In client ID
$clientId = "115551103032-9bmhltoftioe48m5bo7op5oimuur7d8a.apps.googleusercontent.com";

// Get the JWT from the query parameter
$jwt =  $_GET['token'];
$_SESSION['jwt'] = $jwt;

if (empty($jwt)) {
    echo json_encode(['error' => 'JWT is empty']);
    session_destroy();
    echo "<script>window.location.href='index.php';</script>";
}

// Google's public keys URL
$publicKeysUrl = 'https://www.googleapis.com/oauth2/v3/certs';

// Fetch Google's public keys
$publicKeys = JWK::parseKeySet(json_decode(file_get_contents($publicKeysUrl), true));

try {
    // Decode the JWT using Google's public keys
    $decoded = JWT::decode($jwt, $publicKeys, ['RS256']);
    // You can access the decoded claims
    $data  =   $decoded;

    // Prepare and execute SELECT statement
    // Execute SELECT statement

    // Check if user exists
    $email = $data->email;
    $selectQuery = "SELECT * FROM tbl_user WHERE email = '$email'";
    $result = mysqli_query($mysqli, $selectQuery);

    $userExists = mysqli_num_rows($result) > 0;

    if (!$userExists) {
        // Insert the user into tbl_user
        $insertQuery = "INSERT INTO tbl_user (email, name, picture) VALUES ('$data->email', '$data->name', '$data->picture')";
        mysqli_query($mysqli, $insertQuery);
    }

    // Fetch user data

    $userData = mysqli_fetch_assoc($result);

    // Store user ID in session
    $_SESSION['id_ortu'] = $userData['id'];
    $_SESSION['email'] = $userData['email'];
    // Tutup koneksi
    mysqli_close($mysqli);
} catch (\Exception $e) {
    // Handle JWT decoding errors

    if ($e->getMessage() == "Expired token") {
        echo "<script>window.location.href='index.php';</script>";
    }
}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10 mt-5 p-5">

                <div class="alert alert-success">Selamat Datang di Aplikasi Gizidukasi, Aplikasi Pencatatan Gizi dan Tumbuh Kembang Anak.</div>

                <?php
                  
                $id_ortu = $userData['id'];

                $q = mysqli_query($koneksi, "select * from tbl_anak where id_ortu = '$id_ortu'");
                if (mysqli_num_rows($q) < 1) { ?>
                    <div class="alert alert-danger">Anda belum membuat daftar anak, silakan <a href='page.php?page=daftar_anak' class='btn btn-primary'>Daftar Anak</a> untuk menggunakan fitur aplikasi</div>
                <?php
                } ?>
                <div class="card">
                    <div class="card-header">
                        Catatan Tumbuh Kembang Perbulan
                    </div>
                    <div class="card">


                        <div class="card-body">
                            <canvas id="lineChart" width="500" height="300"></canvas>


                            <table id="giziTable" class="mt-5 table table-bordered table-striped table-hovered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Nama Anak</th>
                                        <th>Periode</th>
                                        <th>Berat Badan</th>
                                        <th>Tinggi Badan</th>
                                        <th>Lingkar Kepala</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = mysqli_query($koneksi, "select *, a.id as id_tk from tbl_tumbuhkembang a join tbl_anak b on a.id_anak = b.id where a.id_ortu='$id_ortu' order by a.periode asc;");
                                    while ($data = mysqli_fetch_array($q)) { ?>
                                        <tr>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['periode'] ?></td>
                                            <td><?= $data['tb_anak'] ?></td>
                                            <td><?= $data['bb_anak'] ?></td>
                                            <td><?= $data['lka_anak'] ?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
               
                    <div class="card mt-3">
                        <div class="card-header">Artikel</div>
                        <div class="card-body">
                            <div class="row">

                            <?php 

                            $q = mysqli_query($koneksi, "select *  from tbl_artikel");
                            while($data = mysqli_fetch_array($q)){ ?>
                                <div class="col-sm-6 col-lg-4 mb-3">
                                    <div class="card mb-3 h-100">
                                        <img class='img img-fluid' src='admin/<?= $data['img']?>'>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $data['judul']?></h5>
                                            <p class="card-text"><?=  substr($data['isi'], 0 , 200) ?></p>
                                            <p class="card-text"><small class="text-muted"><?= $data['created_date'] ?></small></p>
                                            <a class='btn btn-info float-left' href='page.php?page=article&id=<?= $data['id']?>'>Selengkapnya</a>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        </div>
            </div>
        </div>
</main>
</div>
</div>

<script>
        // Data from PHP
        <?php
            // Data retrieval from PHP
            $id_ortu = $_SESSION['id_ortu'];
            $q = mysqli_query($koneksi, "select *, a.id as id_tk from tbl_tumbuhkembang a join tbl_anak b on a.id_anak = b.id where a.id_ortu='$id_ortu' order by a.periode asc;");
            $chartData = array();
            while ($data = mysqli_fetch_array($q)) {
                $chartData[] = array(
                    'nama' => $data['nama'],
                    'periode' => $data['periode'],
                    'tb_anak' => $data['tb_anak'],
                    'bb_anak' => $data['bb_anak'],
                    'lka_anak' => $data['lka_anak']
                );
            }
        ?>

        // JavaScript for Chart.js
        // Convert PHP array to JavaScript array
        var chartData = <?php echo json_encode($chartData); ?>;

        // Prepare data for Chart.js
        var labels = [];
        var tbData = [];
        var bbData = [];
        var lkaData = [];

        chartData.forEach(function(data) {
            labels.push(data.periode);
            tbData.push(data.tb_anak);
            bbData.push(data.bb_anak);
            lkaData.push(data.lka_anak);
        });

        // Create a line chart
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tinggi Badan',
                    data: tbData,
                    borderColor: 'blue',
                    fill: false
                }, {
                    label: 'Berat Badan',
                    data: bbData,
                    borderColor: 'green',
                    fill: false
                }, {
                    label: 'Lingkar Kepala',
                    data: lkaData,
                    borderColor: 'red',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Tumbuh Kembang Anak'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Periode'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Data'
                        }
                    }]
                }
            }
        });
    </script>