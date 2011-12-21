<?php
	$hostname	= strtolower(php_uname('n'));
	$server		= $_SERVER['SERVER_NAME'];

	if (($server === "localhost") || ($server === "127.0.0.1") || ($server === $hostname)){
		$db_host = "localhost";
		$db_name = "cooking";
		$db_user = "root";
		$db_password = "";	
	} else {
		$db_host = "XXXX";
		$db_name = "XXXX";
		$db_user = "XXXX";
		$db_password = "XXXX";
	}
    
    if ($hostname === "laxlinux-cl") {
        $db_name = "JeNeSaisPasCuisiner";
		$db_user = "silly";
		$db_password = "none";
    }

	unset($server, $hostname);
	

	$tables = array("Carts" => "Carts",
                    "Carts_ln_Recipes" => "Carts_ln_Recipes",
                    "Ingredients" => "Ingredients",
                    "Recipes" => "Recipes",
                    "Recipes_ln_Ingredients" => "Recipes_ln_Ingredients",
                    "Users" => "Users",
                    "Users_ln_Carts" => "Users_ln_Carts");
    
	// credentials array, useful for passing to functions
    $credentials = array("db_host" => $db_host, "db_name" => $db_name, "db_user" => $db_user, "db_password" => $db_password, "tables" => $tables);
?>
