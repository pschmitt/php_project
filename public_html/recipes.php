<?php
require_once("includes/functions/mysqli.inc.php");
require_once("includes/functions/queries.inc.php");
if (isset($_GET['recipe_id'])) {
	// Si un id de recette est défini, on affiche le titre, les ingrédients et la préparation
	// correspondant à l'id de cette recette.
	
    $db = db_con();
    $sql = recipe_by_id($_GET['recipe_id']);
    $res = query($db, $sql);
    $recipe = mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    $sql = ingredients_by_recipe_id($_GET['recipe_id']);
    $res = query($db, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $recipe['ing'][] = $row['name'];
    }
    mysqli_free_result($res);
    printf("<h2>%s</h2>\n<h3>Ingredients</h3>\n<ul>\n", $recipe['title']);
    foreach ($recipe['ing'] as $ing)
        printf("\t<li>%s</li>\n", $ing);
    printf("</ul>\n<h3>Preparation</h3>\n%s\n", $recipe['preparation']);
    mysqli_close($db);

} else if (isset($_GET['cat'])) {
	// Sinon, si une catégorie est définie, cela signifie qu'on a cliqué dans le menu et on affiche
	// donc le titre de toutes les recettes contenant au moins un des ingrédients.
	
	$db = db_con();
	$ing_list = array();
	if (isset($Thesaurus[$_GET['cat']])) {
		// Construction de la requête SQL
		// Liste d'ingrédients
		
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
?>
