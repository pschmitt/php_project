<?php
	include("./Thesaurus.php");
	
	foreach($Thesaurus as $IdConcept => $concept) {
		if (isset($concept['S'])) {
			foreach($concept['S'] as $IdConceptFils) {
				$Thesaurus[$IdConceptFils]['P'][$IdConcept] = $IdConcept;
			}
		}
	}
	
	 echo "<pre>";
	 // var_dump($Thesaurus);
	 echo "</pre>";
     
     $fp = fopen('/tmp/th.php', 'w');
     fwrite($fp, print_r($Thesaurus));
     fclose($fp);
?>
