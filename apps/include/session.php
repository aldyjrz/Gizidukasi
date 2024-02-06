
<?php

require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\JWK;

// Your Google Sign-In client ID
$clientId = "115551103032-9bmhltoftioe48m5bo7op5oimuur7d8a.apps.googleusercontent.com";

// Get the JWT from the query parameter
$jwt =  $_SESSION['jwt'];

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