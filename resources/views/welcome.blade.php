
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>طلباتي</title>
    <!-- //font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@200;300;400&display=swap"
        rel="stylesheet"
    />
    <!-- //bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-grid.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <!-- fontawsome -->
    <link rel="stylesheet" href="css/all.min.css" />
    <!-- style sheet -->
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/home.css" />
</head>
<body>
<div class="mycontainer">
    <header
        class="bg-white mb-4 p-3 d-flex align-items-center justify-content-between"
    >
        <!-- show mobile -->
        <div class="mobile_screen">
            <button
                class="btn"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight"
            >
                <i class="fa-solid fa-bars"></i>
            </button>

            <div
                class="offcanvas offcanvas-end offcanvas_mobile"
                tabindex="-1"
                id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel"
            >
                <div class="offcanvas-header">
                    <button
                        type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="offcanvas-body">
                    <div class="container_ifno">
                        <div class="image">
                            <img src="./image/3azmak.png" alt="3azmak_title" />
                        </div>
                        <h2 class="name">فهد الغامري</h2>
                        <ul class="p-0">
                            <hr />
                            <li class="my-2">
                                <i class="fa-solid fa-globe mx-2"></i> تغيير اللغة
                            </li>
                            <hr />
                            <!-- <li class="my-2">
                              <i class="fa-solid fa-gear mx-2"></i> الإعدادت
                            </li>
                            <hr /> -->
                            <li class="my-2">
                                <a href='/terms&conditions'>
                                    <i class="fa-solid fa-file-contract mx-2"></i> الشروط
                                    والأحكام</a
                                >
                            </li>
                            <hr />
                            <li class="my-2">
                                <a href='/contactus'>
                                    <i class="fa-solid fa-envelope mx-2"></i> تواصل معنا</a
                                >
                            </li>
                            <hr />
                            <li class="my-2">
                                <a href='/aboutapp'>
                                    <i class="fa-solid fa-circle-exclamation mx-2"></i> حول
                                    التطبيق</a
                                >
                            </li>
                            <hr />
                        </ul>
                        <button class="joinUs_btn">
                            <a href='/joinus'>
                                <i class="fa-regular fa-star mx-1"></i> انضم إلينا</a
                            >
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <h5>طلباتي</h5>
        <div class="icons">
            <i class="fa-regular fa-bell mx-3"></i>
        </div>
    </header>
    <!-- <img src="./image//cartempty.jpg" -->
    <main>
        <div class="teeeeest my-1 mx-2">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link active"
                        id="pills-home-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-home"
                        type="button"
                        role="tab"
                        aria-controls="pills-home"
                        aria-selected="true"
                    >
                        <i class="fa-solid fa-cart-shopping"></i>
                        السلة
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="pills-profile-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-profile"
                        type="button"
                        role="tab"
                        aria-controls="pills-profile"
                        aria-selected="false"
                    >
                        <i class="fa-regular fa-clock prv_order"></i>
                        طلباتي السابقة
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="pills-home"
                    role="tabpanel"
                    aria-labelledby="pills-home-tab"
                >
                    <!-- <div id="cartItemsContainer" class="p-5 m-auto">
                  </div> -->
                    <div calss="cartItemsContainer" class="m-auto">
                        <div class="wrapper-class">
                            <p>عدد عناصر السلة :(2)</p>
                            <div>
                                <i class="fa-solid fa-trash-can mx-1"></i>
                                <span> افراغ السلة</span>
                            </div>
                            <!-- <i class="fa-solid fa-trash-can"></i>
                              <span> افراغ السلة</span> -->
                            <!-- </div> -->
                        </div>
                        <div class="bg-white main_wrap">
                            <div class="cart-item">
                                <div class="image">
                                    <img src="./image/cover1.jpg" alt="" />
                                </div>
                                <div class="details">
                                    <h6>اسم الوجبة</h6>
                                    <img
                                        src="./image//logo.png"
                                        alt="logo"
                                        width="22"
                                        height="22"
                                    />
                                    <small>برغر كينغ</small>
                                    <p class="my-1">
                                        وصف قصير عن الوجبة هنا وصف قصير عن الوجبة هناوصف قصير عن
                                        الوجبة هنا وصف قصير عن الوجبة هنا
                                    </p>
                                    <div
                                        class="action d-flex align-items-center justify-content-between"
                                    >
                                        <div>
                                            <del>60</del>
                                            <span>45.5</span>
                                            <small> ر.س</small>
                                        </div>
                                        <div
                                            class="action_operation d-flex align-items-center justify-content-between"
                                        >
                                            <button class="border-0">+</button>
                                            <span class="text-dark"> 1 </span>
                                            <button class="border-0">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="inf_3azema">
                                <div class="image d-inline-block">
                                    <img src="./image//letter.jpg" alt="" />
                                </div>
                                <!-- <img src="./image//letter.jpg" alt="" /> -->
                                <h5 class="d-inline-block">معلومات العزيمة</h5>
                                <form>
                                    <div class="inner_form">
                                        <div class="name">
                                            <div class="container_input">
                                                <i class="fa fa-user"></i>
                                                <input
                                                    type="text"
                                                    id="name"
                                                    placeholder=" اسم الشخص"
                                                />
                                            </div>
                                        </div>
                                        <div class="phone_number">
                                            <div class="container_input">
                                                <i class="fa fa-phone"></i>
                                                <input
                                                    style="direction: rtl"
                                                    type="tel"
                                                    id="phone_number"
                                                    placeholder=" رقم الموبايل "
                                                />
                                            </div>
                                        </div>
                                        <div class="suitable">
                                            <div class="container_input">
                                                <button
                                                    class="btn btn_custom"
                                                    type="button"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasBottom"
                                                    aria-controls="offcanvasBottom"
                                                >
                                                    <div>
                                                        <i class="fa-solid fa-heart"></i>
                                                        <span> المناسبة </span>
                                                    </div>
                                                    <i class="fa-solid fa-angle-left"></i>
                                                </button>

                                                <div
                                                    class="offcanvas offcanvas-bottom"
                                                    tabindex="-1"
                                                    id="offcanvasBottom"
                                                    aria-labelledby="offcanvasBottomLabel"
                                                >
                                                    <div class="offcanvas-header">
                                                        <h5
                                                            class="offcanvas-title"
                                                            id="offcanvasBottomLabel"
                                                        >
                                                            اختر مناسبة العزيمة
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close text-reset"
                                                            data-bs-dismiss="offcanvas"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="offcanvas-body small">
                                                        <div class="choose_suitable p-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center my-4"
                                                            >
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-between align-items-center my-4"
                                                            >
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-between align-items-center my-4"
                                                            >
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-between align-items-center my-4"
                                                            >
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="d-flex justify-content-center gap-3 align-items-center my-4"
                                                            >
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                                <button value="1">
                                                                    <img src="./image/1.png" alt="" />
                                                                    <p>صداقة</p>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <select></select> -->
                                            </div>
                                        </div>
                                        <div class="message">
                                            <div class="container_input">
                                                <!-- <i class="fa fa-phone"></i> -->
                                                <textarea
                                                    id="message"
                                                    placeholder=" الرسالة"
                                                    rows="5"
                                                ></textarea>
                                            </div>
                                        </div>
                                        <div class="send_message">
                                            <label for="send_message">رسالة العزيمة عبر :</label>
                                            <div class="d-flex align-items-center my-3">
                                                <div class="WhatsApp d-flex align-items-center">
                                                    <input
                                                        type="radio"
                                                        name="send_message"
                                                        value="WhatsApp"
                                                        id="WhatsApp"
                                                    />
                                                    <label for="WhatsApp"> WhatsApp</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <button class="global_btn d-block m-auto">
                                      <i class="fa-solid fa-cart-shopping text-white"></i>
                                      اضافة للسلة
                                    </button> -->
                                </form>
                            </div>
                        </div>
                        <div class="bg-white main_wrap mb-3">
                            <div class="cart-item">
                                <div class="image">
                                    <img src="./image/cover1.jpg" alt="" />
                                </div>
                                <div class="details">
                                    <h6>اسم الوجبة</h6>
                                    <img
                                        src="./image//logo.png"
                                        alt="logo"
                                        width="22"
                                        height="22"
                                    />
                                    <small>برغر كينغ</small>
                                    <p class="my-1">
                                        وصف قصير عن الوجبة هنا وصف قصير عن الوجبة هناوصف قصير عن
                                        الوجبة هنا وصف قصير عن الوجبة هنا
                                    </p>
                                    <div
                                        class="action d-flex align-items-center justify-content-between"
                                    >
                                        <div>
                                            <del>60</del>
                                            <span>45.5</span>
                                            <small> ر.س</small>
                                        </div>
                                        <div
                                            class="action_operation d-flex align-items-center justify-content-between"
                                        >
                                            <button class="border-0">+</button>
                                            <span class="text-dark"> 2 </span>
                                            <button class="border-0">-</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="addto_3azema px-4">
                                <div class="image d-inline-block">
                                    <img src="./image//letter.jpg" alt="" />
                                </div>
                                <h5 class="d-inline-block">معلومات العزيمة</h5>
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" />
                                    <label class="text_checkbox mx-2">
                                        تتضمن مع العزيمة السابقة (فهد الغامدي)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    id="pills-profile"
                    role="tabpanel"
                    aria-labelledby="pills-profile-tab"
                >
                    <div class="orderId mx-3 my-4 p-3 bg-white">
                        <div
                            class="details_order d-flex align-items-center justify-content-between"
                        >
                            <h6 class="numberOrder">الطلب رقم 6546-A</h6>
                            <h6 class="time">
                                <i class="fa-regular fa-clock prv_order mx-1"></i> منذ
                                ساعتين
                            </h6>
                        </div>
                        <div class="details_restaurant my-2">
                            <img
                                src="./image//logo.png"
                                alt="logo"
                                width="28"
                                height="28"
                            />
                            <small>برغر كينغ</small>
                            <div class="meals d-flex align-items-center my-1">
                                <div class="myMeal">
                                    <img src="./image/cover1.jpg" />
                                    <span class="amount_of_meals"> 3</span>
                                </div>
                                <div class="myMeal mx-2">
                                    <img src="./image/cover1.jpg" />
                                </div>
                                <div class="myMeal">
                                    <img src="./image/cover1.jpg" />
                                    <span class="amount_of_meals"> 2</span>
                                </div>
                            </div>
                        </div>
                        <!-- Meals for each restaurant -->
                        <div class="details_restaurant my-2">
                            <img
                                src="./image//logo.png"
                                alt="logo"
                                width="28"
                                height="28"
                            />
                            <small>Divine French Dining </small>
                            <div class="meals d-flex align-items-center my-1">
                                <div class="myMeal">
                                    <img src="./image/cover1.jpg" />
                                    <span class="amount_of_meals"> 3</span>
                                </div>
                                <div class="myMeal mx-2">
                                    <img src="./image/cover1.jpg" />
                                </div>
                                <div class="myMeal">
                                    <img src="./image/cover1.jpg" />
                                    <span class="amount_of_meals"> 2</span>
                                </div>
                            </div>
                        </div>
                        <!-- Meals for each restaurant -->
                        <div
                            class="footer_orderId my-3 d-flex align-items-center justify-content-between"
                        >
                  <span class="price"
                  ><small class="font-weight-bold"> 45</small> ر.س</span
                  >
                            <div class="action_btn">
                                <button class="restrotion bg-white mx-1 px-2 py-2">
                                    <i class="fa-solid fa-rotate-right"></i>
                                    إعادة
                                </button>
                                <button class="global_btn">
                                    <a class='text-white' href='/details_myorder'>
                                        التفاصيل</a
                                    >
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="total bg-white px-4 py-2" id="total_followPayment">
        <div class="d-flex align-items-center justify-content-between w-100">
            <div class="total_price">
                <p>الإجمالي</p>
                <p><span> 91.0</span> ر.س</p>
            </div>
            <div class="payment">
                <a href='/wayofpayment'>
                    متابعة إلى الدفع
                    <i class="fa-solid fa-angle-left"></i>
                </a>
            </div>
        </div>
    </div>
    <footer
        class="px-4 py-3 d-flex align-items-center justify-content-around"
    >
        <div class="mainHome d-flex flex-column align-items-center">
            <a href='/home'> <i class="fa fa-house"></i></a>
            <a href='/home'> الرئيسية</a>
        </div>
        <div class="myorder d-flex flex-column align-items-center">
            <a href='/cart'> <i class="fa-solid fa-cart-shopping"></i></a>
            <a href='/cart'> طلباتي</a>
        </div>
        <div class="myAccount d-flex flex-column align-items-center">
            <a href='/myaccount'> <i class="fa-solid fa-user"></i></a>
            <a href='/myaccount'> حسابي</a>
        </div>
    </footer>
</div>
<script src="./js/GetProductToCart.js"></script>
<script src="js/bootstrap.bundle.js"></script>
</body>
</html>
<style>
    .action_operation {
        background-color: #f8f8f8;
        border-radius: 8px;
        padding: 10px;
        width: 100px;
    }
    .action_operation button {
        color: var(--main_color);
        background: none;
    }

    #total_followPayment {
        display: block;
        border-bottom: 1px solid var(--bg-btn);
        border-radius: 15px 15px 0px 0px;
        /* box-shadow: ; */
        box-shadow: 2px 2px 12px 2px #dbd7d724;
    }
    .orderId {
        border-radius: 10px;
    }
    .orderId .time,
    .orderId .time i {
        color: var(--second_color);
        font-size: 12px;
        font-weight: 400;
    }
    .myMeal {
        width: 55px;
        height: 55px;
        position: relative;
    }
    .myMeal img {
        width: 100%;
        height: 100%;
        border-radius: 13px;
        object-fit: cover;
        /* position: relative; */
    }
    .myMeal .amount_of_meals {
        background-color: var(--black_color);
        color: white;
        position: absolute;
        content: "";
        right: -3px;
        bottom: -3px;
        z-index: 999;
        width: 22px;
        height: 22px;
        line-height: 22px;
        border-radius: 50%;
        text-align: center;
        font-size: 14px;
    }
    .footer_orderId span {
        font-weight: 300;
        color: var(--second_color);
        font-size: 13px;
    }
    .footer_orderId span small {
        color: var(--black_color) !important;
        font-weight: 500 !important;
        font-size: 16px !important;
    }
    #cartItemsContainer,
    .cartItemsContainer {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .details p,
    small {
        color: var(--second_color) !important;
        font-size: 13px;
    }
    .details del {
        color: var(--second_color) !important;
    }
    .details .action span {
        color: var(--main_color);
        font-weight: 700;
    }
    #cartItemsContainer i {
        font-size: 48px;
        color: var(--second_color);
    }
    #cartItemsContainer p {
        color: var(--second_color);
        font-weight: 400;
        margin: 15px 0;
    }

    #cartItemsContainer a {
        background: #f79b36;
        border: none;
        color: white;
        margin: 30px auto;
        text-align: center;
        min-width: 110px;
        display: block;
        padding: 8px 15px;
        font-size: 18px;
        border-radius: 8px;
    }
    .teeeeest .nav-link {
        color: var(--black_color);
        font-size: 12px;
    }
    .teeeeest .nav-pills .nav-link.active,
    .nav-pills .show > .nav-link {
        background-color: var(--black_color);
        margin: 0 10px;
    }
    .teeeeest .nav-pills .nav-link,
    .nav-pills .show > .nav-link {
        background-color: white;
        margin: 0 10px;
    }
    .teeeeest .nav-link i {
        font-size: 14px;
        margin: 0 10px;
    }
    .teeeeest .prv_order {
        color: #f79b36;
    }
    .wrapper-class {
        width: 100%;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .wrapper-class p {
        color: var(--black_color) !important;
    }
    .wrapper-class div {
        color: red !important;
        font-size: 12px !important;
    }
    .main_wrap {
        border-radius: 8px;
        padding-bottom: 20px;
    }
    .cart-item {
        display: flex;
        flex-direction: row;
        column-gap: 30px;
        margin: 10px 0;
        padding: 15px;
    }
    .cart-item p {
        font-size: 12px;
        font-weight: 300;
    }
    @media (max-width: 768px) {
        /* .cart-item .image {
          width: 300px !important;
          height: 150px !important;
        } */
        .cart-item p {
            font-size: 10px;
        }
        .details h6 {
            font-size: 12px !important;
            font-weight: 400;
        }
        .details .action span {
            font-weight: 500;
            font-size: 14px !important;
        }
        .numberOrder,
        .orderId .time {
            font-size: 12px;
            font-weight: 400;
        }
        .choose_suitable button p {
            font-size: 10px;
            font-weight: 400;
        }
    }
    .choose_suitable button {
        background: #f4f4f4;
        border: none;
        border-radius: 8px;
        width: 90px;
        height: 90px;
    }
    .choose_suitable .row {
        background-color: red !important;
    }
    .cart-item .image {
        width: 160px;
        height: 100px;
    }
    .cart-item .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    .payment {
        background: #f79b36;
        border: none;
        color: white;
        min-width: 110px;
        /* display: block; */
        padding: 8px 15px;
        border-radius: 8px;
        /* transitio/n: all var(--transtion) ease-in-out; */
        /* &:active {
          background-color: var(--bg-btn);
        } */
    }
    .payment a {
        color: white;
        font-size: 14px;
    }
    .payment a i {
        margin: 0 10px;
    }
    /* .total {
      border-bottom: 1px solid var(--bg-btn);
      border-radius: 15px 15px 0px 0px;
      /* box-shadow: ; */
    /* box-shadow: 2px 2px 12px 2px #dbd7d724; */
    /* } */
    .total_price p:nth-child(2) span {
        color: #f79b36;
    }
    .text_checkbox {
        font-size: 12px;
    }
    .inf_3azema {
        border-radius: 8px;
        border: 1px solid #f8f8f8;
        margin: 0 10px;
        padding: 15px 10px;
    }
    .inf_3azema .image,
    .addto_3azema .image {
        width: 13px;
        height: 16px;
    }
    .inf_3azema .image img,
    .addto_3azema .image img {
        width: 100%;
        height: 100%;
    }
    .inf_3azema,
    .addto_3azema {
    h5,
    .send_message {
        font-weight: 400;
        font-size: 12px;
    }
    }
    ::placeholder {
        font-size: 12px;
    }
    @media (max-width: 768px) {
        .inf_3azema .image {
            width: 11.5px;
            height: 16px;
        }
    }
    .inf_3azema .btn_custom {
        background: transparent !important;
        width: 100%;
        text-align: start;
        display: flex;
        justify-content: space-between;
        color: #c7c7c7;
    }
    .inf_3azema .btn_custom:focus {
        box-shadow: 0 0 0 0.25rem transparent;
    }

    ::placeholder {
        color: #c7c7c7;
    }
    .fa-heart {
        margin-right: -10px;
    }
    .send_message {
        font-size: 16px;
    }
</style>
