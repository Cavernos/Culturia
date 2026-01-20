
<h1 class="page-title">Artistes</h1>

<div class="shop-container">
    <?php foreach($artists ?? [] as $artist) {?>
        <a href="<?= $pathFor("artists.profile", ["id"=> $artist->id]) ?>" id="<?= $artist->id ?>" class="card">
            <div class="card-container">
                <img class='card-image' src="<?= $artist->avatar ?>" alt="<?= $artist->username ?>" srcset=""/>
                <div class="card-title">
                    <h4 class="card-name"><?= $artist->username ?></h4>
                </div>
            </div>
        </a>
    <?php } ?>
</div>
<?= $paginate($artists,"artists.index"); ?>

