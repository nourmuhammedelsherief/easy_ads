const addToCartButtons = document.querySelectorAll(".cart-btn");
addToCartButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const productId = this.dataset.productId;
    const productContainer = document.getElementById(productId);
    const productName =
      productContainer.querySelector(".content_list h3").textContent;
    const productPrice =
      productContainer.querySelector(".price span").textContent;
    const productImage = productContainer.querySelector(".image img").src;

    addToCart(productId, productName, productPrice, productImage);
  });
});

function addToCart(productId, productName, productPrice, productImage) {
  // Check for existing product in cart
  const existingProduct = cartItems.find(
    (item) => item.productId === productId
  );

  if (existingProduct) {
    // Increase quantity if product exists
    existingProduct.quantity++;
  } else {
    // Add new product to cart
    cartItems.push({
      productId,
      productName,
      productPrice,
      productImage,
      quantity: 1,
    });
  }

  // Store updated cart items in local storage
  localStorage.setItem("cartItems", JSON.stringify(cartItems));

  // Display updated cart items (implement this section)
}

// Retrieve cart items from local storage on page load
window.addEventListener("load", () => {
  const storedCartItems = localStorage.getItem("cartItems");
  if (storedCartItems) {
    cartItems = JSON.parse(storedCartItems);
    // Display retrieved cart items (implement this section)
  }
});

// Define cartItems array to store cart data (retrieved from local storage if available)
let cartItems = localStorage.getItem("cartItems")
  ? JSON.parse(localStorage.getItem("cartItems"))
  : [];
const uniqueProductIds = [...new Set(cartItems.map((item) => item.productId))];
const numberOfUniqueProductsAdded = uniqueProductIds.length;
const numberProduct = localStorage.setItem(
  "numberProduct",
  numberOfUniqueProductsAdded
);
