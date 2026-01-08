<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris - Culturia</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Le header sera inclus via PHP -->
    
    <main>
        <h1>Mes Favoris</h1>
        <div class="favorites-info">
            <h2>Nombre d'œuvres: <!-- <?php echo count($favorites); ?> --></h2>
        </div>

        <table class="favorites-table">
            <thead>
                <tr>
                    <th>Oeuvre</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Taille</th>
                    <th>Type</th>
                    <th>Retirer</th>
                </tr>
            </thead>
            <tbody>
                <!-- Boucle PHP ici pour afficher chaque œuvre likée -->
                <!-- <?php foreach($favorites as $artwork): ?> -->
                <tr>
                    <td>
                        <img src="<!-- chemin_image -->" alt="<!-- nom_oeuvre -->" class="artwork-img">
                    </td>
                    <td><!-- nom_oeuvre --></td>
                    <td><!-- prix --> €</td>
                    <td><!-- dimensions --></td>
                    <td><!-- type/catégorie --></td>
                    <td>
                        <form method="POST" action="">
                            <button type="submit" name="remove_favorite" value="<!-- id_oeuvre -->">
                                <!-- Icône poubelle -->
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- <?php endforeach; ?> -->
            </tbody>
        </table>

        <div class="action-buttons">
            <form method="POST" action="">
                <button type="submit" name="add_all_to_cart" class="btn-primary">
                    Tout ajouter au panier
                </button>
            </form>
        </div>
    </main>

    <!-- Le footer sera inclus via PHP -->
</body>
</html>
