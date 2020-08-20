<?php

if (!isset($_SESSION['account'])) {
    session_start();
}
// KHÔNG CÓ LỆNH
if (!isset($_GET['router']) && !isset($_POST['router']) && !isset($_GET['control']) && !isset($_POST['control'])) {
    if (isset($_SESSION['account']) && isset($_SESSION['password'])) {
        $account = $_SESSION['account'];
        $password = $_SESSION['password'];
        if ($account === 'admin' && $password === 'levinhthanh') {
            $display_list_customer = 'none';
            $display_add_employee = 'none';
            $display_add_product = 'none';
            $display_list_product  = 'none';
            $display_edit_product  = 'none';
            $display_list_employee = 'none';
            $display_edit_employee = "none";
            include('View/admin_view.php');
        } else {
            if ($account[0] === '$') {
                include('View/employee_view.php');
            } else {
                $display_list_customer = 'none';
                include('Model/home_model.php');
                include('View/home_view.php');
            }
        }
    } else {
        include('Model/home_model.php');
        include('View/home_view.php');
    }
}
// TỒN TẠI GET-ROUTER
if (isset($_GET['router'])) {
    $router = $_GET['router'];
    switch ($router) {
        case 'admin': {
                include('Controller/Controller_admin.php');
                break;
            }
        case 'employee': {
                include('Controller/Controller_employee.php');
                break;
            }
        case 'customer': {
                include('Controller/Controller_customer.php');
                break;
            }
    }
}
// TỒN TẠI POST-ROUTER
if (isset($_POST['router'])) {
    $router = $_POST['router'];
    switch ($router) {
        case 'admin': {
                include('Controller/Controller_admin.php');
                break;
            }
        case 'employee': {
                include('Controller/Controller_employee.php');
                break;
            }
        case 'customer': {
                include('Controller/Controller_customer.php');
                break;
            }
    }
}
// VÀO TRANG ĐĂNG NHẬP
if (isset($_GET['control']) && $_GET['control'] === 'login') {
    $error_login = "";
    include('View/login_view.php');
}
// VÀO TRANG ĐĂNG KÝ
if (isset($_GET['control']) && $_GET['control'] === 'register') {
    include('Model/register_model.php');
    include('View/register_view.php');
}
// YÊU CẦU ĐĂNG KÝ
if (isset($_POST['control']) && $_POST['control'] === 'require_register') {
    include('Model/register_model.php');
    include('View/register_view.php');
}
// YÊU CẦU ĐĂNG NHẬP
if (isset($_POST['control']) && $_POST['control'] === 'require_login') {
    $account = $_POST['account'];
    $password = $_POST['password'];
    $result_check = System::check_login($account, $password);
    if ($result_check['status_login'] === 'success') {
        $_SESSION['account'] = $account;
        $_SESSION['password'] = $password;
        if ($result_check['account_of'] === 'admin') {
            $check_admin = true;
            include('Controller/Controller_admin.php');
        }
        if ($result_check['account_of'] === 'employee') {
            include('View/employee_view.php');
        }
        if ($result_check['account_of'] === 'customer') {
            include('Model/home_model.php');
            include('View/home_view.php');
        }
    } else {
        $error_login = $result_check['error_login'];
        include('View/login_view.php');
    }
}
