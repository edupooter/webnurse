<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "usuario".
 *
 * @property string $id
 * @property string $username Nome de Usuário
 * @property string $password Senha do usuário
 * @property string $authKey Chave de autenticação
 * @property string $hospital Hospital
 */
class Usuario extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{usuario}}';
    }

    // public static function getDb() {
    //     return Yii::$app->get('hcpa');
    //     return Yii::$app->get(Yii::$app->user->identity->hospital);
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 30],
            [['username'], 'unique', 'targetAttribute' => 'username', 'message' => 'Já existe um usuário com esse nome.'],
            [['username'], 'trim'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 60],

            [['authKey'], 'string', 'max' => 50],
            [['authKey'], 'unique'],

            [['hospital'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nome de Usuário',
            'password' => 'Senha do usuário',
            'authKey' => 'Chave de autenticação',
            'hospital' => 'Hospital',
        ];
    }

    public static function findIdentity($id)
    {
  		return static::findOne($id);
  	}

  	public static function findIdentityByAccessToken($token, $type = null)
    {
  		throw new NotSupportedException();
  	}

  	public function getId()
    {
  		return $this->id;
  	}

  	public static function findByUsername($username)
    {
  		return self::findOne(['username'=>$username]);
  	}

  	// public function getAuthKey()
    // {
  	// 	return $this->authKey;
  	// }
    //
  	// public function validateAuthKey($authKey)
    // {
  	// 	return $this->authKey === $authKey;
  	// }

    public function getAuthKey()
    {
        return static::findOne('authKey');
    }

    public function validateAuthKey($authKey)
    {
        return static::findOne(['authKey' => $authKey]);
    }

  	// public function validatePassword($password){

  	// }

    public function validatePassword($password)
    {
        // return $this->password === $password;
        // // Check the hashed password with the password entered by user
        return $this->password === static::hashPassword($password);
    }

    public static function hashPassword($password)
    {   // Function to create password hash
        $salt = "nurse478";
        return md5($password.$salt);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->isNewRecord)
            {
                $this->authKey = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

}
