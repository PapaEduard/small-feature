<?php
if (!defined('PHPUNIT_TEST')) {
    header('Content-Type: application/json');
}

// Dummy response
echo json_encode([
    'status' => 'success',
    'message' => 'Hello from Docker PHP!'
]);
?>
