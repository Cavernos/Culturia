<h1 class="page-title">Profil de <?= $user->username ?? ""?></h1>
<div class="panel">
    <nav class="panel-nav" >
        <button class="panel-button active"><?= $current_user() == $user ? "Vos i" : "I"?>nformations</button>
        <?php if ($current_user() == $user) { ?>
            <button class="panel-button"><?= $current_user() == $user ? "Vos o" : "O"?>euvres favorites</button>
            <button class="panel-button"><?= $current_user() == $user ? "Vos c" : "C"?>ommandes</button>
        <?php } ?>
    </nav>
    <div class="panel-element active">
        <h1 class="page-sub-title"><?= $current_user() == $user ? "Vos i" : "I"?>nformations</h1>
        <div class="panel-container">
            <div class="profile-header">
                <img src="<?= $user->avatar ?: "/assets/img/account.svg"?>" alt="Profile"/>
                <div class="profile-infos">
                    <h1 class="profile-name"><?= $user->username ?></h1>
                    <h2 class="profile-email"><?= $user->email ?></h2>
                </div>
            </div>
            <?php if($user == $current_user()) { ?>
                <div class="profile-actions">
                    <a href="#" class="button">Modifier le profil</a>
                    <form method="POST" class="delete-form">
                        <input type="hidden" name="_METHOD" value="DELETE"/>
                        <button class="button" type="submit">Supprimer le profil</button>
                    </form>
                </div>
            <?php } ?>


        </div>
    </div>

    <div class="panel-element">
        <h1 class="page-sub-title"><?= $current_user() == $user ? "Vos o" : "O"?>euvres favorites</h1>
        <div class="panel-container">
            <?php foreach ($favorites ?? [] as $artwork) {?>
                <a href="<?= $pathFor("shop.view", ["slug" => $artwork->getSlug(), "id" => $artwork->id]) ?>" class="card">
                    <?php if($current_user() == $user) { ?>
                        <form method="POST" action="<?= $pathFor("client.favorite.delete" ,["id" => $artwork->id]) ?>" class="delete-form">
                            <?= $csrf_input() ?>
                            <input type="hidden" name="_METHOD" value="DELETE"/>
                            <button type="submit">&times;</button>
                        </form>
                    <?php } ?>
                    <div class="card-container">
                        <img class='card-image' src="<?= $artwork->getThumb() ?>" alt="<?=$artwork->name ?>" srcset=""/>
                        <div class="card-title">
                            <h4 class="card-name"><?= $artwork->name ?></h4>
                            <h4 class="card-price"><?= $artwork->price ?> €</h4>
                        </div>
                        <p class="card-description"><?= $artwork->description ?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
    <div class="panel-element">
        <h1 class="page-sub-title"><?= $current_user() == $user ? "Vos c" : "C"?>ommandes</h1>
        <div class="panel-container">
            <?php foreach ($orders ?? [] as $order) { ?>
                <div class="order-container">
                    <img src="/assets/img/account.svg" alt="client"/>
                    <h2>De : Client 1</h2>
                    <h2>Nombre d'article : <?= count($order["artworks"]) ?></h2>
                    <h2>Prix total : <?= array_sum(array_column(iterator_to_array($order["artworks"]), 'price'))?> €</h2>
                    <a id="toggle" class="button">Récapitulatif de la commande</a>
                    <div class="order-content">
                        <?php foreach ($order["artworks"] as $artwork) { ?>
                            <div class="card">
                                <div class="card-container">
                                    <img class='card-image' src="<?= $artwork->getThumb() ?>" alt="<?= $artwork->name ?>" srcset=""/>
                                    <div class="card-title">
                                        <h4 class="card-name"><?= $artwork->name ?></h4>
                                        <h4 class="card-price"><?= $artwork->price ?> €</h4>
                                    </div>
                                    <p class="card-description"><?= $artwork->description ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if(iterator_count($order['artworks']) > 4) { ?>
                            <a href="" class="button">Voir toutes les oeuvres</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

