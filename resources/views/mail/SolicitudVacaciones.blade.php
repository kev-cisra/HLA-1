<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body, table, td, a {
        -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;
    }

    table, td {
        mso-table-lspace: 0pt; mso-table-rspace: 0pt;
    }

    img {
        -ms-interpolation-mode: bicubic;
    }

    img {
        border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;
    }

    table {
        border-collapse: collapse !important;
    }

    body {
        height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;
    }

    a[x-apple-data-detectors] {
        color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important;
    }

    div[style*="margin: 16px 0;"] {
        margin: 0 !important;
    }

</style>

<body style="background-color: #f7f5fa; margin: 0 !important; padding: 0 !important;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#426899" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="480" >
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
                            <div style="display: block; font-family: Arial Black; color: #ffffff; font-size: 18px;" border="0">HILATURAS LOS ANGELES</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#426899" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="480" >
                    <tr>
                        <td bgcolor="#ffffff" align="left" valign="top" style="padding: 20px 20px 10px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
                            <h1 style="font-size: 18px; font-weight: 600; margin: 0;">Hola!</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px; font-family: fantasy;">
                <table border="0" cellpadding="0" cellspacing="0" width="480" >
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr align="center">
                                    <td colspan="2" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 16px; font-weight: 400; line-height: 25px;">
                                        <p>Tienes una solicitud de aprovación de vacaciones</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:25px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 14px; font-weight: 600; line-height: 25px;">Núm Nómina: </th>
                                    <td align="left" valign="top" style="padding-left:1px;padding-right:30px;padding-bottom:10px;font-family: fantasy; font-size: 12px; font-weight: 500; line-height: 25px;"> {{ $Vac->IdEmp }} </td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:25px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 14px; font-weight: 600; line-height: 25px;">Nombre: </th>
                                    <td align="left" valign="top" style="padding-left:1px;padding-right:30px;padding-bottom:10px;font-family: fantasy; font-size: 12px; font-weight: 500; line-height: 25px;">{{ $Vac->Nombre }}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:25px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 14px; font-weight: 600; line-height: 25px;">Fecha Inicio: </th>
                                    <td align="left" valign="top" style="padding-left:1px;padding-right:30px;padding-bottom:10px;font-family: fantasy; font-size: 12px; font-weight: 500; line-height: 25px;">{{ $Vac->FechaInicio }}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:25px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 14px; font-weight: 600; line-height: 25px;">Fecha Fin: </th>
                                    <td align="left" valign="top" style="padding-left:1px;padding-right:30px;padding-bottom:10px;font-family: fantasy; font-size: 12px; font-weight: 500; line-height: 25px;">{{ $Vac->FechaFin }}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:25px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 14px; font-weight: 600; line-height: 25px;">Dias Solicitados: </th>
                                    <td align="left" valign="top" style="padding-left:1px;padding-right:30px;padding-bottom:10px;font-family: fantasy; font-size: 12px; font-weight: 500; line-height: 25px;">{{ $Vac->DiasTomados }} Dias</td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2" style="padding-top:25px; padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: fantasy; font-size: 16px; font-weight: 600; line-height: 30px;">
                                        <a style="text-decoration: none; cursor: pointer; color:#0284C7" href="https://intranethlangeles.com/RecursosHumanos/Vacaciones">Para autorizarlas visita la siguiente liga</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 0px 10px 10px 10px; border-top:1px solid #fff;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#fff">
                                                    <img src="data:image/png;base64,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">
                                                    <p style="margin-top: 23px; margin-bottom: 0px; font-size: 14px; font-family: Arial, sans-serif; text-aling: center; color: #0284C7;">&reg; HilaturasLosAngeles<br/><a href="http://hilaturaslosangeles.com/" style="color: #ffffff; text-decoration: underline"></a></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
