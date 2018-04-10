<?php

class Main {
    var $query = "";
    var $current = 0;
    var $offset = 0;
    var $table_fields = array();
    
    function fetchData($query, $fetchtype){
        $stmt = $GLOBALS["con"]->prepare($query);
        $stmt->execute();
        if($fetchtype == 1){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else if($fetchtype == 2){
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        else{
            $result = $stmt->fetchColumn();
        }
        return $result;
    }

    function getOptions($table_fields){
        $selects = array();
        if($GLOBALS['table'] == 'firms'){
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
        }
        else{
            foreach($table_fields as $col){
                $selects[$col] = array();
                if($col == 'speciality'){
                    $query = 'SELECT speciality FROM specialities';
                    $result = $this->fetchData($query, 2);
                    foreach($result as $res){
                        if(!in_array($res, $selects[$col])){
                            array_push($selects[$col], $res);
                        }
                    }
                }
                else if($col == 'qualification'){
                    $query = 'SELECT qualification FROM qualifications';
                    $result = $this->fetchData($query, 2);
                    foreach($result as $res){
                        if(!in_array($res, $selects[$col])){
                            array_push($selects[$col], $res);
                        }
                    }
                }
                else if($col == 'practice'){
                    $query = 'SELECT practice FROM practices';
                    $result = $this->fetchData($query, 2);
                    foreach($result as $res){
                        if(!in_array($res, $selects[$col])){
                            array_push($selects[$col], $res);
                        }
                    }
                }
                else{
                    $cols = array("age", "city", "state", "gender");
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
                }
            }

        }

        return $selects;
    }

    function filter($table_fields, $postData){
        $base = "";
        if($GLOBALS['table'] == 'firms'){
            $base = "SELECT * FROM ".$GLOBALS['table'].' ';
       }
       else{
         $base =  "SELECT
                    docs.id,full_name,email,mobile,age,gender,city,state,postcode,GROUP_CONCAT( DISTINCT specialities.speciality) as speciality, GROUP_CONCAT( DISTINCT qualifications.qualification) as qualification, GROUP_CONCAT( DISTINCT practices.practice) as practice FROM `docs` 
                                left JOIN doctor_specialities on doctor_specialities.doctor_id=docs.id
                                left JOIN specialities on specialities.id=doctor_specialities.speciality_id
                                LEFT JOIN doctor_qualifications on doctor_qualifications.doctor_id=docs.id
                                LEFT JOIN qualifications on qualifications.id=doctor_qualifications.qualification_id
                                left JOIN doctor_practices on doctor_practices.doctor_id=docs.id
                                LEFT JOIN practices on practices.id=doctor_practices.practice_id";
       }
        $query = $base." WHERE ";
        $check = false;
        foreach($postData as $key => $val){
                if($check){
                    $query = $query." AND ";
                }
                $check = true;
                $query = $query.' '.$key.' IN (';
                for($i=0;$i<sizeof($val);$i++){
                    $query = $query."'".$val[$i]."'";
                    if($i != sizeof($val)-1){
                        $query = $query.',';
                    }
                }
                $query = $query.')';
            }
            // echo $query;



        if($GLOBALS['table'] == 'firms'){
            $query = $query.' LIMIT 10 OFFSET 0';
            $_SESSION['query'] = $query;
        }
        else{
            $_SESSION['query'] = $query.' GROUP BY docs.id ';
            $query = $query.' GROUP BY docs.id LIMIT 10 OFFSET 0';
            // echo $query;
        }
        $_SESSION['filter'] = true;
        // echo $query;
        // echo $_SESSION['query'];
        $this->checkRes($_SESSION['query'], 0);
        // echo $query;
        return $query;
    }

    function getCols(){
        $table_fields = array();
        if($GLOBALS['table'] == 'firms'){
          $desc = "DESCRIBE ".$GLOBALS['table'];
          $table_fields = $this->fetchData($desc,2);
        }
        else{
            $base = "SELECT
            docs.id,full_name,email,mobile,age,gender,city,state,postcode,GROUP_CONCAT( DISTINCT specialities.speciality) as speciality, GROUP_CONCAT( DISTINCT qualifications.qualification) as qualification, GROUP_CONCAT( DISTINCT practices.practice) as practice FROM `docs` 
                left JOIN doctor_specialities on doctor_specialities.doctor_id=docs.id
                left JOIN specialities on specialities.id=doctor_specialities.speciality_id
                LEFT JOIN doctor_qualifications on doctor_qualifications.doctor_id=docs.id
                LEFT JOIN qualifications on qualifications.id=doctor_qualifications.qualification_id
                left JOIN doctor_practices on doctor_practices.doctor_id=docs.id
                LEFT JOIN practices on practices.id=doctor_practices.practice_id
                 GROUP BY docs.id ";
                $rs = $GLOBALS['con']->query($base.' LIMIT 0');
                for ($i = 0; $i < $rs->columnCount(); $i++) {
                    $col = $rs->getColumnMeta($i);
                    $columns[] = $col['name'];
                }
                $table_fields = array_values($columns);
            }
        return $table_fields;
}

    function checkRes($query, $current){
        // echo $query;
        $result = $this->fetchData($query, 3);
        // echo 'reachd';
        // var_dump($result);
        if($result == null || $result == 0){
            echo 'No results Found.';
        }
        else{
            // var_dump($result);
            echo "Page ".$current." of ".$result.' pages';
        }
    }

    function getQuery($req=null, $current=0){
        $offset = $current*10;
        $base = "";
        if($GLOBALS['table'] == 'firms'){
             $base = "SELECT * FROM ".$GLOBALS['table'].' ';
        }
        else{
            $base = "SELECT
                    docs.id,full_name,email,mobile,age,gender,city,state,postcode,GROUP_CONCAT( DISTINCT specialities.speciality) as specialities, GROUP_CONCAT( DISTINCT qualifications.qualification) as qualifications, GROUP_CONCAT( DISTINCT practices.practice) as practices FROM `docs` 
                        left JOIN doctor_specialities on doctor_specialities.doctor_id=docs.id
                        left JOIN specialities on specialities.id=doctor_specialities.speciality_id
                        LEFT JOIN doctor_qualifications on doctor_qualifications.doctor_id=docs.id
                        LEFT JOIN qualifications on qualifications.id=doctor_qualifications.qualification_id
                        left JOIN doctor_practices on doctor_practices.doctor_id=docs.id
                        LEFT JOIN practices on practices.id=doctor_practices.practice_id
            GROUP BY docs.id ";
        }
        $limitset = "LIMIT 10 OFFSET ".$offset;
        if($req == null){
            $query = $base.$limitset;
        }
        else if($req == "change"){
            if($_SESSION['filter']==false){
                $query = $base.$limitset;
                $baseCount = "SELECT COUNT(*) FROM ".$GLOBALS['table'];
                $this->checkRes($baseCount, $current);
            }
            else{
                $query = $_SESSION['query'].' '.$limitset;
                $this->checkRes($_SESSION['query'], $current);
            }
        }
        // echo $query;
        return $query;
    }
}

?>