<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monitores".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $contrasena
 * @property string $fecha_nac
 * @property string $foto
 * @property string $telefono
 * @property string $horario_entrada
 * @property string $horario_salida
 * @property int $especialidad
 * @property string $token
 * @property bool $confirmado
 *
 * @property Clases[] $clases
 * @property Entrenamientos[] $entrenamientos
 */
class Monitores extends \yii\db\ActiveRecord
{
    /**
     * Escenario para la creación de clientes.
     * @var string
     */
    const SCENARIO_CREATE = 'create';
    /**
     * Escenario para la modificación de clientes.
     * @var string
     */
    const SCENARIO_UPDATE = 'update';
    /**
     * Escenario donde se convierte un cliente a monitor.
     * @var string
     */
    const SCENARIO_CONVERTIR = 'convertir';

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
        return 'monitores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email', 'fecha_nac', 'especialidad'], 'required'],
            [['contrasena'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['contrasena_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE]],
            [['contrasena'], 'compare', 'on' => [self::SCENARIO_UPDATE]],
            [['fecha_nac', 'horario_entrada', 'horario_salida', 'token'], 'safe'],
            [['telefono'], 'number'],
            [['especialidad'], 'default', 'value' => null],
            [['especialidad'], 'integer'],
            [['confirmado'], 'boolean'],
            [['nombre'], 'string', 'max' => 32],
            [['email', 'contrasena'], 'string', 'max' => 60],
            [['foto'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email'], 'unique',
               'targetClass' => Administradores::ClassName(),
                'targetAttribute' => ['email'],
            ],
            [['email'], 'unique',
               'targetClass' => Clientes::ClassName(),
                'targetAttribute' => ['email'],
                'except' => self::SCENARIO_CONVERTIR,
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
            'fecha_nac' => 'Fecha de nacimiento',
            'foto' => 'Foto',
            'telefono' => 'Telefono',
            'horario_entrada' => 'Inicio jornada',
            'horario_salida' => 'Fin jornada',
            'especialidad' => 'Especialidad',
            'token' => 'Token',
            'confirmado' => 'Confirmado',
            'contrasena_repeat' => 'Repetir Contraseña',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClases()
    {
        return $this->hasMany(Clases::className(), ['monitor' => 'id'])->inverseOf('monitorClase');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrenamientos()
    {
        return $this->hasMany(Entrenamientos::className(), ['monitor_id' => 'id'])->inverseOf('monitor');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesEntrenamientos()
    {
        return $this->hasMany(Clientes::className(), ['id' => 'cliente_id'])->viaTable('entrenamientos', ['monitor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsp()
    {
        return $this->hasOne(Especialidades::className(), ['id' => 'especialidad'])->inverseOf('monitores');
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
            if ($this->foto === '') {
                $this->foto = $this->getOldAttribute('foto');
            }
        }
        return true;
    }
}
