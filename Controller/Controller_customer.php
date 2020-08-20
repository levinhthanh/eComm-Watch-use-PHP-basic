<?php

if (isset($_POST['control'])) {
    $control = $_POST['control'];
    switch ($control) {
        case "add_to_box": {
                if (!isset($_SESSION['count_in_box'])) {
                    $_SESSION['count_in_box'] = 0;
                }
                $product_new_add = $_POST['product_code'];
                $i = 1;
                $session = 'product_' . $i;
                while (isset($_SESSION[$session]) && $_SESSION[$session] != $product_new_add) {
                    $i++;
                    $session = 'product_' . $i;
                }
                if(!isset($_SESSION[$session])){
                    $_SESSION[$session] = $product_new_add;
                    $_SESSION['count_in_box'] += 1;
                }
                include('Model/home_model.php');
                include('View/home_view.php');
                break;
            }
    }
}

if (isset($_GET['control'])) {
    $control = $_GET['control'];
    switch ($control) {
        case 'logout': {
                $hiUser = "";
                $log_in = "block";
                $log_out = "none";
                session_destroy();
                include('Model/home_model.php');
                include('View/home_view.php');
                break;
            }
        case 'new_product_list': {
                include('Model/home_model.php');
                $new_list_group = Customer::get_new_list();
                $slide_show = 'none';
                $new_list = 'none';
                $hot_list = 'none';
                include('View/home_view.php');
                break;
            }
        case 'hot_product_list': {
                include('Model/home_model.php');
                $hot_list_group = Customer::get_hot_list();
                $slide_show = 'none';
                $new_list = 'none';
                $hot_list = 'none';
                include('View/home_view.php');
                break;
            }
        case 'watch_product': {
                $line = $_GET['product_line'];
                include('Model/home_model.php');
                $line_list_group = Customer::get_line_list($line);
                $slide_show = 'none';
                $new_list = 'none';
                $hot_list = 'none';
                include('View/home_view.php');
                break;
            }
    }
}
