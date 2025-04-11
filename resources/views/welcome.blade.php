<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modern Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background: linear-gradient(90deg, #004e92, #000428);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #fff !important;
        }

        .nav-link {
            color: #f8f9fa !important;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #ffd700 !important;
        }

        .btn-outline-light {
            margin-left: 0.5rem;
        }

        .shadow-lg-custom {
            box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top shadow-lg-custom">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">MoHospital</a>
            <button class="navbar-toggler text-white border-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon bg-light rounded"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hospitals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Medical Stores</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                    <a href="{{ route('register.form') }}" class="btn btn-light ms-2">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
