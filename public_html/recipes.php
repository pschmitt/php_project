<?php
if (isset($_GET['recipe_id'])) {
	// Si un id de recette est défini, on affiche le titre, les ingrédients et la préparation
	// correspondant à l'id de cette recette.
	
	// TODO
} else if (isset($_GET['cat'])) {
	// Sinon, si une catégorie est définie, cela signifie qu'on a cliqué dans le menu et on affiche
	// donc le titre de toutes les recettes contenant au moins un des ingrédients.
	
	if (isset($Thesaurus[$_GET['cat']])) {
		//print_r($father);
		echo '<a href="'.$_SERVER['PHP_SELF'].'?p=home">Home</a> > ';
		
		find_father($Thesaurus[$_GET['cat']], $Thesaurus);
		$father_array = array_reverse($father_array);
		foreach($father_array as $IdFather => $father) {
			if ( $IdFather != 0 && $IdFather != 1 ) {
				echo "<a href=".$_SERVER['PHP_SELF']."?cat=".$IdFather.">".ucwords($father)."</a> > ";
			}
		}
		
		echo ucwords($Thesaurus[$_GET['cat']]['T']);
	}
}
?>