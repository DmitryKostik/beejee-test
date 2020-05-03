<?php
use core\Base;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <title>TEST MVC</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">Test</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <?php if (!Base::$app->user->getIsGuest()) : ?>
                <ul class="navbar-nav">
                    <a class="nav-link"><?= Base::$app->user->identity->username; ?></span></a>
                    <form action='/user/logout' method="POST">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Выйти</button>
                    </form>
                </ul>
                    
                <?php else : ?>
                    <a class="nav-link" href="/user/login">Войти</span></a>
                <?php endif; ?>
            </div>
        </nav>

        <div class="container">
            <?php include PROJECT_PATH . "/" . $viewPath; ?>
        </div>
        <div id="alert-info" class="alert" role="alert" style="position: fixed; display:none; right: 0; top: 10%;"></div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $(".js-job-checkbox").change(function() {
                $.post(
                    "/main/switch?json=true",
                    {
                        id: $(this).data("id"),
                        checked: $(this).prop("checked") ? 1 : 0
                    }
                );
            })

            $(".js-content-save").click(function() {
                $.post(
                    "/main/change?json=true",
                    {
                        id: $(this).data("id"),
                        task: $(this).parent().children(".card-text").text()
                    }
                ).done(function(response) {
                    response == true ? 
                        showAlert('success', 'Сохранено'):
                        showAlert('danger', response.error_msg);
                });
            })


            function showAlert(alertClass, msg) {
                alert = $("#alert-info");
                alert.text(msg);
                alert.addClass('alert-' + alertClass);
                alert.show().delay(1000).fadeOut(1000, function() {
                    alert.text('');
                    alert.removeClass('alert-' + alertClass);
                });
            }
        </script>
    </body>
</html>
