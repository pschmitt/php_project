<?php
	// Fonction qui met les majuscules aux bons endroits dans une phrase.
	// Source: http://www.brightcherry.co.uk/scribbles/2010/07/31/php-capitalize-first-letter-of-every-sentence/
	function capitalize_sentence($str) {
		//first we make everything lowercase, and then make the first letter if the entire string capitalized
		$string = ucfirst(strtolower($str));
		 
		//now we run the function to capitalize every letter AFTER a full-stop (period).
		$string = preg_replace_callback('/[.!?].*?\w/', create_function('$matches', 'return strtoupper($matches[0]);'), $string);
		 
		//return the result
		return $string;
	}
 ?>