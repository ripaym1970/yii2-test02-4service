<?php

namespace console\controllers;

use common\models\User;
use DomainException;
use yii\console\Controller;

/**
 * Interactive console users manager
 */
class AdminController extends Controller
{

    /**
     * Create user and add role to him
     */
    public function actionCreate(): void {
        $this->stdout('Создание нового администратора:' . PHP_EOL);
        $user = new User();
        $user->username = $this->prompt('Login:', ['required' => true]);
        $user->setPassword($this->prompt('Password:', ['required' => true]));

        $user->email    = $user->username.'@yii2-test-4service.loc';
        $user->status   = 10;

        try {
            if (!$user->save()) {
                print_r(['Ошибки:', implode(',', $user->getFirstErrors())]);
                exit;
            }

            $this->stdout('Успешно сохранено!' . PHP_EOL);
        } catch (DomainException $e) {
            $this->stdout('Ошибки добавления: ' . $e->getMessage() . PHP_EOL);
        }
    }
}
