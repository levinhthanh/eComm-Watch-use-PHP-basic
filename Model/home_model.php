<?php
$slide_show = 'block';
$new_list = 'block';
$hot_list = 'block';
$new_list_group = "";
$hot_list_group = "";
$line_list_group = "";

if (!isset($_SESSION['account']) && !isset($_SESSION['password'])) {
    $hiUser = "";
    $log_in = "block";
    $log_out = "none";
}
if (!isset($_SESSION['count_in_box']) || $_SESSION['count_in_box'] == 0) {
    $label_empty_display = "block";
    $count_in_box = 0;
    $box_products_show = "";
    $btn_buy_display = "none";
} else {
    $label_empty_display = "none";
    $count_in_box = $_SESSION['count_in_box'];
    $box_products_show = "";
    $i = 1;
    $session = 'product_' . $i;
    $count = 'product_count_' . $i;
    while (isset($_SESSION[$session])) {
        $pc = $_SESSION[$session];
        $product = new CRUD_database;
        $product->connect();
        $sql = "SELECT product_name FROM products WHERE product_code = $pc";
        $row = $product->executeOne($sql);
        $pn = $row['product_name'];
        $box_products_show .= "
                        <tr>
                            <td style='font-size: 1vw; color:yellow; text-align:left;'> $pn</td>
                        </tr>
                        ";
        $i++;
        $session = 'product_' . $i;
    }
    $btn_buy_display = "block";
}
if (isset($_SESSION['account']) && isset($_SESSION['password']) && $_SESSION['account'] !== 'admin') {
    $log_in = "none";
    $log_out = "block";
    $account = $_SESSION['account'];
    $check_account_code = new CRUD_database;
    $check_account_code->connect();
    $sql = "SELECT account_code FROM accounts WHERE account_name = '$account'";
    $row = $check_account_code->executeOne($sql);
    $account_code = $row['account_code'];
    $check_name = new CRUD_database;
    $check_name->connect();
    $sql = "SELECT customer_fullname FROM customers WHERE account_code = $account_code";
    $row = $check_name->executeOne($sql);
    $customer_name = $row['customer_fullname'];
    $hiUser = "Xin chào, $customer_name";
}

// SẢN PHẨM MỚI
$product_show_data = new CRUD_database;
$product_show_data->connect();
$data_products = $product_show_data->executeAll("SELECT * FROM list_products");

$product_code = [];
$product_name = [];
$product_images = [];
$product_price_sale = [];
$is_new = [];
$product_new = [];
$i = 0;
foreach ($data_products as $key => $value) {
    $product_code[$i] = $value['product_code'];
    $product_name[$i] = $value['product_name'];
    $product_images[$i] = $value['image1'];
    $product_price_sale[$i] = $value['price_sale'];
    $product_price_sale[$i] = number_format($product_price_sale[$i], 0, ',', '.');
    $is_new[$i] = $value['is_new'];
    if ($is_new[$i] === 'new' && $i < 30) {
        $product_new[$i] = "<form action='index.php' method='post'>
        <input type='hidden' name='router' value='customer'>
        <input type='hidden' name='control' value='add_to_box'>
        <input type='hidden' name='product_code' value=" . $product_code[$i] . ">
        <img id='image_product_show' src='$product_images[$i]'>
        <a id='name_product_show' href='index.php?router=customer&control=watch_product&product=" . $product_code[$i] . "'>" . $product_name[$i] . "</a>
        <label id='price_product_show'>" . $product_price_sale[$i] . "đ</label>
        <button id='button_product_show'>Thêm vào giỏ hàng</button></form>";
        $i++;
    }
}

// SẢN PHẨM HOT
$product_code = [];
$product_name = [];
$product_images = [];
$product_price_sale = [];
$is_new = [];
$product_hot = [];
$i = 0;
foreach ($data_products as $key => $value) {
    $product_code[$i] = $value['product_code'];
    $product_name[$i] = $value['product_name'];
    $product_images[$i] = $value['image1'];
    $product_price_sale[$i] = $value['price_sale'];
    $product_price_sale[$i] = number_format($product_price_sale[$i], 0, ',', '.');
    $is_hot[$i] = $value['is_hot'];
    if ($is_hot[$i] === 'hot' && $i < 30) {
        $product_hot[$i] = "<form action='index.php' method='post'>
        <input type='hidden' name='router' value='customer'>
        <input type='hidden' name='control' value='add_to_box'>
        <input type='hidden' name='product_code' value=" . $product_code[$i] . ">
        <img id='image_product_show' src='$product_images[$i]'>
        <a id='name_product_show' href='index.php?router=customer&control=watch_product&product=" . $product_code[$i] . "'>" . $product_name[$i] . "</a>
        <label id='price_product_show'>" . $product_price_sale[$i] . "đ</label>
        <button id='button_product_show'>Thêm vào giỏ hàng</button></form>";
        $i++;
    }
}
