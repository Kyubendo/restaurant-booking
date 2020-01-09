<html>
<head>
    <title>TestSite</title>
    <link rel="stylesheet" href="styles.css" type="text/css">

</head>
<?php
set_error_handler(function($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
$selTime = htmlspecialchars($_POST['time']);
$chairNumFilter = 'any';
$zoneFilter = 'any';

try
{
    $chairNumFilter = htmlspecialchars($_POST['chairNumFilter']);
} catch (Exception $e){}

try
{
    $zoneFilter = htmlspecialchars($_POST['zoneFilter']);
} catch (Exception $e){}
?>
<body>
<h1>Свободные столики на <?php echo $selTime; ?>:</h1>

<form action="time-processing.php" method="post">
    <input hidden name="time" <?php echo "value='$selTime'" ?>>


    <p><b>Количество мест:</b></p>
    <select name="chairNumFilter">
        <option <?php if ($chairNumFilter=='any'){ echo 'selected';}?> value="any">Любое</option>
        <option <?php if ($chairNumFilter=='2'){ echo 'selected';}?> value="2">2 места</option>
        <option <?php if ($chairNumFilter=='3'){ echo 'selected';}?> value="3">3 места</option>
        <option <?php if ($chairNumFilter=='4'){ echo 'selected';}?> value="4">4 места</option>
    </select>

    <input hidden name="time" value=<?php echo $selTime?>>
    <p><b>Зона:</b></p>
    <select name="zoneFilter">
        <option <?php if ($zoneFilter=='any'){ echo 'selected';}?> value="any">Любая</option>
        <option <?php if ($zoneFilter=='0'){ echo 'selected';}?> value="0">Обычная</option>
        <option <?php if ($zoneFilter=='1'){ echo 'selected';}?> value="1">Для курящих</option>
        <option <?php if ($zoneFilter=='2'){ echo 'selected';}?> value="2">Детская</option>
    </select>
    <br>
    <br>

    <input type="submit" value="Отфильтровать">

</form>
<hr color="black">

<?php

$zoneA = ["Обычная", "Для курящих", "Детская"];


require_once('D:\PHP\WAMP\W\www\components\DB.php');

$db = DB::getConnection();



$selTimeF1 = $selTime . ':00';
$selTimeF = date("H:i:s", strtotime($selTimeF1));

$timeList = array();



$result = $db->query("SELECT * FROM myshema.time WHERE time='$selTimeF'");

$result->setFetchMode(PDO::FETCH_ASSOC);
$i = 0;
while ($row = $result->fetch()) {
    $timeList[$i]['time'] = $row['time'];
    $timeList[$i]['idTable'] = $row['idTable'];
    $i++;
}


$tableList = array();



if ($chairNumFilter!='any')
{
    $result = $db->query("SELECT * FROM myshema.table WHERE chairNum = '$chairNumFilter'");
}
if ($zoneFilter!='any')
{
    $result = $db->query("SELECT * FROM myshema.table WHERE zone = '$zoneFilter'");
}

if ($chairNumFilter!='any' && $zoneFilter!='any')
{
    $result = $db->query("SELECT * FROM myshema.table WHERE zone = '$zoneFilter' AND chairNum = '$chairNumFilter'");
}

if ($chairNumFilter=='any' && $zoneFilter=='any')
{
    $result = $db->query("SELECT * FROM myshema.table");
}

$result->setFetchMode(PDO::FETCH_ASSOC);
$i = 0;
while ($row = $result->fetch()) {
    $tableList[$i]['idTable'] = $row['idTable'];
    $tableList[$i]['chairNum'] = $row['chairNum'];
    $tableList[$i]['zone'] = $row['zone'];
    $i++;
}

?>
<?php foreach ($tableList as $tableItem):?>
<?php
    foreach ($timeList as $timeItem)
        if ($timeItem['idTable']==$tableItem['idTable'])
        {
            continue 2;

        }

        echo '<h2>Столик № '.$tableItem['idTable'].'</h2>';
        echo '<p>'.'Количество мест: '.$tableItem['chairNum'].'</p>';
        echo '<p>'.'Зона: '.$zoneA[$tableItem['zone']].'</p>';

        echo '<form action="confirm-book.php" method="post">';
        echo '<input type="hidden"  name="time" value='.$selTime.'></textblock>';
        echo '<button type="submit" name="idTable" value='.$tableItem['idTable'].'>Забронировать</button>';
        echo '</form>';

        echo '<hr>';
        echo '<br>';
        ?>

<?php endforeach;?>

<br>
<br>
<a href="http://localhost/main/">Вернуться на главную</a>

</body>
</html>