<?= $csrf_input() ?>
<?= $field($errors ?? [], 'image', $item->name ?? null,  "Image :", ["type" => "file"]); ?>
<?php if($item->image) { ?>
    <img src="<?= $item->getThumb() ?>" alt=""/>
<?php } ?>
<?= $field($errors ?? [], 'name', $item->name ?? null,  "Nom de l'oeuvre :"); ?>
<?= $field($errors ?? [], 'description', $item->description ?? null,  "Description :", ["type" => "textarea"]); ?>
<?= $field($errors ?? [], 'creation_date', $item->creationDate ?? null,  "Date de création"); ?>
<?= $field($errors ?? [], 'price', $item->price ?? null,  "Prix :", ["type" => "number"]); ?>
<?= $field($errors ?? [], 'artist_id', $item->artistId ?? null,  "Artiste :", ["options" => $artists]); ?>
