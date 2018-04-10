<?php
 require_once 'DB/db.php';
 require_once 'DB/main.php';

session_start();

$utils = new main;
$table_fields = null;
$current = 0;
$query = $utils->getQuery($current=0);
// echo $query;
$results = $utils->fetchData($query, 1);
// print_r($results);
$table_fields = $utils->getCols();
// var_dump($table_fields);
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
        // var_dump($_POST);
        $query = $utils->filter($table_fields, $_POST);
        $results = $utils->fetchData($query, 1);
        // foreach($_POST as $key=>$val){
        //         print_r($_POST[$key]);die;
        //         }
        // }
        }

$selects = $utils->getOptions($table_fields);
    
require 'views.php';
?>
