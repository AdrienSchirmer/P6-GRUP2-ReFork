<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Confirmació de Cita</title>
</head>
<body style="margin:0; padding:0; background:#f3f4f6; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden;">

    <!-- HEADER -->
    <tr>
        <td style="background:#0f5f7f; color:#ffffff; padding:20px;">
            <table width="100%">
                <tr>
                    <td style="vertical-align:middle;">
                        <img
                    src="{{ storage_path('app/public/FarmaciaSolerLogoTallDark.png') }}"
                    alt="Logo Farmàcia Soler"
                    style="height: 52px; width: auto; object-fit: contain;"
                />
                    </td>
                    <td align="right" style="vertical-align:middle;">
                        <span style="background:#dcfce7; color:#166534; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:bold;">
                            Reserva Confirmada
                        </span>
                    </td>
                </tr>
            </table>

            <p style="margin:10px 0 0; font-size:12px; opacity:0.9;">
                {{ $data['address'] }} · Tel. {{ $data['phone'] }}
            </p>
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:20px;">

            <p style="margin:0 0 10px; font-size:14px;">
                Hola <strong>{{ $data['name'] }}</strong>,
            </p>

            <p style="margin:0 0 20px; font-size:13px; color:#555;">
                La teva cita ha estat confirmada correctament.
            </p>

            <!-- TWO COLUMN -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>

                    <!-- LEFT -->
                    <td width="50%" style="padding-right:8px; vertical-align:top;">

                        <p style="font-size:11px; color:#64748b; font-weight:bold; text-transform:uppercase; border-bottom:1px solid #e2e8f0; padding-bottom:5px;">
                            Detalls de la Cita
                        </p>

                        <table width="100%" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px; font-size:12px;">
                            <tr>
                                <td style="color:#64748b;">Servei</td>
                                <td align="right" style="font-weight:bold; color:#0f5f7f;">
                                    {{ $data['service_name'] }}
                                </td>
                            </tr>
                            <tr>
                                <td style="color:#64748b;">Durada</td>
                                <td align="right">{{ $data['duration'] }}</td>
                            </tr>
                            <tr>
                                <td style="color:#64748b;">Data</td>
                                <td align="right">{{ $data['date'] }}</td>
                            </tr>
                            <tr>
                                <td style="color:#64748b;">Hora</td>
                                <td align="right">{{ $data['time'] }}</td>
                            </tr>
                        </table>

                    </td>

                    <!-- RIGHT -->
                    <td width="50%" style="padding-left:8px; vertical-align:top;">

                        <p style="font-size:11px; color:#64748b; font-weight:bold; text-transform:uppercase; border-bottom:1px solid #e2e8f0; padding-bottom:5px;">
                            Dades del Client
                        </p>

                        <table width="100%" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px; font-size:12px;">
                            <tr>
                                <td style="color:#64748b;">Nom</td>
                                <td align="right" style="font-weight:bold;">
                                    {{ $data['name'] }}
                                </td>
                            </tr>
                            <tr>
                                <td style="color:#64748b;">Correu</td>
                                <td align="right">
                                    {{ $data['email'] }}
                                </td>
                            </tr>
                        </table>

                    </td>

                </tr>
            </table>

            <!-- NOTICE -->
            <div style="margin-top:20px; background:#fefce8; border:1px solid #fde68a; border-left:4px solid #f59e0b; padding:12px; font-size:12px; color:#92400e;">
                <strong>Recordeu:</strong> Si no podeu assistir, cancel·leu amb almenys 24 hores d'antelació.
            </div>

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="text-align:center; padding:15px; font-size:11px; color:#94a3b8; border-top:1px solid #e2e8f0;">
            Document generat automàticament per {{ $data['pharmacy'] }}<br>
            {{ now()->format('d/m/Y H:i') }}
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>