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

    printf("Success...%s\n<br />\n", mysqli_get_host_info($db));
    
    // set autocommit
    mysqli_autocommit($db, TRUE);

    // create DB (cooking)
    $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("DB sucessfully created.\n<br />\n");
    
    // set default DB name
    mysqli_select_db($db, $db_name);

    // create TABLE (recipes)
    $sql = "CREATE TABLE IF NOT EXISTS ".$table." (
         id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
         title VARCHAR(100),
         ingredients TEXT,
         preparation TEXT
    )";
    if (!mysqli_query($db, $sql))
        printf("Error: %s\n", mysqli_error($db));
    printf("TABLE succesfully created.\n<br />\n");

    // read data from file
    $file = "./data/Recettes.xml";
    $fp = fopen($file, "r");
    if (!$fp)
        die("impossible d'ouvrir le fichier xml");
    
    function clean_line($str) {
        // TODO: don't delete the '
        // TODO: error handling
        return utf8_encode(preg_replace('[\']', null, $str));
        // global $db;
        // return utf8_encode(mysqli_real_escape_string($db, $str));
    }

    $index = 0;
    while (($line = fgets($fp)) && ($index = $index + 1)) { // $i++ ?!
        $line = clean_line($line);
        $data_array[$index] = simplexml_load_string($line);
    }
    fclose($fp);
    /*echo "<pre>";
    print_r($data_array); 
    echo "</pre>";
    unset ($index);*/


    // submit to DB
    // TODO: add data (ingredients etc)
    $sql = "";
    $ing = "";
    foreach($data_array as $index => $recipe) {
        // TODO: Error handling (multiple executions)
        foreach($recipe->IN as $ingredient)
            $ing .= $ingredient->ING."--";
        //echo $ing."<br/>";
        $sql = "INSERT INTO $table VALUES ('$index', '$recipe->TI', '$recipe->PR', '$ing')";

        if (!mysqli_query($db, $sql))
            printf("Error: %s\n<br />\n", mysqli_error($db));

        $ing = "";
    }
/*    if (!mysqli_multi_query($db, $sql))
        printf("Error: %s\n<br />\n",mysqli_error($db));
    printf("Database succesfully filled\n");*/

    // test if already present
    // $sql = "SELECT * FROM ".$table." WHERE id = 1";
    
    // search
    // $sql = "SELECT `preparation` FROM ".$table." WHERE ingredients like '%orange%'";


    mysqli_close($db);
?>

</body>
</html>
