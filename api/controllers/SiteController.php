<?php

namespace api\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\helpers\BaseUrl;
/**
 * Site controller
 */
class SiteController extends Controller
{
    public $defaultAction = 'index';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (YII_ENV == 'dev' || YII_ENV == 'sandbox') {
            $this->redirect('/swagger/?url=' . BaseUrl::base(true) . '/swagger.json');
        } else {
            throw new ForbiddenHttpException();
        }
    }

    public function actionPing()
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = ['status' => 'ok'];
    }
}
