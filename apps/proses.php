<?php

session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db_gizi");

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
$sekarang = date("Y-m-d H:i:s");
$page = $_GET['page'];
$act = $_GET['act'];
if ($page == "daftar_anak" && $act == "tambah_anak") {
    // Ambil data dari formulir
    $namaAnak = $_POST['namaAnak'];
    $tglLahir = $_POST['tglLahir'];

    $umur = $_POST['umur'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $idOrtu = $_POST['id_ortu'];

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO tbl_anak (id_ortu, tgl_lahir, nama, umur, kelamin) VALUES ('$idOrtu', '$tglLahir', '$namaAnak', '$umur', '$jenisKelamin')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header("Location: page.php?page=daftar_anak&msg=Berhasil tambah data anak");
        exit(); // Ensure that no further code is executed after the redirect

    } else {
        header("Location: page.php?page=daftar_anak&msg=" . mysqli_error($koneksi));

        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else if ($page == "daftar_anak" && $act == "hapus") {
    // Ambil data dari formulir
    $id = $_GET['id'];


    // Query untuk menyimpan data ke database
    $query = " delete from tbl_anak where id='$id';";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        header("Location: page.php?page=daftar_anak&msg=Berhasil hapus data anak");
        exit(); // Ensure that no further code is executed after the redirect

    } else {
        header("Location: page.php?page=daftar_anak&msg=" . mysqli_error($koneksi));

        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else if ($page == "gizi" && $act == "tambah") {


    $idAnak = $_POST['idAnak'];
    $namaMakanan = $_POST['namaMakanan'];
    $id_ortu = $_POST['id_ortu'];

    $jamMakan = $_POST['jamMakan'];
    $kalori = isset($_POST['kalori']) ? $_POST['kalori'] : 0;

    // Perform necessary validation here if needed

    // Insert data into the database
    $query = "INSERT INTO  `tbl_gizi_anak` (
         `id_anak`,
         `id_ortu`,
        `nama_makanan`,
        `jam_makan`,
        `jml_kalori`,
        `created_date`
      )
      VALUES
        (
           '$idAnak',
           '$id_ortu',

          '$namaMakanan',
          '$jamMakan',
          '$kalori',
          '$sekarang'
        );
        ";
    // Execute the query
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>window.location.href='page.php?page=gizi&msg=Berhasil Tambah Data'</script>"; // Send success response back to the client
    } else {
        echo "<script>window.location.href='page.php?page=gizi&msg=Gagal Tambah Data'</script>"; // Send success response back to the client
    }
}

else if ($page == "tumbuh_kembang" && $act == "tambah") {

  // Retrieve form data
  $id_ortu = $_POST['id_ortu'];
  $idAnak = $_POST['idAnak'];
  $periode = $_POST['periode'];
    $t = date("Y", strtotime($periode));
    $m = date("m", strtotime($periode));
  $q_check = mysqli_query($koneksi, "select * from tbl_tumbuhkembang where id_anak='$idAnak' and YEAR(periode) = '$t' AND MONTH(periode) = '$m';");
    $rows = mysqli_num_rows($q_check);

 

    if($rows > 0 ){
        echo "<script>alert('anda telah membuat catatan pada periode ini'); window.location.href='page.php?page=tumbuh_kembang';</script>";
        exit();
    }
  $bb_anak = isset($_POST['bb_anak']) ? $_POST['bb_anak'] : 0;
  $tb_anak = isset($_POST['tb_anak']) ? $_POST['tb_anak'] : 0;
  $lka_anak = isset($_POST['lka_anak']) ? $_POST['lka_anak'] : 0;

  // Perform validation and sanitation as needed

  // Insert data into MySQL database
  $sql = "INSERT INTO  `tbl_tumbuhkembang` (
 
    `id_anak`,
    `id_ortu`,
    `periode`,
    `bb_anak`,
    `tb_anak`,
    `lka_anak`
  )
  VALUES
    (
 
      '$idAnak',
      '$id_ortu',
      '$periode',
      '$bb_anak',
      '$tb_anak',
      '$lka_anak'
    );
   " ;

    // Execute the query
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        echo "<script>window.location.href='page.php?page=tumbuh_kembang&msg=Berhasil Tambah Data'</script>"; // Send success response back to the client
    } else {
   echo "<script>window.location.href='page.php?page=tumbuh_kembang&msg=Gagal Tambah Data'</script>"; // Send success response back to the client
    }
}
else if ($page == "tumbuh_kembang" && $act == "delete") {

  // Retrieve form data
  $id = $_GET['id'];
   

  $result = mysqli_query($koneksi, "DELETE FROM tbl_tumbuhkembang where id = '$id' ;");
   

    if ($result) {
        echo "<script>window.location.href='page.php?page=tumbuh_kembang&msg=Berhasil Tambah Data'</script>"; // Send success response back to the client
    } else {
   echo "<script>window.location.href='page.php?page=tumbuh_kembang&msg=Gagal Tambah Data'</script>"; // Send success response back to the client
    }
}
// Tutup koneksi
mysqli_close($koneksi);
