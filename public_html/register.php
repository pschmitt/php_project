<h2>S'enregistrer</h2>
<form id="registration" method="post" action="<?php echo $_SERVER['PHP_SELF']."?p=registered" ?>">
    <p>
        <label for="name">Nom: </label>
        <input type="text" name="name" id="name" placeholder="Votre nom" />
    </p>
    <p>
        <label for="first_name">Prénom: </label>
        <input type="text" name="first_name" id="first_name" placeholder="Votre prénom" />
    </p>
    <p>
        <label for="username">Pseudo *: </label>
        <input type="text" name="username" id="username" title="Pseudo" placeholder="Votre pseudo" required />
        <span id="availability_status"></span>
    </p>
    <p>
        <label for="password">Mot de passe *: </label>
        <input type="password" name="password" title="mot de passe" id="password" placeholder="••••" required />
    </p>
    <p>
        <label for="gender">Vous êtes: </label>
        <select name="gender" id="gender">
            <option value="default" selected="selected"></option>
            <option value="female">Une femme</option>
            <option value="male">Un homme</option>
        </select>
    </p>
    <p>
        <label for="birth_year">Date de naissance: </label>
        <select name="birth_year" id="birth_year">
            <option value="default" selected="selected"></option>
            <?php
                for ($year = 1901; $year < 2012; $year++) {
                    echo "<option value=".$year.">\n\t".$year."\n</option>\n";
                }
            ?>
        </select>
    </p>
    <!--p ? -->
    <fieldset>
        <legend>Adresse</legend>
        <label for="street_address">Rue: </label>
        <input type="text" name="street_address" id="street_address" />
        <br />
        <label for="zip_code">Code postal: </label>
        <input type="text" name="zip_code" id="zip_code" />
        <br />
        <label for="city">Ville: </label>
        <input type="text" name="city" id="city" />
    </fieldset>
    <!--/p ? -->
    <p>
        <label for="tel_num">Numéro de téléphone: </label>
        <input type="tel" name="tel_num" id="tel_num" placeholder="01 02 03 04 05" />
    </p>
    <p>
        <label for="email">Adresse email: </label>
        <input type="text" name="email" id="email" placeholder="xxx@yyy.com" /> <!-- type="email" -->
    </p>
	<p>
		<h6>les données précedées de * sont obligatoires</h6>
	</p>
    <p>
        <input type="submit" value="Envoyer" class="submit" />
    </p>
</form>
<div id="rep"></div>
<!-- http://www.matiasmancini.com.ar/jquery-plugin-ajax-form-validation-html5.html  -->
<script src="js/jquery.html5form-1.4-min.js"></script>
<script>
     $(document).ready(function(){
        $('#registration').html5form({
            allBrowsers : true,
            async : false,
            colorOn: '#000',
            colorOff: '#888',
            //emptyMessage : 'Ce champ est obligatoire',
            messages : 'fr',
            responseDiv : '#rep'
        });
        var default_color = $("#username").css('background-color');
        $("#username").keyup(function() { //if theres a change in the username textbox
            $("#username").css('background-color', default_color);
            var username = $("#username").val();//Get the value in the username textbox
            if (username.length > 3) { //if the lenght greater than 3 characters
                $("#availability_status").html('Checking availability...');
                //Add a loading image in the span id="availability_status"

                $.ajax({  //Make the Ajax Request
                    type: "POST",
                    url: "includes/functions/check_username_availability.php",  //file name
                    data: "username="+ username,  //data
                    success: function(server_response) {
                        $("#availability_status").ajaxComplete(function(event, request){
                            if (server_response == '0') { 
                                $("#availability_status").html('Available');
                                $("#username").css('background-color', '#90EE90');
                            } else if (server_response == '1') { //if it returns "1"
                                $("#availability_status").html('Not Available');
                                $("#username").css('background-color', '#FF4500');
                            }
                        });
                    }
                });
            } else {
                $("#availability_status").html('Username too short');
            }
            return false;
        });
     });
</script>

