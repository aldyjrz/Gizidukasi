<?php
include 'include/session.php';


?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-md-4 mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10">

                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-4">Form Laporan Gizi Makanan Anak</h2>
                    </div>
                    <div class="card-body">
                        <form action='proses.php?page=gizi&act=tambah' method="POST" id="giziForm">
                         <div class="form-group">
                                <label for="namaAnak">Nama Anak:</label>

                                <select name='idAnak' class='form-select select'>
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
                                <label for="namaMakanan">Nama Makanan:</label>
                                <input type="text" class="form-control" id="namaMakanan" name="namaMakanan" required>
                            </div>

                            <div class="form-group mt-2">
                                <label for="jamMakan">Jam Makan:</label>
                                <input type="time" class="form-control" id="jamMakan" name="jamMakan" required>
                            </div>

                            <div class="form-group mt-2">
                                <label for="kalori">Kalori:</label>
                                <input type="number" class="form-control" id="kalori" name="kalori" placeholder='Kosongkan jika tidak mengetahui'>
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
                            

                        <table id="giziTable" class="table table-bordered table-striped table-hovered">
                            <thead>
                                <tr>
                                    <th>Nama Anak</th>
                                    <th>Jenis Makanan</th>
                                    <th>Jam Makan</th>
                                    <th>Kalori</th>

                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = mysqli_query($koneksi, "select * from tbl_gizi_anak a join tbl_anak b on a.id_anak = b.id where a.id_ortu='$id_ortu';");
                                while ($data = mysqli_fetch_array($q)) { ?>
                                    <tr>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['nama_makanan'] ?></td>
                                        <td><?= $data['jam_makan'] ?></td>
                                        <td><?= $data['jml_kalori'] ?></td>

                                        <td><?= $data['created_date'] ?></td>

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