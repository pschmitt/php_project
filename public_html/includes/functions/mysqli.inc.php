<?php
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
