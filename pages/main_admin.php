<div class="el-list">
    <div class="list-row cols">
        <div class="list-row-col" style="width: 50px;">ID</div>
        <div class="list-row-col" style="width: 150px;">Специальность</div>
        <div class="list-row-col">ФИО</div>
    </div>
    <? foreach($doctors as $doctor): ?>
        <div class="list-row">
            <div class="list-row-col" style="width: 50px;"><?=$doctor['id']?></div>
            <div class="list-row-col" style="width: 150px;"><?=$doctor['type']?></div>
            <div class="list-row-col"><?=$doctor['fullname']?></div>
        </div>
    <? endforeach; ?>
    <div class="list-row cols">
        <button class=".form-group-button link" style="width:100%; height: 40px;" href="/doctor/new/">Добавить нового специлиста</button>
    </div>
</div>