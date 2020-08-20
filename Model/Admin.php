<?php

class Admin
{
    public static function update_product(
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
    ) {
        $line_code = new CRUD_database;
        $line_code->connect();
        $sql = "SELECT line_code FROM product_line WHERE line_name = '$line_name'";
        $row = $line_code->executeOne($sql);
        $line_code = $row['line_code'];
        
        $update_product = new CRUD_database;
        $update_product->connect();
        $sql = "UPDATE products SET 
        product_name = '$name',
        price_buy = '$price_buy',
        price_sale = '$price_sale',
        count = '$count',
        line_code = '$line_code',
        status = '$status',
        is_hot = '$is_hot',
        is_new = '$is_new',
        hot_sale = '$hot_sale'
        WHERE product_code = '$code'
        ";
        $update_product->updateData($sql);

        $image1 = 'View/images/watchs/' . $image1['name'];
        $image2 = 'View/images/watchs/' . $image2['name'];
        $image3 = 'View/images/watchs/' . $image3['name'];

        $images_code = new CRUD_database;
        $images_code->connect();
        $sql = "SELECT images_code FROM products WHERE product_code = '$code'";
        $row = $images_code->executeOne($sql);
        $images_code = $row['images_code'];

        $update_images = new CRUD_database;
        $update_images->connect();
        $sql = "UPDATE images SET image1 = '$image1', image2 = '$image2', image3 = '$image3' 
        WHERE images_code = $images_code";
        $update_images->updateData($sql);
    }


    public static function validate_update_product(
        $name,
        $price_buy,
        $price_sale,
        $count,
        $hot_sale
    ) {
        $checkForm = true;
        $register_result = [];

        if ($name === "") {
            $checkForm = false;
        }

        $check_buy = "/^[0-9]{5,10}$/";
        if ($price_buy === "" || !preg_match($check_buy, $price_buy)) {
            $checkForm = false;
        }

        $check_sale = "/^[0-9]{5,10}$/";
        if ($price_sale === "" || !preg_match($check_sale, $price_sale)) {
            $checkForm = false;
        }

        $check_count = "/^[0-9]{1,6}$/";
        if ($count === "" || !preg_match($check_count, $count)) {
            $checkForm = false;
        }

        $check_hot_sale = "/^[0-9]{1,2}$/";
        if ($hot_sale === "" || !preg_match($check_hot_sale, $hot_sale)) {
            $checkForm = false;
        }

        if ($checkForm) {
            $register_result['status'] = "success";
        } else {
            $register_result['status'] = "error";
        }
        return $register_result;
    }

    public static function get_one_product($code)
    {
        $table_one_product = "";
        $get_info = new CRUD_database;
        $get_info->connect();
        $sql = "SELECT * FROM list_products WHERE product_code = $code";
        $row = $get_info->executeOne($sql);
        // Thông tin sản phẩm
        $name = $row['product_name'];
        $price_buy = $row['price_buy'];
        $price_sale = $row['price_sale'];
        $count = $row['count'];
        $image1 = $row['image1'];
        $image2 = $row['image2'];
        $image3 = $row['image3'];
        $line_name = $row['line_name'];
        $status = $row['status'];
        $is_hot = $row['is_hot'];
        $is_new = $row['is_new'];
        $hot_sale = $row['hot_sale'];

        $table_one_product .=
            "
                <tr>
                    <td id='td_edit_product'>Tên sản phẩm</td>
                    <td id='td_edit_product'>$name</td>
                    <td id='td_edit_product'>
                    <input type='text' name='name' value='$name'>
                    </td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Giá nhập</td>
                    <td id='td_edit_product'>$price_buy</td>
                    <td id='td_edit_product'><input type='text' name='price_buy' value='$price_buy'></td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Giá bán</td>
                    <td id='td_edit_product'>$price_sale</td>
                    <td id='td_edit_product'><input type='text' name='price_sale' value='$price_sale'></td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Số lượng</td>
                    <td id='td_edit_product'>$count</td>
                    <td id='td_edit_product'><input type='text' name='count' value='$count'></td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Hình ảnh 1</td>
                    <td id='td_edit_product'>$image1</td>
                    <td id='td_edit_product'><input id='file_image' type='file' name='image1' value='$image1'></td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Hình ảnh 2</td>
                    <td id='td_edit_product'>$image2</td>
                    <td id='td_edit_product'><input id='file_image' type='file' name='image2' value='$image2'></td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Hình ảnh 3</td>
                    <td id='td_edit_product'>$image3</td>
                    <td id='td_edit_product'><input id='file_image' type='file' name='image3' value='$image3'></td>
                </tr>
                <tr>
                <td id='td_edit_product'>Dòng</td>
                <td id='td_edit_product'>$line_name</td>
                <td id='td_edit_product'>
                   <select name='line'>
                      <option value='Rado'>Rado</option>
                      <option value='Casio'>Casio</option>
                      <option value='Seiko'>Seiko</option>
                      <option value='Citizen'>Citizen</option>
                      <option value='Apple watch'>Apple watch</option>
                      <option value='Bulova'>Bulova</option>
                      <option value='Candino'>Candino</option>
                      <option value='Claude Bernard'>Claude Bernard</option>
                      <option value='Fossil'>Fossil</option>
                      <option value='Orient'>Orient</option>
                      <option value='Movado'>Movado</option>
                      <option value='Police'>Police</option>
                      <option value='TeinTop'>TeinTop</option>
                      <option value='Rolex'>Rolex</option>
                      <option value='Omega'>Omega</option>
                   </select>
                </td>
                </tr>
                <tr>
                <td id='td_edit_product'>Trạng thái</td>
                <td id='td_edit_product'>$status</td>
                <td id='td_edit_product'>
                   <select name='status'>
                      <option value='ready'>Ready</option>
                      <option value='not ready'>Not ready</option>
                   </select>
                </td>
                </tr>
                <tr>
                <td id='td_edit_product'>Hot?</td>
                <td id='td_edit_product'>$is_hot</td>
                <td id='td_edit_product'>
                   <select name='is_hot'>
                      <option value='hot'>Hot</option>
                      <option value='not'>Not hot</option>
                   </select>
                </td>
                </tr>
                <tr>
                <td id='td_edit_product'>New?</td>
                <td id='td_edit_product'>$is_new</td>
                <td id='td_edit_product'>
                   <select name='is_new'>
                      <option value='new'>New</option>
                      <option value='not'>Not new</option>
                   </select>
                </td>
                </tr>
                <tr>
                    <td id='td_edit_product'>Hot sale</td>
                    <td id='td_edit_product'>$hot_sale</td>
                    <td id='td_edit_product'><input type='text' name='hot_sale' value='$hot_sale'></td>
                </tr>
              
                ";
        return $table_one_product;
    }

    public static function delete_product($code)
    {
        $images_code = new CRUD_database;
        $images_code->connect();
        $sql = "SELECT images_code FROM products WHERE product_code = $code";
        $row = $images_code->executeOne($sql);
        $images_code = $row['images_code'];

        $delete_product = new CRUD_database;
        $delete_product->connect();
        $sql = "DELETE FROM products WHERE product_code = $code";
        $delete_product->deleteData($sql);

        $delete_images = new CRUD_database;
        $delete_images->connect();
        $sql = "DELETE FROM images WHERE images_code = $images_code";
        $delete_images->deleteData($sql);
    }

    public static function get_list_products()
    {
        $data = new CRUD_database;
        $data->connect();
        $sql = "SELECT * FROM list_products";
        $result = $data->executeAll($sql);
        $table_list_product = "";
        foreach ($result as $key => $value) {
            $image1 = $value['image1'];
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $price_buy = $value['price_buy'];
            $price_sale = $value['price_sale'];
            $count = $value['count'];
            $line_name = $value['line_name'];
            $status = $value['status'];
            $is_hot = $value['is_hot'];
            $is_new = $value['is_new'];
            $hot_sale = $value['hot_sale'];
            $table_list_product .=
                "
                <tr>
                <td id='td_list_product'><img src='$image1' style='width:5vw; height:6vw;'></td>
                <td id='td_list_product'>$product_code</td>
                <td id='td_list_product'>$product_name</td>
                <td id='td_list_product'>$price_buy</td>
                <td id='td_list_product'>$price_sale</td>
                <td id='td_list_product'>$count</td>
                <td id='td_list_product'>$line_name</td>
                <td id='td_list_product'>$status</td>
                <td id='td_list_product'>$is_hot</td>
                <td id='td_list_product'>$is_new</td>
                <td id='td_list_product'>$hot_sale</td>
                <td id='td_list_product'>
                <div class='edit_delete'>
                    <a href='index.php?router=admin&control=edit_product&code=$product_code&name=$product_name' id='btn_edit'><i class='far fa-edit'></i></a>
                    <a href='index.php?router=admin&control=delete_product&code=$product_code&name=$product_name' id='btn_delete'><i class='far fa-trash-alt'></i></a>
                </div>
                </td>
        </tr>
        ";
        }
        return $table_list_product;
    }

    public static function save_new_product(
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
    ) {
        $image1 = 'View/images/watchs/' . $image1['name'];
        $image2 = 'View/images/watchs/' . $image2['name'];
        $image3 = 'View/images/watchs/' . $image3['name'];
        $save_img = new CRUD_database;
        $save_img->connect();
        $sql = "INSERT INTO images(image1, image2, image3) VALUES (?,?,?)";
        $data = array("$image1", "$image2", "$image3");
        $save_img->insertData($sql, $data);

        $images_code = new CRUD_database;
        $images_code->connect();
        $sql = "SELECT images_code FROM images";
        $row = $images_code->executeAll($sql);
        foreach ($row as $key => $value) {
            $images_code = $value['images_code'];
        }

        $line_code = new CRUD_database;
        $line_code->connect();
        $sql = "SELECT line_code FROM product_line WHERE line_name = '$line'";
        $row = $line_code->executeOne($sql);
        $line_code = $row['line_code'];

        $save_product = new CRUD_database;
        $save_product->connect();
        $sql = "INSERT INTO products(product_name, price_buy, price_sale, count, line_code, images_code, status, is_hot, is_new)
        VALUES (?,?,?,?,?,?,?,?,?)";
        $data = array("$name", "$price_buy", "$price_sale", "$count", "$line_code", "$images_code", "$status", "$is_hot", "$is_new");
        $save_product->insertData($sql, $data);
    }

    public static function validate_product($name, $price_buy, $price_sale, $count)
    {
        $checkForm = true;
        $register_result = [];
        $register_result['name'] = "";
        $register_result['price_buy'] = "";
        $register_result['price_sale'] = "";
        $register_result['count'] = "";

        if ($name === "") {
            $checkForm = false;
            $register_result['name'] = "error";
        }

        $check_buy = "/^[0-9]{5,10}$/";
        if ($price_buy === "" || !preg_match($check_buy, $price_buy)) {
            $checkForm = false;
            $register_result['price_buy'] = "error";
        }

        $check_sale = "/^[0-9]{5,10}$/";
        if ($price_sale === "" || !preg_match($check_sale, $price_sale)) {
            $checkForm = false;
            $register_result['price_sale'] = "error";
        }

        $check_count = "/^[0-9]{1,6}$/";
        if ($count === "" || !preg_match($check_count, $count)) {
            $checkForm = false;
            $register_result['count'] = "error";
        }

        if ($checkForm) {
            $register_result['status'] = "success";
        } else {
            $register_result['status'] = "error";
        }
        return $register_result;
    }

    public static function update_employee(
        $code,
        $fullname,
        $birthday,
        $address,
        $phone,
        $email,
        $possition,
        $salary,
        $join_day,
        $account_name,
        $account_status
    ) {
        $update_employee = new CRUD_database;
        $update_employee->connect();
        $sql = "UPDATE employees SET 
        employee_fullname = '$fullname',
        employee_birthday = '$birthday',
        employee_address = '$address',
        employee_phone = '$phone',
        employee_email = '$email',
        employee_join_day = '$join_day',
        employee_salary = '$salary',
        employee_possition = '$possition'
        WHERE employee_code = '$code'
        ";
        $update_employee->updateData($sql);

        $get_account_code = new CRUD_database;
        $get_account_code->connect();
        $sql = "SELECT account_code FROM employees WHERE employee_code = $code ";
        $row = $get_account_code->executeOne($sql);
        $account_code = $row['account_code'];
        // $account_code = (int)$account_code;
        $update_account = new CRUD_database;
        $update_account->connect();
        $sql = "UPDATE accounts SET account_name = '$account_name', account_status = '$account_status'
         WHERE account_code = '$account_code'";
        $update_account->updateData($sql);
    }

    public static function save_new_employee(
        $fullname,
        $birthday,
        $address,
        $phone,
        $email,
        $account,
        $password,
        $possition,
        $salary
    ) {
        // save account
        $password = MD5($password);
        $data = array("$account", "$password");
        $sql = 'INSERT INTO accounts (account_name, account_password, register_day) values (?,?,NOW())';
        $add_account = new CRUD_database;
        $add_account->connect();
        $add_account->insertData($sql, $data);

        // save employee
        $account_code = new CRUD_database;
        $account_code->connect();
        $row = $account_code->executeOne("SELECT account_code FROM accounts WHERE account_name = '$account'");
        if (isset($row['account_code'])) {
            $account_code = $row['account_code'];
        }
        $data = array("$fullname", "$birthday", "$address", "$phone", "$email", "$possition", "$salary", "$account_code");
        $sql = 'INSERT INTO employees (employee_fullname, employee_birthday, employee_address,
         employee_phone,employee_email,employee_possition,employee_salary, join_day, account_code) values (?,?,?,?,?,?,?,NOW(),?)';
        $addEmployee = new CRUD_database;
        $addEmployee->connect();
        $addEmployee->insertData($sql, $data);
    }

    public static function validate_update_employee(
        $fullname,
        $birthday,
        $address,
        $phone,
        $email,
        $possition,
        $salary,
        $join_day,
        $account,
        $status
    ) {
        $checkForm = true;
        $register_result = [];
        // check name  
        $checkName = "/^[^0-9\`\~\!\@\#\%\^\&\*\(\)\-\=\_\+\{\}\[\]\\\|\;\:\'\"\,\.\<\>\/\?]+$/";
        if ($fullname === "" || !preg_match($checkName, $fullname)) {
            $checkForm = false;
        }

        // check status
        if ($status === "") {
            $checkForm = false;
        }

        // check possition
        if ($possition === "") {
            $checkForm = false;
        }

        // check birthday
        $checkBirthday = substr($birthday, 0, 4);
        if ($checkBirthday > 2000 || $checkBirthday < 1970 || $birthday === "") {
            $checkForm = false;
        }

        // check join day
        $checkJoin_day = substr($join_day, 0, 4);
        if ($checkJoin_day < 2020 || $join_day === "") {
            $checkForm = false;
        }
        // check salary 
        $checkSalary = "/^[0-9]{7,10}$/";
        if ($salary === "" || !preg_match($checkSalary, $salary)) {
            $checkForm = false;
        }
        // check address
        $checkAddress = "/^[^\`\~\!\@\#\%\^\&\*\(\)\=\{\}\[\]\\\|\;\:\'\"\<\>\?]+$/";
        if ($address === "" || !preg_match($checkAddress, $address)) {
            $checkForm = false;
        }
        // check phone
        $checkPhone = "/^0[0-9]{9}$/";
        if ($phone === "" || !preg_match($checkPhone, $phone)) {
            $checkForm = false;
        }
        // check email
        $checkEmail = "/^[A-Za-z0-9]+[A-Za-z0-9]*@[A-Za-z0-9]+(\.[A-Za-z0-9]+)$/";
        if ($email === "" || !preg_match($checkEmail, $email)) {
            $checkForm = false;
        }
        // check account
        $checkAccount = "/^[$]{1}[A-Z]{1}[0-9]{4}$/";
        if ($account === "" || ($account !== "" && $account[0] !== "$") || !preg_match($checkAccount, $account)) {
            $checkForm = false;
        } else {
            $checkOldAccount = new CRUD_Database;
            $checkOldAccount->connect();
            $row = $checkOldAccount->executeAll("SELECT account_name from accounts where account_name = '$account' ");
            if (count($row) > 1) {
                $checkForm = false;
            }
        }

        if ($checkForm) {
            $register_result['status'] = "success";
        } else {
            $register_result['status'] = "error";
        }
        return $register_result;
    }

    public static function validate_employee(
        $fullname,
        $birthday,
        $address,
        $phone,
        $email,
        $account,
        $password,
        $possition,
        $salary
    ) {
        $checkForm = true;
        $register_result = [];
        $register_result['fullname'] = "";
        $register_result['birthday'] = "";
        $register_result['address'] = "";
        $register_result['phone'] = "";
        $register_result['email'] = "";
        $register_result['account'] = "";
        $register_result['password'] = "";
        $register_result['possition'] = "";
        $register_result['salary'] = "";
        // check name  
        $checkName = "/^[^0-9\`\~\!\@\#\%\^\&\*\(\)\-\=\_\+\{\}\[\]\\\|\;\:\'\"\,\.\<\>\/\?]+$/";
        if ($fullname === "" || !preg_match($checkName, $fullname)) {
            $checkForm = false;
            $register_result['fullname'] = "error";
        }

        // check password
        $checkPassword = "/^[a-zA-Z0-9]{6,20}$/";
        if ($password === "" || !preg_match($checkPassword, $password)) {
            $checkForm = false;
            $register_result['password'] = "error";
        }

        // check possition
        if ($possition === "") {
            $checkForm = false;
            $register_result['possition'] = "error";
        }

        // check birthday
        $checkBirthday = substr($birthday, 0, 4);
        if ($checkBirthday > 2000 || $checkBirthday < 1970 || $birthday === "") {
            $checkForm = false;
            $register_result['birthday'] = "error";
        }
        // check salary 
        $checkSalary = "/^[0-9]{7,10}$/";
        if ($salary === "" || !preg_match($checkSalary, $salary)) {
            $checkForm = false;
            $register_result['salary'] = "error";
        }
        // check address
        $checkAddress = "/^[^\`\~\!\@\#\%\^\&\*\(\)\=\{\}\[\]\\\|\;\:\'\"\<\>\?]+$/";
        if ($address === "" || !preg_match($checkAddress, $address)) {
            $checkForm = false;
            $register_result['address'] = "error";
        }
        // check phone
        $checkPhone = "/^0[0-9]{9}$/";
        if ($phone === "" || !preg_match($checkPhone, $phone)) {
            $checkForm = false;
            $register_result['phone'] = "error";
        }
        // check email
        $checkEmail = "/^[A-Za-z0-9]+[A-Za-z0-9]*@[A-Za-z0-9]+(\.[A-Za-z0-9]+)$/";
        if ($email === "" || !preg_match($checkEmail, $email)) {
            $checkForm = false;
            $register_result['email'] = "error";
        }
        // check account
        $checkAccount = "/^[$]{1}[A-Z]{1}[0-9]{4}$/";
        if ($account === "" || ($account !== "" && $account[0] !== "$") || !preg_match($checkAccount, $account)) {
            $checkForm = false;
            $register_result['account'] = "error";
        } else {
            $checkOldAccount = new CRUD_Database;
            $checkOldAccount->connect();
            $row = $checkOldAccount->executeOne("SELECT account_name from accounts where account_name = '$account' ");
            if (isset($row['account_name'])) {
                $checkForm = false;
                $register_result['account'] = "error";
            }
        }

        if ($checkForm) {
            $register_result['status'] = "success";
        } else {
            $register_result['status'] = "error";
        }
        return $register_result;
    }

    public static function edit_customer($code)
    {
        $account_code = new CRUD_database;
        $account_code->connect();
        $sql = "SELECT account_code FROM customers WHERE customer_code = $code";
        $row = $account_code->executeOne($sql);
        $account_code = $row['account_code'];

        $account_status = new CRUD_database;
        $account_status->connect();
        $sql = "SELECT account_status FROM accounts WHERE account_code = $account_code";
        $row = $account_status->executeOne($sql);
        $account_status = $row['account_status'];

        $edit_customer = new CRUD_database;
        $edit_customer->connect();
        if ($account_status === 'open') {
            $sql = "UPDATE accounts SET account_status = 'locked' WHERE account_code = $account_code";
        } else {
            $sql = "UPDATE accounts SET account_status = 'open' WHERE account_code = $account_code";
        }
        $edit_customer->deleteData($sql);
    }

    public static function delete_customer($code)
    {
        $account_code = new CRUD_database;
        $account_code->connect();
        $sql = "SELECT account_code FROM customers WHERE customer_code = $code";
        $row = $account_code->executeOne($sql);
        $account_code = $row['account_code'];

        $delete_customer = new CRUD_database;
        $delete_customer->connect();
        $sql = "DELETE FROM customers WHERE customer_code = $code";
        $delete_customer->deleteData($sql);

        $delete_account = new CRUD_database;
        $delete_account->connect();
        $sql = "DELETE FROM accounts WHERE account_code = $account_code";
        $delete_account->deleteData($sql);
    }

    public static function get_one_employee($code)
    {
        $table_one_employee = "";
        $get_info = new CRUD_database;
        $get_info->connect();
        $sql = "SELECT * FROM list_employees WHERE employee_code = $code";
        $row = $get_info->executeOne($sql);
        // Thông tin nhân viên
        $name = $row['employee_fullname'];
        $birthday = $row['employee_birthday'];
        $address = $row['employee_address'];
        $phone = $row['employee_phone'];
        $email = $row['employee_email'];
        $possition = $row['employee_possition'];
        $salary_ss = $row['employee_salary'];
        $salary = number_format($salary_ss, 0, ',', '.');
        $join_day = $row['join_day'];
        $account = $row['account_name'];
        $status = $row['account_status'];
        $table_one_employee .=
            "
                <tr>
                    <td id='td_edit_employee'>Tên nhân viên</td>
                    <td id='td_edit_employee'>$name</td>
                    <td id='td_edit_employee'>
                    <input type='text' name='fullname_employee' value='$name'>
                    </td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Ngày sinh</td>
                    <td id='td_edit_employee'>$birthday</td>
                    <td id='td_edit_employee'><input type='date' name='birthday_employee' value='$birthday'></td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Địa chỉ</td>
                    <td id='td_edit_employee'>$address</td>
                    <td id='td_edit_employee'><input type='text' name='address_employee' value='$address'></td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Số điện thoại</td>
                    <td id='td_edit_employee'>$phone</td>
                    <td id='td_edit_employee'><input type='text' name='phone_employee' value='$phone'></td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Email</td>
                    <td id='td_edit_employee'>$email</td>
                    <td id='td_edit_employee'><input type='text' name='email_employee' value='$email'></td>
                </tr>
                <tr>
                <td id='td_edit_employee'>Chức vụ</td>
                <td id='td_edit_employee'>$possition</td>
                <td id='td_edit_employee'>
                   <select name='possition_employee'>
                      <option value='Nhân viên kinh doanh'>Nhân viên kinh doanh</option>
                      <option value='Quản lý bán hàng'>Quản lý bán hàng</option>
                      <option value='Nhân viên đóng gói'>Nhân viên đóng gói</option>
                      <option value='Nhân viên IT'>Nhân viên IT</option>
                   </select>
                </td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Lương</td>
                    <td id='td_edit_employee'>$salary đ</td>
                    <td id='td_edit_employee'><input type='text' name='salary_employee' value='$salary_ss'></td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Ngày gia nhập</td>
                    <td id='td_edit_employee'>$join_day</td>
                    <td id='td_edit_employee'><input type='date' name='join_day' value='$join_day'></td>
                </tr>
               
                <tr>
                    <td id='td_edit_employee'>Tài khoản</td>
                    <td id='td_edit_employee'>$account</td>
                    <td id='td_edit_employee'><input type='text' name='account_name' value='$account'></td>
                </tr>
                <tr>
                    <td id='td_edit_employee'>Trạng thái</td>
                    <td id='td_edit_employee'>$status</td>
                    <td id='td_edit_employee'>
                    <select name='account_status'>
                       <option value='open'>Open</option>
                       <option value='locked'>Locked</option>
                    </select>
                 </td>
                </tr>
                ";
        return $table_one_employee;
    }

    public static function delete_employee($code)
    {
        $account_code = new CRUD_database;
        $account_code->connect();
        $sql = "SELECT account_code FROM employees WHERE employee_code = $code";
        $row = $account_code->executeOne($sql);
        $account_code = $row['account_code'];

        $delete_employee = new CRUD_database;
        $delete_employee->connect();
        $sql = "DELETE FROM employees WHERE employee_code = $code";
        $delete_employee->deleteData($sql);

        $delete_account = new CRUD_database;
        $delete_account->connect();
        $sql = "DELETE FROM accounts WHERE account_code = $account_code";
        $delete_account->deleteData($sql);
    }

    public static function get_list_customers()
    {
        $data = new CRUD_database;
        $data->connect();
        $sql = "SELECT * FROM list_customers";
        $result = $data->executeAll($sql);
        $table_list_customer = "";
        foreach ($result as $key => $value) {
            $code = $value['customer_code'];
            $name = $value['customer_fullname'];
            $birthday = $value['customer_birthday'];
            $address = $value['customer_address'];
            $phone = $value['customer_phone'];
            $email = $value['customer_email'];
            $account = $value['account_name'];
            $register_day = $value['register_day'];
            $status = $value['account_status'];
            $table_list_customer .=
                "
        <tr>
                <td id='td_list_customer'>$code</td>
                <td id='td_list_customer'>$name</td>
                <td id='td_list_customer'>$address</td>
                <td id='td_list_customer'>$birthday</td>
                <td id='td_list_customer'>$phone</td>
                <td id='td_list_customer'>$email</td>
                <td id='td_list_customer'>$account</td>
                <td id='td_list_customer'>$register_day</td>
                <td id='td_list_customer'>$status</td>
                <td id='td_list_customer'>
                <div class='edit_delete'>
                    <a href='index.php?router=admin&control=edit_customer&code=$code&name=$name' id='btn_edit'><i class='far fa-edit'></i></a>
                    <a href='index.php?router=admin&control=delete_customer&code=$code&name=$name' id='btn_delete'><i class='far fa-trash-alt'></i></a>
                </div>
                </td>
        </tr>
        ";
        }
        return $table_list_customer;
    }

    public static function get_list_employees()
    {
        $data = new CRUD_database;
        $data->connect();
        $sql = "SELECT * FROM list_employees";
        $result = $data->executeAll($sql);
        $table_list_employee = "";
        foreach ($result as $key => $value) {
            $code = $value['employee_code'];
            $name = $value['employee_fullname'];
            $birthday = $value['employee_birthday'];
            $address = $value['employee_address'];
            $phone = $value['employee_phone'];
            $email = $value['employee_email'];
            $possition = $value['employee_possition'];
            $salary = $value['employee_salary'];
            $join_day = $value['join_day'];
            $account = $value['account_name'];
            $status = $value['account_status'];
            $table_list_employee .=
                "
        <tr>
                <td id='td_list_employee'>$code</td>
                <td id='td_list_employee'>$name</td>
                <td id='td_list_employee'>$address</td>
                <td id='td_list_employee'>$birthday</td>
                <td id='td_list_employee'>$phone</td>
                <td id='td_list_employee'>$email</td>
                <td id='td_list_employee'>$possition</td>
                <td id='td_list_employee'>$salary</td>
                <td id='td_list_employee'>$join_day</td>
                <td id='td_list_employee'>$account</td>
                <td id='td_list_employee'>$status</td>

                <td id='td_list_employee'>
                <div class='edit_delete'>
                    <a href='index.php?router=admin&control=edit_employee&code=$code&name=$name' id='btn_edit'><i class='far fa-edit'></i></a>
                    <a href='index.php?router=admin&control=delete_employee&code=$code&name=$name' id='btn_delete'><i class='far fa-trash-alt'></i></a>
                </div>
                </td>
        </tr>
        ";
        }
        return $table_list_employee;
    }
}
