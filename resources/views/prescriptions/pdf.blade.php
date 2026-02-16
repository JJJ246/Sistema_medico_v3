<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Receta Médica - {{ $prescription->id }}</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            color: #333;
            line-height: 1.5;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2.5cm;
            background-color: #f8fafc; /* Slate-50 */
            border-bottom: 2px solid #10b77f; /* Primary Green */
            padding: 0.5cm 2cm;
            display: flex;
            align-items: center;
        }
        .header-content {
            width: 100%;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a; /* Slate-900 */
        }
        .logo span {
            color: #10b77f;
        }
        .date {
            float: right;
            font-size: 14px;
            color: #64748b;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-block {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b; /* Slate-500 */
            font-weight: bold;
            margin-bottom: 2px;
        }
        .value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .rx-section {
            margin-top: 40px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            position: relative;
        }
        .rx-symbol {
            position: absolute;
            top: -20px;
            left: 20px;
            background-color: #fff;
            padding: 0 10px;
            font-size: 32px;
            font-weight: bold;
            color: #10b77f;
            font-family: serif;
        }
        .medication-name {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 10px;
        }
        .medication-detail {
            font-size: 14px;
            color: #334155;
            margin-top: 5px;
        }
        .sub-details {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #cbd5e1;
            font-size: 13px;
        }
        .footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            line-height: 2cm; /* Vertically center text */
            font-size: 12px;
            color: #94a3b8;
        }
        .signature-box {
            margin-top: 80px;
            text-align: right;
            padding-right: 20px;
        }
        .signature-line {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #0f172a;
            text-align: center;
            padding-top: 5px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <span class="logo">Salud<span>Conectada</span></span>
            <div class="date">Fecha: {{ $prescription->created_at->format('d/m/Y') }}</div>
        </div>
    </header>

    <table class="info-grid">
        <tr>
            <td class="info-block">
                <div class="label">Doctor Prescriptor</div>
                <div class="value">Dr. {{ $prescription->doctor->name }}</div>
                <div class="label">Especialidad</div>
                <div class="value">Medicina General</div>
            </td>
            <td class="info-block" style="text-align: right;">
                <div class="label">Paciente</div>
                <div class="value">{{ $prescription->patient->name }}</div>
                <div class="label">ID Paciente (MRN)</div>
                <div class="value">{{ $prescription->patient->mrn ?? 'N/A' }}</div>
            </td>
        </tr>
    </table>

    <div class="rx-section">
        <div class="rx-symbol">Rx</div>
        
        <div class="medication-name">
            {{ $prescription->medication->name }}
        </div>
        <div class="medication-detail">
            <strong>Dosis:</strong> {{ $prescription->medication->strength ?? $prescription->medication->dosage ?? 'N/A' }}
        </div>
        
        <div class="sub-details">
            <p><strong>Frecuencia:</strong> {{ $prescription->frequency }}</p>
            <p><strong>Duración:</strong> {{ $prescription->duration_days }} días</p>
            <p><strong>Cantidad Total:</strong> {{ $prescription->total_quantity }} unidades</p>
            <br>
            <p><strong>Instrucciones:</strong></p>
            <p style="font-style: italic;">{{ $prescription->instructions ?? 'Seguir indicaciones médicas.' }}</p>
        </div>
    </div>

    <div class="signature-box">
        <div class="signature-line">
            Firma del Doctor<br>
            <span style="font-weight: normal; font-size: 10px;">Licencia: {{ rand(10000, 99999) }}</span>
        </div>
    </div>

    <div class="footer">
        SaludConectada - Sistema de Gestión Médica Integral - Generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
