<h1 class="page-title">Modification du profil</h1>
<form enctype="multipart/form-data" action="<?= $pathFor("auth.edit", ["id" => $user->id]) ?>" method="POST">
    <?php require($viewPath . "/form.php") ?>
    <div class="form-actions">
        <button type="submit" class="button">
            Modifier
        </button>
        <a href="<?=  $pathFor("auth.index", ["id" => $user->id]) ?>" class="button">Revenir en arrière</a>
    </div>
</form>
