<table class="table">
                <tbody>
                <tr>
                    <td>ID</td>
                    <td><?= $user['id'] ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?= $user['email'] ?></td>
                </tr>
                <tr>
                    <td>Имя</td>
                    <td><?= $user['name'] ?></td>
                </tr>

                <tr>
                    <td>Роль</td>
                    <td><?= $user['role'] == 'user' ? 'Пользователь' : 'Администратор' ?></td>
                </tr>
                </tbody>
</table>

<a href="<?= ADMIN ?>/user/edit?id=<?= $user['id'] ?>" class="btn btn-flat btn-secondary">Редактировать профиль</a>


    <div class="card-body">
        <h3 style="margin-top: 30px">Файлы пользователя</h3>
        <?php if (!empty($orders)): ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID заказа</th>
                        <th>Статус</th>
                        <th>Создан</th>
                        <th>Изменен</th>
                        <th>Сумма</th>
                        <td width="50"><i class="fas fa-pencil-alt"></i></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr <?php if ($order['status']) echo 'class="table-info"' ?>>
                            <td><?= $order['id'] ?></td>
                            <td>
                                <?= $order['status'] ? 'Завершен' : 'Новый' ?>
                            </td>
                            <td><?= $order['created_at'] ?></td>
                            <td><?= $order['updated_at'] ?></td>
                            <td>$<?= $order['total'] ?></td>
                            <td width="50">
                                <a class="btn btn-info btn-sm" href="<?= ADMIN ?>/order/edit?id=<?= $order['id'] ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <p><?= count($orders) ?> заказ(ов) из: <?= $total; ?></p>
                    <?php if ($pagination->countPages > 1): ?>
                        <?= $pagination; ?>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <p>У пользователя еще нет добавленных файлов...</p>
        <?php endif; ?>

    </div>

