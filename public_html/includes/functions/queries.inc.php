<?php
    function recipe_by_ing ($ingredient) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT STRAIGHT_JOIN title
                FROM ".$tables["Recipes"]." AS R, "
                      .$tables["Recipes_ln_Ingredients"]." AS ln, "
                      .$tables["Ingredients"]." AS i
                WHERE R.id=ln.id_recipe
                AND ln.id_ingredient=i.id
                AND i.name='".mysqli_real_escape_string($db, $ingredient)."'";
    }

?>
