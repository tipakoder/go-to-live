<div class="form">
    <form action="/reg/" method="POST" class="form-action">
        <h3 class="form-title">Регистрация</h3>
        <div class="form-group">
            <input id="lastname_field" type="text" class="form-group-input" placeholder="Фамилия">
            <input id="firstname_field" type="text" class="form-group-input" placeholder="Имя">
            <input id="middlename_field" type="text" class="form-group-input" placeholder="Отчество">
        </div>
        <div class="form-group">
            <input id="email_field" type="email" class="form-group-input" placeholder="Email">
        </div>
        <div class="form-group">
            <input id="password_field" type="password" class="form-group-input" placeholder="Пароль">
        </div>
        <div class="form-group">
            <input id="photo_field" type="file" class="form-group-input" placeholder="Фото" accept=".jpg, .jpeg, .png">
        </div>
        <div class="form-group">
            <button id="btn_success" class="form-group-button">Создать аккаунт</button>
        </div>
    </form>
</div>

<script src="/res/js/form.js"></script>