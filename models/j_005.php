<?php
//ไฟล์ประเภท model เป็นไฟล์ที่ทำงานกับตารางในฐานข้อมูล
class J_005
{
    //ตัวแปร--------------
    //ตัวแปรสําหรับเชื่อมต่อฐานข้อมูล
    private $connDB;
    //ตัวแปรสําหรับเชื่อมต่อคอลลัมในตาราง
    public $id;
    public $taskName;
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

    //ดึงข้อมูลตามเงื่อนไขที่กำหนด
    public function getTaskByTaskName($taskname)
    {
        //คำสั่ง sql
        $sql = "SELECT * FROM j_005_tb WHERE taskName = :taskname ORDER BY createAt DESC";
        // $sql = "SELECT * FROM j_005_tb WHERE taskName LIKE :taskname ORDER BY createAt DESC";

        //คลีนข้อมูลที่ใช้เป็นเงื่อนไชที่รับเข้ามา
        $taskname = htmlspecialchars(strip_tags($taskname));

        //เตรียมคำสั่ง sql เพื่อพร้อมใช้งาน
        $stmt = $this->connDB->prepare($sql);

        //กำหนดค่าให้กับ sql parameter 
        $stmt->bindParam(":taskname", $taskname);

        //เรียกใช้คำสั่ง sql
        $stmt->execute();

        //ส่งค่าข้อมูลกลับไปใช้ตามความต้องการ 
        return $stmt;
    }

    //ฟังก์ชั่นดึงข้อมูลทั้งหมดในตาราง ตอนเงื่อนไขที่กำหนดให้ คือ taskDetail (ขอแค่มีบางค่าถือว่าเจอ) และ taskStatus เป็น 1 (เสร็จแล้ว)
    public function getTaskByTaskDetailAndTaskStatus($taskDetails, $taskStatus)
    {
        //คำสั่ง sql
        $sql = "SELECT * FROM j_005_tb WHERE taskDetails LIKE :taskDetails AND taskStatus = :taskStatus ORDER BY createAt DESC";

        //คลีนข้อมูลที่ใช้เป็นเงื่อนไชที่รับเข้ามา
        $taskDetails = htmlspecialchars(strip_tags($taskDetails));
        $taskStatus = htmlspecialchars(strip_tags($taskStatus));

        //เตรียมคำสั่ง sql เพื่อพร้อมใช้งาน
        $stmt = $this->connDB->prepare($sql);
        $search = '%' . $taskDetails . '%';
        //กำหนดค่าให้กับ sql parameter 
        $stmt->bindParam(":taskDetails", $search);
        $stmt->bindParam(":taskStatus", $taskStatus);

        //เรียกใช้คำสั่ง sql
        $stmt->execute();

        //ส่งค่าข้อมูลกลับไปใช้ตามความต้องการ 
        return $stmt;
    }

    //ฟังก์ชั่นเพิ่มข้อมูล
    public function addtask($taskName, $taskDetails, $taskStatus)
    {
        //คำสั่ง sql
        $sql = "INSERT INTO j_005_tb (taskName, taskDetails, taskStatus, createAt) VALUES (:taskName, :taskDetails, :taskStatus)";

        //คลีนข้อมูลที่ใช้เป็นเงื่อนไชที่รับเข้ามา
        $taskName = htmlspecialchars(strip_tags($taskName));
        $taskDetails = htmlspecialchars(strip_tags($taskDetails));
        $taskStatus = intval(htmlspecialchars(strip_tags($taskStatus)));

        //เตรียมคำสั่ง sql เพื่อพร้อมใช้งาน
        $stmt = $this->connDB->prepare($sql);

        //กำหนดค่าให้กับ sql parameter 
        $stmt->bindParam(":taskName", $taskName);
        $stmt->bindParam(":taskDetails", $taskDetails);
        $stmt->bindParam(":taskStatus", $taskStatus);

        //รันคำสั่ง sql
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชั่นแก้ไขข้อมูลในตาราง ตามเงื่อนไขที่กำหนด
    public function updateTaskByID($id, $taskName, $taskDetails, $taskStatus)
    {
        //คำสั่ง sql
        $sql = "UPDATE j_005_tb SET taskName = :taskName, taskDetails = :taskDetails, taskStatus = :taskStatus WHERE id = :id";

        //คลีนข้อมูลที่ใช้เป็นเงื่อนไชที่รับเข้ามา
        $id = intval(htmlspecialchars(strip_tags($id)));
        $taskName = htmlspecialchars(strip_tags($taskName));
        $taskDetails = htmlspecialchars(strip_tags($taskDetails));
        $taskStatus = intval(htmlspecialchars(strip_tags($taskStatus)));

        //เตรียมคำสั่ง sql เพื่อพร้อมใช้งาน
        $stmt = $this->connDB->prepare($sql);

        //กำหนดค่าให้กับ sql parameter 
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":taskName", $taskName);
        $stmt->bindParam(":taskDetails", $taskDetails);
        $stmt->bindParam(":taskStatus", $taskStatus);

        //รันคำสั่ง sql
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชั่นลบข้อมูลในตาราง ตามเงื่อนไขที่กำหนด
    public function deleteTaskByID($id)
    {
        //คำสั่ง sql
        $sql = "DELETE FROM j_005_tb WHERE id = :id";

        //คลีนข้อมูลที่ใช้เป็นเงื่อนไชที่รับเข้ามา
        $id = intval(htmlspecialchars(strip_tags($id)));

        //เตรียมคำสั่ง sql เพื่อพร้อมใช้งาน
        $stmt = $this->connDB->prepare($sql);

        //กำหนดค่าให้กับ sql parameter 
        $stmt->bindParam(":id", $id);

        //รันคำสั่ง sql
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
