<?php
   
    isset($_POST['recipe_id']) or die ("Incomplete POST data received");

    session_start();
    if ((isset($_POST['user_id'])) && ($_POST['user_id'] != -1)) {
        $passwd_file = realpath('../../../.login/DB_credentials.php');
        require_once($passwd_file);

        $db = mysqli_connect($db_host, $db_user, $db_password, $db_name)
            or die("Error: ".mysqli_error());

        function remove_bookmark($user_id, $bookmark_id) {
            if (!isset($GLOBALS['db'], $GLOBALS['tables']))
                die("No DB connection !");
            $db = $GLOBALS['db'];
            $tables = $GLOBALS['tables'];

            return "DELETE FROM ".$tables['Carts'].
                " WHERE id_user='".mysqli_real_escape_string($db, $user_id)."'
                        AND id_recipe='".mysqli_real_escape_string($db, $bookmark_id)."'";
        }

        $sql = remove_bookmark($_POST['user_id'], $_POST['recipe_id']);
        //echo $sql;
        mysqli_query($db, $sql);
        mysqli_close($db);
    } else {
        if (isset($_SESSION['favs'])) {
            foreach($_SESSION['favs'] as $index => $fav) {
                if ($fav == $_POST['recipe_id'])
                    unset($_SESSION['favs'][$index]);
            }
        }
    }
    echo '0';
?>
