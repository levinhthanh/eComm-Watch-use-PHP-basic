<?php
// Khai báo
$display_list_customer = 'none';
$delete_customer = "none";
$edit_customer = "none";

$display_list_product = 'none';
$delete_product = "none";
$display_edit_product = "none";

$display_add_product = 'none';
$lable_confirm = 'none';
$status_add = "";
$name = "";
$name_status = 'fas fa-pencil-alt';
$name_color = 'black';
$price_buy = "";
$price_buy_status = 'fas fa-pencil-alt';
$price_buy_color = 'black';
$price_sale = "";
$price_sale_status = 'fas fa-pencil-alt';
$price_sale_color = 'black';
$count = "";
$count_status = 'fas fa-pencil-alt';
$count_color = 'black';

$display_list_employee = 'none';
$delete_employee = "none";
$display_edit_employee = "none";
$status_update = "";
$display_add_employee = "none";
$fullname_employee = "";
$fullname_color = 'black';
$fullname_status = 'fas fa-pencil-alt';
$birthday_employee = "";
$birthday_color = 'black';
$birthday_status = 'fas fa-pencil-alt';
$address_employee = "";
$address_color = 'black';
$address_status = 'fas fa-pencil-alt';
$phone_employee = "";
$phone_color = 'black';
$phone_status = 'fas fa-pencil-alt';
$email_employee = "";
$email_color = 'black';
$email_status = 'fas fa-pencil-alt';
$account_employee = "";
$account_color = 'black';
$account_status = 'fas fa-pencil-alt';
$password_employee = "";
$password_color = 'black';
$password_status = 'fas fa-pencil-alt';
$salary_employee = "";
$salary_color = 'black';
$salary_status = 'fas fa-pencil-alt';
$lable_confirm = 'none';
// Chọn kênh
if (isset($_GET['control'])) {
    $control = $_GET['control'];
    switch ($control) {
        case 'edit_product': {
                $code = $_GET['code'];
                $name = $_GET['name'];
                $display_edit_product = 'block';
                $table_one_product = Admin::get_one_product($code);
                include('View/admin_view.php');
                break;
            }
        case 'delete_product': {
                $code = $_GET['code'];
                $name = $_GET['name'];
                $display_list_product = 'block';
                $table_list_product = Admin::get_list_products();
                $delete_product = "block";
                include('View/admin_view.php');
                break;
            }
        case 'show_product_list': {
                $display_list_product = 'block';
                $table_list_product = Admin::get_list_products();
                include('View/admin_view.php');
                break;
            }
        case 'add_product': {
                $display_add_product = 'block';
                include('View/admin_view.php');
                break;
            }
        case 'show_employee_list': {
                $display_list_employee = 'block';
                $table_list_employee = Admin::get_list_employees();
                include('View/admin_view.php');
                break;
            }
        case 'delete_employee': {
                $code = $_GET['code'];
                $name = $_GET['name'];
                $display_list_employee = 'block';
                $table_list_employee = Admin::get_list_employees();
                $delete_employee = "block";
                include('View/admin_view.php');
                break;
            }
        case 'add_employee': {
                $display_add_employee = 'block';
                include('View/admin_view.php');
                break;
            }
        case 'logout': {
                $hiUser = "";
                $log_in = "block";
                $log_out = "none";
                session_destroy();
                include('Model/home_model.php');
                include('View/home_view.php');
                break;
            }
        case 'show_customer_list': {
                $display_list_customer = 'block';
                $table_list_customer = Admin::get_list_customers();
                include('View/admin_view.php');
                break;
            }
        case 'delete_customer': {
                $code = $_GET['code'];
                $name = $_GET['name'];
                $display_list_customer = 'block';
                $table_list_customer = Admin::get_list_customers();
                $delete_customer = "block";
                include('View/admin_view.php');
                break;
            }
        case 'edit_customer': {
                $code = $_GET['code'];
                $name = $_GET['name'];
                $display_list_customer = 'block';
                $table_list_customer = Admin::get_list_customers();
                $edit_customer = "block";
                include('View/admin_view.php');
                break;
            }
        case 'edit_employee': {
                $code = $_GET['code'];
                $name = $_GET['name'];
                $table_one_employee = Admin::get_one_employee($code);
                $display_edit_employee = "block";
                include('View/admin_view.php');
                break;
            }
    }
}
if (isset($_POST['control'])) {
    $control = $_POST['control'];
    switch ($control) {
        case 'require_update_product': {
                $display_edit_product = "block";

                $code = $_POST['code'];
                $name = $_POST['name'];
                $price_buy = $_POST['price_buy'];
                $price_sale = $_POST['price_sale'];
                $count = $_POST['count'];
                $line_name = $_POST['line'];
                $image1 = $_FILES['image1'];
                move_uploaded_file($image1['tmp_name'], 'View/images/watchs/' . $image1['name']);
                $image2 = $_FILES['image2'];
                move_uploaded_file($image2['tmp_name'], 'View/images/watchs/' . $image2['name']);
                $image3 = $_FILES['image3'];
                move_uploaded_file($image3['tmp_name'], 'View/images/watchs/' . $image3['name']);
                $status = $_POST['status'];
                $is_hot = $_POST['is_hot'];
                $is_new = $_POST['is_new'];
                $hot_sale = $_POST['hot_sale'];
                $result = Admin::validate_update_product(
                    $name,
                    $price_buy,
                    $price_sale,
                    $count,
                    $hot_sale
                );
                if ($result['status'] === 'success') {
                    Admin::update_product(
                        $code,
                        $name,
                        $price_buy,
                        $price_sale,
                        $count,
                        $line_name,
                        $image1,
                        $image2,
                        $image3,
                        $status,
                        $is_hot,
                        $is_new,
                        $hot_sale
                    );
                    $status_update = "Bạn đã cập nhật sản phẩm thành công!";
                }
                if ($result['status'] === 'error') {
                    $status_update = "Có lỗi, vui lòng kiểm tra đầu vào lại!";
                }
                $table_one_product = Admin::get_one_product($code);
                $display_edit_product = "block";
                include('View/admin_view.php');
                break;
            }
        case 'require_delete_product': {
                $display_list_product = 'block';
                $code = $_POST['code'];
                Admin::delete_product($code);
                $table_list_product = Admin::get_list_products();
                include('View/admin_view.php');
                break;
            }
        case 'require_add_product': {
                $name = $_POST['name'];
                $price_buy = $_POST['price_buy'];
                $price_sale = $_POST['price_sale'];
                $count = $_POST['count'];
                $line = $_POST['line'];
                $image1 = $_FILES['image1'];
                move_uploaded_file($image1['tmp_name'], 'View/images/watchs/' . $image1['name']);
                $image2 = $_FILES['image2'];
                move_uploaded_file($image2['tmp_name'], 'View/images/watchs/' . $image2['name']);
                $image3 = $_FILES['image3'];
                move_uploaded_file($image3['tmp_name'], 'View/images/watchs/' . $image3['name']);
                $status = $_POST['status'];
                if (isset($_POST['is_new'])) {
                    $is_new = $_POST['is_new'];
                } else {
                    $is_new = 'not';
                }
                if (isset($_POST['is_hot'])) {
                    $is_hot = $_POST['is_hot'];
                } else {
                    $is_hot = 'not';
                }
                $result = Admin::validate_product($name, $price_buy, $price_sale, $count);
                if ($result['status'] === 'success') {
                    Admin::save_new_product(
                        $name,
                        $price_buy,
                        $price_sale,
                        $count,
                        $line,
                        $image1,
                        $image2,
                        $image3,
                        $status,
                        $is_new,
                        $is_hot
                    );
                    $name_color = 'green';
                    $name_status = 'fas fa-check';
                    $price_buy_color = 'green';
                    $price_buy_status = 'fas fa-check';
                    $price_sale_color = 'green';
                    $price_sale_status = 'fas fa-check';
                    $count_color = 'green';
                    $count_status = 'fas fa-check';
                    $display_add_product = 'block';
                    $lable_confirm = 'block';
                    $status_add = 'Bạn đã thêm sản phẩm thành công!';
                    include('View/admin_view.php');
                    break;
                } else {
                    if ($result['name'] === 'error') {
                        $name_color = 'red';
                        $name_status = 'fas fa-times';
                    } else {
                        $name_color = 'green';
                        $name_status = 'fas fa-check';
                    }
                    if ($result['price_buy'] === 'error') {
                        $price_buy_color = 'red';
                        $price_buy_status = 'fas fa-times';
                    } else {
                        $price_buy_color = 'green';
                        $price_buy_status = 'fas fa-check';
                    }
                    if ($result['price_sale'] === 'error') {
                        $price_sale_color = 'red';
                        $price_sale_status = 'fas fa-times';
                    } else {
                        $price_sale_color = 'green';
                        $price_sale_status = 'fas fa-check';
                    }
                    if ($result['count'] === 'error') {
                        $count_color = 'red';
                        $count_status = 'fas fa-times';
                    } else {
                        $count_color = 'green';
                        $count_status = 'fas fa-check';
                    }
                    $display_add_product = 'block';
                    $lable_confirm = 'block';
                    $status_add = 'Có lỗi, bạn vui lòng kiểm tra lại!';
                    include('View/admin_view.php');
                    break;
                }
            }
        case 'require_update_employee': {
                $display_edit_employee = "block";

                $code = $_POST['code'];
                $fullname_employee = $_POST['fullname_employee'];
                $birthday_employee = $_POST['birthday_employee'];
                $address_employee = $_POST['address_employee'];
                $phone_employee = $_POST['phone_employee'];
                $email_employee = $_POST['email_employee'];
                $possition_employee = $_POST['possition_employee'];
                $salary_employee = $_POST['salary_employee'];
                $join_day = $_POST['join_day'];
                $account_name = $_POST['account_name'];
                $account_status = $_POST['account_status'];
                $result = Admin::validate_update_employee(
                    $fullname_employee,
                    $birthday_employee,
                    $address_employee,
                    $phone_employee,
                    $email_employee,
                    $possition_employee,
                    $salary_employee,
                    $join_day,
                    $account_name,
                    $account_status
                );

                if ($result['status'] === 'success') {
                    Admin::update_employee(
                        $code,
                        $fullname_employee,
                        $birthday_employee,
                        $address_employee,
                        $phone_employee,
                        $email_employee,
                        $possition_employee,
                        $salary_employee,
                        $join_day,
                        $account_name,
                        $account_status
                    );
                    $status_update = "Bạn đã cập nhật nhân viên thành công!";
                }
                if ($result['status'] === 'error') {
                    $display_edit_employee = "block";
                    $status_update = "Có lỗi, vui lòng kiểm tra đầu vào lại!";
                }
                $table_one_employee = Admin::get_one_employee($code);
                $display_edit_employee = "block";
                include('View/admin_view.php');
                break;
            }
        case 'require_delete_employee': {
                $display_list_employee = 'block';
                $code = $_POST['code'];
                Admin::delete_employee($code);
                $table_list_employee = Admin::get_list_employees();
                include('View/admin_view.php');
                break;
            }
        case 'require_add_employee': {
                $fullname_employee = $_POST['fullname_employee'];
                $birthday_employee = $_POST['birthday_employee'];
                $address_employee = $_POST['address_employee'];
                $phone_employee = $_POST['phone_employee'];
                $email_employee = $_POST['email_employee'];
                $account_employee = $_POST['account_employee'];
                $password_employee = $_POST['password_employee'];
                $possition_employee = $_POST['possition_employee'];
                $salary_employee = $_POST['salary_employee'];
                $result = Admin::validate_employee(
                    $fullname_employee,
                    $birthday_employee,
                    $address_employee,
                    $phone_employee,
                    $email_employee,
                    $account_employee,
                    $password_employee,
                    $possition_employee,
                    $salary_employee
                );
                if ($result['status'] === 'success') {
                    Admin::save_new_employee(
                        $fullname_employee,
                        $birthday_employee,
                        $address_employee,
                        $phone_employee,
                        $email_employee,
                        $account_employee,
                        $password_employee,
                        $possition_employee,
                        $salary_employee
                    );
                    $fullname_color = 'green';
                    $fullname_status = 'fas fa-check';
                    $birthday_color = 'green';
                    $birthday_status = 'fas fa-check';
                    $address_color = 'green';
                    $address_status = 'fas fa-check';
                    $phone_color = 'green';
                    $phone_status = 'fas fa-check';
                    $email_color = 'green';
                    $email_status = 'fas fa-check';
                    $account_color = 'green';
                    $account_status = 'fas fa-check';
                    $password_color = 'green';
                    $password_status = 'fas fa-check';
                    $salary_color = 'green';
                    $salary_status = 'fas fa-check';
                    $display_add_employee = 'block';
                    $lable_confirm = 'block';
                    include('View/admin_view.php');
                    break;
                } else {
                    if ($result['fullname'] === 'error') {
                        $fullname_color = 'red';
                        $fullname_status = 'fas fa-times';
                    } else {
                        $fullname_color = 'green';
                        $fullname_status = 'fas fa-check';
                    }
                    if ($result['birthday'] === 'error') {
                        $birthday_color = 'red';
                        $birthday_status = 'fas fa-times';
                    } else {
                        $birthday_color = 'green';
                        $birthday_status = 'fas fa-check';
                    }
                    if ($result['address'] === 'error') {
                        $address_color = 'red';
                        $address_status = 'fas fa-times';
                    } else {
                        $address_color = 'green';
                        $address_status = 'fas fa-check';
                    }
                    if ($result['phone'] === 'error') {
                        $phone_color = 'red';
                        $phone_status = 'fas fa-times';
                    } else {
                        $phone_color = 'green';
                        $phone_status = 'fas fa-check';
                    }
                    if ($result['email'] === 'error') {
                        $email_color = 'red';
                        $email_status = 'fas fa-times';
                    } else {
                        $email_color = 'green';
                        $email_status = 'fas fa-check';
                    }
                    if ($result['account'] === 'error') {
                        $account_color = 'red';
                        $account_status = 'fas fa-times';
                    } else {
                        $account_color = 'green';
                        $account_status = 'fas fa-check';
                    }
                    if ($result['password'] === 'error') {
                        $password_color = 'red';
                        $password_status = 'fas fa-times';
                    } else {
                        $password_color = 'green';
                        $password_status = 'fas fa-check';
                    }
                    if ($result['possition'] === 'error') {
                        $possition_color = 'red';
                        $possition_status = 'fas fa-times';
                    } else {
                        $possition_color = 'green';
                        $possition_status = 'fas fa-check';
                    }
                    if ($result['salary'] === 'error') {
                        $salary_color = 'red';
                        $salary_status = 'fas fa-times';
                    } else {
                        $salary_color = 'green';
                        $salary_status = 'fas fa-check';
                    }
                    $display_add_employee = 'block';
                    include('View/admin_view.php');
                    break;
                }
            }
        case 'require_delete_customer': {
                $display_list_customer = 'block';
                $code = $_POST['code'];
                Admin::delete_customer($code);
                $table_list_customer = Admin::get_list_customers();
                include('View/admin_view.php');
                break;
            }
        case 'require_edit_customer': {
                $display_list_customer = 'block';
                $code = $_POST['code'];
                Admin::edit_customer($code);
                $table_list_customer = Admin::get_list_customers();
                include('View/admin_view.php');
                break;
            }
    }
}


if (isset($check_admin) && $check_admin === true) {
    include('View/admin_view.php');
}


if (!isset($_GET['control']) && !isset($_POST['control'])) {
    include('View/admin_view.php');
}
