const button = document.getElementById("pills-profile-tab");
const button2 = document.getElementById("pills-home-tab");
const total = document.getElementById("total_followPayment");

button.addEventListener("click", function () {
  total.style.display = "none";
});
button2.addEventListener("click", function () {
  total.style.display = "block";
});
const cartItems = JSON.parse(localStorage.getItem("cartItems"));
const cartItemsContainer = document.getElementById("cartItemsContainer");
const numberProduct = JSON.parse(localStorage.getItem("numberProduct"));

if (cartItems && cartItems.length > 0) {
  // Create the wrapper element
  const wrapper = document.createElement("div");
  wrapper.classList.add("wrapper-class"); // Add your desired wrapper class name

  // Create and append numberProductElement
  const numberProductElement = document.createElement("p");
  numberProductElement.textContent = `عدد عناصر السلة :(${numberProduct})`;
  wrapper.appendChild(numberProductElement);

  // Create and append removeBell element
  const removeBell = document.createElement("div");
  const removeBellIcon = document.createElement("i");
  removeBellIcon.className = "fa-solid  fa-trash-can"; // Assuming Font Awesome classes
  removeBell.appendChild(removeBellIcon);
  // test

  // Add title:
  const removeBellTitle = document.createElement("span");
  removeBellTitle.textContent = "افراغ السلة";
  removeBell.appendChild(removeBellTitle);

  // ... (existing code for adding icon and title to removeBell) ...
  wrapper.appendChild(removeBell);

  // Append the wrapper to the cartItemsContainer
  cartItemsContainer.appendChild(wrapper);
  cartItems.forEach((item) => {
    // Generate HTML markup for each item
    const itemMarkup = `
<div class="cart-item">
  <div class="image">
    <img src="${item.productImage}" alt="Product Image" />
  </div>
  <div class="details">
    <h4>${item.productName}</h4>
    <p>Price: $${item.productPrice}</p>
    <p>quantity: $${item.quantity}</p>
  </div>
</div>
`;
    cartItemsContainer.innerHTML += itemMarkup;
  });
} else {
  var text = document.createElement("p");
  var icon = document.createElement("i");
  var link = document.createElement("a");

  // Set the class attribute of the icon
  icon.className = "fa-solid fa-cart-shopping";
  link.href = "home.html";
  link.textContent = "الصفحة الرئيسية";
  text.textContent = "لا يوجد عناصر بالسلة";

  // Append the icon to the cartItemsContainer
  cartItemsContainer.appendChild(icon);
  cartItemsContainer.appendChild(text);
  cartItemsContainer.appendChild(link);
}
