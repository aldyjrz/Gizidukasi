<?php
session_start();

function encrypt_decrypt($action, $string)
{
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'aldytoi1337';
    $secret_iv = 'aqifa';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
$koneksi = mysqli_connect("localhost", "root", "", "db_gizi");

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
$sekarang = date("Y-m-d H:i:s");



$username = mysqli_escape_string($koneksi, $_POST['username']);
$password = encrypt_decrypt("encrypt", mysqli_escape_string($koneksi, $_POST['password']));

$q = mysqli_query($koneksi, "select * from tbl_admin where username='$username' and password='$password';");
if(mysqli_num_rows($q) > 0 ){
    $data = mysqli_fetch_array($q);
    $_SESSION['username'] = $data['username'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    echo "<script> window.location.href = 'page.php?page=artikel'</script>";

}else{
    echo "<script>alert('User tidak ditemukan'); window.location.href = 'index.php'</script>";
}