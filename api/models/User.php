<?php

namespace api\models;

use yii\web\IdentityInterface;
use common\models\User as UserCommon;
use Yii;

/**
 * Class User
 *
 * @package api\models
 */
class User extends UserCommon implements IdentityInterface
{

    public function rules()
    {
        $rules = parent::rules();

        return $rules;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        return $scenarios;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $id = \Yii::$app->session->get('userId');
        if ($id) {
            return static::findOne(['id' => $id]);
        }
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return \Yii::$app->session->getId();
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        if ($authKey == \Yii::$app->session->getId()) {
            return true;
        }
        return false;
    }
}
