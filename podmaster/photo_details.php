<?php 
if (isset($_GET['id'])) {
    $photos = [
        1 => 'Description for Image 1',
        2 => 'Description for Image 2',
        3 => 'Description for Image 3'
    ];

    $id = (int)$_GET['id'];
    $response = isset($photos[$id]) ? $photos[$id] : 'No details available.';

    echo json_encode(['details' => $response]);
}
?>