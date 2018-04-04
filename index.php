<?php
 require_once 'DB/db.php';
 require_once 'DB/main.php';

 session_start();
 


$utils = new main;

$query = $utils->getQuery($current=0);
$results = $utils->fetchData($query, 1);
$table_fields = $utils->getCols();

if(isset($_GET)){
    $_SESSION['filter'] = false;
 $_SESSION['query'] = "";
//  echo $_SESSION['query'];
    $getPage = $_GET['page'];
    if($getPage >= 0 || $getPage <= $pages){
        $current = $getPage;
        $query = $utils->getQuery($req="change", $current);
        // echo $query;
    }
    else{
        $current = 0;
        $query = $utils->getQuery($req="change", $current);
    }
    $results = $utils->fetchData($query, 1);
}

  if($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = $utils->filter($table_fields, $_POST);
        $results = $utils->fetchData($query, 1);
     }

$selects = $utils->getOptions($table_fields);
    














    // function displayDetails($current, $pages){
    //     echo 'Page '.($current+1).' of '.floor($pages+1).' pages.';
    // }

    // function getQuery($query){

    // }

    //  if(isset($_GET)){
    //     $getPage = $_GET['page'];
    //     if($getPage >= 0 || $getPage <= $pages){
    //         $current = $getPage;
    //         $offset = $current*10;
    //     }
    //     else{
    //         $current = 0;
    //         $offset = 0;
    //     }
    //     echo 'Page '.($current+1).' of '.floor($pages+1).' pages.';
    //  }
    //  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //      $query = "SELECT * FROM ".$table." WHERE ";
    //      $check = false;
    //      foreach($table_fields as $field){
    //          if($_POST[$field] != NULL){
    //              if($check){
    //                  $query = $query." AND ";
    //              }
    //              $check = true;
    //              $multi = explode(',', $_POST[$field]);
    //              $query = $query.$field.' IN (';
    //              if(count($multi) > 1){
                     
    //                  for($i=0;$i<sizeof($multi);$i++){
    //                      $query = $query.'"'.$multi[$i].'"';
    //                      if($i != sizeof($multi)-1){
    //                          $query = $query.',';
    //                      }
    //                      else{
    //                          $query = $query.')';
    //                      }
    //                  }
    //              }
    //              else{
    //                  $query = $query.'"'.$_POST[$field].'")';
    //              }
    //          }
    //      }
    //  }
    //  else{
    //      $query = "SELECT * FROM ".$table." LIMIT 10 OFFSET ".$offset;
    //  }
    //  $stmt = $conn->prepare($query);
    //  $stmt->execute();

    require 'views.php';
    ?>
