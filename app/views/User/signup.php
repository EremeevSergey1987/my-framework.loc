<h1>Регистрация</h1>

<div class="container">
    <div class="row">
        <div class="col">
            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['errors']; unset($_SESSION['errors']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<form method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="Иван" value="<?=get_field_value('name')?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" value="<?=get_field_value('email')?>">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="Пароль" value="<?=get_field_value('password')?>">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </div>

</form>

<?php //if(isset($_SESSION['form_data'])){unset($_SESSION['form_data']);} ?>