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

        /* Header stay di paling atas secara mutlak */
        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        #mainContent {
            padding-top: 90px;
            /*jarak antar mian content dan header */
        }

        /* Kontainer Navigasi */
        #bottomNav {
            display: flex;
            justify-content: space-between;
            /* Jarak antar elemen */
            align-items: center;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            padding: 12px 16px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 50;
            border-top: 1px solid #e5e7eb;
        }

        /* Item Navigasi */
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #6b7280;
            /* Gray-500 */
            font-size: 11px;
            /* Ukuran lebih kecil untuk mobile */
            font-weight: 500;
            transition: color 0.3s ease-in-out, transform 0.2s ease-in-out;
            flex: 1;
            /* Membagi ruang secara merata */
            max-width: 60px;
            /* Batasan lebar tiap item */
        }

        /* Ikon Navigasi */
        .nav-icon {
            font-size: 24px;
            margin-bottom: 4px;
            color: inherit;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        /* Efek Hover */
        .nav-item:hover {
            color: #2563eb;
            /* Blue-600 */
        }

        /* Teks Navigasi */
        .nav-text {
            font-size: 10px;
            /* Teks kecil untuk menghemat ruang */
            font-weight: 500;
            text-align: center;
        }

        /* Penanda Aktif */
        .nav-item.text-blue-500 .nav-icon {
            color: #2563eb;
            /* Blue-600 */
        }

        /* Responsif untuk Tablet */
        @media (min-width: 640px) {
            #bottomNav {
                padding: 16px 32px;
                /* Tambah padding */
            }

            .nav-item {
                font-size: 13px;
                /* Ukuran teks lebih besar */
                max-width: 80px;
                /* Lebar lebih besar */
            }

            .nav-icon {
                font-size: 28px;
                /* Ikon lebih besar */
            }

            .nav-text {
                font-size: 12px;
                /* Teks lebih besar */
            }
        }

        /* Responsif untuk Layar Besar */
        @media (min-width: 1024px) {
            #bottomNav {
                display: none;
                /* Sembunyikan di layar besar */
            }
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