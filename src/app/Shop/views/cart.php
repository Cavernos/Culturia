<h1 class="page-title">Mon panier</h1>
<div class="cart-container">
    <h2 class="left">Nombre d'articles: 5</h2>
    <h2 class="right">Prix total: 2000€</h2>
</div>
<hr>
<table class="cart-articles">
    <thead class="cart-article-head">
    <tr>
        <th class="cart-article-properties">Oeuvre</th>
        <th class="cart-article-properties">Prix</th>
        <th class="cart-article-properties">Taille</th>
        <th class="cart-article-properties">Type</th>
        <th class="cart-article-properties">Retirer</th>
    </tr>
    </thead>
    <tbody class="cart-article-body">
    <tr>
        <td><img src="../public/assets/img/oeuvre_1.png" alt="" srcset=""/></td>
        <td>650 €</td>
        <td>60x70</td>
        <td>Abstrait</td>
        <td><button class="button iconify-button delete-button"></button></td>
    </tr>
    <tr>
        <td><img src="../public/assets/img/oeuvre_2.png" alt="" srcset=""/></td>
        <td>650 €</td>
        <td>60x70</td>
        <td>Abstrait</td>
        <td><button class="button iconify-button delete-button"></button></td>
    </tr>
    <tr>
        <td><img src="../public/assets/img/oeuvre_3.png" alt="" srcset=""/></td>
        <td>650 €</td>
        <td>60x70</td>
        <td>Abstrait</td>
        <td><button class="button iconify-button delete-button"></button></td>
    </tr>
    </tbody>
</table>
<?= $paginate([], "shop.cart")?>
<div class="cart-footer">
    <h1>Prix total : 2000 €</h1>
    <button class="button">Finaliser ma commande</button>

</div>