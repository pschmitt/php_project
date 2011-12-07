<div class="fil-ariane">
	<?php
		/**
		 * Gestion du fil d'Ariane
		 * Author: Mathieu Morainville
		 */
		
		$father_array = array();
		
		function find_father($ingredient_type, $array) {
			global $father_array;
			if (isset($ingredient_type['P'])) {
				//foreach($ingredient_type['P'] as $fathers => $father) {
					$fathers_key = array_keys($ingredient_type['P']); // Récupère les clés des pères
					$father_array[$ingredient_type['P'][$fathers_key[0]]] = $array[$ingredient_type['P'][$fathers_key[0]]]['T'];
					find_father($array[$ingredient_type['P'][$fathers_key[0]]], $array);
					
					// Tout ceci pour s'assurer qu'on ne récupère bien qu'un père. En effet, étrangement certains ingrédients (Turnip par exemple)
					// semble avoir plusieurs pères, ce qui n'est pourtant pas le cas et cela a pour conséquence d'afficher un mauvais fil d'Ariane.
					
					//$father_array[$father] = $array[$father]['T'];
					//find_father($array[$father], $array);
				//}
			}
		}
		
		if (isset($_GET['p']) && $_GET['p'] != 'home') {
			echo '<a href="'.$_SERVER['PHP_SELF'].'?p=home">Home</a> > <span>'.ucwords($_GET['p'])."</span>\n";
		} else if (isset($_GET['cat'])) {
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
	
    <!-- <a href="#">Viandes</a> &gt; <a href="#">Dinde</a> -->
</div>
