
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
                        <a class="card">
                            <div class="card-container">
                                <img class='card-image' src="<?php echo $artwork->image ?>" alt="" srcset=""/>
                                <div class="card-title">
                                    <h4 class="card-name"><?php echo $artwork->name ?></h4>
                                    <h4 class="card-price"><?php echo $artwork->price ?>€</h4>
                                </div>
                                <h4 class="card-author">Artiste</h4>             
                                <p class="card-description"><?php echo $artwork->description ?></p>
                            </div>
                        </a> 
                <?php } ?>      
            </div>
            <div class="pagination-container">
                <button class="button iconify-button left-pagination-button"></button>
                <button class="button pagination">1</button>
                <button class="button pagination">2</button>
                <button class="button pagination">3</button>
                <button class="button pagination">4</button>
                <button class="button pagination">5</button>
                <button class="button pagination">6</button>
                <button class="button pagination">7</button>
                <button class="button pagination">8</button>
                <button class="button pagination">9</button>
                <button class="button pagination">10</button>
                <button class="button iconify-button right-pagination-button"></button>
</div>

