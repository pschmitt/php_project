<?php
    isset($_POST['recipe_id'], $_POST['user_id']) or die ("Incomplete POST data received");
    $passwd_file = realpath('../../../.login/DB_credentials.php');
    require_once($passwd_file);

    $db = mysqli_connect($db_host, $db_user, $db_password, $db_name)
        or die("Error: ".mysqli_error());

    function add_to_bookmarks($user_id, $bookmark_id) {
        if (!isset($GLOBALS['db'], $GLOBALS['tables']))
            die("No DB connection !");
        $db = $GLOBALS['db'];
        $tables = $GLOBALS['tables'];

        return "INSERT INTO ".$tables['Carts'].
               " VALUES (".mysqli_real_escape_string($db, $user_id).
               ", ".mysqli_real_escape_string($db, $bookmark_id).")";
    }

    $sql = add_to_bookmarks($_POST['user_id'], $_POST['recipe_id']);
    mysqli_query($db, $sql);
    mysqli_close($db);
    
    echo '0';

?>
