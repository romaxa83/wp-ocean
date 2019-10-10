<h2>ЗАЯВКА</h2>
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