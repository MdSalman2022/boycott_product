<?php
  // If not started yet, start the session here
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  // Get current page for active state
  $current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boycott Israel</title>
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <style>
    .nav-link {
      position: relative;
      transition: all 0.3s ease;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: #3B82F6;
      transition: width 0.3s ease;
    }
    .nav-link:hover::after, .nav-link.active::after {
      width: 100%;
    }
    .mobile-menu-transition {
      transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }
  </style>
</head>
<body class="font-sans bg-gray-50">
<header class="bg-white shadow-md py-4 px-6 sticky top-0 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <a class="text-2xl font-bold text-gray-800 flex items-center space-x-2 hover:text-blue-600 transition duration-300" href="index.php">
      <img class="size-10" src="../assets/images/logo.png" alt="">
      <span>Boycott Israel</span>
    </a>
    
    <!-- Mobile menu button -->
    <div class="md:hidden">
      <button id="mobile-menu-button" class="text-gray-600 hover:text-blue-600 focus:outline-none">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
    
    <!-- Desktop Navigation -->
    <nav class="hidden md:block">
      <ul class="flex space-x-6 items-center">
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <!-- Admin navigation -->
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'index.php' ? 'active text-blue-600' : '' ?>" href="index.php">Home</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'dashboard.php' ? 'active text-blue-600' : '' ?>" href="dashboard.php">Dashboard</a></li>
          <li>
            <a class="ml-4 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-medium" href="logout.php">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </a>
          </li>
        <?php elseif (isset($_SESSION['user_id'])): ?>
          <!-- Logged-in user navigation -->
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'index.php' ? 'active text-blue-600' : '' ?>" href="index.php">Home</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'categories.php' ? 'active text-blue-600' : '' ?>" href="categories.php">Categories</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'about.php' ? 'active text-blue-600' : '' ?>" href="about.php">About Us</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'contact.php' ? 'active text-blue-600' : '' ?>" href="contact.php">Contact Us</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'suggest-product.php' ? 'active text-blue-600' : '' ?>" href="suggest-product.php">Suggest Product</a></li>
          <li>
            <div class="flex items-center ml-4 px-3 py-1 rounded-full bg-gray-100">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              <span class="text-sm font-medium text-gray-700"><?php echo $_SESSION['name']; ?></span>
            </div>
          </li>
          <li>
            <a class="ml-4 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-medium" href="logout.php">
              Logout
            </a>
          </li>
        <?php else: ?>
          <!-- Not logged in navigation -->
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'index.php' ? 'active text-blue-600' : '' ?>" href="index.php">Home</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'categories.php' ? 'active text-blue-600' : '' ?>" href="categories.php">Categories</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'about.php' ? 'active text-blue-600' : '' ?>" href="about.php">About Us</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'contact.php' ? 'active text-blue-600' : '' ?>" href="contact.php">Contact Us</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'suggest-product.php' ? 'active text-blue-600' : '' ?>" href="suggest-product.php">Suggest Product</a></li>
          <li>
            <a class="ml-4 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 font-medium" href="login.php">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              Login
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
  
  <!-- Mobile Navigation Menu -->
  <div id="mobile-menu" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-40 hidden">
    <div class="flex justify-end p-4">
      <button id="close-menu-button" class="text-white">
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <nav class="flex flex-col items-center justify-center h-full mobile-menu-transition">
      <ul class="flex flex-col space-y-6 text-center w-full">
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="index.php">Home</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="dashboard.php">Dashboard</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="logout.php">Logout</a></li>
        <?php elseif (isset($_SESSION['user_id'])): ?>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="index.php">Home</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="categories.php">Categories</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="about.php">About Us</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="contact.php">Contact Us</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="suggest-product.php">Suggest Product</a></li>
          <li class="text-blue-400 text-xl font-medium"><?php echo $_SESSION['name']; ?></li>
          <li><a class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="index.php">Home</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="categories.php">Categories</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="about.php">About Us</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="contact.php">Contact Us</a></li>
          <li><a class="text-white text-xl hover:text-blue-400 font-medium" href="suggest-product.php">Suggest Product</a></li>
          <li><a class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium" href="login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</header>

<script>
  // Mobile menu functionality
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const closeMenuButton = document.getElementById('close-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.remove('hidden');
  });

  closeMenuButton.addEventListener('click', () => {
    mobileMenu.classList.add('hidden');
  });
</script>