<h1 class="page-title">Mon panier</h1>
<div class="cart-container">
    <h2 class="left">Nombre d'articles: <?= count($items) ?></h2>
    <h2 class="right">Prix total: <?=$total_price?>€</h2>
</div>
<hr>
<table class="cart-articles">
    <thead class="cart-article-head">
    <tr>
        <th class="cart-article-properties">Oeuvre</th>
        <th class="cart-article-properties">Nom</th>
        <th class="cart-article-properties">Prix</th>
        <th class="cart-article-properties">Taille</th>
        <th class="cart-article-properties">Type</th>
        <th class="cart-article-properties">Retirer</th>
    </tr>
    </thead>
    <tbody class="cart-article-body">
    <?php foreach ($items as $item){ ?>
    <tr>
        <td><img src="<?= $item->image ?>" alt="<?=$item->name ?>" srcset=""/></td>
        <td><?= $item->name ?></td>
        <td><?= $item->price ?> €</td>
        <td>60x70</td>
        <td>Abstrait</td>
        <td><button class="button iconify-button delete-button"></button></td>
    </tr>
        <?php } ?>
    </tbody>
</table>
<div class="cart-footer">
    <h1>Prix total : <?=$total_price?> €</h1>
    <button class="button">Finaliser ma commande</button>

</div>