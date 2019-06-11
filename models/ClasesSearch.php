<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ClasesSearch represents the model behind the search form of `app\models\Clases`.
 */
class ClasesSearch extends Clases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'monitor', 'plazas'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre', 'monitorClase.nombre'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['monitorClase.nombre']);
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
        $fecha = new \DateTime('now');
        $ahora = $fecha->format('Y-m-d H:i:s');
        $query = Clases::find()->joinWith(['monitorClase'])->where(['>=', 'fecha', $ahora]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['fecha' => SORT_ASC, 'fecha' => SORT_ASC]],
        ]);

        $dataProvider->sort->attributes['monitorClase.nombre'] = [
           'asc' => ['monitores.nombre' => SORT_ASC],
           'desc' => ['monitores.nombre' => SORT_DESC],
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
            'fecha' => $this->fecha,
            'monitor' => $this->monitor,
            'plazas' => $this->plazas,
        ]);

        $query->andFilterWhere(['ilike', 'clases.nombre', $this->nombre])
        ->andFilterWhere(['ilike', 'monitores.nombre', $this->getAttribute('monitorClase.nombre')]);

        return $dataProvider;
    }
}
