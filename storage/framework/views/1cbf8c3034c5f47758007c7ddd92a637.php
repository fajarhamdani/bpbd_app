<html>
 <head>
  <title>
   Agenda BPBD
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        .sidebar .profile {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .sidebar .profile img {
            border-radius: 50%;
            margin-right: 10px;
        }
        .sidebar .profile .name {
            font-weight: 500;
        }
        .sidebar .profile .role {
            font-size: 14px;
            color: #bdc3c7;
        }
        .sidebar .menu {
            list-style: none;
            padding: 0;
        }
        .sidebar .menu li {
            margin: 10px 0;
        }
        .sidebar .menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar .menu li a .icon {
            margin-right: 10px;
        }
        .sidebar .menu li a.active {
            background-color: #f39c12;
            padding: 10px;
            border-radius: 5px;
        }
        .content {
            flex-grow: 1;
            background-color: #ecf0f1;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header .title {
            font-weight: 500;
            color: #27ae60;
        }
        .header .profile {
            display: flex;
            align-items: center;
        }
        .header .profile img {
            border-radius: 50%;
            margin-right: 10px;
        }
        .header .profile .name {
            font-weight: 500;
        }
        .table-container {
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container table th, .table-container table td {
            padding: 10px;
            border: 1px solid #bdc3c7;
            text-align: left;
        }
        .table-container table th {
            background-color: #ecf0f1;
        }
        .table-container .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
        .table-container .pagination .entries {
            display: flex;
            align-items: center;
        }
        .table-container .pagination .entries select {
            margin-left: 5px;
        }
        .table-container .pagination .buttons {
            display: flex;
            align-items: center;
        }
        .table-container .pagination .buttons button {
            margin-left: 5px;
            padding: 5px 10px;
            border: none;
            background-color: #bdc3c7;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }
        .table-container .pagination .buttons button:hover {
            background-color: #95a5a6;
        }
  </style>
 </head>
 <body>
  <div class="sidebar">
   <div class="profile">
    <img alt="Profile Picture" height="50" src="https://storage.googleapis.com/a1aa/image/0EcklseirDQNU6dtZc1TxLI5FiR6tnv4pyLmIBqqZ2vixl0JA.jpg" width="50"/>
    <div>
     <div class="name">
      Agenda BPBD
     </div>
     <div class="role">
      Admin
     </div>
    </div>
   </div>
   <ul class="menu">
    <li>
     <a class="active" href="#">
      <i class="fas fa-home icon">
      </i>
      Beranda
     </a>
    </li>
    <li>
     <a href="#">
      <i class="fas fa-user icon">
      </i>
      Data User
     </a>
    </li>
    <li>
     <a href="#">
      <i class="fas fa-calendar-alt icon">
      </i>
      Agenda Kegiatan
     </a>
    </li>
    <li>
     <a href="#">
      <i class="fas fa-info-circle icon">
      </i>
      Informasi Ruang Rapat
     </a>
    </li>
   </ul>
  </div>
  <div class="content">
   <div class="header">
    <div class="title">
     SISTEM INFORMASI AGENDA BPBD PROVINSI JAWA BARAT
    </div>
    <div class="profile">
     <img alt="Profile Picture" height="30" src="https://storage.googleapis.com/a1aa/image/0EcklseirDQNU6dtZc1TxLI5FiR6tnv4pyLmIBqqZ2vixl0JA.jpg" width="30"/>
     <div class="name">
      Agenda BPBD
     </div>
    </div>
   </div>
   <div class="table-container">
    <table>
     <thead>
      <tr>
       <th>
        ID
       </th>
       <th>
        Kegiatan
       </th>
       <th>
        Tanggal
       </th>
       <th>
        Jam
       </th>
       <th>
        Tempat
       </th>
       <th>
        Keterangan
       </th>
       <th>
        Undangan
       </th>
      </tr>
     </thead>
     <tbody>
      <!-- Add table rows here -->
     </tbody>
    </table>
    <div class="pagination">
     <div class="entries">
      Show
      <select>
       <option value="10">
        10
       </option>
       <option value="25">
        25
       </option>
       <option value="50">
        50
       </option>
       <option value="100">
        100
       </option>
      </select>
      entries
     </div>
     <div class="buttons">
      <button>
       CSV
      </button>
      <button>
       Excel
      </button>
      <button>
       PDF
      </button>
      <button>
       Print
      </button>
     </div>
    </div>
   </div>
  </div>
 </body>
</html><?php /**PATH C:\laragon\www\perjalanan-dinas\resources\views/welcome.blade.php ENDPATH**/ ?>