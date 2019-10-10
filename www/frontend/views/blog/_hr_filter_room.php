<div class="filter-items__header d-flex justify-content-between align-items-stretch p-0" >
    <select class="mobile-shadow-select d-md-none" name="filterHotelRoomMobile">
        <?php foreach ($allRoom as $room):?>
            <option value="<?= $room?>"><?= $room?></option>
        <?php endforeach; ?>
    </select>
    <select class="js-states form-control room-select search-select" name="filterHotelRoom">
        <?php foreach ($allRoom as $room):?>
            <option value="<?= $room?>"><?= $room?></option>
        <?php endforeach; ?>
    </select>
</div>
