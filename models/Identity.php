<?php

namespace app\models;

use Yii;
use yii\base\InvalidCallException;
use yii\web\IdentityInterface;

/**
 * Controla el login en función del modelo de usuario.
 * @var mixed
 */
final class Identity implements IdentityInterface
{
    /**
     * Define un de los tipos permitidos, en este caso: clientes.
     * @var string
     */
    const TIPO_CLIENTE = 'clientes';
    /**
     * Define un de los tipos permitidos, en este caso: monitores.
     * @var string
     */
    const TIPO_MONITOR = 'monitores';
    /**
     * Define un de los tipos permitidos, en este caso: administradores.
     * @var string
     */
    const TIPO_ADMIN = 'admininistradores';
    /**
     * Los tipos permitidos.
     * @var array
     */
    const TIPOS_PERMITIDOS = [self::TIPO_CLIENTE, self::TIPO_MONITOR, self::TIPO_ADMIN];

    /**
     * El id del usuario.
     * @var int
     */
    private $_id;
    /**
     * El tipo de usuario.
     * @var string
     */
    private $_tipo;
    /**
     * El nombre del usuario.
     * @var string
     */
    private $_nombre;
    /**
     * La contraseña del usuario.
     * @var string
     */
    private $_password;

    public static function findIdentity($id)
    {
        $parts = explode('-', $id);
        if (\count($parts) !== 2) {
            throw new InvalidCallException('El id debe estar formado por tipo-digito');
        }
        [$tipo, $digito] = $parts;

        if (!\in_array($tipo, self::TIPOS_PERMITIDOS, true)) {
            throw new InvalidCallException('Tipo de usuario no permitido');
        }

        $model = null;
        switch ($tipo) {
            case self::TIPO_CLIENTE:
                $model = Clientes::find()->where(['id' => $digito])->one();
                break;
            case self::TIPO_MONITOR:
                $model = Monitores::find()->where(['id' => $digito])->one();
                break;
            case self::TIPO_ADMIN:
                $model = Administradores::find()->where(['id' => $digito])->one();
                break;
        }

        if ($model === null) {
            return false;
        }

        $identity = new self();
        $identity->_id = $id;
        $identity->_nombre = $model->nombre;
        $identity->_password = $model->contrasena;
        return $identity;
    }

    public static function findIdentityByAccessToken($token, $tipo = null)
    {
    }

    /**
     * Comprueba que la contraseña introducida se corresponde con la del usuario introducido.
     * @param  string $password la contraseña introducida
     * @return bool           si coincide o no
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->_password);
    }

    /**
     * Identifica a un usuario mediante su email.
     * @param  string $email El email del usuario
     * @return Identity|null EL usuario, o nulo, en función de si existe o no
     */
    public static function findIdentityByEmail($email)
    {
        $model = Clientes::find()->where(['email' => $email])->one();
        if (!$model) {
            $model = Monitores::find()->where(['email' => $email])->one();
        }
        if (!$model) {
            $model = Administradores::find()->where(['email' => $email])->one();
        }

        if (!$model) {
            return false;
        }

        if ($model instanceof Clientes) {
            $tipo = self::TIPO_CLIENTE;
        } elseif ($model instanceof Monitores) {
            $tipo = self::TIPO_MONITOR;
        } else {
            $tipo = self::TIPO_ADMIN;
        }

        $identity = new self();
        $identity->_id = $tipo . '-' . $model->id;
        $identity->_nombre = $model->nombre;
        $identity->_password = $model->contrasena;
        return $identity;
    }

    public function getId()
    {
        return $this->_id;
    }

    /**
     * Devuelve el nombre del usuario.
     * @return string El nombre del usuario
     */
    public function getNombre()
    {
        return $this->_nombre;
    }

    public function getAuthKey()
    {
        // return $this->_authkey;
    }

    public function validateAuthKey($authKey)
    {
        // return $this->getAuthKey() === $authKey;
    }
}
