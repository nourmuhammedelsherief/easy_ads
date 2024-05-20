function shuffle(array) {
  var currentIndex = array.length,
    randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {
    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex],
      array[currentIndex],
    ];
  }

  return array;
}

function spin() {
  // Play the sound
  // wheel.play();
  // Inisialisasi variabel
  const box = document.getElementById("box");
  const element = document.getElementById("mainbox");
  let SelectedItem = "";

  // Shuffle 450 karena class box1 sudah ditambah 90 derajat diawal. minus 40 per item agar posisi panah pas ditengah.
  // Setiap item memiliki 12.5% kemenangan kecuali item sepeda yang hanya memiliki sekitar 4% peluang untuk menang.
  // Item berupa ipad dan samsung tab tidak akan pernah menang.
  // let Sepeda = shuffle([2210]); //Kemungkinan : 33% atau 1/3
  let list = [];
  let dd = [];
  console.log('products : ', productList);
  $.each(productList, function (key, value) {

    dd.push(value.deg);

  });
  console.log('list: ', dd, productList);
  let tt = shuffle(dd);
  var selectedItem = null;
  $.each(productList, function (k, v) {
    if (v.deg == tt[0]) {
      selectedItem = v;
    }
  });
  console.log('select item : ', selectedItem);
  var x = 1024; //min value
  var y = 9999; // max value
  var max = 10;
  var min = 1;

  var deg =  (Math.random() * (y-x) + x) +  selectedItem.deg;

  // Proses
  box.style.setProperty("transition", "all ease 5s");
  box.style.transform = "rotate(" + deg + "deg)";
  element.classList.remove("animate");
  setTimeout(function () {
    element.classList.add("animate");
  }, 5000);

  // Munculkan Alert
  setTimeout(function () {
    // applause.play();
    swal(
      "تهانئ",
      "انت اكسبت " + selectedItem.name + ".",
      "success"
    ).then(function(isConfirm){
      $('input[name=item_id]').val(selectedItem.id);
      sendRequest();
    });
  }, 5500);

  // Delay and set to normal state
  setTimeout(function () {
    box.style.setProperty("transition", "initial");
    box.style.transform = "rotate(90deg)";
  }, 6000);
}
