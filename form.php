<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $price = $_POST['price'];
    $time_spent = $_POST['time_spent'];

    $is_long_enough = ($time_spent >= 30);

    $token_data = json_decode(file_get_contents('tokens.txt'), true);
    $access_token = $token_data['access_token'];

    $contact_data = [
        "name" => $name,
        "custom_fields_values" => [
            [
                "field_code" => "PHONE",
                "values" => [
                    ["value" => $phone, "enum_code" => "WORK"]
                ]
            ],
            [
                "field_code" => "EMAIL",
                "values" => [
                    ["value" => $email, "enum_code" => "WORK"]
                ]
            ]
        ]
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "https://xsenus222.amocrm.ru/api/v4/contacts");
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([$contact_data]));

    $response = curl_exec($curl);
    $form_submitted = false;

    if (!curl_errno($curl)) {
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_code == 200) {
            $response_data = json_decode($response, true);
            $contact_id = $response_data['_embedded']['contacts'][0]['id'] ?? null;

            if ($contact_id) {
                $deal_data = [
                    "name" => "Сделка для $name",
                    "pipeline_id" => 8848094,
                    "status_id" => 71488374,
                    "_embedded" => [
                        "contacts" => [
                            ["id" => $contact_id]
                        ]
                    ],
                    "price" => (int)$price,
                    "custom_fields_values" => [
                        [
                            "field_id" => 561633,
                            "values" => [
                                ["value" => $is_long_enough]
                            ]
                        ]
                    ]
                ];

                curl_setopt($curl, CURLOPT_URL, "https://xsenus222.amocrm.ru/api/v4/leads");
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([$deal_data]));
                $deal_response = curl_exec($curl);

                if (!curl_errno($curl)) {
                    $deal_http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    if ($deal_http_code == 200) {
                        $form_submitted = true;
                    }
                }
            }
        }
    }
    curl_close($curl);

    header('Content-Type: application/json');
    echo json_encode(["form_submitted" => $form_submitted]);
    exit;
}
?>
