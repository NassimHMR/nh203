<?php
require_once('../../ressources/includes/connexion-bdd.php');

$pageCourante = "articles";

$formulaire_soumis = !empty($_POST);

if ($formulaire_soumis) {
    if (
        isset(
            $_POST['id'],
            $_POST['titre'],
            $_POST['chapo'],
            $_POST['contenu'],
            $_POST['date_creation'],
            $_POST['auteur_id']
        )
    ) {
        $id = htmlentities($_POST['id']);
        $titre = htmlentities($_POST['titre']);
        $chapo = htmlentities($_POST['chapo']);
        $contenu = htmlentities($_POST['contenu']);
        $date_creation = new DateTimeImmutable($_POST['date_creation']);
        $auteur_id = htmlentities($_POST['auteur_id']);

        // Insert the article into the table
        $creerArticleCommande = $clientMySQL->prepare(
            'INSERT INTO article(id, auteur_id, titre, chapo, contenu, date_creation) 
             VALUES (:id, :auteur_id, :titre, :chapo, :contenu,:date_creation)'
        );

        $creerArticleCommande->execute([
            'id' => $id,
            'titre' => $titre,
            'chapo' => $chapo,
            'contenu' => $contenu,
            'date_creation' => $date_creation->format('Y-m-d H:i:s'),
            'auteur_id' => $auteur_id,
        ]);

        // Select the author's name for display
        $selectAuteurCommande = $clientMySQL->prepare(
            'SELECT CONCAT(prenom, " ", nom) AS auteur_nom 
             FROM auteur 
             WHERE id = :auteur_id'
        );

        $selectAuteurCommande->execute(['auteur_id' => $auteur_id]);
        $auteur = $selectAuteurCommande->fetch();

        // Display the confirmation message
        echo '<div class="flex justify-center items-center">
                <p class="text-green-500 font-bold"> Vous avez créé un nouvel article !</p>
              </div>';
        echo '<div class="flex justify-center items-center">
                <p>Auteur: ' . $auteur['auteur_nom'] . '</p>
              </div>';

        // Redirect to the article list after 3 seconds
        header("refresh:3;url=https://nassimhmr.alwaysdata.net/nh203/administration/articles/");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../ressources/includes/head.php"); ?>

    <title>Création Article - Administration</title>
</head>

<body>
    <?php include_once '../ressources/includes/menu-principal.php'; ?>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un article</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="py-6">
                <form method="POST" action="" class="rounded-lg bg-white p-4 shadow border-gray-300 border-1">
                    <section class="grid gap-6">
                        <div class="col-span-12">
                            <label for="id" class="block text-lg font-medium text-gray-700">ID</label>
                            <input type="text" name="id" id="id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="col-span-12">
                            <label for="titre" class="block text-lg font-medium text-gray-700">Titre</label>
                            <input type="text" name="titre" id="titre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="col-span-12">
                            <label for="chapo" class="block text-lg font-medium text-gray-700">Chapô</label>
                            <textarea name="chapo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="chapo" required></textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="contenu" class="block text-lg font-medium text-gray-700">Contenu</label>
                            <textarea name="contenu" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="contenu" required></textarea>
                        </div>

                        <div class="col-span-12">
                            <label for="date_creation" class="block text-lg font-medium text-gray-700">Date de création</label>
                            <input type="date" name="date_creation" id="date_creation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="col-span-12">
                            <label for="auteur_id" class="block text-lg font-medium text-gray-700">Auteur</label>
                            <input type="text" name="auteur_id" id="auteur_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <button type="submit" class="rounded-md bg-indigo-600 py-2 px-4 text-lg font-medium text-white shadow-sm hover:bg-indigo-700">Créer</button>
                        </div>

                    </section>
                </form>
            </div>
        </div>
    </main>
    <?php require_once("../ressources/includes/global-footer.php"); ?>
</body>

</html>