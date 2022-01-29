<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <meta name="author" content="https://www.kcteles.com/">
    <meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nosnippet, noodp">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form method="post" action="<?= base_url() ?>login/access">
            <h1 class="h3 mb-3 fw-normal">Acessar sistema</h1>
            <? if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
            } else {
                echo "";
            } ?>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" autofocus required>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="18" required>
                <label for="password">Senha</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            <div class="form-floating">
                <a href="<?= base_url() ?>login/passwordForgot" title="Recuperar senha"><i class="mdi mdi-lock"></i> Recuperar senha</a>
            </div>
            <p class="mt-5 mb-3 small"><a href="https://www.kcteles.com/" title="Desenvolvido por KC Teles" target="_blank">Desenvolvido por KC Teles</a></p>
        </form>
    </main>
</body>

</html>