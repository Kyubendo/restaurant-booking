<?php
$idTableSel = htmlspecialchars($_POST['idTable']);
?>

<h2>Заказ столика №<?php echo $idTableSel;?>
    на <?php echo $timeSel = htmlspecialchars($_POST['time']);?> часов.</h2>
    <form action="book-processing.php" method="post">
        <p>Имя: <input required name="name"</p>
        <p>E-mail: <input name="email"</p>
        <p>Телефон: <input required name="phoneNum"</p>
        <?php
        echo '<input type="hidden"  name="time" value='.$timeSel.'></textblock>';
        echo '<input type="hidden"  name="idTable" value='.$idTableSel.'></textblock>';
        ?>
        <p><input type="submit" value="Подтвердить"></p>
    </form>

<br>
<br>
<a href="http://localhost/main/">Вернуться на главную</a>

