<?php

namespace frontend\controllers;

use common\components\ApiHelper;
use common\components\auth\JwtIdentity;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect('index.php?r=subject-category/index');
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
            if ($content->status_code == ApiHelper::STATUS_OK && isset($token)) {
                // Создаем cookie
                $cookie = new \yii\web\Cookie([
                    'name' => 'usernameFront',
                    'value' => ['email' => $model->username, 'token' => $token],
                    'httpOnly' => true,
                    'expire' => time() + 86400 * 365, // срок действия - 1 год
                    'path' => '/',              // важно: общий путь
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
        Yii::$app->response->cookies->remove('usernameFront');
        return $this->goHome();
    }
}
