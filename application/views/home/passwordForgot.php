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
        <form class="form-horizontal m-t-20" method="post" id="forwardform">
            <h1 class="h3 mb-3 fw-normal">Recuperar senha</h1>
            <p>Informe seu e-mail e enviaremos instruções para você criar sua senha.</p>
            <spam id="forwardview"></spam>
            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" autofocus required>
                <label for="email">E-mail</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Enviar</button>
            <div class="form-floating">
                <a href="<?= base_url() ?>login" title="Login"><i class="mdi mdi-lock"></i> Entrar</a>
            </div>
            <p class="mt-5 mb-3 small"><a href="https://www.kcteles.com/" title="Desenvolvido por KC Teles" target="_blank">Desenvolvido por KC Teles</a></p>
        </form>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#forwardform').submit(function(e) {
            e.preventDefault();
            const email = $('input[name="email"]').val();
            $.ajax({
                url: '<?= base_url() ?>login/forward',
                type: 'POST',
                data: {
                    email: email
                },
                success: function(response) {
                    $('#forwardview').html(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return false;
        });

        $(document).ready(function() {
            setInterval(function() {

                var divmsg = "[class^='divmsg']:";

                $(divmsg + "visible").hide("fast", function() {
                    $(divmsg + "hidden")
                        .not(this)
                        .show();
                });

            }, 10000);
        });
    </script>
</body>

</html>