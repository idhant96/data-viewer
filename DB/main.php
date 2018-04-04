<?php

class Main {
    var $query = "";
    var $current = 0;
    var $offset = 0;
    function fetchData($query, $fetchtype){
        $stmt = $GLOBALS["con"]->prepare($query);
        $stmt->execute();
        if($fetchtype == 1){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else if($fetchtype == 2){
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        return $result;
    }

    function getOptions($table_fields){
        $selects = array();
        $cols = array( "type", "grade", "headquarter");
        foreach($table_fields as $col){
            if(in_array($col, $cols)){
                $query = 'SELECT '.$col.' FROM '.$GLOBALS['table'];
                $selects[$col] = array();
                $result = $this->fetchData($query, 2);
                foreach($result as $res){
                    if(!in_array($res, $selects[$col])){
                        array_push($selects[$col], $res);
                    }
                }
            }
        }
        return $selects;
    }



    function filter($table_fields, $postData){
        $query = "SELECT * FROM ".$GLOBALS['table']." WHERE ";
        $check = false;
        foreach($table_fields as $field){
            if($postData[$field] != NULL){
                if($check){
                    $query = $query." AND ";
                }
                $check = true;
                $multi = explode(',', $postData[$field]);
                $query = $query.$field.' IN (';
                if(count($multi) > 1){
                    for($i=0;$i<sizeof($multi);$i++){
                        $query = $query.'"'.$multi[$i].'"';
                        if($i != sizeof($multi)-1){
                            $query = $query.',';
                        }
                        else{
                            $query = $query.')';
                        }
                    }
                }
                else{
                    $query = $query.'"'.$postData[$field].'")';
                }
            }
        }
        $_SESSION['filter'] = true;
        $_SESSION['query'] = $query;
        $query = $query.' '.'LIMIT 10 OFFSET 0';
        // echo $query;
        return $query;
    }

    function getCols(){
        $desc = "DESCRIBE ".$GLOBALS['table'];
        $table_fields = $this->fetchData($desc,2);
        return $table_fields;
    }

    function getQuery($req=null, $current=0, $pquery=null){
        $offset = $current*10;
        $base = "SELECT * FROM ".$GLOBALS['table'].' ';
        $limitset = "LIMIT 10 OFFSET ".$offset;
        if($req == null){
            $query = $base.$limitset;
        }
        else if($req == "change"){
            if($_SESSION['filter']==false){
                $query = $base.$limitset;
            }
            else{
                $query = $_SESSION['query'].' '.$limitset;
            }
        }
        return $query;
    }
}

?>