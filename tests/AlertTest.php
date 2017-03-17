<?php
/**
 * @link http://ipaya.cn/
 * @copyright Copyright (c) 2016 ipaya.cn
 * @license http://ipaya.cn/license
 */

namespace iPayaUnit\alert;


use iPaya\alert\Alert;

class AlertTest extends TestCase
{
    public function testAlert()
    {
        Alert::add('success', 'Success');
        $output = Alert::widget();

        static::assertContains('Success', $output);
    }
}
