<?php
header("Content-Type: application/json;charset=utf-8");
require_once (__DIR__.'/src/crest.php');

function send2B24($answers, $phone) {
    $text = "";
    foreach($answers as $answer) {
        $text .= $answer["queston"];
        $text .= "\n";
        $text .= $answer["answer"];
        $text .= "\n";
    }

    header("Conten-Type: application/json;charset=utf-8");
    $params = [
        "fields" => [
            // "UF_CRM_1670995676556" => $text,
            // "CATEGORY_ID" => "37",
            "TITLE" => "Заявка с fedresursonline_bot",
            "OPPORTUNITY" => "0",
            "UTM_CAMPAIGN" => "fedresursonline_bot",
            "PHONE" => [ [ "VALUE" => $phone, "VALUE_TYPE" => "WORK" ] ],
            "COMMENTS" => $text,
            "ASSIGNED_BY_ID" => "1" // Ответственный!
        ],
    ];

    $result = CRest::call("crm.lead.add", $params);
    echo json_encode( [ 'result' => $result ] );
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