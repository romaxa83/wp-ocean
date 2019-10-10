<h2>ЗАКАЗ НА ТУР</h2>
<div><?php echo $hotel['category']['name'] . ' ' . $hotel['name']; ?></div>
<div><?php echo 'id:' . $hotel['id']; ?></div>
<div><b><?php echo $hotel['countries']['name']; ?></b> / <?php echo $hotel['cites']['name']; ?></div>
<div><b>ЦЕНА</b> - <?php echo $data['price'] . ' грн.'; ?></div>
<table border="1" width="600px">
    <tr>
        <td width="100px">Имя</td>
        <td><?php echo $data['name']; ?></td>
    </tr>
    <tr>
        <td>Телефон</td>
        <td><?php echo $data['phone']; ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td><?php echo $data['email']; ?></td>
    </tr>
    <tr>
        <td>Комментарий</td>
        <td><?php echo $data['comment']; ?></td>
    </tr>
</table>
<a href="<?php echo $link; ?>"><?php echo $link; ?></a>
<table border="1" width="600px">
    <tr>
        <td width="100px">перелет</td>
        <td><?php echo 'из ' . $data['info']['deptCity']; ?></td>
    </tr>
    <tr>
        <td>дата вылета</td>
        <td><?php echo $data['info']['dateBegin']; ?></td>
    </tr>
    <tr>
        <td>ночей в туре</td>
        <td><?php echo $data['info']['days']; ?></td>
    </tr>
    <tr>
        <td>питание</td>
        <td><?php echo $data['info']['food']; ?></td>
    </tr>
    <tr>
        <td>проживание</td>
        <td><?php echo $data['info']['room']; ?></td>
    </tr>
    <tr>
        <td>трансфер</td>
        <td>А/п - отель - а/п</td>
    </tr>
    <tr>
        <td>туристы</td>
        <td><?php echo $data['info']['people']; ?></td>
    </tr>
    <tr>
        <td>страхование</td>
        <td><?php echo $data['info']['insurance']; ?></td>
    </tr>
</table>