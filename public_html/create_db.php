<html>
<head>
	<title>JeNeSaisPasCuisiner.com</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	
<body>

<?php
    $passwd_file = realpath('../.login/DB_credentials.php');
    require "$passwd_file";
    
    // create database
    $db = mysqli_connect($db_host, $db_user, $db_password);
    if (!$db)
        mysqli_connect_error();

    printf("Success...%s\n", mysqli_get_host_info($db));
    
    // set autocommit
    mysqli_autocommit($db, TRUE);

    // create DB (cooking)
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("DB sucessfully created.<br />");
    
    // set default DB name
    mysqli_select_db($db, $db_name);

    // create TABLE (recipes)
    $sql = "CREATE TABLE IF NOT EXISTS ".$table." (
         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
         data VARCHAR(100)
    )";
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("TABLE succesfully created.<br />");

    $file = "./data/Recettes.xml";

    $fp = fopen($file, "r");
    if (!$fp) die("impossible d'ouvrir le fichier xml");

    $i = 0;
    while($line = fgets($fp)) {
        //echo htmlentities($line)."<br />";
        //xml_parse($xml_parser, $line, feof($fp)) or die("xml error !");
        //if (xml_parse_into_struct($xml_parser, $line, $vals, $index) != 0)
        //    echo "ok";
        $line = utf8_encode($line);
        $line = preg_replace('[\']', null, $line);
        $sxml = simplexml_load_string($line);
        $ar[$i] = $sxml;

        $i++;
    }

    echo "<hr/>";

    $l = "\"pd\"'";
    echo "--".$l."--<br/>";
    $l = preg_replace('[\']', null, $l);
    echo "--".$l."--";
    //print_r($ar);    
    echo "<hr/>";
    echo $ar[1486]->TI;
    
    $sql = "";
    foreach($ar as $xxml) {
        $sql .= "INSERT INTO $table VALUES ('NULL', '$xxml->TI');";
    }
    if (!mysqli_multi_query($db, $sql))
        echo "error".mysqli_error($db);
    
    fclose($fp);
    mysqli_close($db);
?>

</body>
</html>
