<?php
class CRUD_Database{
    private $hostname = 'localhost';
    private $username = 'vinhthanhle';
    private $password = 'thanh12345';
    private $dbname = 'db_t-ecomm_watch';
    public $connect = NULL;
    public $result = NULL;
    public function connect()
    {
        $this->connect = new PDO('mysql:dbname='.$this->dbname.';host='.$this->hostname.';charset=utf8', $this->username, $this->password);
        if(!isset($this->connect)){
            echo "Kết nối thất bại!";
        }
        return $this->connect;
    }
    public function executeOne($sql)
    {
        $this->result = $this->connect->prepare("$sql");
        $this->result->setFetchMode(PDO::FETCH_ASSOC);
        $this->result->execute();
        return $this->result->fetch();
    }
    public function executeAll($sql)
    {
        $this->result = $this->connect->prepare("$sql");
        $this->result->setFetchMode(PDO::FETCH_ASSOC);
        $this->result->execute();
        return $this->result->fetchAll();
    }
    public function insertData($sql,$data)
    {
        $this->result = $this->connect->prepare("$sql");
        $this->result->execute($data);
    }
    public function updateData($sql)
    {
        $this->result = $this->connect->prepare("$sql");
        $this->result->execute();
    }
    public function deleteData($sql)
    {
        $this->result = $this->connect->prepare("$sql");
        $this->result->execute();
    }
}
?>