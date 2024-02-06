    <?php
     
    require_once 'vendor/autoload.php';

    use \Firebase\JWT\JWT;
    use \Firebase\JWT\JWK;

    // Your Google Sign-In client ID
    $clientId = "115551103032-9bmhltoftioe48m5bo7op5oimuur7d8a.apps.googleusercontent.com";

    // Get the JWT from the query parameter
    $jwt = $_GET['token'];
    $_SESSION['jwt'] = $jwt;


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

    
    // Prepare and execute SELECT statement
   // Execute SELECT statement
$email = $data->email;
$selectQuery = "SELECT * FROM tbl_user WHERE email = '$email'";
$result = mysqli_query($mysqli, $selectQuery);

// Check if user exists
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
    ?>



    <!-- Content -->
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-10">
                    <div>

                        <img class="rounded-circle" src='<?php echo $data->picture ?>' />
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type='text' disabled class='form-control' value='<?php echo $data->name ?>'></input>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class='form-control' type='text' disabled value='<?php echo $data->email ?>'></input>
                                </div>
                            </div>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
    </div>