<?php
// VÀO TRANG ĐĂNG KÝ
if (isset($_GET['control']) && $_GET['control'] === 'register') {
    $register_success = "";
    $go_to_login = "none";

    $fullname = "";
    $birthday = "";
    $address = "";
    $phone = "";
    $email = "";
    $account = "";
    $password = "";
    $pass_repeat = "";

    $fullname_error = "";
    $birthday_error = "";
    $address_error = "";
    $phone_error = "";
    $email_error = "";
    $account_error = "";
    $password_error = "";
    $pass_repeat_error = "";
}
// YÊU CẦU ĐĂNG KÝ
if (isset($_POST['control']) && $_POST['control'] === 'require_register') {
    $register_success = "";
    $go_to_login = "none";

    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $account = $_POST['account'];
    $password = $_POST['password'];
    $pass_repeat = $_POST['pass_repeat'];

    $check_register = System::validate_account($fullname, $birthday, $address, $phone, $email, $account, $password, $pass_repeat);
    if ($check_register['result'] === 'success') {
        System::save_new_account($fullname, $birthday, $address, $phone, $email, $account, $password);
        $register_success = "Chúc mừng bạn đã đăng ký thành công!";
        $go_to_login = "block";
        $fullname_error = "";
        $birthday_error = "";
        $address_error = "";
        $phone_error = "";
        $email_error = "";
        $account_error = "";
        $password_error = "";
        $pass_repeat_error = "";
    } else {
        if ($check_register['result'] === 'error') {
            $fullname_error = $check_register['fullname_error'];
            $birthday_error = $check_register['birthday_error'];
            $address_error = $check_register['address_error'];
            $phone_error = $check_register['phone_error'];
            $email_error = $check_register['email_error'];
            $account_error = $check_register['account_error'];
            $password_error = $check_register['password_error'];
            $pass_repeat_error = $check_register['pass_repeat_error'];
        }
    }
}
