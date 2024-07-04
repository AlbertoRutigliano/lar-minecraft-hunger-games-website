<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (isset($_GET['input'])) {
    $input = htmlspecialchars($_GET['input']);
    $isUUID = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-5][0-9a-f]{3}-[089ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $input);

    if ($isUUID) {
        $url = "https://sessionserver.mojang.com/session/minecraft/profile/" . $input;
    } else {
        $url = "https://api.mojang.com/users/profiles/minecraft/" . $input;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo json_encode(array("error" => "Request Error: " . curl_error($ch)));
    } elseif ($http_code != 200) {
        echo json_encode(array("error" => "HTTP Error: " . $http_code));
    } else {
        echo $response;
    }

    curl_close($ch);
} else {
    echo json_encode(array("error" => "Input parameter is missing"));
}
