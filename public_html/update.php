<h2>Update</h2>
<form name ="registration" id="registration" method="post" action="<?php echo $_SERVER['PHP_SELF']."?p=updated" ?>" onSubmit="return verif()">  
	<p>
        <label for="name">Nom: </label>
        <input type="text" name="name" id="name" placeholder="Votre nom" />
    </p>
    <p>
        <label for="first_name">Pr&eacute;nom: </label>
        <input type="text" name="first_name" id="first_name" placeholder="Votre pr&eacute;nom" />
    </p>
    <p>
        <label for="username">Pseudo: </label>
        <input type="text" name="username" id="username" title="Pseudo" value="<?php echo $_SESSION['username']; ?>" />
        <span id="availability_status"></span>
    </p>
    <p>
        <label for="password">Ancien mot de passe*: </label>
        <input type="password" name="password" title="mot de passe" id="password" required />
        <span id="password_length"></span>
 
	<p>
        <label for="new_password">Nouveau mot de passe*: </label>
        <input type="password" name="new_password" title="nouveau mot de passe" id="new_password" required />
        <span id="new_password_length"></span>
    </p>
	<p>
		<label for="password_confirmation">Confirmation *: </label>
        <input type="password" name="password_confirmation" title="confirmation mot de passe" id="password_confirmation" required />
        <span id="password_correct"></span>
	</p>	
    <p>
        <label for="gender">Vous &ecirc;tes: </label>
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
        <label for="tel_num">Num&eacute;ro de t&eacute;l&eacute;phone: </label>
        <input type="tel" name="tel_num" id="tel_num" placeholder="01 02 03 04 05" />
    </p>
    <p>
        <label for="email">Adresse email: </label>
        <input type="email" name="email" id="email" placeholder="xxx@yyy.com" /> <!-- type="email" -->
    </p>
		<h6>les donn&eacute;es pr&eacute;ced&eacute;es de * sont obligatoires</h6>
	</p>
    <p>
        <input type="submit" value="Envoyer" id="submit_" disabled="disabled"/>
    </p>
</form>
<div id="rep"></div>
<!-- http://www.matiasmancini.com.ar/jquery-plugin-ajax-form-validation-html5.html  -->
<script src="js/jquery.html5form-1.4-min.js"></script>
<script>
     $(document).ready(function(){
        var username_correct = false;
        //--
		var old_pwd_correct = false;
		//--
        var passwd_correct = false;
        var default_color = $("#username").css('background-color');

        $('#registration').html5form({
            allBrowsers : true,
            async : false,
            colorOn: '#000',
            colorOff: '#888',
            //emptyMessage : 'Ce champ est obligatoire',
            messages : 'fr',
            responseDiv : '#rep'
        });
        
        function allow_submit() {
            if (username_correct && passwd_correct && old_pwd_correct) 
                $("#submit_").removeAttr('disabled');
            else 
                $("#submit_").attr('disabled', 'disabled');
        }

        function check_passwd() {
            var passwd = $("#password").val();//Get the value in the username textbox
            var new_passwd = $("#new_password").val();//Get the value in the username textbox
            var passwdConf = $("#password_confirmation").val();//Get the value in the username textbox
            var length = false;
            var length_new_pwd = false;
            var equals = false;

            if (passwd.length < 6) {
                $("#password_length").html('Password too short');
                length = false;
            } else {
                $("#password_length").html('');
                length = true;
            }
			if (new_passwd.length < 6) {
                $("#new_password_length").html('Password too short');
				//--
                length_new_pwd = false;
				//..
            } else {
                $("#new_password_length").html('');
				//--
                length_new_pwd = true;
				//--
            }
            if (new_passwd === passwdConf) { 
                $("#password_correct").html('');
                $("#password").css('background-color', '#90EE90');
                $("#password_confirmation").css('background-color', '#90EE90');
                equals = true;
            } else { 
                $("#password_correct").html('Passwords don\'t match');
                $("#password").css('background-color', '#FF4500');
                $("#password_confirmation").css('background-color', '#FF4500');
                equals = false;
            }
            if (length && equals && length_new_pwd) {
                passwd_correct = true;
            } else {
                passwd_correct = false;
            }
            allow_submit();
            return false;
        };

        $("#username").keyup(function() { //if theres a change in the username textbox
            $("#username").css('background-color', default_color);
            var username = $("#username").val();//Get the value in the username textbox
			//--
            var password = $("#password").val();//Get the value in the password textbox
			//--
            if (username.length > 3) { //if the lenght greater than 3 characters
                $("#availability_status").html('Checking availability...');
                $.ajax({  //Make the Ajax Request
                    type: "POST",
                    url: "includes/functions/check_username_availability.php",  //file name
                    data: "username="+ username,  //data
                    success: function(server_response) {
                        $("#availability_status").ajaxComplete(function(event, request){
                            if (server_response == '0') { 
                                $("#availability_status").html('Available');
                                $("#username").css('background-color', '#90EE90');
                                username_correct = true;
                            } else if (server_response == '1') { //if it returns "1"
                                $("#availability_status").html('Not Available');
                                $("#username").css('background-color', '#FF4500');
                                username_correct = false;
                            }
                        });
                    }
                });
            } else {
                $("#availability_status").html('Username too short');
                username_correct = false;
            }
			//--
			if (password.length > 5) { //if the lenght greater than 5 characters
                $("#new_password_length").html('Checking availability...');
                $.ajax({  //Make the Ajax Request
                    type: "POST",
                    url: "includes/functions/check_username_password.php",  //file name
                    data: "password="+ password,  //data
                    success: function(server_response) {
                        $("#password_length").ajaxComplete(function(event, request){
                            if (server_response == '0') { 
                                $("#password_length").html('Available'); //je dois supprimer cette ligne
                                $("#password").css('background-color', '#90EE90');
                                old_pwd_correct = true;
                            } else if (server_response == '1') { //if it returns "1"
                                $("#password_length").html('Wrong password');
                                $("#password").css('background-color', '#FF4500');
                                old_pwd_correct = false;
                            }
                        });
                    }
                });
            } else {
                $("#password_length").html('Password too short');
                old_pwd_correct = false;
            }
			//--
            allow_submit();
            return false;
        });

        $("#password").keyup(check_passwd);
        $("#new_password").keyup(check_passwd);
        $("#password_confirmation").keyup(check_passwd);
     });
</script>

