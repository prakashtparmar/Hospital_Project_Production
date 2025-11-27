<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar .active {
            background-color: #007bff;
        }

        .content {
            padding: 20px;
        }

        /* Sticky Footer */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
        }

        .navbar {
            background-color: #007bff;
        }
    </style>
</head>
<body class="bg-light">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HMS Dashboard</a>
    </div>
</nav>

<!-- Main content area with sidebar and content -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h4 class="text-center text-white">Menu</h4>
            <ul class="list-unstyled">
                <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Patients</a></li>
                <li><a href="#"><i class="fas fa-user-md"></i> Doctors</a></li>
                <li><a href="#"><i class="fas fa-calendar"></i> Appointments</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-10 content">
            <div class="container">
                <!-- Dynamic Content Here -->
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center">
    <p>&copy; 2025 HMS. All Rights Reserved.</p>
</footer>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
