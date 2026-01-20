<h1 class="page-title">Mon panier</h1>
<?php if (count($items ?? []) === 0) { ?>
    <div class="no-article-in-cart-container">
        <h1>Aucun article dans le panier</h1>
        <a class="button" href="<?= $pathFor("shop.index") ?>">Retour à la boutique</a>
    </div>

<?php } else {?>
<div class="cart-container">
    <h2 class="left">Nombre d'articles: <?= count($items ?? []) ?></h2>
    <h2 class="right">Prix total: <?=$total_price ?? 0 ?>€</h2>
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
    <?php foreach ($items ?? [] as $item){ ?>
    <tr>
        <td><img src="<?= $item->getThumb() ?>" alt="<?=$item->name ?>" srcset=""/></td>
        <td><?= $item->name ?></td>
        <td><?= $item->price ?> €</td>
        <td>60x70</td>
        <td>Abstrait</td>
        <td>
            <form action="<?= $pathFor("shop.cart.delete", ["id" => $item->id]) ?>" method="POST">
                <input name="_METHOD" value="DELETE" type="hidden"/>
                <?= $csrf_input() ?>
                <button class="button iconify-button delete-button" type="submit"></button>
            </form>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<div class="cart-footer">
    <h1>Prix total : <?=$total_price ?? 0?> €</h1>
    <button class="button" type="submit">Finaliser ma commande</button>
</div>
<?php } ?>