<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
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
$result = $j_005->getTaskByTaskDetailAndTaskStatus($data->taskDetails, $data->taskStatus);

//ตรวจสอลผลลัพธ์ที่ได้จากการทำงานกับตาราง
if ($result->rowCount() > 0) {
    //มีข้อมูล
    $dataInfo = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $dataArray = array(
            "msgresult" => "1",
            "id" => $row["id"],
            "taskName" => $row["taskName"],
            "taskDetails" => $row["taskDetails"],
            "taskStatus" => $row["taskStatus"],
            "createAt" => $row["createAt"],
        );
        array_push($dataInfo, $dataArray);
    }

    echo json_encode($dataInfo);
} else {
    //ไม่มีข้อมูล
    $dataInfo = array();
    $dataArray = array(
        "msgresult" => "0"
    );
    array_push($dataInfo, $dataArray);
    echo json_encode($dataInfo);
}
