<?php

namespace app\controllers;

use app\models\Clases;
use app\models\ClientesClases;
use app\models\Entrenamientos;
use app\models\EntrenamientosSearch;
use app\models\Horarios;
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
                'only' => ['index', 'clientes-entrenador', 'view', 'update', 'delete', 'decidir', 'solicitudes', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getTipoId() == 'administradores';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['clientes-entrenador', 'decidir', 'solicitudes'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getTipoId() == 'monitores';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'solicitar', 'delete'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->getTipoId() == 'clientes';
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entrenamientos model.
     * @param int $cliente_id
     * @param int $monitor_id
     * @param mixed $dia
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cliente_id, $monitor_id, $dia)
    {
        return $this->render('view', [
            'model' => $this->findModel($cliente_id, $monitor_id, $dia),
        ]);
    }

    public function actionCalendario()
    {
        $entrenamientos = Entrenamientos::find()->where(['monitor_id' => Yii::$app->user->identity->getNId()])->all();

        return $this->render('calendario', [
            'entrenamientos' => $entrenamientos,
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
            $comprobar = $this->comprobarHorario($model->fecha);
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
     * @param mixed $dia
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cliente_id, $monitor_id, $dia)
    {
        $model = $this->findModel($cliente_id, $monitor_id, $dia);

        if ($model->load(Yii::$app->request->post())) {
            $comprobar = $this->comprobarHorario($model->fecha);
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
     * Permite aceptar o rechazar las solicitudes de entrenamiento.
     * @param  int $cliente_id El id del cliente
     * @param  int $monitor_id El id del monitor
     * @param mixed $fecha
     * @return mixed
     */
    public function actionDecidir($cliente_id, $monitor_id, $fecha)
    {
        $model = $this->findModel($cliente_id, $monitor_id, $fecha);

        $model->estado = Yii::$app->request->post('estado');
        // if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
            return $this->redirect(['solicitudes']);
        }
        // }
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
            if ($this->comprobarCompatibilidadCliente($model) && $this->comprobarHorario($model->fecha)) {
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
        ]);
    }

    /**
     * Muestra un listado de las solicitudes que tiene un monitor, permitiendole
     * aceptarlas o rechazarlas.
     * @return [type] [description]
     */
    public function actionSolicitudes()
    {
        $searchModel = new EntrenamientosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['monitor_id' => Yii::$app->user->identity->getNId()]);
        $dataProvider->query->andWhere(['estado' => null]);
        $dataProvider->setSort([
            'attributes' => [
                'cliente.nombre' => [
                    'asc' => ['clientes.nombre' => SORT_ASC],
                    'desc' => ['clientes.nombre' => SORT_DESC],
                ],
                'fecha' => [
                    'asc' => ['fecha' => SORT_ASC],
                    'desc' => ['fecha' => SORT_DESC],
                ],
            ],
            'defaultOrder' => [
               'fecha' => SORT_ASC,
            ],
        ]);

        return $this->render('solicitudes', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Entrenamientos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cliente_id
     * @param int $monitor_id
     * @param mixed $fecha
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cliente_id, $monitor_id, $fecha)
    {
        $this->findModel($cliente_id, $monitor_id, $fecha)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Entrenamientos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cliente_id
     * @param int $monitor_id
     * @param mixed $fecha
     * @return Entrenamientos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cliente_id, $monitor_id, $fecha)
    {
        if (($model = Entrenamientos::findOne(['cliente_id' => $cliente_id, 'monitor_id' => $monitor_id, 'fecha' => $fecha])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Comprueba que el horario de una sesión de entrenamiento está dentro del
     * horario de apertura y cierre del gimnasio en el día en el que se quiere
     * llevar a cabo.
     * @param mixed $fecha
     * @return mixed          True si no da error, o flash en caso de haberlo
     */
    private function comprobarHorario($fecha)
    {
        $dia = date('l', strtotime($fecha));
        $dias = [
            'Monday' => '1',
            'Tuesday' => '2',
            'Wednesday' => '3',
            'Thursday' => '4',
            'Friday' => '5',
            'Saturday' => '6',
            'Sunday' => '7',
        ];
        $dia = $dias[$dia];
        $apertura = Horarios::find()->select('apertura')->where(['id' => $dia])->scalar();
        $cierre = Horarios::find()->select('cierre')->where(['id' => $dia])->scalar();


        if ($apertura == null) {
            $mensaje = 'El gimnasio no abre el ' . date('d-m-Y', strtotime($fecha));
            return Yii::$app->session->setFlash('danger', $mensaje);
        }
        if ($cierre < date('H:i:s', strtotime($fecha)) || $apertura > date('H:i:s', strtotime($fecha))) {
            $mensaje = 'Los entrenamientos del ' . date('d-m-Y', strtotime($fecha)) .
                        " deben empezar después de las $apertura" .
                        " y terminar antes de las $cierre.";
            return Yii::$app->session->setFlash('danger', $mensaje);
        }

        return true;
    }

    /**
     * Comprueba que el entrenamiento sea correcto.
     * @param  Entrenamientos $model El entrenamiento que se desea crear
     * @return [type]        [description]
     */
    /**
     * Comprueba que un cliente no tenga clases o entrenamientos que coincidan
     * con el entrenamiento solicitado.
     * @param  Entrenamientos $model Los datos (modelo) del entrenamiento solicitado
     * @return null|bool
     */
    private function comprobarCompatibilidadCliente($model)
    {
        $inicio = $model->fecha;
        $fin = strtotime($inicio) + 60 * 60;
        $fin = date('Y-m-d H:i:s', $fin);
        $fechas = [];
        $clases = ClientesClases::find()->select('clase_id')->where(['cliente_id' => $model->cliente_id])->column();
        foreach ($clases as $clase) {
            $fecha = Clases::find()->select('fecha')->where(['id' => $clase])->scalar();
            array_push($fechas, $fecha);
        }
        $entrenamientos = Entrenamientos::find()->select('fecha')->where(['cliente_id' => $model->cliente_id])->andWhere(['estado' => 1])->column();
        foreach ($entrenamientos as $entrenamiento) {
            array_push($fechas, $entrenamiento);
        }

        $mensaje = 'Ya tienes clases o entrenamientos ese día a esa hora';
        foreach ($fechas as $key => $value) {
            $fechas[$key] = strtotime($value) + 60 * 60;
            $fechas[$key] = date('Y-m-d H:i:s', $fechas[$key]);
            if ($inicio > $value && $inicio < $fechas[$key]) {
                return Yii::$app->session->setFlash('danger', $mensaje);
            }
            if ($fin > $value && $fin < $fechas[$key]) {
                return Yii::$app->session->setFlash('danger', $mensaje);
            }
        }
        return true;
    }
}
