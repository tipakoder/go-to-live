<div class="profile-client">
    <div class="profile-client-main">
        <div class="profile-client-photo">
            <img src="/content/ava_<?=$user['id']?>.png" alt="" class="profile-client-photo-img">
        </div>

        <div class="profile-client-info">
            <h1 class="profile-client-fullname"><?=$user['lastname'] . ' ' . $user['firstname'] . ' ' . $user['middlename']?></h1>
        </div>
    </div>

    <div class="profile-writes-tabs">
        <div class="form-title">Ваши записи</div>
        <button class="form-group-button" id="tab_future">Будущие</button>
        <button class="form-group-button" id="tab_past">Прошедшие</button>
        <button class="form-group-button" id="tab_all">Все</button>
    </div>

    <div class="profile-writes">
        
        <?foreach($writes as $write):?>
        <div class="write" wid="<?=$write['id']?>">
            <div class="write-option">
                <span class="op_name">Дата:</span>
                <span class="op_val date"><?=$write['date']?></span>
            </div>

            <div class="write-option">
                <span class="op_name">Время:</span>
                <span class="op_val time"><?
                    $nums = [[1, '08:00'], [2, '12:00'], [3, '14:00'], [4, '16:00'], [5, '18:00']];
                    foreach($nums as $num)
                    {
                        if($write['option_time'] == $num[0])
                        {
                            echo $num[1];
                        }
                    }
                ?></span>
            </div>

            <div class="write-option">
                <span class="op_name">Доктор:</span>
                <span class="op_val"><?=$write['doctor']?></span>
            </div>

            <div class="write-option">
                <div class="form-group-button action">Отменить запись</div>
            </div>
        </div>
        <?endforeach;?>
    </div>
</div>

<script src="/res/js/form_write.js"></script>