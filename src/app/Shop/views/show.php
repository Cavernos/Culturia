<div class="oeuvre-container">
    <div class="oeuvre-main">
        <div class="oeuvre-image-section">
            <div class="main-image">
                <img src="<?=$artwork->image ?>" alt="<?=$artwork->name?>">
            </div>
        </div>

        <div class="oeuvre-details">
            <h1><?=$artwork->name ?></h1>

            <div class="artist-info">
                <div class="artist-photo"></div>
                <div>
                    <p class="artist-name"><?=$artwork->username ?></p>
                    <p class="artist-location">Paris, France</p>
                </div>
            </div>

            <div class="price-section">
                <span class="price"><?=$artwork->price ?>€</span>
            </div>

            <div class="action-buttons">
                <?php if($pathFor('shop.cart.edit')) { ?>
                <form method="POST" action="<?= $pathFor('shop.cart.edit', ["id" => $artwork->id])?>">
                    <button class="btn-add-cart" type="submit">Ajouter au panier</button>
                </form>
                <?php } ?>
                    <button class="btn-favorite" type="submit">♡</button>


            </div>

            <div class="oeuvre-info">
                <h3>Description</h3>
                <p><?= $artwork->description ?></p>
            </div>

            <div class="oeuvre-specs">
                <h3>Spécifications</h3>
                <ul>
                    <li><strong>Catégorie :</strong> Peinture</li>
                    <li><strong>Technique :</strong> Huile sur toile</li>
                    <li><strong>Dimensions :</strong> 80 x 60 cm</li>
                    <li><strong>Année :</strong> 2024</li>
                    <li><strong>Certificat :</strong> Inclus</li>
                </ul>
            </div>

            <div class="shipping-info">
                <h3>Livraison et retours</h3>
                <p>📦 Livraison gratuite en France métropolitaine</p>
                <p>🔄 Retours acceptés sous 14 jours</p>
                <p>🛡️ Emballage sécurisé professionnel</p>
            </div>
        </div>
    </div>

    <div class="similar-works">
        <h2>Œuvres similaires</h2>
        <div class="works-grid">
            <?php foreach ($similar_artworks as $similar_artwork){?>
            <a href="<?= $pathFor("shop.view", ["slug"=> str_replace(" ", "-", strtolower($similar_artwork->name)), "id"=> $similar_artwork->id]) ?>" id="<?= $similar_artwork->id ?>" class="card">
                <div class="card-container">
                    <img class='card-image' src="<?= $similar_artwork->image ?>" alt="<?= $similar_artwork->name ?>" srcset=""/>
                    <div class="card-title">
                        <h4 class="card-name"><?= $similar_artwork->name ?></h4>
                        <h4 class="card-price"><?= $similar_artwork->price ?>€</h4>
                    </div>
                    <h4 class="card-author"><?= $similar_artwork->username ?></h4>
                    <p class="card-description"><?= $similar_artwork->description ?></p>
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
</div>