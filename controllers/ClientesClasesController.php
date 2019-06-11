<?php

namespace app\controllers;

use app\models\ClientesClases;
use app\models\ClientesClasesSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ClientesClasesController implements the CRUD actions for ClientesClases model.
 */
class ClientesClasesController extends Controller
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
                        'actions' => ['index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getTipoId() == 'administradores';
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
     * Lists all ClientesClases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientesClasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClientesClases model.
     * @param int $cliente_id
     * @param int $clase_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cliente_id, $clase_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($cliente_id, $clase_id),
        ]);
    }

    /**
     * Creates a new ClientesClases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClientesClases();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cliente_id' => $model->cliente_id, 'clase_id' => $model->clase_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClientesClases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cliente_id
     * @param int $clase_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cliente_id, $clase_id)
    {
        $model = $this->findModel($cliente_id, $clase_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cliente_id' => $model->cliente_id, 'clase_id' => $model->clase_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClientesClases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cliente_id
     * @param int $clase_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cliente_id, $clase_id)
    {
        $this->findModel($cliente_id, $clase_id)->delete();
        Yii::$app->response->format = Response::FORMAT_JSON;


        return $this->redirect(['clases/index']);
        // return $this->redirect(['index']);
    }

    /**
     * Finds the ClientesClases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cliente_id
     * @param int $clase_id
     * @return ClientesClases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cliente_id, $clase_id)
    {
        if (($model = ClientesClases::findOne(['cliente_id' => $cliente_id, 'clase_id' => $clase_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
