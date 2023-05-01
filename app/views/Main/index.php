
<?php //if(!empty($names)): ?>
<!--    --><?php //foreach ($names as $name): ?>
<!--        --><?php //= $name->id ?><!-- => --><?php //=$name->name ?><!-- </br>-->
<!--    --><?php //endforeach; ?>
<?php //endif; ?>

<div class="pricing-header p-3 pb-md-4 mx-auto text-center">
    <h1 class="display-4 fw-normal">Файловое хранилище</h1>
    <p class="fs-5 text-body-secondary">Файловое хранилище — облачный сервис для хранения фото, видео и других файлов и обмена ими. Диск синхронизирует файлы между облачным хранилищем и компьютером.</p>
</div>

<main class="row justify-content-center">
    <div class="w-50 p-3">

        <form>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Пароль">
            </div>

            <div class="mb-3">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Запомнить меня</label>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-warning mb-3">Войти</button>
                <button type="submit" class="btn btn-primary mb-3">Забыли пароль?</button>
                <button type="submit" class="btn btn-danger mb-3">Регистрация</button>
            </div>

        </form>
    </div>
</main>
