<?php
 require_once 'DB/db.php';
 require_once 'DB/main.php';

session_start();

$utils = new main;

$current = 0;
$query = $utils->getQuery($current=0);
$results = $utils->fetchData($query, 1);
$table_fields = $utils->getCols();

if($_GET['page'] == -1){
    $_POST = array();
    $_GET = array();
    $_SESSION = array();
    $_SESSION['filter'] = false;
    header("Refresh:0; url=index.php?page=0");
}

else if(isset($_GET['page'])){
    $getPage = $_GET['page'];
    if($getPage >= 0 || $getPage <= $pages){
        $current = $getPage; 
        $query = $utils->getQuery($req="change", $current);
    }
    else{
        $current = 0;
        $query = $utils->getQuery($req="change", $current);
    }
    $results = $utils->fetchData($query, 1);
}

else if($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = $utils->filter($table_fields, $_POST);
        $results = $utils->fetchData($query, 1);
     }

$selects = $utils->getOptions($table_fields);
    
require 'views.php';
?>
