<h2>Enregistrement</h2>

<?php
    function create_db() {
        
    }

    function submit() {
        
    }
    
    if (isset($_POST['username'], $_POST['password'])) {
        printf("Bienvenur sur JeNeSaisPasCuisiner.com, ".$_POST['username'].".\n<br/>\n
                You can now save your favorite recipes.
               ");
     } else {
        printf("<p>\n\tWoops, quelque chose n'a pas fonctionné\n<br />\n<br />\n");
        printf("\t<a href=\"".$_SERVER['PHP_SELF']."?p=home\">Retourner à l'accueil</a>\n<br />\n");
        printf("\t<a href=\"".$_SERVER['PHP_SELF']."?p=register\">S'enregister à nouveau</a>\n</p>");
     }
?>
