<!doctype html>
<html lang="fr-FR">

    <head>

        <title> <?= $title ?> </title>
        <meta name="Description" content="Contenu">
        <link href="assets/css/style.css" rel="stylesheet">

    </head>

    <body>

        <?php
            require 'assets/partials/header_admin.php';
        ?>

        <!-- Si il y a un message a afficher alors on l'affiche -->
        <?php if(isset($_SESSION['message'])): ?>
            <div class="divUserMessage">
                <img src="assets/images/pictos/picto-info.svg">
                <h4><?= $_SESSION['message'] ?></h4>
            </div>
        <?php endif; ?>

        <!-- Contenu principal de la page -->
        <main>

            <?php
                //Appel de la vue demandée par l'user
                require $view;
            ?>

        </main>

    </body>

</html>