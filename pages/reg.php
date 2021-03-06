<div class="form">
    <form action="/reg/" method="POST" class="form-action reg">
        <h3 class="form-title">Регистрация</h3>
        <div class="form-group">
            <input name="lastname" type="text" class="form-group-input" placeholder="Фамилия" require>
            <input name="firstname" type="text" class="form-group-input" placeholder="Имя" require>
            <input name="middlename" type="text" class="form-group-input" placeholder="Отчество" require>
        </div>
        <div class="form-group">
            <input name="email" type="email" class="form-group-input" placeholder="Email" require>
        </div>
        <div class="form-group">
            <input name="password" type="password" class="form-group-input" placeholder="Пароль" require>
        </div>
        <div class="form-group">
            <input name="passwordR" type="password" class="form-group-input" placeholder="Пароль" require>
        </div>
        <div class="form-group">
            <input name="photo" type="file" class="form-group-input" accept="image/png" require>
        </div>
        <div class="form-group">
            <button class="form-group-button">Создать аккаунт</button>
        </div>
    </form>
</div>

<script src="/res/js/form.js"></script>