<?php 
$email_boton = '
<a href="'.$link.'" style="display: block; text-decoration: none; -webkit-text-size-adjust: none; text-align: center; color: #ffffff; background-color: #3AAEE0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; max-width: 169px; width: 85px; width: auto; border-top: 0px solid transparent; border-right: 0px solid transparent; border-bottom: 0px solid transparent; border-left: 0px solid transparent; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif; mso-border-alt: none" target="_blank" rel="noreferrer">
  <span style="font-size: 12px; line-height: 24px"><span style="font-size: 20px; line-height: 40px">'.$link_text.'</span></span>
</a>
<br>';
$html_mail='<!DOCTYPE html>
<html lang="en" class="w-grey" style="min-height: 100%; font-family: Helvetica, Arial, sans-serif !important; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; position: relative; box-sizing: border-box; font-size: 12px; width: 100%; background: #fff; margin: 0;">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description">
        <meta name="author">
        <title>Gente de caña - correo de bienvenida</title>
        <meta name="viewport" content="width=device-width" />
       <style type="text/css">
            .text-right{
                text-align: right !important;
            }
            .text-center{
                text-aling:center !important;
            }
            p{
                line-height: 21px !important;
            }
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #e74c3c; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 700px !important; }
                .col387 { width: 387px !important; }
            }
        </style>
    </head>
    <body bgcolor="#000" style="margin: 0; padding: 0;" yahoo="fix">
    <center><p style="color: #394049; margin: 0px; padding: 0px; height: 0px;">Sistema creado por oskrgl</p></center> <div style="background: #eee;">
        <!--[if (gte mso 9)|(IE)]>
        <table width="700" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td>
        <![endif]-->
        <table align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 100%;" class="content">
            <tr>
                <td align="center" bgcolor="#394049" style="padding: 30px 20px 30px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="https://estudioagil.com/gentedecaa19a/sys/img/logo.png" alt="Logo" width="192" height="auto" style="display:block;" />
                    
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 25px; border-bottom: 1px solid #f6f6f6;">
                    '.$html_mail_titulo.'
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#f9f9f9" style="padding: 20px 20px 0 20px; color: #394049; font-family: Arial, sans-serif; font-size: 20px; line-height: 10px;">
                    '.$html_mail_cuerpo.'
                    '.$email_boton.'
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                   &copy;'.date(Y).' TODOS LOS DERECHOS RESERVADOS POR <a href="#" style="color: #e74c3c;">'.$template['name'].'</a>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </div>
    </body>
</html>';