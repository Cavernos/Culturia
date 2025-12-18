<ul id="artwork-carousel" class="carousel">
    <li class="carousel-element">
        <div class="carousel-element-container">
            <h1 class="carousel-element-name">
                Michel Ange
            </h1>
            <p class="carousel-element-description">
                Artiste capable d’exrimer dans ses œuvres une parfaite maîtrise de l’anatomie et des formes humaines, alliant puissance, expressivité et émotion pour créer des compositions harmonieuses et saisissantes.
            </p>
        </div>
    </li>
    <li class="carousel-element">
        <div class="carousel-element-container">
            <h1 class="carousel-element-name">
                Michel Ange
            </h1>
            <p class="carousel-element-description">
                Artiste capable d’exrimer dans ses œuvres une parfaite maîtrise de l’anatomie et des formes humaines, alliant puissance, expressivité et émotion pour créer des compositions harmonieuses et saisissantes.
            </p>
        </div>
    </li>
    <li class="carousel-element">
        <div class="carousel-element-container">
            <h1 class="carousel-element-name">
                Michel Ange
            </h1>
            <p class="carousel-element-description">
                Artiste capable d’exrimer dans ses œuvres une parfaite maîtrise de l’anatomie et des formes humaines, alliant puissance, expressivité et émotion pour créer des compositions harmonieuses et saisissantes.
            </p>
        </div>
    </li>
    <li class="carousel-element">
        <div class="carousel-element-container">
            <h1 class="carousel-element-name">
                Michel Ange
            </h1>
            <p class="carousel-element-description">
                Artiste capable d’exrimer dans ses œuvres une parfaite maîtrise de l’anatomie et des formes humaines, alliant puissance, expressivité et émotion pour créer des compositions harmonieuses et saisissantes.
            </p>
        </div>
    </li>
</ul>
<h1 class="page-sub-title">Catégories</h1>
<div class="category-container">

        <a href="#" class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/abstrait.png" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Abstrait
            </h4>
        </a>

        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/paysage.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Paysages
            </h4>
        </a>

        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/fleur.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Floral
            </h4>
        </a>

        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/popart.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Pop Art
            </h4>
        </a>


        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/portrait.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Portrait
            </h4>
        </a>


        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/impressionisme.jpeg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Impréssionisme
            </h4>
        </a>


        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/cubisme.jpeg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Cubisme
            </h4>
        </a>


        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/japonais.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Japonais
            </h4>
        </a>


        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/contemporain.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Contemporain
            </h4>
        </a>


        <a class = "categorie-element-container">
            <img class = "categorie-image" src = "/assets/img/sculpture.jpg" alt="" srcset=""/>
            <h4 class = "categorie-element-nom">
                Sculpture
            </h4>
        </a>

</div>
<div class="etes-vous-artiste">
    <div class="artiste-element-container">
        <h1>Etez-vous artiste?</h1>
        <p>Inscrivez-vous pour mettre en ligne vos oeuvres</p>

        <a class="button filter-button">Je m'inscrit</a>

    </div>
    <img class = "categorie-image-artiste" src = "/assets/img/artiste_back.jpg" width="200px" height="200px" srcset=""/>
</div>

<h1 class="page-sub-title">Artistes Populaires</h1>

<ul id="artist-carousel" class="carousel multiple">
    <!-- Slide 1 -->
    <?php for($i= 0; $i < 6; $i++){?>
    <div class="carousel-element">
        <div class="artiste-populaire">
            <img class="image-artiste" src="/assets/img/artist_<?=$i%3 + 1?>.png" alt="Artiste <?=$i+1?>">
            <p class="artiste-nom">Artiste <?=$i+1?></p>
        </div>

    </div>
    <?php }?>
</ul>


<h1 class="page-sub-title">Oeuvres récentes</h1>
<ul id="card-carousel" class="carousel multiple">
    <?php foreach($artworks as $artwork){?>
        <a href="<?= $pathFor("shop.view", ["slug"=> str_replace(" ", "-", strtolower($artwork->name)), "id"=> $artwork->id]) ?>" id="<?= $artwork->id ?>" class="carousel-element card">
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
    <?php }?>
</ul>