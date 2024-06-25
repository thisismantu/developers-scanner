<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Password Reset </title>
    <style>
        p {
            font-size: 15px;
        }

        body {
            background-color: #f7f7f7;
        }
    </style>

</head>

<body>
    <table width="100%" bgcolor="#f7f7f7" cellpadding="0" cellspacing="0" border="0"
        style="border-collapse:collapse; border-spacing:0">
        <tbody>
            <tr>
                <td style="padding-top:22px;">
                    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0"
                        style=" background:#FFF;">
                        <tbody>
                            <tr>
                                <td style="background:#FFF;padding:14px 0;">
                                    <table width="95%;" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="width:90px; padding-bottom:21px; text-align:center;"
                                                    colspan="2">
                                                    <img src="https://efi-s3-private.s3.ap-south-1.amazonaws.com/sign/mail-logo.png"
                                                    alt="{{ Config('app.name') }}"  style="width:50%;">
                                                </td>
                                                <td
                                                    style="font-size:16px; color:#000; text-align:right; font-family: 'Assistant', sans-serif;">
                                                    &nbsp; </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 13px 13px 13px; border-bottom:1px solid #e4dede;">
                                    <p style="font-size:17px; color:#000; font-family: 'Assistant', sans-serif;">Hi
                                        Customer, </p>

                                    <p
                                        style="font-size:14px; line-height:22px; color:#727272; font-family: 'Assistant', sans-serif;">
                                        You're receiving this email because you requested a password reset for your
                                        account. Click on the link below to reset your password.</p>
                                    <p
                                        style="font-size:14px; line-height:22px; color:#727272; font-family: 'Assistant', sans-serif;">
                                        If you have received this email in error, or that an unauthorized person has
                                        accessed your account, please go to 'My Account 'page to reset your password.
                                    </p>
                                    <p
                                        style="font-size:14px; line-height:22px; color:#727272; font-family: 'Assistant', sans-serif;">
                                        <strong> Link: </strong> <a href="{{Third_party_URL($actionUrl)}}" target="_blank" style="color:#0349a5;">
                                            [{{ $displayableActionUrl }}] </a> </p>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align:center; padding:9px; background:#e7e7e7; font-family:'Assistant', sans-serif;">
                                    <p style="margin-bottom:0;"><a href="#"
                                            style="color: #434343; text-decoration:none;"> Contact Us </a> </p>
                                    <p style="margin:8px; color: #434343;"> +91-9311342200 | <a href="#"
                                            style="color:#0349a5;"> care@obsessions.co.in </a> ( Monday to Saturday,
                                        11AM-6PM)</p>
                                    <p style="margin-top: 8px;"><a href="#"
                                            style="text-decoration:none; color:#0349a5;"> www.obsessions.co.in </a> </p>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>