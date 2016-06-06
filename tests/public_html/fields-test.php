<?php

$data = (object) [
    'GET'  => (object) $_GET,
    'POST' => (object) $_POST,
];

echo json_encode($data);
