<?php

namespace app\controllers;

use app\models\Dias;
use app\models\Entrenamientos;
use app\models\EntrenamientosSearch;
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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'clientes-entrenador', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tipo = explode('-', Yii::$app->user->id);
                            return $tipo[0] == 'administradores';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['clientes-entrenador'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tipo = explode('-', Yii::$app->user->id);
                            return $tipo[0] == 'monitores';
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
     * Lista todos los clientes que entrena un entrenador.
     * @return mixed
     */
    public function actionClientesEntrenador()
    {
        $searchModel = new EntrenamientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $id = explode('-', Yii::$app->user->identity->getid())[1];
        $dataProvider->query->where(['monitor_id' => $id]);

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

        if ($model->load(Yii::$app->request->post())) {
            $comprobar = $this->comprobarHorario($model->hora_inicio, $model->hora_fin, $model->dia, $model->diaSemana->dia);

            if ($comprobar) {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
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

        if ($model->load(Yii::$app->request->post())) {
            $comprobar = $this->comprobarHorario($model->hora_inicio, $model->hora_fin, $model->dia, $model->diaSemana->dia);

            if ($comprobar) {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Crea un nuevo entrenamiento usando el id del entrenador y del usuario logueado.
     * @param  int $id El id del entrenador
     * @return mixed
     */
    public function actionSolicitar($id)
    {
        $model = new Entrenamientos();
        $model->monitor_id = $id;
        $model->cliente_id = Yii::$app->user->identity->getNId();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($this->comprobarEntrenamiento($model)) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Solicitud enviada con éxito.');
                } else {
                    Yii::$app->session->setFlash('danger', 'No se puede solicitar dicho entrenamiento, contacte con el administrador.');
                }
            }
            return $this->redirect(['monitores/lista-monitores']);
        }

        return $this->renderAjax('_solicitud', [
            'model' => $model,
            'listaDias' => $this->listaDias(),
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

    /**
     * Comprueba que el horario de una sesión de entrenamiento está dentro del
     * horario de apertura y cierre del gimnasio en el día en el que se quiere
     * llevar a cabo.
     * @param  string $inicio La hora a la que empieza el entrenamiento
     * @param  string $fin    La hora a la que termina el entrenamiento
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
            $mensaje = 'Los entrenamientos del ' . $nDia .
                        " deben empezar después de las $apertura" .
                        " y terminar antes de las $cierre.";
            return Yii::$app->session->setFlash('danger', $mensaje);
        } elseif (strtotime($inicio) > strtotime($fin)) {
            $mensaje = 'Las entrenamientos no pueden terminar antes de la hora a la que empiezan.';
            return Yii::$app->session->setFlash('danger', $mensaje);
        }
        return true;
    }

    /**
     * Comprueba que el entrenamiento sea correcto.
     * @param  Entrenamientos $model El entrenamiento que se desea crear
     * @return [type]        [description]
     */
    private function comprobarEntrenamiento($model)
    {
        // TODO V3: Comprobar que el monitor no tiene entrenamientos a esa hora ese día
        // Comprobar que el cliente no tiene entrenamientos ni clases a esa hora ese día
        $entrenamientos = Entrenamientos::find()->where(['cliente_id' => $model->cliente_id])->andWhere(['monitor_id' => $model->monitor_id])->andWhere(['dia' => $model->dia])->count();
        $monitor = Monitores::findOne($model->monitor_id);
        if ($entrenamientos) {
            $mensaje = 'Ya tiene un entrenamiento el ' . $model->diaSemana->dia . ' con este monitor.';
            return Yii::$app->session->setFlash('danger', $mensaje);
        } elseif (strtotime($model->hora_inicio) >= strtotime($model->hora_fin)) {
            $mensaje = 'El entrenamiento no puede comenzar después de la hora a la que finaliza.';
            return Yii::$app->session->setFlash('danger', $mensaje);
        } elseif (strtotime($model->hora_inicio) < strtotime($monitor->horario_entrada) ||
            strtotime($model->hora_fin) > strtotime($monitor->horario_salida)) {
            $mensaje = 'El horario solicitado está fuera del horario de trabajo del monitor.';
            return Yii::$app->session->setFlash('danger', $mensaje);
        }
        return true;
    }

    /**
     * Devuelve un listado de los dias.
     * @return Dias
     */
    private function listaDias()
    {
        return Dias::find()->select('dia')->indexBy('id')->column();
    }
}
