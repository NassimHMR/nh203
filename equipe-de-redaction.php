<?php
$couleur_bulle_classe = "bleu";
$page_active = "equipe de redaction";

require_once('./ressources/includes/connexion-bdd.php');

$listeAuteursCommande = $clientMySQL->prepare('SELECT * FROM auteur');
$listeAuteursCommande->execute();
$listeAuteurs = $listeAuteursCommande->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <base href="/<?php echo getenv('CHEMIN_BASE') ?>">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Équipe de rédaction - SAÉ 203</title>

    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/reset.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/global.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/header.css">
    <link rel="stylesheet" href="ressources/css/ne-pas-modifier/accueil.css">
    <link rel="icon" href="ressources/images/favicon-GEC_400x400px.png" type="image/png">
    
    <link rel="stylesheet" href="ressources/css/global.css">
    <link rel="stylesheet" href="ressources/css/equipe-de-redaction">
</head>

<body>
    <section>
        <?php require_once('./ressources/includes/header.php');?>
        <?php require_once('./ressources/includes/bulle.php');?>
        <main class="conteneur-principal conteneur-1280">
            <!-- Vous allez principalement écrire votre code HTML dans cette balise -->
            <h1 class="titre-page">Équipe de rédaction</h1>
            <ul class="liste-videos">
                <?php foreach ($listeAuteurs as $auteur) { ?>
                    <a class="video-conteneur">
                        <img class="video-yt" src="<?php echo $auteur["lien_avatar"]?>">
                        <h2 class="titre"><?php echo $auteur["prenom"]?> <?php echo $auteur["nom"]?></h2>
                <?php } ?>
            </ul>
        </main>
        <?php require_once('./ressources/includes/footer.php'); ?>
    </section>
</body>
</html>
