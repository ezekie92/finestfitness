<?php

namespace app\models;

/**
 * This is the model class for table "rutina_actual".
 *
 * @property int $cliente_id
 * @property int $rutina_id
 *
 * @property Clientes $cliente
 * @property Rutinas $rutina
 */
class RutinaActual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rutina_actual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'rutina_id'], 'required'],
            [['cliente_id', 'rutina_id'], 'default', 'value' => null],
            [['cliente_id', 'rutina_id'], 'integer'],
            [['cliente_id'], 'unique'],
            [['cliente_id', 'rutina_id'], 'unique', 'targetAttribute' => ['cliente_id', 'rutina_id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['rutina_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutinas::className(), 'targetAttribute' => ['rutina_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cliente_id' => 'Cliente',
            'rutina_id' => 'Rutina',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clientes::className(), ['id' => 'cliente_id'])->inverseOf('rutinaActual');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutina()
    {
        return $this->hasOne(Rutinas::className(), ['id' => 'rutina_id'])->inverseOf('rutinaActual');
    }
}
