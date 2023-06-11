<?php
$couleur_bulle_classe = "gris";
$page_active = "article";

require_once('./ressources/includes/connexion-bdd.php');

// Vérifier si l'ID de l'article est passé en tant que paramètre dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'article depuis l'URL
    $articleID = $_GET['id'];

    // à adapter
    $articleCommand = $clientMySQL->prepare('SELECT article.*, auteur.lien_avatar, auteur.prenom, auteur.nom FROM article
    JOIN auteur ON article.auteur_id = auteur.id
    WHERE article.id = :id');
    $articleCommand->execute([
        'id' => $articleID,
    ]);
    $article = $articleCommand->fetch();
} else {
    // ID de l'article non spécifié, rediriger vers une page d'erreur ou une autre page par défaut
    header("Location: erreur.php");
    exit();
}
// Fermeture de la connexion à la base de données
$clientMySQL = null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo getenv('CHEMIN_BASE') ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article - SAÉ 203</title>

    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/accueil.css">
    <link rel="icon" href="ressources/images/favicon-GEC_400x400px.png" type="image/png">

    <link rel="stylesheet" href="ressources/css/global.css">
    <link rel="stylesheet" href="ressources/css/accueil.css">
    <link rel="stylesheet" href="ressources/css/article.css">
</head>

<body>
    <section>
        <?php require_once('./ressources/includes/header.php'); ?>
        <?php require_once('./ressources/includes/bulle.php'); ?>

        <main class="conteneur-1280">
            <h1 class="header"><?php echo $article["titre"]; ?></h1>
            <a <?php echo $article["id"]; ?> class='tout'>
                <div class='image-article'>
                    <img class = 'image' src='ressources/images/cergy.jpg' alt='photo_article'>
                </div>
                <section>
                    <p class='chapo'>
                        <?php echo $article['chapo']; ?>
                    </p>
                    <br>
                    <p class='textebox'>
                        <?php echo $article["contenu"]; ?>
                    </p>
                    <br>
                    <div class='auteur'>
                        <img class = "avatar" src='<?php echo $article["lien_avatar"]  ?>' alt='photo'>
                        <br>
                        <p class="nom-prenom"><?php echo $article["prenom"]." ".$article["nom"]; ?></p>
                    </div>
                </section>
            </a>
        </main>
        <?php require_once('./ressources/includes/footer.php'); ?>
    </section>
</body>
</html>