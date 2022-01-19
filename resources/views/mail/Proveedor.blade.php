<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .mail {
        position: relative;
        height: 100vh;
        width: 100%;
        overflow: hidden;
        margin: 0;
        background-color: #fff;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
        font-family: 'Muli', sans-serif;
        font-weight: lighter;
        text-transform: uppercase;
        font-size: 0.75em;
        margin: 0 auto;
    }

    .table {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        position: absolute;
        border-collapse: collapse;
        border: none;
        border: royalblue 3px solid;
    }

    .table-body {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        padding: 5px;
    }

    .h4 {
        opacity: 0.6;
        margin: 0;
        letter-spacing: 1px;
        font-size: 0.75em;
        text-transform: uppercase;
    }

    .mail-box{
        text-align: justify;
        opacity: 0.8;
        padding-left: 20px;
        padding-right: 15px;
    }

    .datos{
        font-size: 1.1em;
        font-family: 'Muli', sans-serif;
        color: #0369A1;
        opacity: 1;
    }

    .link{
        margin-top: 23px;
        margin-bottom: 0px;
        font-size: 14px;
        font-family: Arial, sans-serif;
        color: #0284C7;
    }

</style>

<body>
    <section>
        <div style="position: relative; height: 100vh; width: 100%; overflow: hidden; margin: 0; background-color: #fff; box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2); font-family: 'Muli', sans-serif; font-weight: lighter; text-transform: uppercase; font-size: 0.75em; margin: 0 auto;">
            <table class="table">
                <tbody>
                <tr style="background: royalblue; color: white; font-size: 18px;">
                    <th>Solicitud de Pedido</th>
                </tr>
                <tr>
                    <th>
                    <table class="table-body">
                        <tbody>
                        <tr style="text-align: left;">
                            <th><h3 style="opacity: 0.8; margin: 0; text-align: left; font-size: 0.75em; text-transform: uppercase;">Buen día.</h3></th>
                        </tr>
                        <tr>
                            <th style="text-align: justify; text-transform: uppercase; opacity: 0.8; padding-left: 20px; padding-right: 15px;">
                            <p>Importante anotar los siguientes datos y anotarlos en la documentacion que lleve en su proxima
                                visita a la empresa</p>
                                <ul>
                                    <li>Número de requisición: <span style="font-size: 1.1em; font-family: 'Muli', sans-serif; color: #0369A1; opacity: 1;">{{ $Req[0]->NumReq }}</span> </li>
                                    <li>Orden de Compra: <span style="font-size: 1.1em; font-family: 'Muli', sans-serif; color: #0369A1; opacity: 1;">{{ $Req[0]->OrdenCompra }}</span></li>
                                </ul>
                            </th>
                        </tr>
                        <th style="text-align: justify; text-transform: uppercase; opacity: 0.8; padding-left: 20px; padding-right: 15px;">
                            <p>No responder a este correo</p>
                        </th>
                        <tr>
                            <td>
                                <p style="margin-top: 23px; margin-bottom: 0px; font-size: 14px; font-family: Arial, sans-serif; text-aling: center; color: #0284C7;">&reg; HilaturasLosAngeles<br/><a href="http://hilaturaslosangeles.com/" style="color: #ffffff; text-decoration: underline"></a></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
