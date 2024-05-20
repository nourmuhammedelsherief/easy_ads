document
  .getElementById("cityForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get the selected city
    var selectedCity = document.querySelector('input[name="options"]:checked');

    if (selectedCity) {
      // Redirect to the home.html page
      window.location.href = "home.html";
    }
  });
// document.addEventListener("DOMContentLoaded", function () {
//   new Splide("#card-carousel", {
//     perPage: 2,
//     breakpoints: {
//       640: {
//         perPage: 1,
//       },
//     },
//   }).mount();
// });
// splide
// new Splide(".splide", {
//   // type: "loop",
//   perPage: 4,
//   rewind: true,
//   breakpoints: {
//     640: {
//       perPage: 2,
//     },
//   },
// }).mount();
var elms = document.getElementsByClassName("splide");

for (var i = 0; i < elms.length; i++) {
  new Splide(elms[0], {
    perPage: 4,
    rewind: true,
    breakpoints: {
      640: {
        perPage: 2,
      },
    },
  }).mount();
  new Splide(elms[1], {
    perPage: 4,
    rewind: true,
    breakpoints: {
      640: {
        perPage: 2,
      },
    },
  }).mount();
}
