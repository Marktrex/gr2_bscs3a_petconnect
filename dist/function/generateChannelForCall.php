<?php


$channelName = 'channel_' . uniqid();
header('Content-Type: application/json');
echo json_encode(['channelName' => $channelName]);

?>