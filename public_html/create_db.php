<html>
<head>
	<title>JeNeSaisPasCuisiner.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	
<body>

<?php
    function handle_data($xml_parser, $line) {
        echo $line."<br />";
    }

    $file = "./data/Recettes.txt";

    $fp = fopen($file, "r");
    if (!$fp) die("Impossible d'ouvrir le fichier XML");

    // Create parser
    $xml_parser = xml_parser_create();
    
    // Set callback function
    xml_set_character_data_handler($xml_parser, "handle_data");
    
    while($line = fgets($fp)) {
        echo htmlEntities($line)."<br />";
        //xml_parse($xml_parser, $line, feof($fp)) or die("XML error !");
    }

    xml_parser_free($xml_parser);
    fclose($fp);
?>

</body>
</html>
