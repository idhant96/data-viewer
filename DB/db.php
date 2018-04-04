<?php
$servername = "localhost";
$username = "root";
$password = "idhant";
$db = "backup";
$GLOBALS['table'] = "firms";
try {
    $conn = new PDO("mysql:host=$servername;dbname=".$db, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $GLOBALS['con'] = $conn;
    }
catch(PDOException $e)
    {
        echo "could not connect for some reasons " . $e->getMessage();
    }


// $current = 0;
// $previous = 0;
// $next = 1;

// $offset = 0;
// $desc = "DESCRIBE ".$table;
// $stmt = $conn->prepare($desc);
// $stmt->execute();
// $table_fields = $stmt->fetchAll(PDO::FETCH_COLUMN);
// $desc = 'SELECT COUNT(*) FROM '.$table;
// $stmt = $conn->prepare($desc);
// $stmt->execute();
// $count = $stmt->fetchColumn();
// $pages = $count/10 + 1;
// $query = "";

// $selects = array();
// $cols = array( "type", "grade", "headquarter");
// foreach($table_fields as $col){
//     if(in_array($col, $cols)){
//         $selects[$col] = array();
//         $stmt = $conn->prepare('SELECT '.$col.' FROM '.$table);
//         $stmt->execute();
//         $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
//         foreach($result as $res){
//             if(!in_array($res, $selects[$col])){
//                 array_push($selects[$col], $res);
//             }
//         }
//     }
// }
?>