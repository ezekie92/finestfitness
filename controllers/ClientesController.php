<?php

namespace app\controllers;

use app\models\Clientes;
use app\models\ClientesSearch;
use app\models\Monitores;
use app\models\Tarifas;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'create', 'view', 'delete', 'index'],
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
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
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
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clientes(['scenario' => Clientes::SCENARIO_CREATE]);
        $model->fecha_alta = date('d/m/y');
        $model->contrasena = Yii::$app->security->generateRandomString();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->actionEmail($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'listaTarifas' => $this->listaTarifas(),
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Clientes::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->contrasena = '';

        return $this->render('update', [
            'model' => $model,
            'listaTarifas' => $this->listaTarifas(),
            'listaMonitores' => $this->listaMonitores(),
        ]);
    }

    /**
     * Modifica la contraseña de un cliente existente
     * Si se lleva a cabo con éxito, redirige a login.
     * @param int $id
     * @param string $token
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCambiarContrasena($id, $token)
    {
        $model = $this->findModel($id);
        $model->scenario = Clientes::SCENARIO_UPDATE;
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
     * Deletes an existing Clientes model.
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
     * Envía un email con un link para confirmar el registro.
     * @param  Clientes $model El cliente al que se le enviará el email
     */
    public function actionEmail($model)
    {
        $url = Url::to([
            'clientes/confirmar',
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
            Yii::$app->session->setFlash('success', 'Se ha enviado un correo para la confirmación de registro al cliente.');
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
        return $this->redirect(['clientes/cambiar-contrasena', 'id' => $id, 'token' => $token]);
    }

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
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
     * Devuelve un listado de monitores.
     * @return Monitores el monitor que puede tener un cliente
     */
    private function listaMonitores()
    {
        return Monitores::find()->select('nombre')->indexBy('id')->column();
    }
}
