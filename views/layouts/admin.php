<!doctype html>
<html lang="fr-FR">

    <head>

        <title> <?= $title ?> </title>
        <meta name="description" content="Contenu">
        <link href="assets/css/style.css" rel="stylesheet">

    </head>

    <body>

        <?php
            //GESTION DU HEADER EN FONCTION DU TYPE D'USER (VISITEUR, CONNECTÉ, ADMIN)
            if(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 1){

                if ($_SESSION['user']['is_admin'] == 1) //si c'est un admin qui est connecté alors on affiche le header de l'admin
                    require 'assets/partials/header_admin.php';
                else
                    require 'assets/partials/header_connected.php'; //On require le header de l'user connecté (avec son nom, panier, ...)

            }
            else
                require 'assets/partials/header_unconnected.php'; //On require le header de base (non connecté)
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


        <?php //on inclut le footer en bas de page
            require 'assets/partials/footer.php';
        ?>

    </body>

</html>