<div class="form">
    <form action="/write/" method="POST" class="form-action write">
        <h3 class="form-title">Запись на приём</h3>
        <div class="form-group">
            <input type="date" id="date_sel" name="date" class="form-group-input">

            <select class="form-group-input" id="type_sel">
                <option selected required disabled value="null">Выберите специальность</option>
                <? foreach($types as $type): ?>
                    <option value="<?=$type['id']?>"><?=$type['name']?></option>
                <? endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <select disabled required name="doctor" class="form-group-input" id="doctor_sel">
                <option selected required disabled value="null">Выберите доктора</option>
                <? foreach($doctors as $doctor): ?>
                    <option class="doctor-types doctor-type-<?=$doctor['tid']?>" value="<?=$doctor['id']?>"><?=$doctor['fullname']?></option>
                <? endforeach; ?>
            </select>

            <select disabled required name="option_time" class="form-group-input" id="option_sel">
                <option selected disabled value="null">Выберите номерок</option>
                <option class="options option-1" value="1">08:00</option>
                <option class="options option-2" value="2">12:00</option>
                <option class="options option-3" value="3">14:00</option>
                <option class="options option-4" value="4">16:00</option>
                <option class="options option-5" value="5">18:00</option>
            </select>
        </div>
        <div class="form-group">
            <button class="form-group-button">Записать меня</button>
        </div>
    </form>
</div>

<script src="/res/js/form_write.js"></script>