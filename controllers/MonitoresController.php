<?php

namespace app\controllers;

use app\models\Clases;
use app\models\Clientes;
use app\models\Entrenamientos;
use app\models\Especialidades;
use app\models\Monitores;
use app\models\MonitoresSearch;
use app\models\Pagos;
use app\models\Tarifas;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MonitoresController implements the CRUD actions for Monitores model.
 */
class MonitoresController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'create', 'view', 'index', 'delete', 'lista-monitores', 'solicitar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $ruta = explode('/', Yii::$app->request->get('r'));
                            return ($ruta[0] . '-' . Yii::$app->request->get('id')) == Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'view', 'delete', 'index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $tipo = explode('-', Yii::$app->user->id);
                            return $tipo[0] == 'administradores';
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['lista-monitores', 'solicitar'],
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
     * Lists all Monitores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MonitoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un listado de monitores.
     * @return mixed
     */
    public function actionListaMonitores()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Monitores::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        return $this->render('lista', ['listaDataProvider' => $dataProvider]);
    }


    /**
     * Displays a single Monitores model.
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
     * Creates a new Monitores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Monitores(['scenario' => Monitores::SCENARIO_CREATE]);
        $model->contrasena = Yii::$app->security->generateRandomString();
        $model->horario_entrada = '00:00:00';
        $model->horario_salida = '00:00:00';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->actionEmail($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'listaEsp' => $this->listaEsp(),
        ]);
    }

    /**
     * Updates an existing Monitores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Monitores::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->contrasena = '';

        return $this->render('update', [
            'model' => $model,
            'listaEsp' => $this->listaEsp(),
        ]);
    }

    /**
     * Modifica la contraseña de un monitor existente
     * Si se lleva a cabo con éxito, redirige a login.
     * @param int $id
     * @param string $token
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCambiarContrasena($id, $token)
    {
        $model = $this->findModel($id);
        $model->scenario = Monitores::SCENARIO_UPDATE;
        $model->contrasena = '';

        if ($model->load(Yii::$app->request->post())) {
            $model->confirmado = true;
            if ($model->save()) {
                return $this->redirect(['site/login']);
            }
        }

        return $this->render('cambiarContrasena', [
            'model' => $model,
        ]);
    }

    /**
     * Convierte un monitor a cliente.
     * @param  int $id El id del monitor a convertir
     * @return mixed
     */
    public function actionConvertir($id)
    {
        $actual = $this->findModel($id);

        $nuevo = new Clientes(['scenario' => Clientes::SCENARIO_CONVERTIR]);
        $nuevo->nombre = $actual->nombre;
        $nuevo->email = $actual->email;
        $nuevo->fecha_nac = $actual->fecha_nac;
        $nuevo->contrasena = $actual->contrasena;
        $nuevo->confirmado = true;


        if ($nuevo->load(Yii::$app->request->post())) {
            if ($nuevo->validate()) {
                $clases = Clases::find()->where(['monitor' => $actual->id])->count();
                if ($clases) {
                    $error = 'Este monitor tiene clases asignadas. Asigne otro monitor a sus clases';
                    return $this->redirect(['clases/index', 'nombre' => $actual->nombre]);
                }
                $entrenamientos = Entrenamientos::find()->where(['monitor_id' => $actual->id])->all();
                foreach ($entrenamientos as $entrenamiento) {
                    $entrenamiento->delete();
                }
                $this->findModel($id)->delete();
                $nuevo->save();
                $pago = new Pagos();
                $pago->cliente_id = $nuevo->id;
                $fecha = new \DateTime('now', new \DateTimeZone('UTC'));
                $pago->fecha = $fecha->format('Y-m-d H:i:s');
                $pago->concepto = 'Pago en mano';
                $pago->cantidad = $nuevo->tarifas->precio;
                $pago->save();
                return $this->redirect(['clientes/view', 'id' => $nuevo->id]);
            }
        }

        return $this->render('//clientes/create', [
            'model' => $nuevo,
            'listaTarifas' => $this->listaTarifas(),
        ]);
    }

    /**
     * Envía un email con un link para confirmar el registro.
     * @param  Monitores $model El monitor al que se le enviará el email
     */
    public function actionEmail($model)
    {
        $url = Url::to([
            'monitores/confirmar',
            'id' => $model->id,
            'token' => $model->token,
        ], true);

        if (Yii::$app->mailer->compose()
            ->setFrom('finestfitnessdaw@gmail.com')
            ->setTo($model->email)
            ->setSubject('Confirmar registro FinestFitness')
            ->setTextBody("Clique en el siguiente enlace para confirmar su registro: $url")
            ->send()
        ) {
            Yii::$app->session->setFlash('success', 'Se ha enviado un correo para la confirmación de registro al monitor.');
        } else {
            Yii::$app->session->setFlash('error', 'No se ha podido enviar el correo de verificación.');
        }
    }

    /**
     * Confirma el registro del usuario.
     * @param  int    $id    El del usuario a confirmar
     * @param  string $token El token de autenticación del usuario a confirmar
     * @return mixed         Redirige a un sitio u otro de la aplicación.
     */
    public function actionConfirmar($id, $token)
    {
        $model = $this->findModel($id);
        if ($model->token === $token) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registro confirmado. Establezca su contraseña para poder empezar a usar la aplicación.');
            } else {
                Yii::$app->session->setFlash('error', 'No se ha podido confirmar el registro.');
            }
        } else {
            if ($model->confirmado) {
                Yii::$app->session->setFlash('info', 'Ya había validado su cuenta. Si necesita ayuda contacte con su gimnasio');
            } else {
                Yii::$app->session->setFlash('error', 'Error de confirmación, póngase en contacto con su gimnasio.');
            }
            return $this->redirect(['site/login']);
        }
        return $this->redirect(['monitores/cambiar-contrasena', 'id' => $id, 'token' => $token]);
    }

    /**
     * Deletes an existing Monitores model.
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
     * Finds the Monitores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Monitores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Monitores::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Devuleve una lista de las especialidades que puede tener un monitor.
     * @return Especialidades especialidad que puede tener un monitor
     */
    private function listaEsp()
    {
        return Especialidades::find()->select('especialidad')->indexBy('id')->column();
    }

    /**
     * Devuelve un listado de las tarifas.
     * @return Tarifas
     */
    private function listaTarifas()
    {
        return Tarifas::find()->select('tarifa')->indexBy('id')->column();
    }
}
