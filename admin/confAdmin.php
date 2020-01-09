<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

require_once('D:\PHP\WAMP\W\www\components\DB.php');

try
{
    $password = htmlspecialchars($_POST['password']);
    if ($password == 'qwe123')
    {
        $db = DB::getConnection();


        $status =['Ожидает выполнения', 'В исполнение', 'Вылолнен', 'Отклонён'];


        try
        {
            $prIdRequest = htmlspecialchars($_POST['idRequest']);
            $prStatus = htmlspecialchars($_POST['status']);
            $reject = htmlspecialchars($_POST['reject']);

            $res = $db->query("SELECT * FROM myshema.request WHERE idRequest='$prIdRequest'");
            $res->setFetchMode(PDO::FETCH_ASSOC);
            $timeList = array();


            $i = 0;
            while ($row = $res->fetch()) {
                $timeList[$i]['time'] = $row['time'];
                $timeList[$i]['idTable'] = $row['idTable'];
                $i++;
            }
            foreach ($timeList as $timeItem)
            {
                $time = $timeItem['time'];
                $idTable = $timeItem['idTable'];
            }


            if ($reject == 'Отклонить')
            {
                $prStatus+=2;
                $db->query("DELETE FROM myshema.time WHERE time = '$time' AND idTable = '$idTable'");
            } else
            {
                $prStatus++;
            }



            $db->query("UPDATE myshema.request SET status = '$prStatus' WHERE idRequest='$prIdRequest'");

        } catch(Exception $e){}
        $selStatus = 'any';

        try
        {
            $selStatus = htmlspecialchars($_POST['selStatus']);
        }catch (Exception $e){}


        ?>


        <form action="confAdmin.php" method="post">
        <input hidden name="password" value="qwe123">


        <p><b>Статус заказа: </b></p>
        <select name="selStatus">
            <option <?php if ($selStatus=='any'){ echo 'selected';}?> value="any">Любой</option>
            <option <?php if ($selStatus=='0'){ echo 'selected';}?> value="0">Ожидает выполнения</option>
            <option <?php if ($selStatus=='1'){ echo 'selected';}?> value="1">В исполнение</option>
            <option <?php if ($selStatus=='2'){ echo 'selected';}?> value="2">Вылолнен</option>
            <option <?php if ($selStatus=='3'){ echo 'selected';}?> value="3">Отклонён</option>
        </select>
            <p><input type="submit" value="Отфильтровать"></p>
        </form>
        <hr color="black">
        <br>
<?php


        if ($selStatus == 'any')
        {
            $result = $db->query("SELECT * FROM myshema.request");
        }else
        {
            $result = $db->query("SELECT * FROM myshema.request WHERE status='$selStatus'");
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        $requestList = array();
        while ($row = $result->fetch()) {
            $requestList[$i]['idRequest'] = $row['idRequest'];
            $requestList[$i]['name'] = $row['name'];
            $requestList[$i]['phoneNumber'] = $row['phoneNumber'];
            $requestList[$i]['email'] = $row['email'];
            $requestList[$i]['idTable'] = $row['idTable'];
            $requestList[$i]['time'] = $row['time'];
            $requestList[$i]['status'] = $row['status'];
            $i++;
        }

        //echo print_r($requestList);

        foreach ($requestList as $requestItem)
        {
            echo '<form action="confAdmin" method="post"><input hidden name="password" value="qwe123">';

            echo '<p>Заказанный столик: №'.$requestItem['idTable'].'</p>';
            echo '<p>Имя клиента:'.$requestItem['name'].'</p>';
            echo '<p>Телефон:'.$requestItem['phoneNumber'].'</p>';
            echo '<p>E-mail:'.$requestItem['email'].'</p>';
            echo '<p>Заказанный столик: №'.$requestItem['idTable'].'</p>';
            echo '<p>Статус заказа: '.$status[$requestItem['status']].'</p>';

            echo '<input hidden name="idRequest" value='.$requestItem['idRequest'].'></texarea>';
            echo '<input hidden name="status" value='.$requestItem['status'].'></texarea>';
            echo '<input hidden name="reject" value=0></texarea>';

            if ($requestItem['status']==0)
            {
                echo '<input type="submit" name="reject" value="Начать обработку">';
            } elseif ($requestItem['status']==1)
            {
                echo '<input type="submit" name="reject" value="Подтвердить">';

                echo '<p><input type="submit" name="reject" value="Отклонить"></p>';
            }elseif ($requestItem['status']==2)
            {
                echo '<p><b>Заказ подтверждён.</b></p>';
            }else
            {
                echo '<p><b>Заказ отклонён.</b></p>';
            }
            echo '</form>';
            echo '<hr>';
            echo '<br>';


        }
        echo '<br><br><a href="http://localhost/main/">Вернуться на главную</a>';

        echo '<form action="change-table.php" method="post">
<br><br><input type="submit" value="Изменить сосояние столика">
<input hidden name="password" value="qwe123">
</form>';


    } else
    {
        echo 'Неправильный пароль.';
    }

}catch (Exception $e)
{
    echo 'Вы не можете зайти на эту страницу без пароля администратора!';
}


