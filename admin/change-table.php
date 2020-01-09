<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
$password = htmlspecialchars($_POST['password']);
require_once('D:\PHP\WAMP\W\www\components\DB.php');
if ($password == 'qwe123') {
    $db = DB::getConnection();

    $zoneA =['Обычная', 'Для курящих', 'Детская'];



    try
    {
        $zone = htmlspecialchars($_POST['changeZone']);
        $idTable = htmlspecialchars($_POST['idTable']);
        $db->query("UPDATE myshema.table SET zone='$zone' WHERE idTable ='$idTable'");

    }catch(Exception $e){}



    $res = $db->query("SELECT * FROM myshema.table");
    $res->setFetchMode(PDO::FETCH_ASSOC);
    $tableList = array();



    $i = 0;
    while ($row = $res->fetch()) {
        $tableList[$i]['idTable'] = $row['idTable'];
        $tableList[$i]['chairNum'] = $row['chairNum'];
        $tableList[$i]['zone'] = $row['zone'];
        $i++;
    }
    foreach ($tableList as $tableItem)
    {
        echo '<form action="change-table.php" method="post"><input hidden name="password" value="qwe123">';

        echo '<p>Столик: №'.$tableItem['idTable'].'</p>';
        echo '<p>Количество стульев:'.$tableItem['chairNum'].'</p>';
        echo '<p>Зона:'.$zoneA[$tableItem['zone']].'</p>';
        echo '<p>Изменить состояние столика (зону): </p>';
        ?>
        <select name="changeZone">
            <option value="0">Обычная</option>
            <option value="1">Для курящих</option>
            <option value="2">Детская</option>
        </select>
        <input hidden name="password" value="qwe123"><?php
        echo '<input hidden name="idTable" value='.$tableItem['idTable'].'></textarea>';
        ?>
        <input type="submit" value="Изменить">
        <br>
        <br>
        <hr>

<?php

        echo '</form>';


    }

} else
{
    echo 'Неверный пароль';
}
