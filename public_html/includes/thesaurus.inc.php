<?php
	/**
	 * Code à inclure dans header.inc.php
	 * Permet de transformer le thésaurus fourni en menu.
	 */
	include("./data/Thesaurus.php"); // Problème connu : pour tester simplement la page avec thesaurus.inc.php le chemin doit être : ../data/Thesaurus.php
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
	function find_son($ingredient_type, $array) {
		if (isset($ingredient_type['S'])) {
			echo "<ul>\n";
			foreach($ingredient_type['S'] as $sons => $son) {
				echo "<li><a href=".$_SERVER['PHP_SELF'].">".$array[$son]['T']."</a>";
				find_son($array[$son], $array);
			}
			echo "</ul>\n";
		}
	}
	
	find_son($Thesaurus[1], $Thesaurus);
?>