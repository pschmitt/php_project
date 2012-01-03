<h2>Recherche avancée</h2>

<form id="search_form" method="post">
    <p>
        <label for="recipe_title">Recherche par titre de recette: </label>
        <input type="text" name="recipe_title" value="<?php echo isset($_POST['recipe_title']) ? $_POST['recipe_title'] : null ?>"/>
    </p>
    <p>
        <label for="ingredient">... par ingrédient: </label>
        <input type="text" name="ingredient" value="<?php echo isset($_POST['ingredient']) ? $_POST['ingredient'] : null ?>"/>
    </p>
    <input type="submit" value="Rechercher" />
</form>

<?php
    require_once("includes/functions/mysqli.inc.php");
    require_once("includes/functions/queries.inc.php");
    $db = db_con();
    
    if ((isset($_POST['recipe_title'])) && (isset($_POST['ingredient'])) && !(empty($_POST['recipe_title']))
        || !(empty($_POST['ingredient']))) {
        echo '<h3 id="result_title">Résultats</h3>';
    } else {
		echo '<h3 id="result_title">Aucun résultats</h3>';
		echo '<p>Vous n\'avez pas formulé de requête !</p>';
	}
	
    if ((isset($_POST['recipe_title'], $_POST['ingredient']))
        && !(empty($_POST['recipe_title']))
        && !(empty($_POST['ingredient']))) {
		
		$sql = recipe_by_title_and_ing($_POST['recipe_title'], $_POST['ingredient']);
        $res = query($db, $sql);
		
		//echo $sql;
		
        echo "Voici les recettes comprenant '".$_POST['recipe_title']."' dans le titre et '".$_POST['ingredient']."' dans les ingrédients.<br />\n";
    } else if ((isset($_POST['recipe_title']))
        && !(empty($_POST['recipe_title']))) {
		
        $sql = recipe_by_title($_POST['recipe_title']);
        $res = query($db, $sql);
    } else if ((isset($_POST['ingredient']))
        && !(empty($_POST['ingredient']))) {
		
        $sql = recipe_by_ing($_POST['ingredient']);
        $res = query($db, $sql);
		
		//echo $sql;
    }
    if (isset($sql, $res)) {
		if (mysqli_fetch_assoc($res) != 0) {
			echo "<dl>\n";
			while ($row = mysqli_fetch_assoc($res)) {
				echo '<dt><a href="index.php?p=recipes&recipe_id='.$row['id'].'">'.$row['title'].'</a></dt>'."\n";
				//printf("%s<br/>\n", $row["title"]);
			}
			echo "</dl>\n";
			mysqli_free_result($res);
		} else {
			echo "<p>Pas de résultats !</p>";
		}
    }
    if (isset($db))
        mysqli_close($db);
?>
