

<tr class="tr-more-info">
     <td colspan="12">
         <?php if(!empty($data)):?>
         <ul>
             <li><b>Время вылета:</b> <?= $data->dateBegin??'не указано'?> </li>
             <li><b>Вылет из:</b> <?= $data->deptCity??'не указано'?> в
                 <?= $data->city??'не указано'?> ( <?= $data->country??'не указано'?> ) </li>
             <li><b>Отель:</b> <?= $data->hotelName??'не указано'?></li>
             <li><b>Ночей:</b> <?= $data->days??'не указано'?> </li>
             <li><b>Комната:</b> <?= $data->room??'не указано'?> </li>
             <li><b>Еда:</b> <?= $data->food??'не указано'?> </li>
             <li><b>Кол-во людей:</b> <?= $data->people??'не указано'?> </li>
             <li><b>Страховка:</b> <?= $data->insurance??'не указано'?> </li>
         </ul>
         <?php else:?>
             <p>Нет данных</p>
         <?php endif;?>
     </td>
 </tr>

