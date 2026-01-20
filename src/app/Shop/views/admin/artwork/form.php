<?= $csrf_input() ?>
<img src="<?= $item->getThumb() ?>" alt=""/>
<?= $field($errors ?? [], 'image', $item->image ?? null,  "Image :", ["type" => "file"]); ?>
<?= $field($errors ?? [], 'name', $item->name ?? null,  "Nom de l'oeuvre :"); ?>
<?= $field($errors ?? [], 'description', $item->description ?? null,  "Description :", ["type" => "textarea"]); ?>
<?= $field($errors ?? [], 'creation_date', $item->creationDate ?? null,  "Date de création"); ?>
<?= $field($errors ?? [], 'price', $item->price ?? null,  "Prix :", ["type" => "number"]); ?>
<?php if(true) { ?>
    <?= $field($errors ?? [], 'artist_id', $item->artistId ?? null,  "Artiste :", ["options" => $artists, "class" => "readonly"]); ?>
<?php } ?>
