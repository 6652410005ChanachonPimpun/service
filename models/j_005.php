<?php
//ไฟล์ประเภท model เป็นไฟล์ที่ทำงานกับตารางในฐานข้อมูล
class J_005
{
    //ตัวแปร--------------
    //ตัวแปรสําหรับเชื่อมต่อฐานข้อมูล
    private $connDB;
    //ตัวแปรสําหรับเชื่อมต่อคอลลัมในตาราง
    public $id;
    public $taskname;
    public $taskDetail;
    public $taskStatus;
    public $createAt;

    //ตัวแปรเบ็ตเล็ต
    public $msg;

    //คอนสตรัคเตอร์--------------
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //ฟังก์ชั่นการทำงาน (CRUD)--------------
    //ฟังก์ชั่นดึงข้อมูลทั้งหมด
    public function getAllTask()
    {
        //คำสั่ง sql
        $sql = "SELECT * FROM j_005_tb ORDER BY createAt DESC";

        //เตรียมคำสั่ง sql เพื่อพร้อมใช้งาน
        $stmt = $this->connDB->prepare($sql);

        //เรียกใช้คำสั่ง sql
        $stmt->execute();

        //ส่งค่าข้อมูลกลับไปใช้ตามความต้องการ
        return $stmt;
    }
}
