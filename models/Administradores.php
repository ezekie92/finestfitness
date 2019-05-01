<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "administradores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $contrasena
 */
class Administradores extends \yii\db\ActiveRecord
{
    /**
     * Escenario para la creación de administradores.
     * @var string
     */
    const SCENARIO_CREATE = 'create';
    /**
     * Escenario para la modificación de administradores.
     * @var string
     */
    const SCENARIO_UPDATE = 'update';
    /**
     * Se usa para comparar las contraseñas al cambiarlas.
     * @var string
     */
    public $contrasena_repeat;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'administradores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email'], 'required'],
            [['contrasena'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['contrasena_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE]],
            [['contrasena'], 'compare', 'on' => [self::SCENARIO_UPDATE]],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['email'], 'unique'],
            [['email'], 'unique',
               'targetClass' => Clientes::ClassName(),
                'targetAttribute' => ['email'],
            ],
            [['email'], 'unique',
               'targetClass' => Monitores::ClassName(),
                'targetAttribute' => ['email'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'contrasena' => 'Contraseña',
            'token' => 'Token',
            'confirmado' => 'Confirmado',
            'contrasena_repeat' => 'Repetir Contraseña',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                goto salto;
            }
        } elseif ($this->scenario === self::SCENARIO_UPDATE) {
            if ($this->contrasena === '') {
                $this->contrasena = $this->getOldAttribute('contrasena');
            } else {
                salto:
                $this->contrasena = Yii::$app->security
                    ->generatePasswordHash($this->contrasena);
                $this->token = Yii::$app->security->generateRandomString();
            }
        }
        return true;
    }
}
