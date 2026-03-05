<?php
class ConnectDB
{
    private $connDB;

    private $host = "82.25.121.181";
    private $user = "u231198616_dti268";
    private $password = "Dti028074500";
    private $dbname = "u231198616_dti268_db";

    //ฟังก์ชั่นเชื่อมต่อฐานข้อมูล
    public function getConnectDB()
    {
        //กำหนดการเชื่อมต่อฐานข้อมูล
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";

        try {
            //สร้างการเชื่อมต่อข้อมูล
            $this->connDB = new PDO($dsn, $this->user, $this->password);
            $this->connDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        //ส่งค่าการเชื่อมต่อฐานข้อมูล
        return $this->connDB;
    }
}
