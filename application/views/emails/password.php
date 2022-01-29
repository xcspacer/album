<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Recuperar Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="96%">
        <tr>
            <td align="center" style="color: #000000; font-family: Arial, sans-serif; font-size: 16px; padding: 10px 0 30px 0;">
                Olá, recebemos sua solicitação de recuperação de senha, acesse:
            </td>
        </tr>
        <tr>
            <td align="center" style="color: #000000; font-family: Arial, sans-serif; font-size: 16px; padding: 10px 0 30px 0;">
                <a href="<?= base_url() ?>login/passwordRedefine/<?= $hash ?>"><?= base_url() ?>login/passwordRedefine/<?= $hash ?></a>
            </td>
        </tr>
        <tr>
            <td align="center" style="color: #3a3a3a; font-family: Arial, sans-serif; font-size: 14px; line-height: 10px; padding: 10px 0 10px 0;">
                Este é um e-mail automático. Por favor, não responda.
            </td>
        </tr>
        <tr>
            <td align="center" style="color: #3a3a3a; font-family: Arial, sans-serif; font-size: 14px; line-height: 10px; padding: 10px 0 10px 0;">
                E-mail privado para: <?= $email ?>
            </td>
        </tr>
    </table>
</body>

</html>