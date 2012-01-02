<?php

    /**
      * retourne la requête SQL qui permet d'obtenir les récettes contenant un ingrédient donné
      * utilé par: recherche avancée
      */
    function recipe_by_ing ($ingredient) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT id, title
                FROM ".$tables["Recipes"]." AS R, "
                      .$tables["Recipes_ln_Ingredients"]." AS ln, "
                      .$tables["Ingredients"]." AS i
                WHERE R.id=ln.id_recipe
                AND ln.id_ingredient=i.id
                AND i.name LIKE '%".mysqli_real_escape_string($db, $ingredient)."%'";
    }
    
    /**
      * retourne la requête SQL qui permet d'obtenir la/les récette(s) qui ont un certain titre
      * utilisé par: recherche avancée
      */
    function recipe_by_title($title) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT id, title
                FROM ".$tables["Recipes"].
                " WHERE title LIKE '%".mysqli_real_escape_string($db, $title)."%'";
    }
    
    /**
      *  retourne la requête SQL qui permet d'obtenir les récettes contenant LES ingrédients donnés
      *  utilisé par: recipes.php (affichage des recettes)
      */
    function recipes_by_ing_list ($ing_list) {
         if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT DISTINCT R.id, R.title, R.preparation
				FROM ".$tables['Recipes']." AS R, "
                      .$tables['Recipes_ln_Ingredients']." AS ln, "
                      .$tables['Ingredients']." AS i
				WHERE R.id=ln.id_recipe AND ln.id_ingredient=i.id AND i.name IN ('".$ing_list."')";
    }

    /**
      * retourne la requête SQL qui permet d'obtenir le titre et la marche à suivre d'une recette 
      * utilisé par: results.php (affichage d'une recette)
      */
    function recipe_by_id($id) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT title, preparation
                FROM ".$tables['Recipes']." AS R
                WHERE R.id=".mysqli_real_escape_string($db, $id); 
    }
    
    /**
      * retourne la requête SQL qui permet d'obtenir les ingrédients contenus dans une recette
      * utilisé par: recipes.php (affichage d'une recette)
      */
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

    /**
      * retourne la requête SQL qui permet d'ajouter une recette aux favoris
      * utilisé par: recipes.php (affichage d'une recette)
      */
    function add_to_bookmarks($user_id, $recipe_id) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "INSERT INTO ".$tables['Carts_ln_Recipes'].
               " VALUES (".mysqli_real_escape_string($db, $user_id).
               ", ".mysqli_real_escape_string($db, $recipe_id).")";
    }

    /**
      * retourne la requête SQL qui permet d'ajouter une recette aux favoris
      * utilisé par: login.php
      */
    function get_uid($username, $password) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "SELECT id FROM ".$tables['Users']." WHERE username='".mysqli_real_escape_string($db, $username)."' AND password='".mysqli_real_escape_string($db, sha1($password))."'";
    }

    function get_favorites($user_id) {
         if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];
        
        return "SELECT id, title
                FROM ".$tables['Recipes']." as R, "
                .$tables['Carts']." as C 
                WHERE R.id=C.id_recipe AND C.id_user='".mysqli_real_escape_string($db, $user_id)."'";
    }
?>
