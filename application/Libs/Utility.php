<?php
namespace Mini\Libs;

use Mini\Model\DLA;
use Bcrypt\Bcrypt;

class Utility
{

    public function sendMail($name, $emails, $phone, $subject, $message_in)
    {
        $message = '<!DOCTYPE html><html><head><title>' . $subject . '</title><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"><style>body{font-family: "Lato", "Muli", sans-serif;}
        </style></head><body><div class="container">
        <h2>A visitor just submitted a request from the website, details below.</h2>
        <table>
        <tr>
        <td>Name</td>
        <td> ' . $name . '</td>
        </tr>
        <tr>
        <td>Email</td>
        <td> ' . $emails . '</td>
        </tr><tr>
        <td>Phone No: </td>
        <td> ' . $phone . '</td>
        </tr>
        <tr>
        <td>Subject: </td>
        <td> ' . $subject . '</td>
        </tr>
        <tr>
        <td>Message: </td>
        <td> ' . $message_in . '</td>
        </tr>
        </table>
        </div><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script></body></html>';
        // Create the Transport
        $transport = (new \Swift_SmtpTransport(EmailServer, EmailPort, 'ssl'))->setUsername(Email)->setPassword(EmailPwrd);

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message())->setSubject($subject)
            ->setFrom([
            Email => 'Daystar Leadership Academy'
        ])
            ->setTo([
            'clientrelationship@nobelovagradani.org',
            'support@nobelovagradani.org'
        ])
            ->setBody($message, 'text/html');
        // Send the message
        $result = $mailer->send($message);

        return $result;
    }

    public function sanitizeString($string)
    {
        $string = str_replace(' ', '-', strtolower($string)); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function get_client_ip()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                if (strpos($ip, ",")) {
                    $exp_ip = explode(",", $ip);
                    $ip = $exp_ip[0];
                }
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
                if (strpos($ip, ",")) {
                    $exp_ip = explode(",", $ip);
                    $ip = $exp_ip[0];
                }
            } else if (getenv('HTTP_CLIENT_IP')) {
                $ip = getenv('HTTP_CLIENT_IP');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        return $ip;
    }

    public function verifyPassword($plain_password, $cipher_password)
    {
        $response = false;
        $bcrypt = new Bcrypt();
        $bcrypt_version = '2y';

        if ($bcrypt->verify($plain_password, $cipher_password)) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }

    public function encryptPassword($plain_password)
    {
        $bcrypt = new Bcrypt();
        $bcrypt_version = '2y';

        return $bcrypt->encrypt($plain_password, $bcrypt_version);
    }

    public function generate_random_string($length = 12)
    {
        $alphabets = range('A', 'Z');
        $alphabetsLower = range('a', 'z');
        $numbers = range('0', '9');
        $additional_characters = array(
            '_',
            '#',
            '@'
        );
        $final_array = array_merge($alphabets, $alphabetsLower, $numbers, $additional_characters);
        // $final_array = array_merge($numbers);

        $password = '';

        while ($length --) {
            $key = array_rand($final_array);
            $password .= $final_array[$key];
        }

        return $password;
    }

    public function generateToken($length = 23)
    {
        try {
            return bin2hex(random_bytes($length));
        } catch (\Exception $e) {}
    }

    public function encryptData($data)
    {
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $crypted_token = openssl_encrypt($data, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
        unset($data, $cipher_method, $enc_key, $enc_iv);

        return $crypted_token;
    }

    public function decryptData($encrypted)
    {
        list ($encrypted, $enc_iv) = explode("::", $encrypted);
        ;
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($encrypted, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        unset($encrypted, $cipher_method, $enc_key, $enc_iv);

        return $token;
    }

    public function sendGenericMail($recipient_email, $in_message, $subject = 'Daystar Leadership Academy - Reset Password')
    {
        $message = <<<EOT
    <!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Daystar Leadership Academy</title><style type="text/css">@media screen and (max-width: 600px) {table[class="container"] {width: 95% !important; }
        } #outlook a { padding: 0; } body { width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;margin: 0;padding: 0;}.ExternalClass { width: 100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}#backgroundTable {margin: 0;padding: 0;
            width: 100% !important;line-height: 100% !important;}img {outline: none; text-decoration: none;-ms-interpolation-mode: bicubic;} a img {border: none;} .image_fix {display: block;
        }p {margin: 1em 0;}h1, h2, h3, h4, h5, h6 { color: black !important;}h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: #00008b !important;} h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: red !important;} h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: #00008b !important;}table td {border-collapse: collapse; }table {
            border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;}a { color: #000; }@media only screen and (max-device-width: 480px) {a[href^="tel"], a[href^="sms"] {
                text-decoration: none;color: black; pointer-events: none;cursor: default;} .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration: default;color: orange !important; /* or whatever your want */
                pointer-events: auto;cursor: default;} } @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {a[href^="tel"], a[href^="sms"] {text-decoration: none;
                color: #00008b;  pointer-events: none;cursor: default;}.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration: default;color: orange !important; pointer-events: auto;
                cursor: default;}}@media only screen and (-webkit-min-device-pixel-ratio: 2) {} @media only screen and (-webkit-device-pixel-ratio: .75) {}@media only screen and (-webkit-device-pixel-ratio: 1) {}
        @media only screen and (-webkit-device-pixel-ratio: 1.5) {}h2 {color: #181818;font-family: Helvetica, Arial, sans-serif;font-size: 22px;line-height: 22px;font-weight: normal;}a.link1 {
        }a.link2 {color: #fff;text-decoration: none;font-family: Helvetica, Arial, sans-serif;font-size: 16px;color: #fff;border-radius: 4px;} p { color: #555; font-family: Helvetica, Arial, sans-serif;
            font-size: 16px;line-height: 160%; }</style><script type="colorScheme" class="swatch active">{"name":"Default","bgBody":"ffffff","link":"fff", "color":"555555", "bgItem":"ffffff",
    "title":"181818" } </script></head><body><table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class="bgBody"><tr><td><table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0">
                <tr><td><table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"><tr><td class="movableContentContainer bgItem"><div class="movableContent">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"><tr height="40"> <td width="200">&nbsp;</td><td width="200">&nbsp;</td><td width="200">&nbsp;</td>
</tr><tr><td width="200" valign="top">&nbsp;</td><td width="200" valign="top" align="center"><div class="contentEditableContainer contentImageEditable"><div class="contentEditable" align="center">
                                                         <img src="' . URL . 'img/logo.png" width="200"  alt="Logo" data-default="placeholder"/>
</div> </div></td><td width="200" valign="top">&nbsp;</td></tr><tr height="25"><td width="200">&nbsp;</td><td width="200">&nbsp;</td><td width="200">&nbsp;</td> </tr></table> </div>
 <div class="movableContent"><table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"> <tr><td width="100%" colspan="3" align="center" style="padding-bottom:10px;padding-top:25px;">
<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
                                                            <h2> $subject </h2>
</div> </div></td> </tr> <tr><td width="100">&nbsp;</td><td width="400" align="center"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="left">
                                                            <p>Hi,  <br/>
                                                                $in_message </p>
</div> </div> </td><td width="100">&nbsp;</td></tr></table><table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"><tr><td width="200">&nbsp;</td>
<td width="200" align="center" style="padding-top:25px;"><table cellpadding="0" cellspacing="0" border="0" align="center" width="200" height="50"><tr><td bgcolor="#00008b" align="center"
style="border-radius:4px;" width="200" height="50"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
</div></div></td></tr></table></td><td width="200">&nbsp;</td></tr></table></div><div class="movableContent"><table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
 class="container"><tr><td width="100%" colspan="2" style="padding-top:65px;"><hr style="height:1px;border:none;color:#333;background-color:#ddd;"/></td> </tr><tr> <td width="60%" height="70" valign="middle"
  style="padding-bottom:20px;"></td> <td width="40%" height="70" align="right" valign="top" align="right" style="padding-bottom:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"
  align="right"><tr><td width="57%"></td><td valign="top" width="34"> <div class="contentEditableContainer contentFacebookEditable" style="display:inline;"><div class="contentEditable">
                                                                             <a target="_blank" href="#"
                                                                             data-default="placeholder"
                                                                            style="text-decoration:none;">
                                                                            <img src="' . URL . 'img/facebook.png"
                                                                             data-default="placeholder"
                                                                             data-max-width="30" data-customIcon="true"
                                                                             width="30" height="30" alt="facebook"
                                                                             style="margin-right:40x;">
                                                                            </a>
</div></div></td><td valign="top" width="34"><div class="contentEditableContainer contentTwitterEditable" style="display:inline;"> <div class="contentEditable">
                                                                             <a target="_blank" href="#"
                                                                            data-default="placeholder"
                                                                           style="text-decoration:none;">
                                                                            <img src="' . URL . 'img/twitter.png"
                                                                             data-default="placeholder"
                                                                             data-max-width="30" data-customIcon="true"
                                                                             width="30" height="30" alt="twitter"
                                                                             style="margin-right:40x;">
                                                                            </a>
</div> </div></td> <td valign="top" width="34"><div class="contentEditableContainer contentImageEditable"  style="display:inline;"> <div class="contentEditable">
                                                                        <a target="_blank" href="#"
                                                                           data-default="placeholder"
                                                                           style="text-decoration:none;">
                                                                            <img src="' . URL . 'img/pinterest.png" width="30"
                                                                                 height="30" data-max-width="30"
                                                                                 alt="pinterest"
                                                                                 style="margin-right:40x;"/>
                                                                        </a>
</div></div></td></tr></table></td></tr></table></div></td> </tr> </table> </td></tr></table></td> </tr></table></body></html>
EOT;

        // Create the Transport
        $transport = (new \Swift_SmtpTransport(EmailServer, EmailPort))->setUsername(APP_EMAIL)->setPassword(APP_PWRD);

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message($subject))->setFrom(array(
            APP_EMAIL => 'Daystar Leadership Academy'
        ))
            ->setTo(array(
            $recipient_email => 'Me'
        ))
            ->setBody($message, 'text/html');

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }

    public function SendActivationEmail($first_name, $recipient_email, $in_message, $link, $subject = 'Daystar Leadership Academy - Activate Account')
    {
        $message = <<<EOT
    <!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Daystar Leadership Academy</title><style type="text/css">@media screen and (max-width: 600px) {table[class="container"] {width: 95% !important; }
        } #outlook a { padding: 0; } body { width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;margin: 0;padding: 0;}.ExternalClass { width: 100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}#backgroundTable {margin: 0;padding: 0;
            width: 100% !important;line-height: 100% !important;}img {outline: none; text-decoration: none;-ms-interpolation-mode: bicubic;} a img {border: none;} .image_fix {display: block;
        }p {margin: 1em 0;}h1, h2, h3, h4, h5, h6 { color: black !important;}h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: #00008b !important;} h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: red !important;} h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: #00008b !important;}table td {border-collapse: collapse; }table {
            border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;}a { color: #000; }@media only screen and (max-device-width: 480px) {a[href^="tel"], a[href^="sms"] {
                text-decoration: none;color: black; pointer-events: none;cursor: default;} .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration: default;color: orange !important; /* or whatever your want */
                pointer-events: auto;cursor: default;} } @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {a[href^="tel"], a[href^="sms"] {text-decoration: none;
                color: #00008b;  pointer-events: none;cursor: default;}.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration: default;color: orange !important; pointer-events: auto;
                cursor: default;}}@media only screen and (-webkit-min-device-pixel-ratio: 2) {} @media only screen and (-webkit-device-pixel-ratio: .75) {}@media only screen and (-webkit-device-pixel-ratio: 1) {}
        @media only screen and (-webkit-device-pixel-ratio: 1.5) {}h2 {color: #181818;font-family: Helvetica, Arial, sans-serif;font-size: 22px;line-height: 22px;font-weight: normal;}a.link1 {
        }a.link2 {color: #fff;text-decoration: none;font-family: Helvetica, Arial, sans-serif;font-size: 16px;color: #fff;border-radius: 4px;} p { color: #555; font-family: Helvetica, Arial, sans-serif;
            font-size: 16px;line-height: 160%; }</style><script type="colorScheme" class="swatch active">{"name":"Default","bgBody":"ffffff","link":"fff", "color":"555555", "bgItem":"ffffff",
    "title":"181818" } </script></head><body><table cellpadding="0" width="100%" cellspacing="0" border="0" id="backgroundTable" class="bgBody"><tr><td><table cellpadding="0" width="620" class="container" align="center" cellspacing="0" border="0">
                <tr><td><table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"><tr><td class="movableContentContainer bgItem"><div class="movableContent">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"><tr height="40"> <td width="200">&nbsp;</td><td width="200">&nbsp;</td><td width="200">&nbsp;</td>
</tr><tr><td width="200" valign="top">&nbsp;</td><td width="200" valign="top" align="center"><div class="contentEditableContainer contentImageEditable"><div class="contentEditable" align="center">
                                                         <img src="' . URL . 'img/logo.png" width="200"  alt="Logo" data-default="placeholder"/>
</div> </div></td><td width="200" valign="top">&nbsp;</td></tr><tr height="25"><td width="200">&nbsp;</td><td width="200">&nbsp;</td><td width="200">&nbsp;</td> </tr></table> </div>
 <div class="movableContent"><table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"> <tr><td width="100%" colspan="3" align="center" style="padding-bottom:10px;padding-top:25px;">
<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
                                                            <h2> $subject </h2>
</div> </div></td> </tr> <tr><td width="100">&nbsp;</td><td width="400" align="center"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="left">
                                                            <p>Hi  $first_name,
                                                                <br/>
                                                                <br/>
                                                                $in_message</p>
</div> </div> </td><td width="100">&nbsp;</td></tr></table><table cellpadding="0" cellspacing="0" border="0" align="center" width="600" class="container"><tr><td width="200">&nbsp;</td>
<td width="200" align="center" style="padding-top:25px;"><table cellpadding="0" cellspacing="0" border="0" align="center" width="200" height="50"><tr><td bgcolor="#00008b" align="center" 
style="border-radius:4px;" width="200" height="50"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
                                                                        <a target="_blank" href="' . $link . '" class="link2">ACTIVATE ACCOUNT</a>
</div></div></td></tr></table></td><td width="200">&nbsp;</td></tr></table></div><div class="movableContent"><table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
 class="container"><tr><td width="100%" colspan="2" style="padding-top:65px;"><hr style="height:1px;border:none;color:#333;background-color:#ddd;"/></td> </tr><tr> <td width="60%" height="70" valign="middle"
  style="padding-bottom:20px;"></td> <td width="40%" height="70" align="right" valign="top" align="right" style="padding-bottom:20px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"
  align="right"><tr><td width="57%"></td><td valign="top" width="34"> <div class="contentEditableContainer contentFacebookEditable" style="display:inline;"><div class="contentEditable">                                                                     
                                                                             <a target="_blank" href="#"
                                                                             data-default="placeholder"
                                                                            style="text-decoration:none;">
                                                                            <img src="' . URL . 'img/facebook.png"
                                                                             data-default="placeholder"
                                                                             data-max-width="30" data-customIcon="true"
                                                                             width="30" height="30" alt="facebook"
                                                                             style="margin-right:40x;">
                                                                            </a>
</div></div></td><td valign="top" width="34"><div class="contentEditableContainer contentTwitterEditable" style="display:inline;"> <div class="contentEditable">
                                                                             <a target="_blank" href="#" 
                                                                            data-default="placeholder"
                                                                           style="text-decoration:none;">                                                            
                                                                            <img src="' . URL . 'img/twitter.png"
                                                                             data-default="placeholder"
                                                                             data-max-width="30" data-customIcon="true"
                                                                             width="30" height="30" alt="twitter"
                                                                             style="margin-right:40x;">
                                                                            </a>
</div> </div></td> <td valign="top" width="34"><div class="contentEditableContainer contentImageEditable"  style="display:inline;"> <div class="contentEditable"> 
                                                                        <a target="_blank" href="#"
                                                                           data-default="placeholder"
                                                                           style="text-decoration:none;">
                                                                            <img src="' . URL . 'img/pinterest.png" width="30"
                                                                                 height="30" data-max-width="30"
                                                                                 alt="pinterest"
                                                                                 style="margin-right:40x;"/>
                                                                        </a>
</div></div></td></tr></table></td></tr></table></div></td> </tr> </table> </td></tr></table></td> </tr></table></body></html>
EOT;

        // Create the Transport
        $transport = (new \Swift_SmtpTransport(EmailServer, EmailPort))->setUsername(APP_EMAIL)->setPassword(APP_PWRD);

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message($subject))->setFrom(array(
            APP_EMAIL => 'Daystar Leadership Academy'
        ))
            ->setTo(array(
            $recipient_email => 'Me'
        ))
            ->setBody($message, 'text/html');

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }
}
