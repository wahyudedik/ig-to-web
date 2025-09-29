<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Gagal - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .error-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .error-header {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .error-body {
            padding: 2rem;
        }

        .error-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 3rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="error-card">
                    <div class="error-header">
                        <h3 class="mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Verifikasi Gagal
                        </h3>
                    </div>
                    <div class="error-body text-center">
                        <div class="error-icon">
                            <i class="fas fa-times"></i>
                        </div>

                        <h4 class="mb-3 text-danger">Maaf!</h4>

                        <p class="text-muted mb-4">
                            {{ session('error', 'Link verifikasi tidak valid atau sudah expired.') }}
                        </p>

                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Link verifikasi mungkin sudah digunakan atau sudah tidak berlaku.
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('verification.resend-guest') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Minta Link Verifikasi Baru
                            </a>

                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Kembali ke Login
                            </a>
                        </div>

                        <hr class="my-4">

                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Masih bermasalah? Hubungi administrator untuk bantuan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
