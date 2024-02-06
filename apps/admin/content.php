<?php


$page = $_GET['page'];

switch ($page) {
    case "dashboard":
        include 'dashboard.php';
        break;  
        case "edit":
            include 'edit.php';
            break;
      
  
    
}
