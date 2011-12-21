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
    
    function recipes_by_ing_list ($ing_list) {
         if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT *
				FROM ".$tables['Recipes']." AS R, "
                      .$tables['Recipes_ln_Ingredients']." AS ln, "
                      .$tables['Ingredients']." AS i
				WHERE R.id=ln.id_recipe AND ln.id_ingredient=i.id AND i.name IN ('".$ing_list."')";
    }

    function recipe_by_id($id) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT title, preparation
                FROM ".$tables['Recipes']." AS R
                WHERE R.id=".mysqli_real_escape_string($db, $id); 
    }
    
    function ingredients_by_recipe_id($id) {   
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT * 
                FROM ".$tables['Ingredients']." as i, "
                      .$tables['Recipes']." as R, "
                      .$tables['Recipes_ln_Ingredients']." as ln
                WHERE i.id=ln.id_ingredient
                      AND ln.id_recipe=R.id
                      AND R.id=".mysqli_real_escape_string($db, $id);
    }

    function add_to_bookmarks($user_id, $bookmark_id) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "INSERT INTO ".$tables['Users_ln_Carts'].
               " VALUES (".mysqli_real_escape_string($db, $user_id).
               ", ".mysqli_real_escape_string($db, $bookmark_id).")";
    }
?>
