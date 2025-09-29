<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kelulusan - {{ $kelulusan->nama }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .certificate-container {
            background: white;
            border: 8px solid #d4af37;
            border-radius: 15px;
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: #4a90e2;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .certificate-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .certificate-subtitle {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .certificate-content {
            text-align: center;
            margin: 40px 0;
        }

        .certificate-text {
            font-size: 16px;
            line-height: 1.8;
            color: #34495e;
            margin-bottom: 30px;
        }

        .student-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            text-decoration: underline;
            text-decoration-color: #d4af37;
            text-decoration-thickness: 2px;
            margin: 20px 0;
        }

        .student-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
            border-left: 4px solid #4a90e2;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .detail-label {
            font-weight: bold;
            color: #2c3e50;
            min-width: 150px;
        }

        .detail-value {
            color: #34495e;
            flex: 1;
            text-align: right;
        }

        .certificate-footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        .signature-section {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            border-bottom: 2px solid #2c3e50;
            width: 200px;
            margin: 0 auto 10px;
            height: 50px;
        }

        .signature-label {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 10px;
        }

        .certificate-date {
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
            color: #7f8c8d;
        }

        .certificate-number {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #4a90e2;
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }

        .status-lulus {
            background: #27ae60;
            color: white;
        }

        .status-tidak-lulus {
            background: #e74c3c;
            color: white;
        }

        .status-mengulang {
            background: #f39c12;
            color: white;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
            }

            .certificate-container {
                margin: 0;
                box-shadow: none;
                border: 2px solid #d4af37;
            }
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="certificate-number">
            No: {{ $kelulusan->id }}/{{ $kelulusan->tahun_ajaran }}
        </div>

        <div class="certificate-header">
            <div class="school-logo">S</div>
            <h1 class="certificate-title">Sertifikat Kelulusan</h1>
            <p class="certificate-subtitle">Portal Sekolah - Sistem Informasi Kelulusan</p>
        </div>

        <div class="certificate-content">
            <div class="certificate-text">
                Dengan ini menyatakan bahwa:
            </div>

            <div class="student-name">{{ $kelulusan->nama }}</div>

            <div class="student-details">
                <div class="detail-row">
                    <span class="detail-label">NISN:</span>
                    <span class="detail-value">{{ $kelulusan->nisn }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">NIS:</span>
                    <span class="detail-value">{{ $kelulusan->nis ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jurusan:</span>
                    <span class="detail-value">{{ $kelulusan->jurusan ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tahun Ajaran:</span>
                    <span class="detail-value">{{ $kelulusan->tahun_ajaran }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ $kelulusan->status }}">
                            {{ ucfirst(str_replace('_', ' ', $kelulusan->status)) }}
                        </span>
                    </span>
                </div>
                @if ($kelulusan->tanggal_lulus)
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Lulus:</span>
                        <span class="detail-value">{{ $kelulusan->tanggal_lulus->format('d F Y') }}</span>
                    </div>
                @endif
            </div>

            <div class="certificate-text">
                @if ($kelulusan->status === 'lulus')
                    Telah dinyatakan <strong>LULUS</strong> dari pendidikan di sekolah ini.
                @elseif($kelulusan->status === 'tidak_lulus')
                    Dinyatakan <strong>TIDAK LULUS</strong> dan perlu mengulang.
                @else
                    Sedang dalam proses <strong>MENGULANG</strong>.
                @endif
            </div>
        </div>

        <div class="certificate-footer">
            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-label">Kepala Sekolah</div>
            </div>

            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-label">Wali Kelas</div>
            </div>
        </div>

        <div class="certificate-date">
            Dikeluarkan pada: {{ now()->format('d F Y') }}
        </div>
    </div>
</body>

</html>
