<?php
    function recipe_by_ing ($ingredient) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT title
                FROM ".$tables["Recipes"]." AS R, "
                      .$tables["Recipes_ln_Ingredients"]." AS ln, "
                      .$tables["Ingredients"]." AS i
                WHERE R.id=ln.id_recipe
                AND ln.id_ingredient=i.id
                AND i.name LIKE '%".mysqli_real_escape_string($db, $ingredient)."%'";
    }
    
    function recipe_by_title($title) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT title
                FROM ".$tables["Recipes"].
                " WHERE title LIKE '%".mysqli_real_escape_string($db, $title)."%'";
    }
?>
