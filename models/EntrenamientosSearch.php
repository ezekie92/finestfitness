<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EntrenamientosSearch represents the model behind the search form of `app\models\Entrenamientos`.
 */
class EntrenamientosSearch extends Entrenamientos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'monitor_id'], 'integer'],
            [['estado'], 'boolean'],
            [['fecha', 'cliente.nombre', 'monitor.nombre'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['cliente.nombre', 'monitor.nombre']);
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
        $tipo = Yii::$app->user->identity->getTipoId();
        $query = Entrenamientos::find()->joinWith(['cliente', 'monitor']);

        if ($tipo == 'clientes') {
            $query->where(['cliente_id' => Yii::$app->user->identity->getNId()]);
            $query->andWhere(['estado' => 1]);
        } elseif ($tipo == 'monitores') {
            $query->where(['monitor_id' => Yii::$app->user->identity->getNId()]);
            $query->andWhere(['estado' => 1]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['fecha' => SORT_ASC]],
        ]);

        $dataProvider->sort->attributes['cliente.nombre'] = [
           'asc' => ['clientes.nombre' => SORT_ASC],
           'desc' => ['clientes.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['monitor.nombre'] = [
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
            'cliente_id' => $this->cliente_id,
            'monitor_id' => $this->monitor_id,
            'fecha' => $this->fecha,
            'estado' => $this->estado,
        ]);

        $query->andFilterWhere(['ilike', 'clientes.nombre', $this->getAttribute('cliente.nombre')])
        ->andFilterWhere(['ilike', 'monitores.nombre', $this->getAttribute('monitor.nombre')]);

        return $dataProvider;
    }
}
