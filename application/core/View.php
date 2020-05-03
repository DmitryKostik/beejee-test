<?php

namespace core;

class View
{
    /** @var string $layout Базовая часть представления */
    private $layout = 'main';

    /** @var string $baseViewPath Путь к представлениям */
    private $baseViewPath = 'application/views';

    /**
     * Рендерит представление.
     * @param string $view Представление.
     * @param mixed $data Данные.
     * @param Controller $context Контроллер.
     * @return string
     */
    public function render($view, $data, $context)
    {
        if (is_array($data)) {
            extract($data);
        }

        $viewPath = $this->baseViewPath . "/" . lcfirst($context->id) . "/$view.php";

        ob_start();
        ob_implicit_flush(false);
        require PROJECT_PATH . "/$this->baseViewPath/layouts/$this->layout.php";
        return ob_get_clean();
    }
}
