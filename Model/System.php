<?php

class System
{

    public static function check_login($account, $password)
    {
        if ($account === "" || $password === "") {
            $arrayResult['status_login'] = "error";
            $arrayResult['error_login'] = "Chưa đủ thông tin đăng nhập!";
            $arrayResult['account_of'] = "";
            return $arrayResult;
        }
        if ($account === "admin" && $password === "levinhthanh") {
            $arrayResult['status_login'] = "success";
            $arrayResult['error_login'] = "";
            $arrayResult['account_of'] = "admin";
            return $arrayResult;
        }
        $password = MD5($password);
        $arrayResult = [];
        $checkAccount = new CRUD_database();
        $checkAccount->connect();
        $result = $checkAccount->executeOne("SELECT account_name, account_password, account_status FROM accounts WHERE account_name = '$account' ");
        if (isset($result['account_name'])) {
            if ($result['account_name'] === $account && $result['account_password'] === $password) {
                if ($account !== 'admin' && $account[0] !== '$') {
                    if ($result['account_status'] !== 'open') {
                        $arrayResult['status_login'] = "error";
                        $arrayResult['error_login'] = "Tài khoản của bạn bị khóa !";
                        $arrayResult['account_of'] = "customer";
                    } else {
                        $arrayResult['status_login'] = "success";
                        $arrayResult['error_login'] = "";
                        $arrayResult['account_of'] = "customer";
                    }
                } else {
                    if ($result['account_status'] !== 'open') {
                        $arrayResult['status_login'] = "error";
                        $arrayResult['error_login'] = "Tài khoản của bạn bị khóa !";
                        $arrayResult['account_of'] = "employee";
                    } else {
                        $arrayResult['status_login'] = "success";
                        $arrayResult['error_login'] = "";
                        $arrayResult['account_of'] = "employee";
                    }
                }
            } else {
                $arrayResult['status_login'] = "error";
                $arrayResult['error_login'] = "Mật khẩu bạn nhập sai!";
                $arrayResult['account_of'] = "";
            }
        } else {
            $arrayResult['status_login'] = "error";
            $arrayResult['error_login'] = "Tài khoản của bạn chưa tồn tại!";
            $arrayResult['account_of'] = "";
        }
        return $arrayResult;
    }


    public static function save_new_account($fullname, $birthday, $address, $phone, $email, $account, $password)
    {
        // save account
        $password = MD5($password);
        $data = array("$account", "$password");
        $sql = 'INSERT INTO accounts (account_name, account_password, register_day) values (?,?,NOW())';
        $add_account = new CRUD_database;
        $add_account->connect();
        $add_account->insertData($sql, $data);
        // save customer
        $account_code = new CRUD_database;
        $account_code->connect();
        $row = $account_code->executeOne("SELECT account_code FROM accounts WHERE account_name = '$account'");
        if (isset($row['account_code'])) {
            $account_code = $row['account_code'];
        }
        $data = array("$fullname", "$birthday", "$address", "$phone", "$email", "$account_code");
        $sql = 'INSERT INTO customers (customer_fullname, customer_birthday, customer_address,
        customer_phone,customer_email,account_code) values (?,?,?,?,?,?)';
        $addCustomer = new CRUD_database;
        $addCustomer->connect();
        $addCustomer->insertData($sql, $data);
    }

    public static function validate_account($fullname, $birthday, $address, $phone, $email, $account, $password, $pass_repeat)
    {
        $checkForm = true;
        $register_result = [];
        // check name  
        $checkName = "/^[^0-9\`\~\!\@\#\%\^\&\*\(\)\-\=\_\+\{\}\[\]\\\|\;\:\'\"\,\.\<\>\/\?]+$/";
        $fullname_error = "";
        if ($fullname === "") {
            $fullname_error = "* Tên chưa được nhập!";
            $checkForm = false;
        } else {
            if (!preg_match($checkName, $fullname)) {
                $fullname_error = "* $fullname là tên không hợp lệ!";
                $checkForm = false;
            }
        }
        // check birthday  
        $checkBirthday = substr($birthday,0,4);
        $birthday_error = "";
        if ($birthday === "") {
            $birthday_error = "* Ngày sinh chưa được nhập!";
            $checkForm = false;
        } else {
            if ($checkBirthday > 2010 || $checkBirthday < 1970) {
                $birthday_error = "* $birthday là ngày không hợp lệ! Năm sinh phải sau 1970 và trước 2010";
                $checkForm = false;
            }
        }
        // check address
        $checkAddress = "/^[^\`\~\!\@\#\%\^\&\*\(\)\=\{\}\[\]\\\|\;\:\'\"\<\>\?]+$/";
        $address_error = "";
        if ($address === "") {
            $address_error = "* Địa chỉ chưa được nhập!";
            $checkForm = false;
        } else {
            if (!preg_match($checkAddress, $address)) {
                $address_error = "* $address là địa chỉ không hợp lệ!";
                $checkForm = false;
            }
        }
        // check phone
        $checkPhone = "/^0[0-9]{9}$/";
        $phone_error = "";
        if ($phone === "") {
            $phone_error = "* Số điện thoại chưa được nhập!";
            $checkForm = false;
        } else {
            if (!preg_match($checkPhone, $phone)) {
                $phone_error = "* $phone là số điện thoại không hợp lệ!";
                $checkForm = false;
            }
        }
        // check email
        $checkEmail = "/^[A-Za-z0-9]+[A-Za-z0-9]*@[A-Za-z0-9]+(\.[A-Za-z0-9]+)$/";
        $email_error = "";
        if ($email === "") {
            $email_error = "* Email chưa được nhập!";
            $checkForm = false;
        } else {
            if (!preg_match($checkEmail, $email)) {
                $email_error = "* $email là email không hợp lệ!";
                $checkForm = false;
            }
        }
        // check account
        $checkAccount = "/^[_a-z0-9]{6,20}$/";
        $account_error = "";
        if ($account === "") {
            $account_error = "* Tài khoản chưa được nhập!";
            $checkForm = false;
        } else {
            if (!preg_match($checkAccount, $account)) {
                $account_error = "* $account là tài khoản không hợp lệ!";
                $checkForm = false;
            } else {
                $checkOldAccount = new CRUD_database;
                $checkOldAccount->connect();
                $row = $checkOldAccount->executeOne("SELECT account_name from accounts where account_name = '$account' ");
                if (isset($row['account_name'])) {
                    $account_error = "* $account là tài khoản đã tồn tại!";
                    $checkForm = false;
                }
            }
        }
        // check password
        $checkPassword = "/^[a-z0-9]{6,20}$/";
        $password_error = "";
        if ($password === "") {
            $password_error = "* Mật khẩu chưa được nhập!";
            $checkForm = false;
        } else {
            if (!preg_match($checkPassword, $password)) {
                $password_error = "* $password là mật khẩu không hợp lệ!";
                $checkForm = false;
            }
        }
        // check password repeat
        $pass_repeat_error = "";
        if ($pass_repeat === "") {
            $pass_repeat_error = "* Mật khẩu xác nhận chưa được nhập!";
            $checkForm = false;
        } else {
            if ($pass_repeat !== $password) {
                if ($password !== "") {
                    $pass_repeat_error = "* Mật khẩu xác nhận chưa đúng!";
                    $checkForm = false;
                }
            }
        }
        if ($checkForm) {
            $register_result['result'] = "success";
            return $register_result;
        } else {
            $register_result['result'] = "error";
            $register_result['fullname_error'] = $fullname_error;
            $register_result['birthday_error'] = $birthday_error;
            $register_result['address_error'] = $address_error;
            $register_result['phone_error'] = $phone_error;
            $register_result['email_error'] = $email_error;
            $register_result['account_error'] = $account_error;
            $register_result['password_error'] = $password_error;
            $register_result['pass_repeat_error'] = $pass_repeat_error;
            return $register_result;
        }
    }
}
