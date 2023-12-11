<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use Dotenv\Dotenv;
use MyApp\Class\AgoraDynamicKey\RtcTokenBuilder2;


$dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
$dotenv->load();

$appID = $_ENV['APP_ID'];
$appCertificate = $_ENV['APP_CERTIFICATE'];

$channelName = $_POST['channel'];
$uid = $_POST['userId'];
$role = RtcTokenBuilder2::ROLE_PUBLISHER;
$expireTimeInSeconds = 3600;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

$token = RtcTokenBuilder2::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
header('Content-Type: application/json');
echo json_encode(['token' => $token, 'appId' => $appID]);
?>