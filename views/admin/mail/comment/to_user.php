<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><ion:lang key="module_comments_mail_user_subject" /></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="<ion:current_lang />" />
        <style type="text/css">
            body{
                color: #000;
                font-family: arial, verdana, sans-serif;
                font-size: 10pt;
                line-height: 1.2em;
                background-color: #fff;
            }
            h1{
                display: block;
                color: #2563A1;
                font-family: arial, verdana, sans-serif;
                font-size: 14pt;
                text-align: left;
                line-height: 1.2em;
                font-weight: normal;
            }
            p{margin-bottom: 10px;}
            a:link, a:visited, a:active, a:hover{
                color: #098ED1;
                text-decoration: underline;
                font-weight: normal;
            }
            a:hover	{
                color: #2563A1;
                text-decoration: none;
            }
        </style>
    </head>
    <body>

        <table border="0" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="bg_fade">
                    <table border="0" width="880">
                        <tr>
                            <td>

                                <h1><ion:data:lang key="module_comments_form_user_dear" swap="data::author" /></h1>

                                <p><ion:data:lang key="form_contact_mail_view_user_message" /></p>

                                <p><ion:lang key="form_contact_mail_view_global_thanks" swap="global::site_title" /></p>

                                <p><?= base_url() ?></p>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>