<?php
	include("./data/Thesaurus.php");
	
	foreach($Thesaurus as $IdConcept => $concept) {
		if (isset($concept['S'])) {
			foreach($concept['S'] as $IdConceptFils) {
				$Thesaurus[$IdConceptFils]['P'][$IdConcept] = $IdConcept;
			}
		}
	}
	
	// echo "<pre>";
	// print_r($Thesaurus);
	// echo "</pre>";
?>