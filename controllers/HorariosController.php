<?php

namespace app\controllers;

use app\models\Clases;
use app\models\Dias;
use app\models\Entrenamientos;
use app\models\Horarios;
use app\models\HorariosSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HorariosController implements the CRUD actions for Horarios model.
 */
class HorariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'view', 'index', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $ruta = explode('/', Yii::$app->request->get('r'));
                            return ($ruta[0] . '-' . Yii::$app->request->get('id')) == Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'view', 'index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tipo = explode('-', Yii::$app->user->id);
                            return $tipo[0] == 'administradores';
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HorariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horarios model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Horarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'dias' => $this->listaDias(),
        ]);
    }

    /**
     * Updates an existing Horarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->cancelarClases($model->apertura, $model->cierre, $model->dia);
            $this->cancelarEntrenamientos($model->apertura, $model->cierre, $model->dia);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'dias' => $this->listaDias(),
        ]);
    }

    /**
     * Deletes an existing Horarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Horarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Horarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Horarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Devuelve un listado de los días de la semana.
     * @return Dias El dia de la semana
     */
    private function listaDias()
    {
        return Dias::find()->select('dia')->indexBy('id')->column();
    }

    /**
     * Cancela las clases que se queden fuera del nuevo horario.
     * @param  string $inicio La hora a la que abre el gimnasio
     * @param  string $fin    La hora a la que abre el gimnasio
     * @param  int $dia       El día de la semana en cuestión
     */
    private function cancelarClases($inicio, $fin, $dia)
    {
        $clases = Clases::find()
                        ->where(['dia' => $dia])
                        ->andWhere(['<', 'hora_inicio', $inicio])
                        ->orWhere(['>', 'hora_fin', $fin])
                        ->all();

        foreach ($clases as $key => $value) {
            $model = Clases::find()->where(['id' => $value->id])->one();
            if ($model->plazas) {
                $model->nombre = $model->nombre . ' (CANCELADA)';
            }
            $model->plazas = 0;
            $model->update();
        }
    }

    /**
     * Cancela los entrenamientos que se queden fuera del nuevo horario.
     * @param  string $inicio La hora a la que abre el gimnasio
     * @param  string $fin    La hora a la que abre el gimnasio
     * @param  int $dia       El día de la semana en cuestión
     */
    private function cancelarEntrenamientos($inicio, $fin, $dia)
    {
        $ent = Entrenamientos::find()
                        ->where(['dia' => $dia])
                        ->andWhere(['<', 'hora_inicio', $inicio])
                        ->orWhere(['>', 'hora_fin', $fin])
                        ->all();

        foreach ($ent as $key => $value) {
            $model = Entrenamientos::find()
                        ->where(['cliente_id' => $value->cliente_id])
                        ->andWhere(['monitor_id' => $value->monitor_id])
                        ->one();
            $model->hora_inicio = null;
            $model->hora_fin = null;
            $model->update();
        }
    }
}
