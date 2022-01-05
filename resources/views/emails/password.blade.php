<!-- resources/views/emails/password.blade.php -->
<!doctype html>
<html lang="fr-BE" style="padding: 0; margin: 0;">
<head>
    <meta charset="UTF-8">
    <title>Mail du site stucher.be</title>
</head>
    <body style="padding: 0; margin: 0;">
        <table bgcolor="#FF4732" border="0" cellpadding="10px" cellspacing="0" width="100%">
            <tr>
                <td align="center" valign="middle">
                    <a href="http://stucher.be">
                        <img src="http://stucher.be/img/logo_stucher_white.png" alt="logo stucher" height="30">
                    </a>
                </td>
            </tr>
        </table>
        <br>
        <table border="0" cellpadding="0" cellspacing="0" width="90%" align="center" style="font-size: 1.2em;">
            <tr>
                <td>
                    <i>Bonjour {{$user->firstname}},</i>
                    <p>Ce mail a été envoyé suite à une demande de changement de mot de passe.</p>
                    <br>
                    <p>Si c'est bien le cas, cliquez sur ce lien :</p>
                    <p>
                        <a href="{{ url('password/reset/'.$token) }}">Changer mon mot de passe</a>
                    </p>
                    <p>Si vous n'avez pas demandé de changer de mot de passe, ne prennez pas en compte cet email.</p>
                    <br>
                    <p>Bonne journée,</p>
                    <br>
                    <i>L'équipe Stucher</i>
                </td>
            </tr>
        </table>
    </body>
</html>