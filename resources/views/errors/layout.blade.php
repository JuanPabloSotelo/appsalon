<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') - @yield('title') | AppSalon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm text-center p-4 p-md-5">
                    <i class="bi @yield('icon') display-3 text-salon"></i>
                    <p class="display-4 fw-bold text-salon mb-0">@yield('code')</p>
                    <h1 class="h4 fw-bold mt-2">@yield('title')</h1>
                    <p class="text-muted mb-4">@yield('message')</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                        <a href="{{ url('/') }}" class="btn btn-salon"><i class="bi bi-house"></i> Ir al inicio</a>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>