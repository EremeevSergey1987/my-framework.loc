<h1>Система управления</h1>
<?php if(!empty($names)): ?>
    <?php foreach ($names as $name): ?>
        <?= $name->id ?> => <?=$name->name ?> </br>
    <?php endforeach; ?>
<?php else: ?>
    <p>Нет данных</p>
<?php endif; ?>