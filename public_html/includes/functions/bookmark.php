<?php
    isset($_GET['recipe_id'], $_GET['user_id']) or die ("Incomplete POST data received");
    //require_once("includes/functions/mysqli.inc.php");
    //require_once("includes/functions/queries.inc.php");

    /*$db = db_con();
    
    $sql = add_to_bookmarks($_GET['user_id'], $_GET['recipe_id']);
    query($db, $sql);*/

    $passwd_file = realpath('../../../.login/DB_credentials.php');
    require_once($passwd_file);

    $db = mysqli_connect($db_host, $db_user, $db_password, $db_name)
        or die("Error: ".mysqli_error());

    function add_to_bookmarks($user_id, $bookmark_id) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "INSERT INTO ".$tables['Users_ln_Carts'].
               " VALUES (".mysqli_real_escape_string($db, $user_id).
               ", ".mysqli_real_escape_string($db, $bookmark_id).")";
    }

    $sql = add_to_bookmarks($_GET['user_id'], $_GET['recipe_id']);
    mysqli_query($db, $sql);
    
    echo '0';

    mysqli_close($db);
?>
