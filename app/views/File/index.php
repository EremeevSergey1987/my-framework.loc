<h1>Список файлов</h1>
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

<form enctype="multipart/form-data" action="/file/add" method="POST">
    <div class="mb-3">
        <input class="form-control" type="file" name="image">
    </div>
    <div class="mb-3">
        <button class="btn btn-success" type="submit">Загрузить</button>
    </div>
</form>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">File name</th>
        <th scope="col">Size</th>
        <th scope="col">Users</th>
        <th scope="col">action</th>
    </tr>
    </thead>
    <tbody>

    <?php if(!empty($files_one_user)): ?>
    <?php foreach ($files_one_user as $file): ?>
    <tr>
        <th scope="row"><?=$file['id']?></th>
        <td><?=$file['file_name']?></td>
        <td><?=$file['size_file']?></td>
        <td><?=$file['main_user']?></td>
        <td>
            <a href="/file/dell?id=<?=$file['id']?>">Удалить</a>
            <a href="/file/info?id=<?=$file['id']?>">Подробнее</a>
            <a download href="<?=PATH_IMG.$_SESSION['user']['id']."/".$file['file_name']?>">Скачать</a>
        </td>
    </tr>

    <?php endforeach; ?>

    <?php else: ?>
        <p>У пользователя нет файлов</p>
    <?php endif; ?>

    </tbody>
</table>
