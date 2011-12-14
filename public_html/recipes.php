<?php
if (isset($_GET['recipe_id'])) {
	// Si un id de recette est défini, on affiche le titre, les ingrédients et la préparation
	// correspondant à l'id de cette recette.
	
	// TODO
} else if (isset($_GET['cat'])) {
	// Sinon, si une catégorie est définie, cela signifie qu'on a cliqué dans le menu et on affiche
	// donc le titre de toutes les recettes contenant au moins un des ingrédients.
	
	require_once("includes/functions/mysqli.inc.php");
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
			}
		}
		
		make_ing_list($Thesaurus[$_GET['cat']], $Thesaurus);
		$ing_list = implode("', '", $ing_list);
		//$ing_list = substr($ing_list, 0, -2); // On enlève la virgule et l'espace après le dernier ingrédient
		//echo $ing_list;
		
		$sql = "SELECT DISTINCT *
				FROM Recipes AS R, Recipes_ln_Ingredients AS ln, Ingredients AS i
				WHERE R.id=ln.id_recipe AND ln.id_ingredient=i.id AND i.name IN ('".$ing_list."')";
		
		echo $sql;
		
		$result = mysqli_query ($db, $sql) or die (mysqli_error($db));
		
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<br /><br /><strong>Titre de la recette</strong><br />\n";
			//print_r($row)
			echo $row['title'];;
		}
	}
}
?>