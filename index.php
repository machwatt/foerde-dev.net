<?php

    $emailToReceiveInquiry = 'slack@foerde-dev.net';
    $emailSubject = 'Förde-Dev – Beitrittsanfrage';
    $errorMessages = array();
    $successMessage = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if(!empty($_POST['email'])) {
                if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $email = htmlspecialchars($_POST['email']);
                } else {
                    throw new Exception('Bitte gebe eine E-Mail-Adresse an.');
                }
            } else {
                throw new Exception('Bitte gebe eine E-Mail an.');
            }
        } catch(Exception $exception) {
            $errorMessages[] = $exception->getMessage();
        }

        if(empty($errorMessages)) {
            $mailSubject = '=?utf-8?b?'.base64_encode($emailSubject).'?=';

            $mailMessage = 'Hi'."\n";
            $mailMessage .= 'Es möchte jemand in den Förde-Dev Slack Channel. Lade doch bitte folge E-Mail-Adresse ein:';
            $mailMessage .= $email;

            $mailHeader = 'MIME-Version: 1.0'."\r\n";
            $mailHeader .= 'Content-type: text/html; charset=UTF-8'."\r\n";
            $mailHeader .= 'From: Förde-Dev Website <info@foerde-dev.net>'."\r\n";

            if(mail($emailToReceiveInquiry, $mailSubject, $mailMessage, $mailHeader)) {
                $successMessage = 'Deine Anfrage wurde erfolgreich abgeschickt, danke.';
            }
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="assets/stylesheets/main.css">
        <title>Förde-Dev</title>
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web:700,300' rel='stylesheet' type='text/css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Förde-Dev ist ein Slack Team, bei dem Entwickler aus Flensburg zusammenkommen und über alles mögliche schnacken.">
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <!--[if IE]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <header>
            <section class="headerContent">
                <img src="assets/images/foerde-dev-logo-weiss.svg" title="Förde-Dev" alt="Förde-Dev Logo">
                <h1>Förde-Dev</h1>
                <h2>Entwickler aus Flensburg und Umgebung treffen sich bei Slack.</h2>
            </section>
        </header>
        <main>
            <p>Du kommst aus Flensburg oder aus der Umgebung? Du bist Web-Entwickler? Du bist offen für Neues? Du hast Lust neue Leute kennenzulernen? Du bist neugierig? Du hast Lust dich mit anderen Entwicklern von nebenan zu unterhalten? Du hast Lust dich über die neusten Technologien, Innovationen und sonstige Themen zu unterhalten? Dann bist du bei uns, den Förde-Devs, gar nicht so verkehrt.</p>
            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                <?php
                    if(!empty($errorMessages)) {
                        foreach ($errorMessages as $error) {
                ?>
                    <strong><?=$error?></strong>
                <?php
                        }
                    } else if($successMessage !== '') {
                ?>
                    <strong><?=$successMessage?></strong>
                <?php
                    }
                ?>
                <input type="email" name="email" placeholder="Mega geil, lade mich per E-Mail ein." required>
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 334.5 334.5" style="enable-background:new 0 0 334.5 334.5;" xml:space="preserve" height="20" width="20">
                        <path fill="#1F51DB" d="M332.797,13.699c-1.489-1.306-3.608-1.609-5.404-0.776L2.893,163.695c-1.747,0.812-2.872,2.555-2.893,4.481  s1.067,3.693,2.797,4.542l91.833,45.068c1.684,0.827,3.692,0.64,5.196-0.484l89.287-66.734l-70.094,72.1  c-1,1.029-1.51,2.438-1.4,3.868l6.979,90.889c0.155,2.014,1.505,3.736,3.424,4.367c0.513,0.168,1.04,0.25,1.561,0.25  c1.429,0,2.819-0.613,3.786-1.733l48.742-56.482l60.255,28.79c1.308,0.625,2.822,0.651,4.151,0.073  c1.329-0.579,2.341-1.705,2.775-3.087L334.27,18.956C334.864,17.066,334.285,15.005,332.797,13.699z"/>
                    </svg>
                </button>
            </form>
        </main>
        <footer>
            <img src="assets/images/foerde-dev-flensburg-logo.svg" title="Förde-Dev" alt="Förde-Dev Logo">
            <address>
                Jöran Kurschatke<br>
                Am Eulenberg 68<br>
                24991 Großsolt<br>
                <a href="mailto:info@foerde-dev.net" title="Jetzt eine E-Mail schreiben">info@foerde-dev.net</a>
            </address>
        </footer>
    </body>
</html>
