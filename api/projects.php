<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$file = __DIR__ . "/../data/projects.json";

if (!file_exists($file)) {
    http_response_code(404);
    echo json_encode(["error" => "Data file not found"]);
    exit;
}

$data = file_get_contents($file);
echo $data;
