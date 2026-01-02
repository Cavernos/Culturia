
            <h1 class="page-title">Oeuvres en vente</h1>
            <?php if($pathFor('shop.filter') != '') { ?>
            <form method="post" action="<?= $pathFor("shop.filter") ?>" class="filter-panel">
                    <div class="filter-panel-element">
                        <button type="submit" class="button iconify-button filter-button">Filtres</button>
                        <?= $field($errors ?? [], 'price', $params["price"] ?? 0, 'Prix', ["type" => "toggleFilter", "class" => "button iconify-button filter-button"]); ?>
                        <?= $field($errors ?? [], 'artists', $params["artists"] ?? 0, 'Artiste', ["type" => "toggleFilter", "class" => "button iconify-button filter-button"]); ?>
                        <button type="submit" id="reset" name="reset" value="1" class="button reset">Réinitialiser</button>
                    </div> 
                    <div class="right">
                        <button type="submit" class="button iconify-button specific-filter-button">Trier par</button>
                    </div>
            </form>
            <?php } ?>
            <div class="shop-container">
                <?php foreach($artworks ?? [] as $artwork) {?>
                        <a href="<?= $pathFor("shop.view", ["slug"=> str_replace(" ", "-", strtolower($artwork->name)), "id"=> $artwork->id]) ?>" id="<?= $artwork->id ?>" class="card">
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

