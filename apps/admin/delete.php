<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = mysqli_connect("localhost", "root", "", "db_gizi");
 $id = $_GET['id'];
            $sql = "delete from tbl_artikel where id='$id';";

            if (mysqli_query($koneksi, $sql)) {
                echo "Data Delete successfully!";
                echo "<script>window.location.href='page.php?page=dashboard'de</script>"; // Send success response back to the client

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
            }
}