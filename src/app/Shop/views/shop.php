
            <h1 class="page-title">Oeuvres en vente</h1>
            <div class="filter-panel">
                    <div class="filter-panel-element">
                        <button class="button iconify-button filter-button">Filtres</button>
                        <button class="button iconify-button specific-filter-button">Prix</button> 
                        <button class="button iconify-button specific-filter-button">Taille</button>
                        <button class="button reset">Réinitialiser</button>
                    </div> 
                    <div class="right">
                        <button class="button iconify-button specific-filter-button">Trier par</button> 
                    </div>
            </div> 
            <div class="shop-container">
                <?php foreach($artworks as $artwork) {?>
                        <a id="<?= $artwork->id ?>" class="card">
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
</div>

