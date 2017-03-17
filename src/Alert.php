<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 * @license http://ipaya.cn/license
 */

namespace iPaya\alert;


use Yii;
use yii\bootstrap\Widget;

class Alert extends Widget
{
    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';

    /**
     * @var array
     */
    public $types = [
        self::TYPE_ERROR => 'alert-danger',
        self::TYPE_SUCCESS => 'alert-success',
        self::TYPE_INFO => 'alert-info',
        self::TYPE_WARNING => 'alert-warning'
    ];


    /**
     * @var array
     */
    public $closeButton = [];

    /**
     * Success alert message.
     *
     * @param string $message
     */
    public static function success($message)
    {
        self::add(self::TYPE_SUCCESS, $message);
    }

    /**
     * @param string $type
     * @param string $message
     */
    public static function add($type, $message)
    {
        $messages = Yii::$app->session->getFlash($type, []);
        $messages[] = $message;
        Yii::$app->session->setFlash($type, $messages);
    }

    /**
     * Error alert message.
     *
     * @param string $message
     */
    public static function error($message)
    {
        self::add(self::TYPE_ERROR, $message);
    }

    /**
     * Info alert message.
     *
     * @param string $message
     */
    public static function info($message)
    {
        self::add(self::TYPE_INFO, $message);
    }

    /**
     * Warning alert message.
     *
     * @param string $message
     */
    public static function warning($message)
    {
        self::add(self::TYPE_WARNING, $message);
    }

    public function init()
    {
        parent::init();
        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';
        foreach ($flashes as $type => $data) {
            if (isset($this->types[$type])) {
                if (!is_array($data)) {
                    $data = (array)$data;
                }
                foreach ($data as $i => $message) {
                    $this->options['class'] = $this->types[$type] . $appendCss;
                    $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;
                    echo \yii\bootstrap\Alert::widget([
                        'body' => $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                }
                $session->removeFlash($type);
            }
        }
    }
}
