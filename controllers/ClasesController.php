<?php

namespace app\controllers;

use app\models\Clases;
use app\models\ClasesSearch;
use app\models\ClientesClases;
use app\models\Dias;
use app\models\Horarios;
use app\models\Monitores;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ClasesController implements the CRUD actions for Clases model.
 */
class ClasesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'create', 'index', 'view', 'delete', 'cambiar-monitor', 'clases-monitor'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'cambiar-monitor'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tipo = explode('-', Yii::$app->user->id);
                            return $tipo[0] == 'administradores';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['clases-monitor'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tipo = explode('-', Yii::$app->user->id);
                            return $tipo[0] == 'monitores';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
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
     * Lists all Clases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lista todas las clases que imparte un entrenador.
     * @return mixed
     */
    public function actionClasesMonitor()
    {
        $searchModel = new ClasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $id = explode('-', Yii::$app->user->identity->getid())[1];
        $dataProvider->query->where(['monitor' => $id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clases model.
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
     * Creates a new Clases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clases();

        if ($model->load(Yii::$app->request->post())) {
            $comprobar = $this->comprobarHorario($model->hora_inicio, $model->hora_fin, $model->dia, $model->diaClase->dia);

            if ($comprobar) {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'listaDias' => $this->listaDias(),
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Updates an existing Clases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $comprobar = $this->comprobarHorario($model->hora_inicio, $model->hora_fin, $model->dia, $model->diaClase->dia);

            if ($comprobar) {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'listaDias' => $this->listaDias(),
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Inscribe un cliente a una clase mediante ajax.
     * @return mixed
     */
    public function actionInscribirse()
    {
        $model = new ClientesClases();
        $model->cliente_id = (int) Yii::$app->request->post('cliente_id');
        $model->clase_id = (int) Yii::$app->request->post('clase_id');
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->save();
    }


    /**
     * Deletes an existing Clases model.
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
     * Cambia el monitor asignado a la Clase.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException si no se encuentra el modelo
     */
    public function actionCambiarMonitor($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->renderAjax('_monitor', [
            'model' => $model,
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Finds the Clases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Clases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clases::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Devuelve un listado de los dias.
     * @return Dias
     */
    private function listaDias()
    {
        return Dias::find()->select('dia')->indexBy('id')->column();
    }

    /**
     * Devuelve un listado de monitores.
     * @return Monitores el monitor que puede imparte la clase
     */
    private function listaMonitores()
    {
        return Monitores::find()->select('nombre')->indexBy('id')->column();
    }

    /**
     * Comprueba que el horario de una clase está dentro del horario de apertura
     * y cierre del gimnasio en el día en el que se quiere impartir la clase.
     * @param  string $inicio La hora a la que empieza la clase
     * @param  string $fin    La hora a la que termina la clase
     * @param  int    $dia    El id del día de la semana
     * @param  string $nDia   El nombre del día de la semana
     * @return mixed          True si no da error, o flash en caso de haberlo
     */
    private function comprobarHorario($inicio, $fin, $dia, $nDia)
    {
        $apertura = Horarios::find()->select('apertura')->where(['id' => $dia])->scalar();
        $cierre = Horarios::find()->select('cierre')->where(['id' => $dia])->scalar();

        if (strtotime($inicio) < strtotime($apertura) ||
            strtotime($inicio) > strtotime($cierre) ||
            strtotime($fin) < strtotime($apertura) ||
            strtotime($fin) > strtotime($cierre)) {
            $mensaje = 'Las clases del ' . $nDia .
                        " deben empezar después de las $apertura" .
                        " y terminar antes de las $cierre.";
            return Yii::$app->session->setFlash('danger', $mensaje);
        } elseif (strtotime($inicio) > strtotime($fin)) {
            $mensaje = 'Las clases no pueden terminar antes de la hora a la que empiezan.';
            return Yii::$app->session->setFlash('danger', $mensaje);
        }
        return true;
    }
}
