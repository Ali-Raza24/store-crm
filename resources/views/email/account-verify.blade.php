<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Email Template</title>
    <style type="text/css">
        /* RESET STYLES */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        html {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            color: #1d262f;
            font-family: 'Poppins', sans-serif;
        }

        body,
        #bodyTable,
        #bodyCell,
        #bodyCell {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
            font-family: 'Poppins', sans-serif;

        }

        table[id=bodyTable] {
            width: 100% !important;
            margin: auto;
            max-width: 500px !important;
            color: #1d262f;
            font-weight: normal;
        }

        img,
        a img {
            border: 0;
            outline: none;
            text-decoration: none;
            height: auto;
            line-height: 100%;
        }

        a {
            text-decoration: none !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #1d262f;
            font-weight: normal;
            font-family: Helvetica;
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            line-height: 125%;
            text-align: Left;
            letter-spacing: normal;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            padding-top: 0;
            padding-bottom: 0;
            padding-left: 0;
            padding-right: 0;
        }

        /* CLIENT-SPECIFIC STYLES */
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        /* Force Hotmail/Outlook.com to display emails at full width. */
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }

        /* Force Hotmail/Outlook.com to display line heights normally. */
        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /* Remove spacing between tables in Outlook 2007 and up. */
        #outlook a {
            padding: 0;
        }

        /* Force Outlook 2007 and up to provide a "view in browser" message. */
        img {
            -ms-interpolation-mode: bicubic;
            display: block;
            outline: none;
            text-decoration: none;
        }

        /* Force IE to smoothly render resized images. */
        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            font-weight: normal !important;
        }

        /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
        .ExternalClass td[class="ecxflexibleContainerBox"] h3 {
            padding-top: 10px !important;
        }

        /* Force hotmail to push 2-grid sub headers down */

        /* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

        /* ========== Page Styles ========== */
        h1 {
            display: block;
            font-size: 26px;
            font-style: normal;
            font-weight: normal;
            line-height: 100%;
        }

        h2 {
            display: block;
            font-size: 20px;
            font-style: normal;
            font-weight: normal;
            line-height: 120%;
        }

        h3 {
            display: block;
            font-size: 17px;
            font-style: normal;
            font-weight: normal;
            line-height: 110%;
        }

        h4 {
            display: block;
            font-size: 18px;
            font-weight: normal;
            line-height: 100%;
        }

        .flexibleImage {
            height: auto;
        }

        .linkRemoveBorder {
            border-bottom: 0 !important;
        }

        table[class=flexibleContainerCellDivider] {
            padding-bottom: 0 !important;
            padding-top: 0 !important;
        }

        body,
        #bodyTable {
            background-color: #ffffff;
        }

        #invisibleIntroduction {
            display: none !important;
        }

        /* Removing the introduction text from the view */

        /*FRAMEWORK HACKS & OVERRIDES */
        span[class=ios-color-hack] a {
            color: #1d262f !important;
            text-decoration: none !important;
        }

        /* Remove all link colors in IOS (below are duplicates based on the color preference) */
        span[class=ios-color-hack2] a {
            color: #1d262f !important;
            text-decoration: none !important;
        }

        span[class=ios-color-hack3] a {
            color: #1d262f !important;
            text-decoration: none !important;
        }

        /* A nice and clean way to target phone numbers you want clickable and avoid a mobile phone from linking other numbers that look like, but are not phone numbers.  Use these two blocks of code to "unstyle" any numbers that may be linked.  The second block gives you a class to apply with a span tag to the numbers you would like linked and styled.
                    Inspired by Campaign Monitor's article on using phone numbers in email: http://www.campaignmonitor.com/blog/post/3571/using-phone-numbers-in-html-email/.
                    */
        .a[href^="tel"],
        a[href^="sms"] {
            text-decoration: none !important;
            color: #1d262f !important;
            pointer-events: none !important;
            cursor: default !important;
        }

        .mobile_link a[href^="tel"],
        .mobile_link a[href^="sms"] {
            text-decoration: none !important;
            color: #1d262f !important;
            pointer-events: auto !important;
            cursor: default !important;
        }

        img {
            width: 100%;
        }

        /* MOBILE STYLES */
        @media only screen and (max-width: 480px) {

            /*////// CLIENT-SPECIFIC STYLES //////*/
            body {
                width: 100% !important;
                min-width: 100% !important;
            }

            table[id="emailHeader"],
            table[id="emailBody"],
            table[id="emailFooter"],
            table[class="flexibleContainer"],
            td[class="flexibleContainerCell"] {
                width: 100% !important;
            }

            td[class="flexibleContainerBox"],
            td[class="flexibleContainerBox"] table {
                display: block;
                width: 100%;
                text-align: left;
            }

            td[class="imageContent"] img {
                height: auto !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            img[class="flexibleImage"] {
                height: auto !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            img[class="flexibleImageSmall"] {
                height: auto !important;
                width: auto !important;
            }

            table[class="flexibleContainerBoxNext"] {
                padding-top: 10px !important;
            }

            table[class="emailButton"] {
                width: 100% !important;
            }

            td[class="buttonContent"] {
                padding: 0 !important;
            }

            td[class="buttonContent"] a {
                padding: 15px !important;
            }
        }

        /*  CONDITIONS FOR ANDROID DEVICES ONLY
            *   http://developer.android.com/guide/webapps/targeting.html
            *   http://pugetworks.com/2011/04/css-media-queries-for-targeting-different-mobile-devices/ ;
            =====================================================*/

        @media only screen and (-webkit-device-pixel-ratio: .75) {
            /* Put CSS for low density (ldpi) Android layouts in here */
        }

        @media only screen and (-webkit-device-pixel-ratio: 1) {
            /* Put CSS for medium density (mdpi) Android layouts in here */
        }

        @media only screen and (-webkit-device-pixel-ratio: 1.5) {
            /* Put CSS for high density (hdpi) Android layouts in here */
        }

        /* end Android targeting */

        /* CONDITIONS FOR IOS DEVICES ONLY
                    =====================================================*/
        @media only screen and (min-device-width: 320px) and (max-device-width: 568px) {
        }

        /* end IOS targeting */
    </style>
</head>

<body bgcolor="#ffffff" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

<center style="background-color:#ffffff;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable"
           style="table-layout: fixed;max-width:100% !important;width: 600px!important; display: block;">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <table bgcolor="#f2f2f2" border="0" cellpadding="0" cellspacing="0" width="600" id="emailBody"
                       style="margin-left: auto; margin-right: auto;">
                    <!--logo-->
                    <tr>
                        <td valign="top" align="center" style="padding: 20px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tbody>
                                <tr>
                                    <td align="center" valign="middle"
                                        style="background: #1d262f; height: 100px;">
                                        <img src="{{asset('email-asset/logo.png')}}" alt="image"
                                                 style="height: 56px; width:auto">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="center" style="padding: 0 60px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tbody>
                                <tr style="text-align: center">
                                    <td align="center" valign="top"
                                        style="">
                                        <h4
                                                style="color: #1d262f; line-height: 124.95%; font-size: 18px; font-weight: bold;">
                                            Verify Your Email Address
                                        </h4>
                                        <p
                                                style="font-size: 14px; color: #1d262f; font-weight: 400; margin: 0 0 22px 0;">
                                            Please confirm that you want to use this as your Yabee account email address. Once its done you will be able to start selling!.</p>
                                        <div style="width: 100%;">
                                            <div style="text-align: center;">
                                                <a href="{{$url}}"
                                                   style="display: inline-block; background: #21B6A8; color: #1d262f; border-radius: 5px; font-size: 14px; font-weight: 700 !important; line-height: 40px; height: 40px; width: 100%; text-align: center;">
                                                    Verify My Email
                                                </a>
                                            </div>
                                        </div>

                                        <p>If that doesn't work, copy and paste the following link in your browser</p>
                                        <p style="word-break: break-word;">{{$url}}</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="center" style="padding: 0 60px;">
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center"
                                   style="padding-top: 15px;">
                                <tbody>
                                <tr>
                                    <td align="center" valign="top"
                                        style="background: #ffffff; border-radius: 10px; padding: 30px 20px 40px 20px;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0"
                                               align="center">
                                            <tbody>
                                            <tr>
                                                <td valign="top" align="center" style="padding: 0 60px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0"
                                                           border="0" align="center">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" valign="top"
                                                                style=" padding: 30px 0 0 0;">
                                                                <h4
                                                                        style="color: #1d262f; line-height: 124.95%; font-size: 18px; font-weight: bold; text-align: center;">
                                                                    Need help?
                                                                </h4>
                                                                <p
                                                                        style="font-size: 12px; color: #7d8996; font-weight: 500; margin: 20px 0 10px 0; text-align: center; width: 340px;">
                                                                    If you have any questions, just
                                                                    reply to this email - we’re always
                                                                    happy to help out.
                                                                </p>
                                                                <a href="#."
                                                                   style="display: block; font-size: 12px; color: #21B6A8; font-weight: 500; margin: 0 0 0 0; text-align: center;">info@yabee.me</a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center" style="padding: 0;">
                                                    <table width="100%" cellspacing="0" cellpadding="0"
                                                           border="0" align="center">
                                                        <tbody>
                                                        <tr style="width: 100%;">
                                                            <td align="left" valign="top">
                                                                <div
                                                                        style="background: #cacaca;height: 2px; width: 100%; margin: 45px 0 20px 0 ;">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center" style="padding: 0 60px;">
                                                    <table width="100%" cellspacing="0" cellpadding="0"
                                                           border="0" align="center">
                                                        <tbody>
                                                        <tr style="width: 100%;">
                                                            <td align="left" valign="top">
                                                                <div
                                                                        style="width: 100%; text-align: center;">
                                                                    <a href="#."
                                                                       style="display: inline-block; height: 27px; width: 27px; margin: 5px;">
                                                                        <img alt=""
                                                                             src="{{asset('email-asset/facebook.png')}}"
                                                                             style="width: 100%;">
                                                                    </a>
                                                                    <a href="#."
                                                                       style="display: inline-block; height: 27px; width: 27px; margin: 5px;">
                                                                        <img alt=""
                                                                             src="{{asset('email-asset/insta.png')}}"
                                                                             style="width: 100%;">
                                                                    </a>
                                                                    <a href="#."
                                                                       style="display: inline-block; height: 27px; width: 27px; margin: 5px;">
                                                                        <img alt=""
                                                                             src="{{asset('email-asset/youtube.png')}}"
                                                                             style="width: 100%;">
                                                                    </a>
                                                                    <a href="#."
                                                                       style="display: inline-block; height: 27px; width: 27px; margin: 5px;">
                                                                        <img alt=""
                                                                             src="{{asset('email-asset/twitter.png')}}"
                                                                             style="width: 100%;">
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" align="center"
                                                    style="padding: 0 0 10px 0;">
                                                    <table width="100%" cellspacing="0" cellpadding="0"
                                                           border="0" align="center">
                                                        <tbody>
                                                        <tr style="width: 100%;">
                                                            <td align="left" valign="top">
                                                                <div
                                                                        style="width: 100%; text-align: center;">
                                                                    <a href="#."
                                                                       style="display: inline-block; margin: 5px; color: #a0a0a0; font-size: 12px;">
                                                                        About Us
                                                                    </a>
                                                                    <a href="#."
                                                                       style="display: inline-block; margin: 5px; color: #a0a0a0; font-size: 12px;">
                                                                        Terms & Condition
                                                                    </a>
                                                                    <a href="#."
                                                                       style="display: inline-block; margin: 5px; color: #a0a0a0; font-size: 12px;">
                                                                        Privacy Policy
                                                                    </a>
                                                                    <a href="#."
                                                                       style="display: inline-block; margin: 5px; color: #a0a0a0; font-size: 12px;">
                                                                        Powered by Yabee
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </td>
                    </tr>
                </table>
</center>
</body>

</html>
