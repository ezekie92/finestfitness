<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RutinasSearch represents the model behind the search form of `app\models\Rutinas`.
 */
class RutinasSearch extends Rutinas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ejercicio', 'dia'], 'integer'],
            [['nombre', 'ejercicios.nombre', 'diaRutina.dia'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['ejercicios.nombre', 'diaRutina.dia']);
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
        $query = Rutinas::find()->joinWith(['ejercicios', 'diaRutina']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['diaRutina.dia'] = [
           'asc' => ['dias.dia' => SORT_ASC],
           'desc' => ['dias.dia' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['ejercicios.nombre'] = [
           'asc' => ['ejercicios.nombre' => SORT_ASC],
           'desc' => ['ejercicios.nombre' => SORT_DESC],
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
            'ejercicio' => $this->ejercicio,
            'dia' => $this->dia,
        ]);

        $query->andFilterWhere(['ilike', 'rutinas.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'dias.dia', $this->getAttribute('diaRutina.dia')])
        ->andFilterWhere(['ilike', 'ejercicios.nombre', $this->getAttribute('ejercicios.nombre')]);

        return $dataProvider;
    }
}
