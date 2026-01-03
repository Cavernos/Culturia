
            <h1 class="page-title">Oeuvres en vente</h1>
            <div class="filter-panel">
                    <div class="filter-panel-element">
                        <button type="submit" class="button iconify-button filter-button">Filtres</button>
                        <a href="<?=$pathFor('shop.index', [], array_merge($_GET, ["artists" => $filter_param["artists"] ?? "desc"]))?>" class="button iconify-button filter-button <?= $_GET['artists'] ?? "desc" ?>">Artistes</a>
                        <a href="<?=$pathFor('shop.index', [], array_merge($_GET, ["price" => $filter_param["price"] ?? "desc"]))?>" class="button iconify-button filter-button <?= $_GET['price'] ?? "desc" ?>">Prix</a>
                        <a href="<?=$pathFor('shop.index')?>" class="button reset">Réinitialiser</a>
                    </div> 
                    <div class="right">
                        <button type="submit" class="button iconify-button specific-filter-button">Trier par</button>
                    </div>
            </div>

            <div class="shop-container">
                <?php foreach($artworks ?? [] as $artwork) {?>
                        <a href="<?= $pathFor("shop.view", ["slug" => str_replace(" ", "-", strtolower($artwork->name)), "id"=> $artwork->id]) ?>" id="<?= $artwork->id ?>" class="card">
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

