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
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'boycott.php' ? 'active text-blue-600' : '' ?>" href="boycott.php">Boycott Strategy</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'about.php' ? 'active text-blue-600' : '' ?>" href="about.php">About Us</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'contact.php' ? 'active text-blue-600' : '' ?>" href="contact.php">Contact Us</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'suggest-product.php' ? 'active text-blue-600' : '' ?>" href="suggest-product.php">Suggest Product</a></li>
          
  <!-- User dropdown -->
            <li class="relative ml-4">
              <button id="userDropdownButton" class="flex items-center px-3 py-1.5 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-sm font-medium text-gray-700"><?php echo $_SESSION['name']; ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              
              <!-- Dropdown menu - hidden by default -->
              <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden transform opacity-0 scale-95 transition-all duration-100 ease-in-out origin-top-right">
                <a href="suggested-products.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                  My Suggestions
                </a>
                <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  Logout
                </a>
              </div>
            </li>
          <?php else: ?>
          <!-- Not logged in navigation -->
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'index.php' ? 'active text-blue-600' : '' ?>" href="index.php">Home</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'categories.php' ? 'active text-blue-600' : '' ?>" href="categories.php">Categories</a></li>
          <li><a class="nav-link text-gray-700 hover:text-blue-600 font-medium <?= $current_page === 'boycott.php' ? 'active text-blue-600' : '' ?>" href="boycott.php">Boycott Strategy</a></li> 
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
  
  <!-- filepath: f:\projects\web_eng_lab_reports\lab_project\final_php_website\includes\header.php -->
  <!-- Modern Mobile Navigation Menu -->
  <div id="mobile-menu" class="fixed inset-0 z-50 invisible">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="mobile-backdrop"></div>
    
    <!-- Menu panel -->
    <div class="absolute top-0 right-0 w-4/5 max-w-sm h-full bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
      <!-- Header with close button -->
      <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
        <button id="close-menu-button" class="p-2 rounded-full hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
          <svg class="h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      
      <!-- Navigation links -->
      <nav class="flex-1 overflow-y-auto py-4">
        <ul class="px-4 space-y-2">
          <?php if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <!-- Admin mobile navigation -->
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'index.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="index.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'index.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  <span>Home</span>
                </div>
              </a>
            </li>
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'dashboard.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="dashboard.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'dashboard.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                  <span>Dashboard</span>
                </div>
              </a>
            </li>
          <?php elseif (isset($_SESSION['user_id'])): ?>
            <!-- Logged-in user mobile navigation -->
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'index.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="index.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'index.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  <span>Home</span>
                </div>
              </a>
            </li>
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'categories.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="categories.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'categories.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                  </svg>
                  <span>Categories</span>
                </div>
              </a>
            </li>
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'suggest-product.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="suggest-product.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'suggest-product.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Suggest Product</span>
                </div>
              </a>
            </li>
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'about.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="about.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'about.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>About Us</span>
                </div>
              </a>
            </li>
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'contact.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="contact.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'contact.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <span>Contact Us</span>
                </div>
              </a>
            </li>
            
            <!-- User section -->
            <li class="mt-6 pt-6 border-t border-gray-100">
              <div class="flex items-center px-4 py-2">
                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-base font-medium text-gray-800"><?php echo $_SESSION['name']; ?></p>
                  <p class="text-sm text-gray-500">User</p>
                </div>
              </div>
            </li>
            <li class="px-4 mt-2">
              <a href="suggested-products.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>My Suggestions</span>
              </a>
            </li>
            <li class="px-4 mt-2">
              <a href="logout.php" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
              </a>
            </li>
          <?php else: ?>
            <!-- Not logged in mobile navigation -->
            <li>
              <a class="block px-4 py-3 rounded-lg transition-colors hover:bg-blue-50 <?= $current_page === 'index.php' ? 'bg-blue-50 text-blue-600' : 'text-gray-700' ?>" href="index.php">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 <?= $current_page === 'index.php' ? 'text-blue-600' : 'text-gray-500' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                  <span>Home</span>
                </div>
              </a>
            </li>
            <!-- Add other nav items with similar styling -->
            <li class="mt-6">
              <a href="login.php" class="flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Login
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
</header> 

<script>
 
  // User dropdown functionality
  const userDropdownButton = document.getElementById('userDropdownButton');
  const userDropdownMenu = document.getElementById('userDropdownMenu');

  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const closeMenuButton = document.getElementById('close-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');
  const mobileBackdrop = document.getElementById('mobile-backdrop');
  const menuPanel = mobileMenu?.querySelector('div:last-child');


  if (mobileMenuButton && closeMenuButton && mobileMenu && menuPanel) {
    // Open mobile menu
    mobileMenuButton.addEventListener('click', () => {
      // Show the entire menu container
      mobileMenu.classList.remove('invisible');
      
      // Animate the backdrop
      setTimeout(() => {
        mobileBackdrop.classList.remove('opacity-0');
      }, 10);
      
      // Slide in the panel
      setTimeout(() => {
        menuPanel.classList.remove('translate-x-full');
      }, 50);
    });

    // Close mobile menu function
    const closeMenu = () => {
      // Slide out the panel
      menuPanel.classList.add('translate-x-full');
      
      // Fade out the backdrop
      mobileBackdrop.classList.add('opacity-0');
      
      // Hide the entire container after animations complete
      setTimeout(() => {
        mobileMenu.classList.add('invisible');
      }, 300);
    };

    // Close menu event listeners
    closeMenuButton.addEventListener('click', closeMenu);
    mobileBackdrop.addEventListener('click', closeMenu);
  }
  
  if (userDropdownButton && userDropdownMenu) {
    userDropdownButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent event bubbling
      
      // Toggle visibility with animation
      if (userDropdownMenu.classList.contains('hidden')) {
        // Show the dropdown
        userDropdownMenu.classList.remove('hidden');
        setTimeout(() => {
          userDropdownMenu.classList.remove('opacity-0', 'scale-95');
          userDropdownMenu.classList.add('opacity-100', 'scale-100');
        }, 10); // Small delay for the CSS transition to work
      } else {
        // Hide the dropdown
        userDropdownMenu.classList.add('opacity-0', 'scale-95');
        userDropdownMenu.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => {
          userDropdownMenu.classList.add('hidden');
        }, 100); // Match this with the CSS transition duration
      }
    });
    
    // Close the dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (userDropdownButton && userDropdownMenu &&
          !userDropdownButton.contains(e.target) && 
          !userDropdownMenu.contains(e.target)) {
        userDropdownMenu.classList.add('opacity-0', 'scale-95');
        userDropdownMenu.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => {
          userDropdownMenu.classList.add('hidden');
        }, 100);
      }
    });
    
    // Close the dropdown when pressing Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !userDropdownMenu.classList.contains('hidden')) {
        userDropdownMenu.classList.add('opacity-0', 'scale-95');
        userDropdownMenu.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => {
          userDropdownMenu.classList.add('hidden');
        }, 100);
      }
    });
  }
</script>