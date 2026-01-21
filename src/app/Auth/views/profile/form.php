<?= $csrf_input() ?>
<?= $field($errors ?? [], 'username', $user->username ?? null,  "Nom d'utilisateur :"); ?>
<?= $field($errors ?? [], 'email', $user->email ?? null,  "Email :", ["type" => "email"]); ?>

