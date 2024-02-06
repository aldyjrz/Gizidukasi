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
        exit;
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



    <!-- Content -->
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-10">
                    <div>
                    <div class="container mt-5">
                        <?php if(isset($_GET['msg'])){  ?>
                        <div class="alert alert-sucess bg-success text-white"><?= $_GET['msg'] != null ? $_GET['msg'] : "" ?></div>
                  <?php  } ?>
                        <h2 class="mb-4">Form Pendaftaran Anak</h2>

<!-- Form Input -->
<form action="proses.php?page=daftar_anak&act=tambah_anak" method="post">
<input type="hidden" class="form-control" id="id_ortu" name="id_ortu"  value = '<?= $_SESSION['id_ortu']?>' required>

    <div class="form-group">
        <label for="namaAnak">Nama Anak:</label>
        <input type="text" class="form-control" id="namaAnak" name="namaAnak" required>
    </div>
    <div class="form-group">
        <label for="tglLahir">Tgl Lahir</label>
        <input type="date" class="form-control" id="tglLahir" onchange="calculateAge()" name="tglLahir" required>
    </div>

    <div class="form-group">
        <label for="umur">Umur (Bulan)</label>
        <input type="number" class="form-control" id="umur" name="umur" required>
    </div>

    <div class="form-group">
        <label for="jenisKelamin">Jenis Kelamin:</label>
        <select class="form-control" id="jenisKelamin" name="jenisKelamin" required>
            <option value="laki-laki">Laki-Laki</option>
            <option value="perempuan">Perempuan</option>
        </select>
    </div>

    

    <button type="submit" class="btn btn-primary mt-2 mb-5 ">Daftar Anak</button>
</form>

<!-- DataTable -->
<table id="tableAnak" class="mt-5 tableAldy table table-bordered table-hovered table-striped mt-5">
        <thead>
            <tr>
                <th>Nama Anak</th>
                <th>Tanggal Lahir</th>

                <th>Umur</th>
                <th>Jenis Kelamin</th>
                <th>-</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $id_ortu = $_SESSION['id_ortu'];
            $q = mysqli_query($koneksi, "select * from tbl_anak where id_ortu = '$id_ortu';");
            while($data = mysqli_fetch_array($q)){
?>
 <td><?=$data['nama'] ?></td>
 <td><?=$data['tgl_lahir'] ?></td>

                <td><?=$data['umur'] ?></td>
                <td><?=$data['kelamin'] ?></td>
                <td><a class='btn btn-danger' href='proses.php?page=daftar_anak&act=hapus&id=<?= $data['id'] ?>'> Hapus </a></td>


<?php } ?>
            </tr>
        </tbody>
    </table>

                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
    </div>
    <script>

function calculateAge() {
        // Get the selected birth date
        var birthDate = new Date(document.getElementById('tglLahir').value);

        // Get the current date
        var currentDate = new Date();

        // Calculate the age in months
        var ageInMonths = (currentDate.getFullYear() - birthDate.getFullYear()) * 12 + (currentDate.getMonth() - birthDate.getMonth());

        // Update the umur input field
        document.getElementById('umur').value = ageInMonths;
}
        </script>
     
    