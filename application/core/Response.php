<?php

namespace core;

class Response
{
    public $headers = [];

    /** Вернуть json */
    public const TYPE_JSON = 'json';

    /** Вернуть html */
    public const TYPE_HTML = 'html';

    /** @var string $responseType Формат ответа */
    public $responseType = 'html';


    public function init()
    {
        $this->detectResponseType();
    }


    /**
     * Устанавливает заголовок ответа.
     * @param string $name Заголовок.
     * @param string $value Значение заголовка.
     * @return void
     */
    public function setHeader($name, $value) : void
    {
        $headers[$name] = $value;
        header("$name: $value");
    }


    /**
     * Выполняет ответ сервера.
     * @param $value Значение отправленное шаблонизатору.
     * @param Controller $context Контроллер.
     */
    public function response($value, Controller $context)
    {
        switch ($this->responseType) {
            case static::TYPE_JSON:
                $output = $this->asJson($value);
                break;
            case static::TYPE_HTML:
                $output = $this->asHtml($value, $context);
                break;
            default:
                $this->responseType = static::TYPE_HTML;
                $output = $this->asHtml($value, $context);
                break;
        }

        echo $output;
        exit();
    }


    /**
     * Определяет запрошенный формат ответа
     */
    public function detectResponseType() : void
    {
        $request = Base::$app->request;
        switch (true) {
            case $request->get('json'):
                $this->responseType = static::TYPE_JSON;
                break;
            default:
                $this->responseType = static::TYPE_HTML;
                break;
        }
    }


    /**
     * Форматирует ответ в json.
     * @param mixed $output Данные для сериализации.
     * @return string
     */
    public function asJson($output)
    {
        $this->setHeader('Content-type', 'application/json');
        return json_encode($output);
    }


    /**
     * Рендерит html
     * @param mixed $output Данные для рендеринга.
     * @param Controller $context Контроллер.
     * @return string
     */
    public function asHtml($output, $context)
    {
        $this->setHeader('Content-type', 'text/html');
        $id = $context->getActionId();
        return $context->render($id, $output);
    }
}
