<?php
// index.php
require_once 'models/product.php';
require_once 'includes/header.php'; 

$products = Product::getAllProducts(); 

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-alternative'])) {
    $productName = $_POST['altName'];
    $brand = $_POST['altBrand'];
    $description = $_POST['altDesc'];
    $image = $_POST['altImage'];
    $link = $_POST['altLink'];
    $ref_id = $_POST['original_product_id']; 
    
    $status = 'active';
    
    $success = Product::addAlternative($productName, $brand, $image, $link, $ref_id, $description, $status);
    
    if ($success) {
        header("Location: index.php?alt_added=success");
    } else {
        header("Location: index.php?alt_added=error");
    }
    exit();
}
?>

<!-- Add Alternative Modal -->
<div id="add-alternative-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-2xl transform transition-all">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h2 class="text-xl font-bold text-gray-800">Add Alternative Product</h2>
            <button id="addAltCancel" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="index.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="original_product_id" id="original_product_id" />
            
            <div>
                <label for="altName" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" id="altName" name="altName" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div>
                <label for="altBrand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                <input type="text" id="altBrand" name="altBrand" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div>
                <label for="altDesc" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="altDesc" name="altDesc" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 resize-y" required></textarea>
            </div>
            
            <div>
                <label for="altImage" class="block text-sm font-medium text-gray-700 mb-1">Image Link</label>
                <input type="text" id="altImage" name="altImage" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div>
                <label for="altLink" class="block text-sm font-medium text-gray-700 mb-1">Source Link</label>
                <input type="url" id="altLink" name="altLink" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" id="addAltCancelBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all">Cancel</button>
                <button type="submit" name="add-alternative" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Product Details Modal -->
<div id="product-details-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white w-full max-w-2xl p-6 rounded-xl shadow-2xl transform transition-all">
        <div class="flex justify-between items-center mb-5">
            <h2 id="modal-product-name" class="text-2xl font-bold capitalize text-gray-800"></h2>
            <button id="productDetailsClose" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="flex flex-col md:flex-row gap-6 mb-6">
            <div class="flex-shrink-0">
                <img id="modal-product-image" class="w-full md:w-40 h-40 object-contain bg-gray-50 rounded-lg border border-gray-200" />
            </div>
            <div class="flex-1">
                <div class="flex items-center mb-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" id="modal-product-brand"></span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800" id="modal-product-category">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span id="category-name"></span>
                    </span>
                </div>
                <p id="modal-product-description" class="text-gray-700 mb-4"></p>
                <div id="modal-product-source" class="text-xs text-gray-500 italic"></div>
            </div>
        </div>
        
        <div class="border-t pt-5">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-lg font-semibold text-gray-800">Alternatives</h3>
                <button type="button" id="productDetailsAddAlt" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Alternative
                </button>
            </div>
            
            <!-- Alternatives List -->
            <div class="mt-2">
                <ul id="alternatives-list" class="space-y-2"></ul>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-gradient-to-b from-white to-gray-50">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-12 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">Boycott Israel Products</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">Find alternatives to products and companies supporting Israel's actions against Palestine</p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-12 relative">
            <div class="flex rounded-lg shadow-sm">
                <input type="text" id="search" class="block w-full px-4 py-3 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Search products or brands...">
                <button class="px-4 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
            <div id="search-results" class="absolute left-0 right-0 bg-white mt-1 rounded-lg shadow-lg z-10 hidden">
                <!-- Search results will appear here -->
            </div>
        </div>
        
        <!-- Status Messages -->
        <?php if (isset($_GET['alt_added']) && $_GET['alt_added'] === 'success'): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-8 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">Alternative product added successfully!</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['alt_added']) && $_GET['alt_added'] === 'error'): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">Error adding alternative product.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Products Grid -->
        <!-- Products Grid -->
    <div class="container mx-auto px-4 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($products as $product) { ?>
                <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full border border-gray-100">
                    <div class="relative overflow-hidden cursor-pointer product-card flex-1">
                        <div class="aspect-square bg-gray-50 p-4 flex items-center justify-center">
                            <img src="<?= $product['image'] ?>" class="max-h-full object-contain transition-transform duration-300 group-hover:scale-105" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="p-4">
                            <h5 class="font-semibold text-gray-800 mb-1 line-clamp-1"><?= htmlspecialchars($product['name']) ?></h5>
                            <div class="flex items-center flex-wrap gap-2">
                                <p class="text-sm text-blue-600 font-medium"><?= htmlspecialchars($product['brand']) ?></p>
                                
                                <?php if (!empty($product['category_name'])): ?>
                                <!-- Category Badge -->
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-2.5 w-2.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <?= htmlspecialchars($product['category_name']) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <button
                        class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 w-full transition-colors flex items-center justify-center space-x-1 add-alternative"
                        data-id="<?= $product['id'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Add Alternative</span>
                    </button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- JS Libraries -->
<link rel="stylesheet" href="assets/css/style.css">
<script src="assets/js/script.js"></script> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  // Add Alternative Button
  document.querySelectorAll('.add-alternative').forEach(button => {
    button.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent opening product details
      const productId = button.getAttribute('data-id');
      document.getElementById('original_product_id').value = productId;
      document.getElementById('add-alternative-modal').classList.remove('hidden');
    });
  });

  // Add Alternative from Product Details
  document.getElementById('productDetailsAddAlt').addEventListener('click', () => {
    const productId = document.getElementById('productDetailsAddAlt').getAttribute('data-product-id');
    document.getElementById('original_product_id').value = productId;
    document.getElementById('product-details-modal').classList.add('hidden');
    document.getElementById('add-alternative-modal').classList.remove('hidden');
  });
 
  // Modal Close Buttons
  document.getElementById('addAltCancel').addEventListener('click', () => {
    document.getElementById('add-alternative-modal').classList.add('hidden');
  });
  
  document.getElementById('addAltCancelBtn').addEventListener('click', () => {
    document.getElementById('add-alternative-modal').classList.add('hidden');
  });
    
  document.getElementById('productDetailsClose').addEventListener('click', () => {
    document.getElementById('product-details-modal').classList.add('hidden');
  });

  // Product Cards Click Handler
  document.querySelectorAll('.product-card').forEach(productDiv => {
    productDiv.addEventListener('click', async () => {
      const productId = productDiv.parentElement.querySelector('.add-alternative').getAttribute('data-id');
      
      try {
        // Fetch product details
        const response = await fetch(`api/get-product.php?id=${productId}`);
        const data = await response.json();
          
        // Set product ID for Add Alternative button
        document.getElementById('productDetailsAddAlt').setAttribute('data-product-id', productId);
    
        // Update product details in modal
        document.getElementById('modal-product-name').textContent = data.product.name;
        document.getElementById('modal-product-brand').textContent = data.product.brand;
        document.getElementById('modal-product-image').src = data.product.image;
        document.getElementById('modal-product-description').textContent = data.product.description || 'No description available';
        document.getElementById('modal-product-source').innerHTML = `Source: <a href="${data.product.link}" target="_blank" class="text-blue-600 hover:underline">${data.product.link}</a>`;
        

        const categoryElement = document.getElementById('modal-product-category');
        const categoryNameElement = document.getElementById('category-name');
      
        if (data.product.category_name) {
            categoryNameElement.textContent = data.product.category_name;
            categoryElement.classList.remove('hidden');
          } else {
            categoryElement.classList.add('hidden');
        }

        // Handle alternatives display
        const alternativesList = document.getElementById('alternatives-list');
        alternativesList.innerHTML = '';
        
        if (data.alternatives.length > 0) {
          // Create Swiper slider for alternatives
          const swiperContainer = document.createElement('div');
          swiperContainer.className = 'alternatives-swiper-container';
          
          const swiperWrapper = document.createElement('div');
          swiperWrapper.className = 'swiper alternativesSwiper';
          swiperWrapper.innerHTML = `
            <div class="swiper-wrapper"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          `;
          swiperContainer.appendChild(swiperWrapper);
          
          // Add alternative cards to Swiper
          const swiperSlides = swiperWrapper.querySelector('.swiper-wrapper');
          
          data.alternatives.forEach(alt => {
            const slide = document.createElement('div');
            slide.className = 'swiper-slide';
            slide.innerHTML = `
              <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow transition h-full p-4">
                <img src="${alt.image}" class="w-full h-24 object-contain mb-3 rounded-md" onerror="this.src='assets/images/placeholder.png'">
                <h4 class="font-medium text-gray-800 text-sm mb-1 truncate">${alt.name}</h4>
                <p class="text-xs text-gray-600 mb-2">${alt.brand}</p>
                <p class="text-xs text-gray-500 mb-3 line-clamp-2">${alt.description || 'No description available'}</p>
                <a href="${alt.link}" target="_blank" 
                  class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 hover:underline">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                  View Source
                </a>
              </div>
            `;
            swiperSlides.appendChild(slide);
          });
          
          alternativesList.appendChild(swiperContainer);
          
          // Initialize Swiper with short timeout
          setTimeout(() => {
            new Swiper('.alternativesSwiper', {
              slidesPerView: 1,
              spaceBetween: 20,
              pagination: {
                el: '.swiper-pagination',
                clickable: true,
              },
              navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
              },
              breakpoints: {
                640: {
                  slidesPerView: 2,
                },
                768: {
                  slidesPerView: 2,
                }
              }
            });
          }, 100);
        } else {
          // No alternatives message
          alternativesList.innerHTML = `
            <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <p class="text-gray-600 mb-4">No alternatives added yet</p>
              <p class="text-sm text-gray-500">Be the first to suggest an alternative product</p>
            </div>
          `;
        }
        
        // Show modal
        document.getElementById('product-details-modal').classList.remove('hidden');
      } catch (error) {
        console.error("Error fetching product data:", error);
      }
    }); 
  });
  
  // Search functionality
const searchInput = document.getElementById('search');
const searchResults = document.getElementById('search-results');

searchInput.addEventListener('input', function() {
  const query = this.value.trim();
  
  // Filter products based on search query
  const filteredProducts = Array.from(document.querySelectorAll('.product-card'))
    .filter(card => {
      // If query is empty or less than 2 chars, include all products
      if (query.length < 2) {
        return true;
      }
      
      const name = card.querySelector('h5').textContent.toLowerCase();
      const brand = card.querySelector('p').textContent.toLowerCase();
      return name.includes(query.toLowerCase()) || brand.includes(query.toLowerCase());
    });
  
  // Handle results display
  if (query.length < 2) {
    searchResults.classList.add('hidden');
  } else {
    // Display count of matching products
    const count = filteredProducts.length;
    searchResults.innerHTML = `<p class="px-4 py-2 text-sm font-medium text-gray-700">Found ${count} matching product${count === 1 ? '' : 's'}</p>`;
    searchResults.classList.remove('hidden');
  }
  
  // Show/hide products based on search
  document.querySelectorAll('.product-card').forEach(card => {
    const productContainer = card.parentElement;
    if (filteredProducts.includes(card)) {
      productContainer.classList.remove('hidden');
    } else {
      productContainer.classList.add('hidden');
    }
  });
});
</script>