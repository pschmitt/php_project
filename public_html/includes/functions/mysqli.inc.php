<?php
    function db_con() {
        isset($GLOBALS['credentials']) or die("Error !");
        
        $cred = $GLOBALS['credentials'];
        $db = mysqli_connect($cred["db_host"], $cred["db_user"], $cred["db_password"], $cred["db_name"]) or die (mysqli_connect_error());
        return $db;
    }

    function query($db, $sql) {
        isset($db, $sql) and $res = mysqli_query($db, $sql) or die("Error: ".mysqli_error($db));
        return $res;
    }

    function get_col_names($db, $table="Users") {
        $sql = "SELECT * FROM ".$table;
        // TODO replace mysqli_query by query()
        $finfo = mysqli_fetch_fields(query($db, $sql));
        foreach ($finfo as $field) {
            $field_names[] = $field->name;
        }
        return $field_names;
    }

?>
