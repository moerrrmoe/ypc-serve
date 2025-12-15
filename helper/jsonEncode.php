<?php

function jsonEncode($data, $status = 200) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}