<?php

namespace app\controllers;

use app\models\Entrenamientos;
use app\models\RutinaActual;
use app\models\RutinaActualSearch;
use app\models\Rutinas;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RutinaActualController implements the CRUD actions for RutinaActual model.
 */
class RutinaActualController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getTipoId() == 'monitores';
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
     * Lists all RutinaActual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RutinaActualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RutinaActual model.
     * @param int $cliente_id
     * @param int $rutina_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cliente_id, $rutina_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cliente_id, $rutina_id),
        ]);
    }

    /**
     * Creates a new RutinaActual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RutinaActual();
        $model->cliente_id = $_GET['cliente_id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['clientes/view', 'id' => $model->cliente_id]);
        }

        $listaRutinas = $this->listaRutinas($model->cliente_id);
        if (!$this->comprobarMonitor($model->cliente_id)) {
            return $this->redirect(['site/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'listaRutinas' => $listaRutinas,
        ]);
    }

    /**
     * Updates an existing RutinaActual model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cliente_id
     * @param int $rutina_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cliente_id, $rutina_id)
    {
        $model = $this->findModel($cliente_id, $rutina_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['clientes/view', 'id' => $model->cliente_id]);
        }
        $listaRutinas = $this->listaRutinas($model->cliente_id);

        if (!$this->comprobarMonitor($model->cliente_id)) {
            return $this->redirect(['site/index']);
        }
        return $this->render('update', [
            'model' => $model,
            'listaRutinas' => $listaRutinas,
        ]);
    }

    /**
     * Deletes an existing RutinaActual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cliente_id
     * @param int $rutina_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cliente_id, $rutina_id)
    {
        $this->findModel($cliente_id, $rutina_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RutinaActual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cliente_id
     * @param int $rutina_id
     * @return RutinaActual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cliente_id, $rutina_id)
    {
        if (($model = RutinaActual::findOne(['cliente_id' => $cliente_id, 'rutina_id' => $rutina_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Devuelve un listado de las rutinas de un cliente.
     * @param int $id
     * @return Rutinas
     */
    private function listaRutinas($id)
    {
        return Rutinas::find()->select('nombre')->where(['cliente_id' => $id])->indexBy('id')->column();
    }

    /**
     * Comprueba que un monitor es entrenador de un cliente.
     * @param  int $id  El id del cliente
     * @return int     0 si no es, >= 1 si si es.
     */
    private function comprobarMonitor($id)
    {
        $monitor = Yii::$app->user->identity->getNId();
        return Entrenamientos::find()->where(['cliente_id' => $id])->andWhere(['monitor_id' => $monitor])->count();
    }
}
