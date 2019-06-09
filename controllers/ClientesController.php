<?php

namespace app\controllers;

use app\models\Clientes;
use app\models\ClientesClases;
use app\models\ClientesSearch;
use app\models\Entrenamientos;
use app\models\Especialidades;
use app\models\Monitores;
use app\models\Pagos;
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
                        'actions' => ['update'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $ruta = explode('/', Yii::$app->request->get('r'));
                            return ($ruta[0] . '-' . Yii::$app->request->get('id')) == Yii::$app->user->id;
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'index'],
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
        $model = $this->findModel($id);

        if (isset($_GET['tx']) && $model->tiempoUltimoPago > 20) {
            $this->gestionarPago($model);
        }


        return $this->render('view', [
            'model' => $model,
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
        $model->fecha_alta = date('d-m-y');
        $model->contrasena = Yii::$app->security->generateRandomString();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->almacenarPago($model);
            $this->actionEmail($model);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'listaTarifas' => $this->listaTarifas(),
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
     * Convierte un cliente en monitor.
     * @param  int $id El id del cliente a convertir
     * @return mixed
     */
    public function actionConvertir($id)
    {
        $actual = $this->findModel($id);
        $nuevo = new Monitores(['scenario' => Monitores::SCENARIO_CONVERTIR]);
        $nuevo->nombre = $actual->nombre;
        $nuevo->email = $actual->email;
        $nuevo->fecha_nac = $actual->fecha_nac;
        $nuevo->contrasena = $actual->contrasena;
        $nuevo->confirmado = true;

        if ($nuevo->load(Yii::$app->request->post())) {
            if ($nuevo->validate()) {
                $entrenamientos = Entrenamientos::find()->where(['cliente_id' => $actual->id])->all();
                foreach ($entrenamientos as $entrenamiento) {
                    $entrenamiento->delete();
                }
                $clases = ClientesClases::find()->where(['cliente_id' => $actual->id])->all();
                foreach ($clases as $clase) {
                    $clase->delete();
                }
                $this->findModel($id)->delete();
                $nuevo->save();
                return $this->redirect(['monitores/view', 'id' => $nuevo->id]);
            }
        }


        return $this->render('/monitores/create', [
            'model' => $nuevo,
            'listaEsp' => $this->listaEsp(),
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

    /**
     * Se encarga de la lógica de los pagos de mensualidades.
     * @param  Clientes $cliente El cliente que realiza el pago
     * @return [type]          [description]
     */
    private function gestionarPago($cliente)
    {
        if (isset($_GET['tx'])) {
            $response = trim($this->paypalPdtRequest($_GET['tx'], getenv('PAYPAL')));

            $response = preg_split('/[\s]+/', $response);
            $estado = array_shift($response);
            $respuesta = [];
            foreach ($response as $value) {
                $tmp = explode('=', $value);
                if (isset($tmp[1])) {
                    $respuesta[$tmp[0]] = $tmp[1];
                } else {
                    $respuesta = $tmp[0];
                }
            }

            if ($estado == 'SUCCESS') {
                $pagado = $this->almacenarPago($cliente);
                if ($pagado) {
                    return $this->redirect(['view', 'id' => $cliente->id]);
                }
            }
        }
    }


    /**
     * Gestiona la petición PDT.
     * PDT Es el mecanismo por el cual Paypal añade a la url de retorno una
     * serie de argumentos con la información relevante sobre el pago realizado.
     * @param  string $tx                 identificador de la transacción
     * @param  string $pdt_identity_token token de identificación de la cuenta business de paypal
     * @return string                     Respuesta con los datos de la transacción
     */
    private function paypalPdtRequest($tx, $pdt_identity_token)
    {
        $request = curl_init();

        // Set request options
        curl_setopt_array(
            $request,
            [
              CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS => http_build_query(
                  [
                    'cmd' => '_notify-synch',
                    'tx' => $tx,
                    'at' => $pdt_identity_token,
                  ]
              ),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_HEADER => false,
            ]
        );

        // Realizar la solicitud y obtener la respuesta y el código de status
        $response = curl_exec($request);
        $status = curl_getinfo($request, CURLINFO_HTTP_CODE);

        // Cerrar la conexión
        curl_close($request);
        return $response;
    }

    /**
     * Crea una nueva instancia de pago.
     * @param Clientes $cliente el cliente que realiza el pago
     * @return mixed
     */
    private function almacenarPago($cliente)
    {
        $pago = new Pagos();
        $pago->cliente_id = $cliente->id;
        $fecha = new \DateTime('now', new \DateTimeZone('UTC'));
        $pago->fecha = $fecha->format('Y-m-d H:i:s');
        $pago->concepto = 'Pago en mano';
        $pago->cantidad = $cliente->tarifas->precio;

        return $pago->save();
    }
}
