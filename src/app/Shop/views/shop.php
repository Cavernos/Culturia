
            <h1 class="page-title">Oeuvres en vente</h1>
            <div class="filter-panel">
                    <div class="filter-panel-element">
                        <button type="submit" class="button iconify-button filter-button">Filtres</button>
                        <?= $filter("price", "Prix", "shop.index", $_GET, ["type" => "toggle"]) ?>
                        <?= $filter('artists', "Artistes", "shop.index", $_GET, ["type" => "toggle"]) ?>
                        <?= $filter(null, "Réinitialiser", "shop.index", $_GET, ["type" => "reset"]) ?>
                    </div> 
                    <div class="right">
                        <button type="submit" class="button iconify-button specific-filter-button">Trier par</button>
                    </div>
            </div>

            <div class="shop-container">
                <?php foreach($artworks ?? [] as $artwork) {?>
                        <a href="<?= $pathFor("shop.view", ["slug" => $artwork->getSlug(), "id"=> $artwork->id]) ?>" id="<?= $artwork->id ?>" class="card">
                            <div class="card-container">
                                <img class='card-image' src="<?= $artwork->image ?>" alt="<?= $artwork->name ?>" srcset=""/>
                                <div class="card-title">
                                    <h4 class="card-name"><?= $artwork->name ?></h4>
                                    <h4 class="card-price"><?= $artwork->price ?>€</h4>
                                </div>
                                <h4 class="card-author"><?= $artwork->username ?></h4>
                                <p class="card-description"><?= $artwork->description ?></p>
                            </div>
                        </a> 
                <?php } ?>      
            </div>
            <?= $paginate($artworks,"shop.index"); ?>

