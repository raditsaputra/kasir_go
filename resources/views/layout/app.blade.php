<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Penjualan App') }}</title>
    
    <!-- Bootstrap and Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://cdn.vectorstock.com/i/1000v/51/51/initial-gs-letter-royal-luxury-logo-template-vector-42835151.jpg" type="image/x-icon">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --dark-blue: #0f2444;
            --gold: #d4af37;
            --gold-light: #f0e4b2;
            --gold-hover: #bfa02e;
            --white: #ffffff;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--dark-blue);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gray-100);
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--dark-blue);
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 0;
            list-style: none;
        }

        .sidebar-item {
            margin-bottom: 5px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--white);
            transition: all 0.3s ease;
            text-decoration: none;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(212, 175, 55, 0.15);
            color: var(--gold);
            border-left: 4px solid var(--gold);
        }

        .sidebar-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        /* Navbar Styling */
        .app-navbar {
            background-color: var(--white);
            height: 70px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
        }

        .navbar-search {
            position: relative;
            width: 300px;
        }

        .navbar-search input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border-radius: 50px;
            border: 1px solid var(--gray-200);
            background-color: var(--gray-100);
            transition: all 0.3s ease;
        }

        .navbar-search input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.25);
            border-color: var(--gold);
        }

        .navbar-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .user-dropdown {
            position: relative;
        }

        .user-button {
            display: flex;
            align-items: center;
            cursor: pointer;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--dark-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
            border: 2px solid var(--gold);
        }

        /* Content Area */
        .content-area {
            padding: 25px;
            background-color: var(--gray-100);
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .card-header {
            background-color: var(--dark-blue);
            color: var(--white);
            padding: 15px 20px;
            font-weight: 600;
            border-bottom: none;
        }
        
        .card-title {
            color: var(--dark-blue);
            font-weight: 600;
            margin-bottom: 15px;
        }

        /* Button Styling */
        .btn-gold {
            background-color: var(--gold);
            color: var(--dark-blue);
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: var(--gold-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-dark-blue {
            background-color: var(--dark-blue);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-dark-blue:hover {
            background-color: #1a3c70;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Table Styling */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern th {
            background-color: var(--dark-blue);
            color: var(--white);
            font-weight: 500;
            padding: 15px;
            text-align: left;
        }

        .table-modern td {
            padding: 15px;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        .table-modern tr:hover {
            background-color: rgba(212, 175, 55, 0.05);
        }

        /* Stats Cards */
        .stats-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background-color: rgba(15, 36, 68, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }

        .stats-icon i {
            font-size: 24px;
            color: var(--dark-blue);
        }

        .stats-info h4 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--dark-blue);
        }

        .stats-info p {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }

        .gold-accent {
            color: var(--gold);
        }

        .badge-gold {
            background-color: var(--gold-light);
            color: var(--dark-blue);
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 50px;
        }

        .badge-dark-blue {
            background-color: var(--dark-blue);
            color: var(--white);
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 50px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
   @include('partials.sidebar')
   <!-- Navbar -->
   @include('partials.navbar')
    <!-- Main Content -->
   @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        // Toggle sidebar
        document.querySelector('.fa-bars').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebar.style.left === '-280px') {
                sidebar.style.left = '0';
                mainContent.style.marginLeft = '280px';
            } else {
                sidebar.style.left = '-280px';
                mainContent.style.marginLeft = '0';
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>