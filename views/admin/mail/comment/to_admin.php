<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><ion:lang key="module_comments_mail_admin_subject" /></title>
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
                                <h1><ion:data:lang key="module_comments_form_admin_dear_site_administrator" /></h1>

                                <p><ion:lang key="module_comments_form_admin_have_new_message" /></p>

                                <p><ion:data:lang key="module_comments_form_admin_message" swap="data::author, data::email, global::site_title" autolink="false" /></p>

                                <p>
                                    <ion:lang key="module_comments_label_author"/> : <b><ion:data:author /></b>, <br/>
                                    <ion:lang key="module_comments_label_email"/> : <b><ion:data:email /></b> <br/>
                                    <ion:lang key="module_comments_label_site"/> : <b><ion:data:site /></b> <br/>
                                    <ion:lang key="module_comments_label_content"/> : <b><ion:data:content /></b> <br/>
                                </p>

                                <p><ion:lang key="module_comments_form_thanks" swap="global::site_title" /></p>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>