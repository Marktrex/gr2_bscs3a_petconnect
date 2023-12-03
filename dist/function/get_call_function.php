<?php

session_start();
use Dotenv\Dotenv;

require '../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '\..\..\\');
$dotenv->load();
// delete this below if gagamitin ung user table
$login_user_id = '';
foreach($_SESSION['user_data'] as $key => $value)
{
    $login_user_id = $value['id'];
}
//until here
$data = array(
    // 'uid' => $_SESSION['auth_user']['id'], - kapag user table eto, pag chatuser table sa baba
    'uid' => $login_user_id,
    'channel' => $_SESSION['channel']
);
echo json_encode($data);
?>