<?php
require_once '../../vendor/autoload.php';
use Dotenv\Dotenv;
use MyApp\Class\AgoraDynamicKey\RtcTokenBuilder;

$dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
$dotenv->load();

$appID = $_ENV['APP_ID'];
$appCertificate = $_ENV['APP_CERTIFICATE'];

$channelName = uniqid('channel_');
$uid = isset($_POST['uid']) ? $_POST['uid'] : 0;
$role = RtcTokenBuilder::RolePublisher;
$expireTimeInSeconds = 3600;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

$token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
header('Content-Type: application/json');
echo json_encode(['token' => $token, 'channelName' => $channelName]);
?>