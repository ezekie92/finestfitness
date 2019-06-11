<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TarifasSearch represents the model behind the search form of `app\models\Tarifas`.
 */
class TarifasSearch extends Tarifas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tarifa'], 'safe'],
            [['hora_entrada_min', 'hora_entrada_max'], 'time'],
            [['precio'], 'number'],
        ];
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
        $query = Tarifas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'precio' => $this->precio,
            'hora_entrada_min' => $this->hora_entrada_min,
            'hora_entrada_max' => $this->hora_entrada_max,
        ]);

        $query->andFilterWhere(['ilike', 'tarifa', $this->tarifa]);

        return $dataProvider;
    }
}
