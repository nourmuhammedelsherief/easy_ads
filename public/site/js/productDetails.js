// Get the necessary elements
var decreaseBtn = document.getElementById("decreaseBtn");
var increaseBtn = document.getElementById("increaseBtn");
var decreaseBtn1 = document.getElementById("decreaseBtn1");
var increaseBtn1 = document.getElementById("increaseBtn1");
var decreaseBtn2 = document.getElementById("decreaseBtn2");
var increaseBtn2 = document.getElementById("increaseBtn2");
var decreaseBtn3 = document.getElementById("decreaseBtn3");
var increaseBtn3 = document.getElementById("increaseBtn3");
var countElement = document.getElementById("count");
var countElement1 = document.getElementById("count1");
var countElement2 = document.getElementById("count2");
var countElement3 = document.getElementById("count3");
var addCheckbox = document.getElementById("add33");

var form = document.getElementById("myForm");

// Set the initial count value
var count = 1;
var countOne = 1;
var counttwo = 1;
var countthree = 1;

// Event listener for the decrease button
decreaseBtn.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  if (count > 1) {
    count--; // Decrease the count value by 1
    countElement.textContent = count;
    var PriceElement = document.getElementById("totalPrice");
    var PriceElement2 = document.getElementById("totalPrice2");
    var totalPrice = parseInt(PriceElement.textContent);
    PriceElement2.textContent -= totalPrice;
  }
});
decreaseBtn1.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  if (countOne > 1) {
    countOne--; // Decrease the count value by 1
    countElement1.textContent = countOne;
    var choose_add = document.getElementById("choose_add");
    var choose_addValue = document.getElementById("choose_addValue");
    var totalPrice = parseInt(choose_add.textContent);
    choose_addValue.textContent -= totalPrice;
  }
});

decreaseBtn2.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  if (counttwo > 1) {
    counttwo--; // Decrease the count value by 1
    countElement2.textContent = counttwo; // Update the count element with the new value
  }
});
decreaseBtn3.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  if (count > 1) {
    count--; // Decrease the count value by 1
    countElement3.textContent = count; // Update the count element with the new value
  }
});

// Event listener for the increase button
increaseBtn.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  count++; // Increase the count value by 1
  countElement.textContent = count;
  var PriceElement = document.getElementById("totalPrice");
  var PriceElement2 = document.getElementById("totalPrice2");
  var totalPrice = parseInt(PriceElement.textContent);
  price = totalPrice * count;
  PriceElement2.textContent = price;
});
// addCheckbox.addEventListener("change", function () {
//   if (addCheckbox.checked) {
//     var price = parseInt(choose_addValue.textContent);
//     updateTotalPrice(price); // Call the updateTotalPrice function with the current price
//   } else {
//     updateTotalPrice(0); // If unchecked, set the price to 0
//   }
// });
increaseBtn1.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  countOne++; // Increase the count value by 1
  countElement1.textContent = countOne; // Update the count element with the new value
  var mainValue = document.getElementById("choose_add");
  var choose_add = parseInt(mainValue.textContent);
  price = choose_add * countOne;
  mainValue.textContent = price;
  // if (addCheckbox.checked) {
  //   updateTotalPrice(price); // Call the updateTotalPrice function with the new price
  // }
});
increaseBtn2.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  counttwo++; // Increase the count value by 1
  countElement2.textContent = counttwo; // Update the count element with the new value
});
increaseBtn3.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form submission
  count++; // Increase the count value by 1
  countElement3.textContent = count; // Update the count element with the new value
});

// // Event listener for form submission
// form.addEventListener("submit", function (event) {
//   event.preventDefault(); // Prevent default form submission
//   // You can perform additional actions here if needed
// });
