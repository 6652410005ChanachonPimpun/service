<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

//เรียกใช้ไฟล์ที่เกี่ยวข้อง
require_once "../connectDB.php";
require_once "../models/j_005.php";

//สร้าง instance ของการติดต่อฐานช้อมูล และทำงานกับตาราง
$connDB = new ConnectDB();
$j_005 = new J_005($connDB->getConnectDB());

//สร้างตัวแปรรับข้อมูลมาจากการเรียกใช้ api
$data = json_decode(file_get_contents("php://input"));

//ทำงานตามวัตถุประลงค์ของ api
$result = $j_005->getTaskByTaskName($data->id, $data->taskName, $data->taskDetails, $data->taskStatus);

if ($result == true) {
    //สำเร็จ
    $dataInfo = array();
    $dataArray = array(
        "msgresult" => "1"
    );
    array_push($dataInfo, $dataArray);
    echo json_encode($dataInfo);
} else {
    //ไม่สำเร็จ
    $dataInfo = array();
    $dataArray = array(
        "msgresult" => "0"
    );
    array_push($dataInfo, $dataArray);
    echo json_encode($dataInfo);
}
