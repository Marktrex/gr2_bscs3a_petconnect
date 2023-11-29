<?php
require_once '../../vendor/autoload.php';
use Agora\AccessToken\RtcTokenBuilder;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$appID = getenv('APP_ID');
$appCertificate = getenv('APP_CERTIFICATE');
$channelName = uniqid('channel_');
$uid = $_POST['uid'];
$role = RtcTokenBuilder::RolePublisher;
$expireTimeInSeconds = 3600;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

$token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
header('Content-Type: application/json');
echo json_encode(['token' => $token, 'channelName' => $channelName, 'appId' => $appID]);
?>