<!DOCTYPE html>
<html lang="fr" dir="ltr" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings xmlns:o="urn:schemas-microsoft-com:office:office">
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <style>
        td, th, div, p, a, h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", sans-serif;
            mso-line-height-rule: exactly;
        }

        .mso-break-all {
            word-break: break-all;
        }
    </style>
    <![endif]-->
    <title>{{ $subject ?? '' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Be+Vietnam+Pro:normal,italic,bold&display=swap" rel="stylesheet"
        media="screen">
    <style>
        .hover-bg-_f0aa0b:hover {
            background-color: #f0aa0b !important
        }

        @media (max-width: 600px) {
            .sm-p-6 {
                padding: 24px !important
            }

            .sm-px-6 {
                padding-left: 24px !important;
                padding-right: 24px !important
            }
        }
    </style>
</head>

<body
    style="margin: 0; width: 100%; background-color: #fefbe8; padding: 0; -webkit-font-smoothing: antialiased; word-break: break-word">
    <div role="article" aria-roledescription="email" aria-label="{{ $subject ?? '' }}" lang="fr" dir="ltr">
        <div
            style="background-color: #fefbe8; font-family: 'Be Vietnam Pro', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
            <table align="center" style="margin: 0 auto" cellpadding="0" cellspacing="0" role="none">
                <tr>
                    <td style="width: 600px; max-width: 100%; border: solid #f0aa0b; border-width: 8px 0 0">
                        <table style="width: 100%" cellpadding="0" cellspacing="0" role="none">
                            <tr>
                                <td class="sm-p-6"
                                    style="border-bottom-right-radius: 8px; border-bottom-left-radius: 8px; background-color: #fffffe; padding: 32px 36px">
                                    <div role="separator" style="line-height: 10px">&zwj;</div>
                                    <div style="width: 100%; text-align: center">
                                        @if ($internal)
                                            <a href="{{ config('app.url') }}">
                                                <img src="{{ getAppEmailLogoInternal() }}" width="210" height="auto"
                                                    alt="{{ getAppTitlePage() }}"
                                                    style="max-width: 100%; vertical-align: middle">
                                            </a>
                                        @else
                                            <a href="{{ getClientWebsite() }}">
                                                <img src="{{ getAppEmailLogoExternal() }}" width="100" height="auto"
                                                    alt="{{ getClientName() }}"
                                                    style="max-width: 100%; vertical-align: middle">
                                            </a>
                                        @endif
                                    </div>
                                    <div role="separator" style="line-height: 50px">&zwj;</div>
                                    <h1
                                        style="margin: 0 0 24px; font-size: 24px; line-height: 32px; font-weight: 600; color: #0f172a">
                                        {{ $greeting }}
                                    </h1>
                                    <div style="margin: 0 0 24px; font-size: 16px; line-height: 24px; color: #475569">
                                        {{ $content ?? '' }}
                                    </div>
                                    @if (!empty($btnLabel) && !empty($btnLink))
                                        <div style="text-align: center">
                                            <a href="{{ $btnLink }}"
                                                style="margin: 0 0 24px; display: inline-block; border-radius: 4px; background-color: #f0aa0b; padding: 16px 24px; font-size: 16px; line-height: 1; font-weight: 600; text-transform: capitalize; color: #f8fafc; text-decoration: none"
                                                class="hover-bg-_f0aa0b">
                                                <!--[if mso]>
                    <i style="mso-font-width: 150%; mso-text-raise: 30px" hidden>&emsp;</i>
                  <![endif]-->
                                                <span style="mso-text-raise: 16px">
                                                    {{ $btnLabel }}
                                                </span>
                                                <!--[if mso]>
                    <i hidden style="mso-font-width: 150%">&emsp;&#8203;</i>
                  <![endif]-->
                                            </a>
                                        </div>
                                    @endif
                                    @if (!empty($optionalEndText))
                                        <div
                                            style="margin: 0 0 24px; font-size: 16px; line-height: 24px; color: #475569">
                                            {{ $optionalEndText }}
                                        </div>
                                    @endif
                                    <div style="margin: 0; font-size: 16px; line-height: 24px; color: #475569">
                                        @if ($internal)
                                            {{ getAppSalutationsInternal() }}
                                        @else
                                            {{ getAppSalutationsExternal() }}
                                        @endif
                                    </div>
                                    @if (!empty($btnLabel) && !empty($btnLink))
                                        <div role="separator"
                                            style="height: 1px; line-height: 1px; margin-top: 24px; margin-bottom: 24px; background-color: #fefbe8">
                                            &zwj;
                                        </div>
                                        <p class="mso-break-all"
                                            style="margin: 0; font-size: 12px; line-height: 20px; color: #475569">
                                            @lang("If you're having trouble clicking the \":actionText\" button, copy and paste the URL below into your web browser:", ['actionText' => $btnLabel])
                                            <a href="{{ $btnLink }}"
                                                style="color: #1e293b; text-decoration: underline">{{ $btnLink }}</a>
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%" cellpadding="0" cellspacing="0" role="none">
                            <tr>
                                <td class="sm-px-6" style="padding: 24px 36px">
                                    <p style="margin: 0; text-align: center; font-size: 12px; color: #64748b">
                                        {{ getClientName() }}
                                        - {{ getClientAddress() }} {{ getClientPostalCode() }} {{ getClientCity() }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
