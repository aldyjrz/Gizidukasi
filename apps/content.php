<?php


$page = $_GET['page'];

switch ($page) {
    case "profile":
        include 'profile.php';
        break;
    case "daftar_anak":
        include 'page/daftar_anak.php';
        break;
    case "gizi":
        include 'page/gizi/gizi.php';
        break;
    case "dashboard":
        include 'page/dashboard.php';
        break;
        case "article":
            include 'page/article.php';
            break;
    case "kalkulator":
        include 'page/kalkulator/kalkulator.php';
        break;
        case "tumbuh_kembang":
            include 'page/tumbuh_kembang/tumbuh_kembang.php';
            break;
    
}
