<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;
    private $_conf = false;
    private $_pago = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Email',
            'password' => 'Contraseña',
            'rememberMe' => 'Recordarme',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->getPago()) {
            return Yii::$app->session->setFlash('danger', 'No pagó el mes anterior. Contacte con el administrador.');
        }
        if ($this->validate() && $this->getConf() && $this->getPago()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]].
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Identity::findIdentityByEmail($this->username);
        }

        return $this->_user;
    }

    /**
     * Devuelve si un usuario está confirmado o no.
     * @return bool Verdadero o falso
     */
    public function getConf()
    {
        if ($this->_conf === false) {
            $this->_conf = Identity::confirmado($this->username);
        }

        return $this->_conf;
    }

    /**
     * Devuelve si un usuario ha pagado la mensualidad.
     * @return bool Si ha pagado o no
     */
    public function getPago()
    {
        if ($this->_pago === false) {
            $this->_pago = Identity::pago($this->username);
        }

        return $this->_pago;
    }
}
