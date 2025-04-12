// script.js
document.addEventListener("DOMContentLoaded", function () {
  const searchBar = document.getElementById("search");

  searchBar.addEventListener("input", function () {
    const query = searchBar.value.toLowerCase();
    const products = document.querySelectorAll(".product-item");

    products.forEach((product) => {
      const name = product.querySelector("h3").textContent.toLowerCase();
      if (name.includes(query)) {
        product.style.display = "block";
      } else {
        product.style.display = "none";
      }
    });
  });

  const buttons = document.querySelectorAll(".add-alternative");
  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      const productId = button.getAttribute("data-id");
      // Handle Add Alternative functionality (e.g., show a form, send request to server)
      console.log("Add alternative for product ID:", productId);
    });
  });
});

// script.js
document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search");
  const productItems = document.querySelectorAll(".product-item");

  searchInput.addEventListener("input", function () {
    const query = searchInput.value.toLowerCase();

    productItems.forEach(function (item) {
      const productName = item.querySelector("h3").textContent.toLowerCase();
      if (productName.includes(query)) {
        item.style.display = "";
      } else {
        item.style.display = "none";
      }
    });
  });
});
