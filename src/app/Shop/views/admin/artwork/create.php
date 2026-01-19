<h1 class="page-title">Ajout d'une Oeuvre</h1>
<form enctype="multipart/form-data" action="<?= $pathFor($routePrefix . ".create") ?>" method="POST">
    <?php require($viewPath . "/form.php") ?>
    <button class="button" type="submit">Ajouter</button>
</form>
