<?php

namespace app\controllers;

use app\models\Personas;
use app\models\PersonasSearch;
use app\models\Tarifas;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PersonasController implements the CRUD actions for Personas model.
 */
class PersonasController extends Controller
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
     * Lists all Personas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lista todos los clientes.
     * @return mixed
     */
    public function actionClientes()
    {
        $searchModel = new PersonasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tipo' => 'Cliente']);

        return $this->render('clientes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lista todos los monitores.
     * @return mixed
     */
    public function actionMonitores()
    {
        $searchModel = new PersonasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tipo' => 'Monitor']);

        return $this->render('monitores', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personas model.
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
     * Creates a new Personas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAltaCliente()
    {
        $model = new Personas(['scenario' => Personas::SCENARIO_CREATE]);
        $model->fecha_alta = new Expression('NOW()');
        $model->tipo = 'Cliente';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('altaCliente', [
            'model' => $model,
            'listaTarifas' => $this->listaTarifas(),
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Creates a new Monitor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAltaMonitor()
    {
        $model = new Personas(['scenario' => Personas::SCENARIO_CREATE]);
        $model->fecha_alta = new Expression('NOW()');
        $model->tipo = 'Monitor';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('altaMonitor', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Personas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Personas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionModificarCliente($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Personas::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->contrasena = '';

        return $this->render('modificarCliente', [
            'model' => $model,
            'listaTarifas' => $this->listaTarifas(),
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Updates an existing Personas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionModificarMonitor($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Personas::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->contrasena = '';

        return $this->render('modificarMonitor', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Personas model.
     * Si se realiza el borrado, redirige a la vista del tipo borrado, o a index
     * si fuese otro tipo distinto a Cliente o Monitor.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->tipo == 'Cliente') {
            $this->findModel($id)->delete();
            return $this->redirect(['clientes']);
        } elseif ($this->findModel($id)->tipo == 'Monitor') {
            $this->findModel($id)->delete();
            return $this->redirect(['monitores']);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Personas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Personas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Devuelve un listado de las tarifas.
     * @return Tarifas
     */
    private function listaTarifas()
    {
        return Tarifas::find()->select('tarifa')->indexBy('id')->column();
    }

    /**
     * Devuelve un listado de personas.
     * @return Personas que son de tipo monitor
     */
    private function listaMonitores()
    {
        return Personas::find()
            ->select('nombre')
            ->where(['tipo' => 'monitor'])
            ->indexBy('id')
            ->column();
    }
}
