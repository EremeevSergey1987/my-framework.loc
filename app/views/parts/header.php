<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <?=$this->getMeta()?>
</head>
<body>
<div class="container py-3">
<header>
        <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-database-fill" viewBox="0 0 16 16">
                    <path fill="#ffc107" d="M3.904 1.777C4.978 1.289 6.427 1 8 1s3.022.289 4.096.777C13.125 2.245 14 2.993 14 4s-.875 1.755-1.904 2.223C11.022 6.711 9.573 7 8 7s-3.022-.289-4.096-.777C2.875 5.755 2 5.007 2 4s.875-1.755 1.904-2.223Z"/>
                    <path d="M2 6.161V7c0 1.007.875 1.755 1.904 2.223C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777C13.125 8.755 14 8.007 14 7v-.839c-.457.432-1.004.751-1.49.972C11.278 7.693 9.682 8 8 8s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z"/>
                    <path d="M2 9.161V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13s3.022-.289 4.096-.777C13.125 11.755 14 11.007 14 10v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z"/>
                    <path d="M2 12.161V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13v-.839c-.457.432-1.004.751-1.49.972-1.232.56-2.828.867-4.51.867s-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972Z"/>
                </svg>
                <span class="fs-4">Best File storage!</span>
            </a>
            <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                <?php if (empty($_SESSION['user'])): ?>
                    <a href="/user/signup" class="me-3 py-2  btn btn-primary">Регистрация</a>
                    <a href="/user/login" class="me-3 py-2 btn btn-warning">Вход</a>
                <?php else: ?>
                    <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/file">Мои файлы</a>
                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                            <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/admin/">Список пользователей</a>
                        <?php else:?>
                            <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="/admin/user/edit">Редактировать мой профиль</a>
                        <?php endif; ?>
                    <a href="/user/logout" class="me-3 py-2 btn btn-danger">Выход</a>
                <?php endif; ?>
            </nav>
        </div>
</header>