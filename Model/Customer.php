<?php

class Customer
{

    public static function get_line_list($line)
    {
        $title_line = strtoupper($line);
        $line_list_group = "<label id='lable_product_list'>~ SẢN PHẨM $title_line ~</label><div class='grid_products'>";
        $product_show_data = new CRUD_database;
        $product_show_data->connect();
        $data_products = $product_show_data->executeAll("SELECT * FROM list_products");

        $product_code = [];
        $product_name = [];
        $product_images = [];
        $product_price_sale = [];
        $line_name = [];
        $product_line = [];
        $i = 0;
        foreach ($data_products as $key => $value) {
            $product_code[$i] = $value['product_code'];
            $product_name[$i] = $value['product_name'];
            $product_images[$i] = $value['image1'];
            $product_price_sale[$i] = $value['price_sale'];
            $product_price_sale[$i] = number_format($product_price_sale[$i], 0, ',', '.');
            $line_name[$i] = $value['line_name'];
       
            if ($line_name[$i] === "$line" && $i < 30) {
                $product_line[$i] = "<div class='product_show'><form action='index.php' method='post'>
                                   <input type='hidden' name='router' value='customer'>
                                   <input type='hidden' name='control' value='add_to_box'>
                                   <input type='hidden' name='product_code' value=" . $product_code[$i] . ">
                                   <img id='image_product_show' src='$product_images[$i]'>
                                   <a id='name_product_show' href='index.php?router=customer&control=watch_product&product=" . $product_code[$i] . "'>" . $product_name[$i] . "</a>
                                   <label id='price_product_show'>" . $product_price_sale[$i] . "đ</label>
                                   <button id='button_product_show'>Thêm vào giỏ hàng</button></form></div>";
                $line_list_group .= $product_line[$i];
            }
            $i++;
        }
        $line_list_group .= '</div>';
        return $line_list_group;
    }

    public static function get_hot_list()
    {
        $hot_list_group = "<label id='lable_product_list'>~ SẢN PHẨM HOT ~</label><div class='grid_products'>";
        $product_show_data = new CRUD_database;
        $product_show_data->connect();
        $data_products = $product_show_data->executeAll("SELECT * FROM list_products");

        $product_code = [];
        $product_name = [];
        $product_images = [];
        $product_price_sale = [];
        $is_hot = [];
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
                $product_hot[$i] = "<div class='product_show'><form action='index.php' method='post'>
                                   <input type='hidden' name='router' value='customer'>
                                   <input type='hidden' name='control' value='add_to_box'>
                                   <input type='hidden' name='product_code' value=" . $product_code[$i] . ">
                                   <img id='image_product_show' src='$product_images[$i]'>
                                   <a id='name_product_show' href='index.php?router=customer&control=watch_product&product=" . $product_code[$i] . "'>" . $product_name[$i] . "</a>
                                   <label id='price_product_show'>" . $product_price_sale[$i] . "đ</label>
                                   <button id='button_product_show'>Thêm vào giỏ hàng</button></form></div>";
                $hot_list_group .= $product_hot[$i];
            }
            $i++;
        }
        $hot_list_group .= '</div>';
        return $hot_list_group;
    }

    public static function get_new_list()
    {
        $new_list_group = "<label id='lable_product_list'>~ SẢN PHẨM MỚI ~</label><div class='grid_products'>";
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
                $product_new[$i] = "<div class='product_show'><form action='index.php' method='post'>
                                   <input type='hidden' name='router' value='customer'>
                                   <input type='hidden' name='control' value='add_to_box'>
                                   <input type='hidden' name='product_code' value=" . $product_code[$i] . ">
                                   <img id='image_product_show' src='$product_images[$i]'>
                                   <a id='name_product_show' href='index.php?router=customer&control=watch_product&product=" . $product_code[$i] . "'>" . $product_name[$i] . "</a>
                                   <label id='price_product_show'>" . $product_price_sale[$i] . "đ</label>
                                   <button id='button_product_show'>Thêm vào giỏ hàng</button></form></div>";
                $new_list_group .= $product_new[$i];
            }
            $i++;
        }
        $new_list_group .= '</div>';
        return $new_list_group;
    }
}
