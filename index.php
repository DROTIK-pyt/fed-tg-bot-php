<?php
require_once (__DIR__.'/src/crest.php');
header("Content-Type: application/json;charset=utf-8");

function send2B24($answers, $phone) {
    $text = $answers;
    $text .= "\n";
    $text .= "Телефон: $phone";
    $params = [
        "fields" => [
            "UF_CRM_1670995676556" => $text,
            "CATEGORY_ID" => "37",
            "TITLE" => "Заявка с ТГ-Бота",
            "OPPORTUNITY" => "0",
            "UTM_CAMPAIGN" => "TG_Bot",
            // "ASSIGNED_BY_ID" => "118745" // Ответственный!
        ],
    ];

    return CRest::call("crm.deal.add", $params);
}

$data = $_POST;

if(!empty($data)) {
    if(isset($data['answers']) && isset($data['phone']) && $data['phone'] != "") {
        $result = send2B24($data['answers'], $data['phone']);
        echo json_encode( [ "ok" => true, "msg" => $result ] );
    } else {
        echo json_encode( [ "ok" => false, "msg" => "Отсутствуют данные." ] );
    }
} else {
    echo json_encode( [ "ok" => false, "msg" => "Переданы не верные данные." ] );
}