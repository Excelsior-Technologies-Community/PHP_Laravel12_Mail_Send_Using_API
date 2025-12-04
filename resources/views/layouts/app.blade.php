<!DOCTYPE html>
<html>
<head>
    <title>Laravel Mail App</title>
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        .navbar {
            /* Navbar styling */
            margin-bottom: 20px;
            text-align: center;
        }
        .card {
            /* Rounded corners for cards */
            border-radius: 15px;
        }
        body {
            /* Page background color */
            background: #f5f6fa;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark w-100 shadow-sm">
    <div class="container-fluid d-flex justify-content-center">
        <span class="navbar-brand mb-0 h1 text-center" style="font-size: 22px;">
            Mail Sender
        </span>
    </div>
</nav>

<!-- Main container for child views -->
<div class="container">
    @yield('content') <!-- Child views will be injected here -->
</div>

</body>
</html>

