<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Diario de Prácticas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }

        .info-box {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-box td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .info-box .title {
            background-color: #f1f5f9;
            font-weight: bold;
            width: 25%;
        }

        .tabla-diario {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .tabla-diario th {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .tabla-diario td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .firmas {
            width: 100%;
            margin-top: 50px;
            text-align: center;
        }

        .firmas td {
            width: 33%;
            padding-top: 50px;
        }

        .linea-firma {
            border-top: 1px solid #000;
            margin: 0 20px;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Diario Oficial de Prácticas</h1>
        <p>Informe de seguimiento de Formación en Centros de Trabajo (FCT)</p>
    </div>

    <table class="info-box">
        <tr>
            <td class="title">Alumno/a:</td>
            <td>{{ Auth::user()->name }}</td>
            <td class="title">Empresa:</td>
            <td>{{ $candidatura->oferta->user->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="title">Tutor Académico:</td>
            <td>{{ Auth::user()->tutor->name ?? 'N/A' }}</td>
            <td class="title">Proyecto/Puesto:</td>
            <td>{{ $candidatura->oferta->titulo ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="title">Horas Realizadas:</td>
            <td style="color: #10b981; font-weight: bold;">{{ $horasRealizadas }}h</td>
            <td class="title">Horas Asignadas:</td>
            <td>{{ $candidatura->horas_totales }}h</td>
        </tr>
    </table>

    <table class="tabla-diario">
        <thead>
            <tr>
                <th style="width: 12%;">Fecha</th>
                <th style="width: 8%;">Horas</th>
                <th style="width: 15%;">Modalidad</th>
                <th>Actividad Realizada</th>
            </tr>
        </thead>
        <tbody>
            @if($jornadas->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">No hay jornadas registradas.</td>
            </tr>
            @else
            @foreach($jornadas as $jornada)
            <tr>
                <td>{{ \Carbon\Carbon::parse($jornada->fecha)->format('d/m/Y') }}</td>
                <td style="text-align: center;">{{ $jornada->horas }}</td>
                <td style="text-transform: capitalize;">{{ $jornada->modalidad }}</td>
                <td>{{ $jornada->actividad }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    <table class="firmas">
        <tr>
            <td>
                <div class="linea-firma">Firma del Alumno/a</div>
            </td>
            <td>
                <div class="linea-firma">Firma del Tutor/a de Empresa</div>
            </td>
            <td>
                <div class="linea-firma">Firma del Tutor/a Académico</div>
            </td>
        </tr>
    </table>

</body>

</html>