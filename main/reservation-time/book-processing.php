<?php
$userName = htmlspecialchars($_POST['name']);
$phoneNumber = htmlspecialchars($_POST['phoneNum']);
$email = htmlspecialchars($_POST['email']);
$selTime = htmlspecialchars($_POST['time']);
$idTable = htmlspecialchars($_POST['idTable']);



require_once('D:\PHP\WAMP\W\www\components\DB.php');

$db = DB::getConnection();

$checkRes = $db->query("SELECT COUNT(*) FROM myshema.time WHERE time ='$selTime' AND idTable='$idTable'");
$checkRes->setFetchMode(PDO::FETCH_ASSOC);
$count = $checkRes->fetch();
if ($count['COUNT(*)'] == 0)
{
    $result = $db->query("SELECT MAX(idRequest) FROM myshema.request");
    $idA = $result->fetch();
    $idReq = $idA['MAX(idRequest)'];
    $idReq+=1;

    $db->query("INSERT INTO request (idRequest, name, phoneNumber, email, idTable, time, status)"
        ."VALUES ('$idReq', '$userName', '$phoneNumber', '$email', '$idTable','$selTime', '0')");

    $db->query("INSERT INTO time (time, idTable) VALUES ('$selTime', '$idTable')");

    echo '<h1>Ваше заявка успешно оформлена!</h1>';

    echo '<br>
<br>
<a href="http://localhost/main/">Вернуться на главную</a>';

}else
{
    echo 'Произошла какая-то ошибка. Скорее всего данный столик на выбраное время уже забронирован.';
}

