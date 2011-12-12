<?php
if (isset($_GET['recipe_id'])) {
	// Si un id de recette est d�fini, on affiche le titre, les ingr�dients et la pr�paration
	// correspondant � l'id de cette recette.
	
	// TODO
} else if (isset($_GET['cat'])) {
	// Sinon, si une cat�gorie est d�finie, cela signifie qu'on a cliqu� dans le menu et on affiche
	// donc le titre de toutes les recettes contenant au moins un des ingr�dients.
	
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