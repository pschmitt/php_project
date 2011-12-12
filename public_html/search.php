<h2>Recherche avancée</h2>

<form id="search_form" method="post">
    <p>
        <label for="recipe_title">Recherche par titre de recette: </label>
        <input type="text" name="recipe_title" value="<?php echo isset($_POST['recipe_title']) ? $_POST['recipe_title'] : null ?>"/>
    </p>
    <p>
        <label for="ingredient">... par ingredient: </label>
        <input type="text" name="ingredient" value="<?php echo isset($_POST['recipe_title']) ? $_POST['ingredient'] : null ?>"/>
    </p>
    <input type="submit" value="Rechercher" />
</form>

<?php
    require_once("includes/functions/mysqli.inc.php");
    require_once("includes/functions/queries.inc.php");
    
    if ((isset($_POST['recipe_title'])) && (isset($_POST['ingredient'])) && !(empty($_POST['recipe_title']))
        || !(empty($_POST['ingredient']))) {
        echo '<h3 id="result_title">Résultats</h3>';
        $db = db_con();
    }

    if ((isset($_POST['recipe_title'], $_POST['ingredient']))
        && !(empty($_POST['recipe_title']))
        && !(empty($_POST['ingredient']))) {
        echo "Both are set";
        echo $_POST['recipe_title']."\n";
        echo $_POST['ingredient'];
    } else if ((isset($_POST['recipe_title']))
        && !(empty($_POST['recipe_title']))) {
        $sql = recipe_by_title($_POST['recipe_title']);
        $res = query($db, $sql);
    } else if ((isset($_POST['ingredient']))
        && !(empty($_POST['ingredient']))) {
        $sql = recipe_by_ing($_POST['ingredient']);
        $res = query($db, $sql);
    }
    if (isset($sql, $res)) {
        while ($row = mysqli_fetch_assoc($res)) {
            printf("%s<br/>\n", $row["title"]);
        }
        mysqli_free_result($res);
    }
    if (isset($db))
        mysqli_close($db);
?>
