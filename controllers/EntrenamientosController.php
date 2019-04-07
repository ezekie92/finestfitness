<?php

namespace app\controllers;

use app\models\Entrenamientos;
use app\models\EntrenamientosSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EntrenamientosController implements the CRUD actions for Entrenamientos model.
 */
class EntrenamientosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Entrenamientos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntrenamientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entrenamientos model.
     * @param int $cliente_id
     * @param int $monitor_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cliente_id, $monitor_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cliente_id, $monitor_id),
        ]);
    }

    /**
     * Creates a new Entrenamientos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entrenamientos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Entrenamientos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cliente_id
     * @param int $monitor_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cliente_id, $monitor_id)
    {
        $model = $this->findModel($cliente_id, $monitor_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cliente_id' => $model->cliente_id, 'monitor_id' => $model->monitor_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Entrenamientos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cliente_id
     * @param int $monitor_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cliente_id, $monitor_id)
    {
        $this->findModel($cliente_id, $monitor_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Entrenamientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cliente_id
     * @param int $monitor_id
     * @return Entrenamientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cliente_id, $monitor_id)
    {
        if (($model = Entrenamientos::findOne(['cliente_id' => $cliente_id, 'monitor_id' => $monitor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
