<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * HorariosSearch represents the model behind the search form of `app\models\Horarios`.
 */
class HorariosSearch extends Horarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dia'], 'integer'],
            [['apertura', 'cierre'], 'time'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['nombreDia.dia']);
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
        $query = Horarios::find()->joinWith('nombreDia');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['dia' => SORT_ASC]],
        ]);

        $dataProvider->sort->attributes['nombreDia.dia'] = [
           'asc' => ['dias.dia' => SORT_ASC],
           'desc' => ['dias.dia' => SORT_DESC],
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
            'dia' => $this->dia,
            'apertura' => $this->apertura,
            'cierre' => $this->cierre,
        ]);

        return $dataProvider;
    }
}
