<form action="" method="POST">

    <article id="input_by_name">
        <label for="nickname">Nom utilisateur</label>
        <input type="text" name="nickname" id="nickname">
        <p class="switch_input">Se connecter avec l'adresse email</p>
    </article>
    <p><?= (isset($errors['login'])) ? $errors['login'] : '' ?></p>

    <article id="input_by_mail">
        <label for="email">Nom utilisateur</label>
        <input type="email" name="email" id="email">
        <p class="switch_input">Se connecter avec le nom utilisateur</p>
    </article>
    <p><?= (isset($errors['login'])) ? $errors['login'] : '' ?></p>

    <label for="pass">Mot de passe</label>
    <input type="password" name="pass" id="pass">
    <p><?= (isset($errors['pass'])) ? $errors['pass'] : '' ?></p>

    <button type="submit">Me connecter</button>

    <p>Mot de passe oublié ? <a href="">Réinitialiser le</a></p>

</form>

