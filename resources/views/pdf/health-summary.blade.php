<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Summary - {{ $patient->mrn ?? 'Patient ' . $patient->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        
        .header {
            border-bottom: 3px solid #1e40af;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .patient-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .patient-info h2 {
            color: #1e40af;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px;
            width: 30%;
            color: #555;
        }
        
        .info-value {
            display: table-cell;
            padding: 8px;
        }
        
        .metrics {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .metric-card {
            display: table-cell;
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            width: 33%;
        }
        
        .metric-card + .metric-card {
            padding-left: 10px;
        }
        
        .metric-value {
            font-size: 32px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px;
        }
        
        .metric-label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section h3 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th {
            background-color: #1e40af;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background-color: #10b981;
            color: white;
        }
        
        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }
        
        .badge-danger {
            background-color: #ef4444;
            color: white;
        }
        
        .achievements {
            display: table;
            width: 100%;
        }
        
        .achievement-item {
            display: table-row;
        }
        
        .achievement-icon {
            display: table-cell;
            font-size: 24px;
            width: 40px;
            padding: 10px;
        }
        
        .achievement-details {
            display: table-cell;
            padding: 10px;
        }
        
        .achievement-title {
            font-weight: bold;
            color: #1e40af;
        }
        
        .achievement-desc {
            color: #666;
            font-size: 10px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Salud Conectada - Health Summary</h1>
        <div class="subtitle">Generated on {{ $generatedAt }}</div>
    </div>

    <!-- Patient Information -->
    <div class="patient-info">
        <h2>Patient Information</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Name:</div>
                <div class="info-value">{{ $patient->full_name ?? $patient->name }}</div>
            </div>
            @if($patient->mrn)
            <div class="info-row">
                <div class="info-label">MRN:</div>
                <div class="info-value">{{ $patient->mrn }}</div>
            </div>
            @endif
            @if($patient->diagnosis)
            <div class="info-row">
                <div class="info-label">Diagnosis:</div>
                <div class="info-value">{{ $patient->diagnosis }}</div>
            </div>
            @endif
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $patient->email }}</div>
            </div>
        </div>
    </div>

    <!-- Adherence Metrics -->
    <div class="metrics">
        <div class="metric-card">
            <div class="metric-value">{{ $weeklyScore }}%</div>
            <div class="metric-label">Weekly Adherence</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">{{ $streak }}</div>
            <div class="metric-label">Day Streak</div>
        </div>
        <div class="metric-card">
            <div class="metric-value">{{ $medications->count() }}</div>
            <div class="metric-label">Active Medications</div>
        </div>
    </div>

    <!-- Medications -->
    <div class="section">
        <h3>Current Medications</h3>
        <table>
            <thead>
                <tr>
                    <th>Medication</th>
                    <th>Dosage</th>
                    <th>SKU</th>
                    <th>Stock Status</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medications as $med)
                <tr>
                    <td><strong>{{ $med->name }}</strong></td>
                    <td>{{ $med->dosage }}</td>
                    <td>{{ $med->sku ?? 'N/A' }}</td>
                    <td>
                        @if($med->isCriticalStock())
                            <span class="badge badge-danger">CRITICAL ({{ $med->current_stock }} left)</span>
                        @elseif($med->isLowStock())
                            <span class="badge badge-warning">LOW ({{ $med->current_stock }} left)</span>
                        @else
                            <span class="badge badge-success">OK ({{ $med->current_stock }} left)</span>
                        @endif
                    </td>
                    <td>{{ $med->instructions ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Achievements -->
    @if($achievements->count() > 0)
    <div class="section">
        <h3>Achievements Earned</h3>
        <div class="achievements">
            @foreach($achievements as $achievement)
            <div class="achievement-item">
                <div class="achievement-icon">{{ $achievement->badge_icon }}</div>
                <div class="achievement-details">
                    <div class="achievement-title">{{ $achievement->title }}</div>
                    <div class="achievement-desc">{{ $achievement->description }} - Earned {{ $achievement->earned_at->format('M d, Y') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This document is confidential and intended solely for the use of the patient and their healthcare provider.</p>
        <p>Salud Conectada © {{ now()->year }}</p>
    </div>
</body>
</html>
