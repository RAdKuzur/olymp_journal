<?php

namespace backend\controllers;

use common\components\ApiHelper;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionIndex()
    {
        return $this->redirect('index.php?r=admin/subject/index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->apiService->post(ApiHelper::AUTH_URL_API, [
                'email' => $model->username,
                'password' => $model->password,
            ]);

            $content = json_decode($response['content']);
            $token = $response['cookies']->getValue('token');
            if ($content->code == ApiHelper::STATUS_OK && isset($token)) {
                // Создаем cookie
                $cookie = new \yii\web\Cookie([
                    'name' => 'usernameBack',
                    'value' => ['email' => $model->username, 'token' => $token],
                    'httpOnly' => true,
                    'path' => '/',              // важно: общий путь
                    'expire' => time() + 86400 * 365, // срок действия - 1 год
                ]);

                // Добавляем cookie в response
                Yii::$app->response->cookies->add($cookie);

                // ВАЖНО: сначала добавляем cookie, потом делаем редирект
                $response = $this->goBack();

                // Убедимся, что cookie сохранилась в редиректе
                if (Yii::$app->response->cookies->has('cookie_name')) {
                    return $response;
                } else {
                    Yii::error('Failed to set cookie');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка авторизации');
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->response->cookies->remove('usernameBack');
        return $this->goHome();
    }
}
