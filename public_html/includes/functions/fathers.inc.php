<?php
    $thesaurus_file=realpath("./data/Thesaurus.php");
    include($thesaurus_file);
    unset($thesaurus_file);

    foreach($Thesaurus as $IdConcept => $concept) {
        if (isset($concept['S'])) {
            foreach($concept['S'] as $IdConceptFils) {
                $Thesaurus[$IdConceptFils]['P'][$IdConcept] = $IdConcept;
            }
        }
    }
    
    // no realpath here: file_* expects a string param
    $file = "./data/Thesaurus_updated.php"; 

    file_exists($file) && unlink($file);

    $fp = fopen($file, 'a');
    $str = "<?php\n \$Thesaurus=";
    fwrite($fp, $str);
    fwrite($fp, var_export($Thesaurus, true));
    unset($Thesaurus);
    $str = "\n?>\n";
    fwrite($fp, $str);
    fclose($fp);
?>
