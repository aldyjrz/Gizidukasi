<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = mysqli_connect("localhost", "root", "", "db_gizi");

    // Retrieve form data
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Image upload handling
    $targetDir = "uploads/"; // Directory where you want to store the uploaded images
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Perform database insertion
            
            if (!$koneksi) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $created_by = "your_created_by"; // Replace with the actual created_by value
            $created_date = date('Y-m-d H:i:s'); // Current date and time

            $sql = "INSERT INTO tbl_artikel (judul, img, isi, created_by, created_date)
                    VALUES ('$title', '$targetFile', '$content', '$created_by', '$created_date')";

            if (mysqli_query($koneksi, $sql)) {
                echo "Data inserted successfully!";
                echo "<script>window.location.href='page.php?page=dashboard'</script>"; // Send success response back to the client

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
            }

            mysqli_close($koneksi);

        }
    }
}