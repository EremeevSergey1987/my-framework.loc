<h1>Редактирование данныйх пользователя</h1>

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

            <?php if (!empty($_SESSION['success_signup_login'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?=$_SESSION['success_signup_login']; unset($_SESSION['success_signup_login']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<form method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="Иван" value="<?=h($_SESSION['user']['name'])?>">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input disabled name="email" type="email" class="form-control" id="email" placeholder="name@example.com" value="<?=h($_SESSION['user']['email'])?>">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input name="password" type="password" class="form-control" id="password" placeholder="Укажите новый пароль если хотите его поменять" value="">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Обновить</button>
    </div>

</form>

<?php //if(isset($_SESSION['form_data'])){unset($_SESSION['form_data']);} ?><?php
