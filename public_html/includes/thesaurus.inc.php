<?php
	/**
	 * Code à inclure dans navigation.inc.php
	 * Permet de transformer le thésaurus fourni en menu.
	 * 
	 * Author: Mathieu Morainville
	 */
	//include("./data/Thesaurus.php"); // Problème connu : pour tester simplement la page avec thesaurus.inc.php le chemin doit être : ../data/Thesaurus.php
	/*
	echo "<pre>\n";
		print_r($Thesaurus);
	echo "</pre>\n";
	*/
	
	/**
	 * Fonction qui retourne les fils d'un type d'ingrédient de manière récursif.
	 * On trouve tout d'abord les fils d'un type d'ingrédient, puis les fils des fils, etc.
	 * On se rend bien compte de la nécessité de recourir à un algorithme récursif.
	 */
	/*
	function find_son($ingredient_type, $array) {
		if (isset($ingredient_type['S'])) {
			echo "\n<ul>\n";
			foreach($ingredient_type['S'] as $sons => $son) {
				echo "<li><a href=".$_SERVER['PHP_SELF'].">".$array[$son]['T']."</a>";
				find_son($array[$son], $array);
				echo "</li>\n";
			}
			echo "</ul>\n";
		}
	}
	
	find_son($Thesaurus[1], $Thesaurus);
	*/
	
	function find_son($ingredient_type, $array) {
		if (isset($ingredient_type['S'])) {
			echo "\n<ul>\n";
			foreach($ingredient_type['S'] as $sons => $son) {
				echo "\t<li><a href=".$_SERVER['PHP_SELF']."?p=recipes&cat=".$son.">".$array[$son]['T']."</a>";
				//find_son($array[$son], $array);
				echo "</li>\n";
			}
			echo "</ul>\n";
		}
	}
	
	if ( isset($_GET["cat"]) ) { // cat for categories
		if (isset($Thesaurus[$_GET["cat"]]['S'])) {
			//$father[] = $Thesaurus[$_GET["cat"]]['T'];
			find_son($Thesaurus[$_GET["cat"]], $Thesaurus);
		}
		else {
			echo "Cette catégorie n'a pas de sous-rubriques.";
		}
	}
	else
		find_son($Thesaurus[1], $Thesaurus);
?>