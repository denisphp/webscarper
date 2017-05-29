<?php
namespace api\components;

use mobidev\swagger\components\api\DataValidationHttpException;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Yii;

class ApiResponse extends Response
{
    public static function beforeSend($event)
    {
        /** @var \yii\web\Response $response */
        $response = $event->sender;
        $response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->get('suppress_response_code')) {
            $response->statusCode = 200;
        }
        if ($response->isSuccessful) {
            if ($response->data == null) {
                $response->data = [
                    'success' => $response->isSuccessful,
                    'code' => $response->getStatusCode(),
                ];
            } else {
                $response->data = ArrayHelper::merge([
                    'success' => $response->isSuccessful,
                    'code' => $response->getStatusCode(),
                ], $response->data);
            }
        } else {
            $e = Yii::$app->getErrorHandler()->exception;
            if ($e) {
                $message = $e->getMessage();
            }
            $response->data = [
                'success' => $response->isSuccessful,
                'code' => $response->getStatusCode(),
                'message' => !empty($message) ? $message : Response::$httpStatuses[$response->getStatusCode()],
            ];
            // Add validation errors to response
            if ($e instanceof DataValidationHttpException) {
                if (Yii::$app->request->get('string_errors')) {
                    $allErrors = [];
                    foreach ($e->validationErrors as $errors) {
                        foreach ($errors as $errorMessage) {
                            $allErrors[] = $errorMessage;
                        }
                    }
                    $response->data['errors'] = implode(' ', $allErrors);
                }
                $response->data = array_merge($response->data, $e->validationErrors);
            }
        }
    }
}