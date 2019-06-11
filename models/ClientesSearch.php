<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClientesSearch represents the model behind the search form of `app\models\Clientes`.
 */
class ClientesSearch extends Clientes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'peso', 'altura', 'tarifa'], 'integer'],
            [['fecha_nac', 'fecha_alta'], 'date'],
            [['nombre', 'email', 'contrasena', 'foto', 'tarifaNombre.tarifa'], 'safe'],
            [['telefono'], 'number'],
            [['confirmado'], 'boolean'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['tarifaNombre.tarifa']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Clientes::find()->joinWith('tarifaNombre');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['tarifaNombre.tarifa'] = [
           'asc' => ['tarifas.tarifa' => SORT_ASC],
           'desc' => ['tarifas.tarifa' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_nac' => $this->fecha_nac,
            'peso' => $this->peso,
            'altura' => $this->altura,
            'telefono' => $this->telefono,
            'tarifa' => $this->tarifa,
            'fecha_alta' => $this->fecha_alta,
            'confirmado' => $this->confirmado,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'contrasena', $this->contrasena])
            ->andFilterWhere(['ilike', 'foto', $this->foto])
            ->andFilterWhere(['ilike', 'tarifas.tarifa', $this->getAttribute('tarifaNombre.tarifa')]);


        return $dataProvider;
    }
}
