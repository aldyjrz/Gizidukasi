<?php
require_once 'vendor/autoload.php';

    use \Firebase\JWT\JWT;
    use \Firebase\JWT\JWK;

    // Your Google Sign-In client ID
    $clientId = "115551103032-9bmhltoftioe48m5bo7op5oimuur7d8a.apps.googleusercontent.com";

    // Get the JWT from the query parameter
    $jwt =  $_SESSION['jwt'] ;

    if (empty($jwt)) {
        echo json_encode(['error' => 'JWT is empty']);
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
    } catch (\Exception $e) {
        // Handle JWT decoding errors

        if ($e->getMessage() == "Expired token") {
            echo "<script>window.location.href='index.php';</script>";
        }
    }

    
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4 mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10">

                <div class="alert alert-warning">Catatan Tumbuh Kembang Anak, di isi setiap bulan sesuai hasil dari posyandu</div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-4">Form Laporan Gizi Makanan Anak</h2>
                    </div>
                    <div class="card-body">
                        <form action='proses.php?page=tumbuh_kembang&act=tambah' method="POST" id="giziForm">
                            <div class="form-group">
                                <label for="namaAnak">Nama Anak:</label>

                                <select name='idAnak' required class='form-select select'>
                                    <option> Pilih Anak Terdaftar </option>
                                    <?php
                                    $id_ortu  = $_SESSION['id_ortu'];
                                    $q = mysqli_query($koneksi, "select * from tbl_anak where id_ortu ='$id_ortu';");

                                    while ($data = mysqli_fetch_array($q)) { ?>
                                        <option value='<?= $data['id'] ?>'><?= $data['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="hidden" class="form-control" id="id_ortu" name="id_ortu" value='<?= $id_ortu ?>' required>

                            <div class="form-group mt-2">
                                <label for="periode">Periode</label>
                                <input type="date" class="form-control" id="periode" name="periode" required>
                            </div>


                            <div class="form-group mt-2">
                                <label for="bb">Berat Badan :</label>
                                <input type="number" class="form-control" id="bb" name="bb_anak" required placeholder='BB Anak sesuai hasil posyandu'>
                            </div>

                            <div class="form-group mt-2">
                                <label for="tb">Tinggi Badan :</label>
                                <input type="number" class="form-control" id="tb" name="tb_anak" required placeholder='TB Anak sesuai hasil posyandu'>
                            </div>

                            <div class="form-group mt-2">
                                <label for="lka_anak">Lingkar Kelapa :</label>
                                <input type="number" class="form-control" id="lka_anak" name="lka_anak" required placeholder='Lingkap Kepala sesuai hasil posyandu'>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Tambah Data</button>
                        </form>
                    </div>
                </div>

                <hr>
                <div class="card">

                    <div class="card-header">
                        Catatan Harian
                    </div>

                    <div class="card-body">


                        <table id="giziTable" class="table table-bordered table-striped table-hovered table-responsive">
                            <thead>
                                <tr>
                                    <th>Nama Anak</th>
                                    <th>Periode</th>
                                    <th>Berat Badan</th>
                                    <th>Tinggi Badan</th>
                                    <th>Lingkar Kepala</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = mysqli_query($koneksi, "select *, a.id as id_tk from tbl_tumbuhkembang a join tbl_anak b on a.id_anak = b.id where a.id_ortu='$id_ortu';");
                                while ($data = mysqli_fetch_array($q)) { ?>
                                    <tr>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['periode'] ?></td>
                                        <td><?= $data['tb_anak'] ?></td>
                                        <td><?= $data['bb_anak'] ?></td>
                                        <td><?= $data['lka_anak'] ?></td>

                                        <td><a href='proses.php?page=tumbuh_kembang&act=delete&id=<?= $data['id_tk']?>' class='btn btn-danger'>Hapus</td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
</main>
</section>

<!-- Custom JS -->
<script>
    // Initialize DataTable
    $(document).ready(function() {

        $('#giziTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'pdf']
        });


    });
</script>