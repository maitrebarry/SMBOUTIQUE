<?php
    require_once('rentrer_anormal.php') ;
    require_once('partials/database.php');
    require_once('function/function.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Vérifier si l'email existe dans la base de données
    $query = $bdd->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Générer un token unique pour la réinitialisation du mot de passe
        $token = bin2hex(random_bytes(16));

        // Mettre à jour le token dans la base de données
        $query = $bdd->prepare("UPDATE utilisateur SET reset_token = ? WHERE email = ?");
        $query->execute([$token, $email]);

        // Construire le lien de réinitialisation
        $reset_link = "http://localhost:8080/Formation/propre/BonAcceuil/reset_password.php?email=$email&token=$token";
        
        // Envoyer un e-mail de réinitialisation avec le lien
        $to = $email;
        $subject = "Réinitialisation du mot de passe";
        $message = "Bonjour,\n\nVous avez demandé une réinitialisation de mot de passe. Cliquez sur le lien suivant pour réinitialiser votre mot de passe :\n\n$reset_link\n\nCordialement,\nZaramarket";
       $headers = "From: barrymoustapha908@gmail.com";
        mail($to, $subject, $message, $headers);

        afficher_message('Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.');
    } else {
        afficher_message('Aucun compte trouvé avec cet e-mail.');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
</head>

<body>
    <h2>Mot de passe oublié</h2>
    <form method="post">
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" name="submit" value="Envoyer">
    </form>
    <?php require_once('partials/afficher_message.php'); ?>
</body>

</html>
