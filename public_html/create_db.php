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

    printf("Success...%s<br />", mysqli_get_host_info($db));
    
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

    // read data from file
    $file = "./data/Recettes.xml";
    $fp = fopen($file, "r");
    if (!$fp)
        die("impossible d'ouvrir le fichier xml");
    
    function clean_line($str) {
        // TODO: don't delete the '
        // TODO: error handling
        return utf8_encode(preg_replace('[\']', null, $str));
    }

    $index = 0;
    while (($line = fgets($fp)) && ($index = $index + 1)) { // $i++ ?!
        $line = clean_line($line);
        $data_array[$index] = simplexml_load_string($line);
    }
    fclose($fp);
    
    // submit to DB
    // TODO: add data (ingredients etc)
    $sql = "";
    foreach($data_array as $recipe) {
        $sql .= "INSERT INTO $table VALUES ('NULL', '$recipe->TI');";
    }
    if (!mysqli_multi_query($db, $sql))
        printf("Error: %s\n",mysqli_error($db));
    printf("Database succesfully filled\n");

    mysqli_close($db);
?>

</body>
</html>
