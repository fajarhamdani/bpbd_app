<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda BPBD Provinsi Jawa Barat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="/images/jabar-pro.png" type="image/png">

    <style>
        .input-field {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            width: 100%;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            border-color: #2563eb;
            outline: none;
        }

        .btn-submit {
            background-color: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
        }

        /* Sidebar Styling */
        #sidebar {
            transition: transform 0.3s ease;
            transform: translateX(-100%);
            z-index: 50;
            width: 256px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }

        #sidebar.active {
            transform: translateX(0);
        }

        /* Sidebar Logo Fixed */
        #sidebarLogo {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 60;
        }

        /* Main Content Shift */
        #mainContent.shifted {
            margin-left: 256px;
            /* Width of the sidebar */
            transition: margin-left 0.3s ease;
        }

        #header.shifted {
            margin-left: 256px;
            /* Width of the sidebar */
            transition: margin-left 0.3s ease;
        }

        .hamburger div {
            transition: all 0.3s ease;
            width: 24px;
            height: 3px;
            background-color: white;
        }

        /* Transformasi saat berubah menjadi "X" */
        .hamburger.open .line1 {
            transform: rotate(45deg) translateY(7px);
            /* Rotasi 45 derajat searah jarum jam */
        }

        .hamburger.open .line2 {
            opacity: 0;
            /* Hilangkan garis tengah */
        }

        .hamburger.open .line3 {
            transform: rotate(-45deg) translateY(-7px);
            /* Rotasi 45 derajat berlawanan arah jarum jam */
        }

        /* Struktur ikon hamburger */
        .hamburger {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            /* Mengatur jarak antar garis saat berbentuk hamburger */
        }

        .participants-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .participants-list span {
            border-radius: 0.25rem;
        }

        #popupForm {
            z-index: 50;
            /* Pastikan popup berada di atas halaman */
        }

        button {
            z-index: 100;
            /* Pastikan tombol berada di atas elemen lainnya */
        }
    </style>
    <!-- script logika sidebar -->
    <script src="{{ asset('js/sidebarToggle.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet">
</head>