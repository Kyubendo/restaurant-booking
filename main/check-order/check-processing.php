<?php
/*try {*/
    $name = htmlspecialchars($_POST['name']);
    $phoneNum = htmlspecialchars($_POST['phoneNum']);

    require_once('D:\PHP\WAMP\W\www\components\DB.php');

    $db = DB::getConnection();

    $result1 = $db->query("SELECT COUNT(*) FROM myshema.request WHERE name ='$name' AND phoneNumber='$phoneNum'");
    $result1->setFetchMode(PDO::FETCH_ASSOC);
    $count = $result1->fetch();
    if ($count['COUNT(*)'] == 0)
    {
        echo 'Ваш заказ не найден. Проверьте правильность введёных данных.';
    }else {

        $result = $db->query("SELECT * FROM myshema.request WHERE name ='$name' AND phoneNumber='$phoneNum'");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $requestList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $requestList[$i]['idTable'] = $row['idTable'];
            $requestList[$i]['status'] = $row['status'];
            $i++;
        }

        $statusA = ['Ожидает обработки', 'Обрабатывается', 'Принят', 'Отклонён'];

        foreach ($requestList as $requestItem) {
            echo '<p>Ваш заказ на столик №' . $requestItem['idTable'] . ' в состоянии: <b>' . $statusA[$requestItem['status']] . '</b></p>';
        }
    }

    echo '<br><br><a href="http://localhost/main/">Вернуться на главную</a>';
/*}
catch(Exception $e)
{
    echo 'Вы не можете проверить заказ не введя данные.';
}*/