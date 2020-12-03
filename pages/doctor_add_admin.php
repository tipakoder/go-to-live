<div class="form">
    <form action="/doctor/new/" method="POST" class="form-action doctor">
        <h3 class="form-title">Добавление нового врача</h3>
        <div class="form-group">
            <input name="fullname" type="text" class="form-group-input" placeholder="ФИО" require>
        </div>
        <div class="form-group">
            <select name="type" class="form-group-input">
                <option selected disabled>Выберите специальность</option>
                <? foreach($types as $type): ?>
                    <option value="<?=$type['id']?>"><?=$type['name']?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <textarea name="description" class="form-group-input">Добавить врача</textarea>
        </div>
        <div class="form-group">
            <button class="form-group-button">Добавить врача</button>
        </div>
    </form>
</div>

<script src="/res/js/form.js"></script>