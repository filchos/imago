<?php

$headers    = getallheaders();
$testHeader = $headers['X-Imagotest'];

foreach (str_split($testHeader) as $char) {
    echo chr(ord($char) + 1);
}
