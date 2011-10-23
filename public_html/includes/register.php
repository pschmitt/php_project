<?php
    // TODO: add code
?>
<script src="http://html5form.googlecode.com/svn/trunk/jquery.html5form-1.4-min.js"></script>
<h1>Register.php</h1>

<p>
    Cum' on, fill that form. Gimme your data.
</p>

<form action="http://google.com" method="post" id="registration_form" autocomplete="on">
    <p>
        <label for="name">Nom: </label>
        <input type="text" name="name" id="name" placeholder="Votre nom" />
    </p>
    <p>
        <label for="first_name">Prénom: </label>
        <input type="text" name="first_name" id="first_name" placeholder="Votre prénom" />
    </p>
    <p>
        <label for="username">Pseudo: </label>
        <input type="text" name="username" id="username" placeholder="Votre pseudo" required />
    </p>
    <p>
        <label for="password">Mot de passe: </label>
        <input type="password" name="password" id="password" required />
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
        <label for="email">Adresse email: </label>
        <input type="text" name="email" id="email" /> <!-- type="email" -->
    </p>
    <p>
        <label for="birth_year">Date de naissance: </label>
        <select name="birth_year" id="birth_year">
            <option value="default" selected="selected"></option>
            <?php
                for ($d = 1901; $d < 2012; $d++) {
                    echo "<option value=".$d.">\n\t".$d."\n</option>\n";
                }
            ?>
        </select>
    </p>
    <p>
        <fieldset>
            <legend>Adresse: </legend>
            <label for="street_address">Rue: </label>
            <input type="text" name="street_address" id="street_address" />
            <label for="zip_code">Code postal: </label>
            <input type="text" name="zip_code" id="zip_code" />
            <label for="city">Ville: </label>
            <input type="text" name="city" id="city" />
        </fieldset>
    </p>
    <p>
        <label for="tel_num">Numéro de téléphone: </label>
        <input type="tel" name="tel_num" id="tel_num" />
    </p>
    <p>
        <input type="submit" value="envoyer" />
    </p>
</form>

<script>
    $(document).ready(function(){
        $('#registration_form').html5form({
            allBrowsers : true,
            method : 'GET',
        });
    });
</script>
