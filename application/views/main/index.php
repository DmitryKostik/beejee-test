<?php
  use core\Base;
  $isGuest = Base::$app->user->getIsGuest();

  $sUsernameAsc = Base::$app->route->buildQueryString(array_merge($_GET, ["sort" => "username"]));
  $sUsernameDesc = Base::$app->route->buildQueryString(array_merge($_GET, ["sort" => "-username"]));
  $sEmailAsc = Base::$app->route->buildQueryString(array_merge($_GET, ["sort" => "email"]));
  $sEmailDesc = Base::$app->route->buildQueryString(array_merge($_GET, ["sort" => "-email"]));
  $sIsActiveAsc = Base::$app->route->buildQueryString(array_merge($_GET, ["sort" => "is_active"]));
  $sIsActiveDesc = Base::$app->route->buildQueryString(array_merge($_GET, ["sort" => "-is_active"]));
?>

<div class="row ml-3">
  <div class="dropdown">
    <button class="btn btn-info dropdown-toggle mb-3 " type="button" id="dropdownSort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Сортировка
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownSort">
      <a class="dropdown-item" href="<?= $sUsernameAsc ?>">Отсортировать по имени пользователя (По возрастанию)</a>
      <a class="dropdown-item" href="<?= $sUsernameDesc ?>">Отсортировать по имени пользователя (По убыванию)</a>
      <a class="dropdown-item" href="<?= $sEmailAsc ?>">Отсортировать по email (По возрастанию)</a>
      <a class="dropdown-item" href="<?= $sEmailDesc ?>">Отсортировать по email (По убыванию)</a>
      <a class="dropdown-item" href="<?= $sIsActiveDesc ?>">Отсортировать по выполнению (Выполненные сверху)</a>
      <a class="dropdown-item" href="<?= $sIsActiveAsc ?>">Отсортировать по выполнению (Выполненные снизу)</a>
      <a class="dropdown-item" href="/">Сбросить сортировку</a>
    </div>
  </div>
  <a class="btn btn-info mb-3 ml-3" href="/main/add">
    Добавить задачу
  </a>
</div>

<?php foreach ($tasks as $task) : ?>
<div class='col-12 mb-3'>
  <div class="card <?= $task->is_active ? "border-success" : "border-danger" ?>">

    <div class="card-header">
          Выполнено: 
          <input 
            class="js-job-checkbox"
            data-id="<?= $task->id ?>"
            type="checkbox"
            aria-label="Выполнено"
            <?= $task->is_active ? "checked" : '' ?>
            <?= $isGuest ? "disabled" : "" ?>
          >
    </div>

    <div class='card-body'>
      <h5 class='card-title'>Имя пользователя: <?= $task->username ?> (<?= $task->email ?>)</h5>
      <p class="card-text" contentEditable=<?= $isGuest ? "false" : "true" ?>><?= htmlspecialchars($task->task) ?></p>
      <?php if (!$isGuest) : ?>
        <button data-id="<?= $task->id ?>" class="btn btn-primary js-content-save">Сохранить</button>
      <?php endif; ?>
    </div>

    <?php if ($task->is_edited) : ?>
      <div class="card-footer">Отредактировано администратором.</div>
    <?php endif; ?>

  </div>
</div>
<?php endforeach; ?>

<?php if (!empty($pagination->links)) : ?>
<nav aria-label="Пагинация">
  <ul class="pagination ml-3">
    <?php foreach($pagination->links as $key => $link) : ?>
    <li class="page-item <?= $key == "current" ? "active" : "" ?>">
      <a class="page-link" href="<?= $link['link'] ?>"><?= $link['number'] ?></a>
    </li>
    <?php endforeach; ?>
  </ul>
</nav>
<?php endif; ?>