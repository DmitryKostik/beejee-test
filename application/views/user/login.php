<?php if (isset($errors)) : ?>
    <?php foreach ($errors as $key => $values) : ?>
        <?php foreach ($values as $value) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $key . " - " . $value?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

<form method="POST" action="/user/login">
  <div class="form-group">
    <label for="exampleInputEmail1">Имя пользователя</label>
    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Пароль</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" class="btn btn-primary">Войти</button>
</form>