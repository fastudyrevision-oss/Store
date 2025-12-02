<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Art Stationery Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Icons & Fonts -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- AOS Animations -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Custom Styles -->
  <link href="../admin/css/style.css" rel="stylesheet">
  <link href="/art_stationery/admin/css/admin-theme.css" rel="stylesheet">

  <style>
    /* 🌈 GLOBAL RESET */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(145deg, #e8f0ff, #ffffff);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
      color: #333;
      transition: background 0.4s ease, color 0.4s ease;
    }

    /* 🧭 SIDEBAR */
    .sidebar {
      width: 250px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(20px);
      border-right: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 10px 0 25px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      padding: 1.5rem 1rem;
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100vh;
      z-index: 10;
    }

    .sidebar h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #222;
      text-align: center;
      margin-bottom: 2rem;
      letter-spacing: 0.5px;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
      transition: color 0.4s ease;
    }

    /* 🌐 NAV LINKS */
    .nav-links {
      list-style: none;
      flex: 1;
    }

    .nav-links a {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      text-decoration: none;
      color: #333;
      font-size: 1rem;
      border-radius: 12px;
      transition: all 0.3s ease;
      margin-bottom: 10px;
      background: rgba(255, 255, 255, 0.3);
      transform-style: preserve-3d;
    }

    .nav-links a i {
      margin-right: 12px;
      font-size: 1.2rem;
    }

    .nav-links a:hover {
      background: linear-gradient(135deg, #007bff, #4f8cff);
      color: white;
      transform: translateX(8px) translateZ(10px) scale(1.05);
      box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
    }

    /* 🧱 PAGE WRAPPER */
    #page-wrapper {
      flex: 1;
      margin-left: 260px;
      padding: 2rem;
      transition: all 0.4s ease;
    }

    /* 🧩 HEADER */
    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2rem;
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(15px);
      padding: 1rem 1.5rem;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
      transform: translateY(0);
      transition: all 0.3s ease;
    }

    header:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    header h1 {
      font-size: 1.8rem;
      font-weight: 600;
      color: #333;
    }

    /* 🌙 THEME TOGGLE */
    .theme-toggle {
      cursor: pointer;
      font-size: 1.5rem;
      color: #555;
      transition: color 0.3s ease, transform 0.3s ease;
    }

    .theme-toggle:hover {
      color: #007bff;
      transform: rotate(20deg);
    }

    /* 🌑 DARK MODE */
    body.dark {
      background: #0f0f12;
      color: #eee;
    }

    body.dark .sidebar {
      background: rgba(25, 25, 25, 0.7);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 10px 0 25px rgba(0, 0, 0, 0.3);
    }

    body.dark .nav-links a {
      color: #bbb;
      background: rgba(255, 255, 255, 0.05);
    }

    body.dark .nav-links a:hover {
      background: linear-gradient(135deg, #6610f2, #0d6efd);
      box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

    body.dark header {
      background: rgba(255, 255, 255, 0.05);
      color: #ddd;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>
<body data-aos="fade-in">

  <!-- 🌈 SIDEBAR -->
  <div class="sidebar" data-aos="fade-right">
    <h2>🎨 Art Stationery</h2>
    <nav>
      <div class="nav-links">
        <a href="index.php?page=dashboard"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="index.php?page=products&action=list"><i class="fa-solid fa-cubes"></i> Products</a>
        <a href="index.php?page=suppliers&action=list"><i class="fa-solid fa-truck"></i> Suppliers</a>
        <a href="#"><i class="fa-solid fa-users"></i> Users</a>
        <a href="#"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
      </div>
    </nav>
  </div>

  <!-- 🧭 MAIN CONTENT -->
  <div id="page-wrapper" data-aos="fade-up">
    <header>
      <h1>Welcome, Admin</h1>
      <i class="fa-solid fa-moon theme-toggle" id="theme-toggle"></i>
    </header>
