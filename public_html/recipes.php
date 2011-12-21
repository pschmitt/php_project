<?php
    require_once("includes/functions/mysqli.inc.php");
    require_once("includes/functions/queries.inc.php");

    $db = db_con();
    if (isset($_GET['recipe_id'])) {
        /*  
         *  Si un id de recette est défini, on affiche le titre, les ingrédients et la préparation
         *  correspondant à l'id de cette recette.
         */

        $sql = recipe_by_id($_GET['recipe_id']);
        $res = query($db, $sql);
        $recipe = mysqli_fetch_assoc($res);
        mysqli_free_result($res);
        $sql = ingredients_by_recipe_id($_GET['recipe_id']);
        $res = query($db, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $recipe['ing'][] = $row;
        }
        mysqli_free_result($res);
        printf("<h2>%s</h2>\n<h3>Ingredients</h3>\n<ul>\n", $recipe['title']);
        printf('<span id="bookmark" href="">>>>add to bookmarks<<<<</span>');
        foreach ($recipe['ing'] as $ing)
            printf("\t<li>%s %s - %s %s%s</li>\n", $ing['qualifiant'], $ing['name'], $ing['quantity'], $ing['unit'], $ing['parenthese'] );
        printf("</ul>\n<h3>Preparation</h3>\n%s\n", $recipe['preparation']);
    } else if (isset($_GET['cat'])) {
        // Sinon, si une catégorie est définie, cela signifie qu'on a cliqué dans le menu et on affiche
        // donc le titre de toutes les recettes contenant au moins un des ingrédients.
        
        $ing_list = array();
        if (isset($Thesaurus[$_GET['cat']])) {
            /* 
             *  Construction de la requête SQL
             *  Liste d'ingrédients
             */
            function make_ing_list($ingredient_type, $array) {
                global $db;
                global $ing_list;
                
                if (isset($ingredient_type['S'])) {
                    foreach($ingredient_type['E'] as $synonyms => $synonym) {
                        $str = mysqli_real_escape_string($db, $synonym);
                        if (!in_array($str, $ing_list))
                            $ing_list[] = $str;
                    }
                    foreach($ingredient_type['S'] as $sons => $son) {
                        foreach($array[$son]['E'] as $synonyms => $synonym) {
                            $str = mysqli_real_escape_string($db, $synonym);
                            if (!in_array($str, $ing_list))
                                $ing_list[] = $str;
                        }
                        //echo $array[$son]['T'].", ";
                        make_ing_list($array[$son], $array);
                    }
                } else {
                    foreach($ingredient_type['E'] as $synonyms => $synonym) {
                        $str = mysqli_real_escape_string($db, $synonym);
                        if (!in_array($str, $ing_list))
                            $ing_list[] = $str;
                    }
                }
            }
            
            make_ing_list($Thesaurus[$_GET['cat']], $Thesaurus);
            $ing_list = implode("', '", $ing_list);
            
            $sql = recipes_by_ing_list($ing_list);	
            
            $result = query($db, $sql);
            
            echo "<h2>Recipes with: ".strtolower($Thesaurus[$_GET['cat']]['T'])."</h2>";
            
            echo "<dl>\n";
            while ($row = mysqli_fetch_assoc($result)) {
                //print_r($row);
                echo '<dt><a href="index.php?p=recipes&recipe_id='.$row['id_recipe'].'">'.$row['title'].'</a></dt>'."\n";
                echo "<dd><strong>Matching ingredients</strong>: ".$row['name']."</dd><br />\n\n";
            }
            echo "</dl>\n";
        }
    }
    mysqli_close($db);

?>
<span id="result"></span>
<script>
    $("#bookmark").click(function() {
        $.ajax({
            type: "GET",
            url: "includes/functions/bookmark.php",
            data: { recipe_id: <?php echo $_GET['recipe_id']?>, user_id: <?php echo $_SESSION['user_id']?> },
            success: function(server_response) {
                $("#result").ajaxComplete(function(event, request) {
                    if (server_response == '0') {
                        $("#result").html = "added !";
                    } else {
                        $("#result").html = "ohohoh..";
                    }
                });
            }
        });
    });
</script>
