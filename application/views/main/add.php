<?php if (isset($errors)) : ?>
    <?php foreach ($errors as $key => $values) : ?>
        <?php foreach ($values as $value) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $key . " - " . $value?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>


<?php if ($data === true) : ?>
    <div class="alert alert-success" role="alert">
        Задача добавлена.
    </div>
<?php endif; ?>

<form method="POST" action="/main/add" enctype='multipart/form-data'>
  <div class="form-group">
    <label for="inputUsername">Имя пользователя</label>
    <input type="text" name="username" class="form-control" id="inputUsername" aria-describedby="username" value="<?= $model->username ?? '' ?>">
  </div>
  <div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="email" name="email" class="form-control" id="inputEmail" aria-describedby="email" value="<?= $model->email ?? '' ?>">
  </div>
  <div class="form-group">
    <label for="textareaTask">Задача</label>
    <textarea class="form-control" name="task" id="textareaTask" cols="30" rows="10"><?= $model->task ?? '' ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>