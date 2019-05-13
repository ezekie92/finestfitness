<?php

namespace app\controllers;

use app\models\Dias;
use app\models\Ejercicios;
use app\models\EjerciciosSearch;
use app\models\Rutinas;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EjerciciosController implements the CRUD actions for Ejercicios model.
 */
class EjerciciosController extends Controller
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
     * Lists all Ejercicios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EjerciciosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ejercicios model.
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
     * Muestra todos los ejercicios de una rutina.
     * @param  int $id El id de la rutina
     * @return mixed
     */
    public function actionRutina($id)
    {
        $searchModel = new EjerciciosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['rutina_id' => $id]);
        $dias = Ejercicios::find()->joinWith('dia')->select('dia')->where(['rutina_id' => $id])->indexBy('dia_id')->distinct()->column();
        ksort($dias);
        $nombre = Rutinas::findOne($id)->nombre;

        return $this->render('rutina', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'nombre' => $nombre,
            'dias' => $dias,
        ]);
    }

    /**
     * Creates a new Ejercicios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ejercicios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Añade un nuevo ejercicio a una rutina concreta.
     * Si se añade con éxito, redirige a la vista de ejercicios de la rutina.
     * @param int $rutina El id de la rutina
     * @return mixed
     */
    public function actionAnadir($rutina)
    {
        $model = new Ejercicios();
        $model->rutina_id = $rutina;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['ejercicios/rutina', 'id' => $rutina]);
        }

        return $this->render('anadir', [
            'model' => $model,
            'listaDias' => $this->listaDias(),
        ]);
    }

    /**
     * Updates an existing Ejercicios model.
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
     * Deletes an existing Ejercicios model.
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
     * Finds the Ejercicios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Ejercicios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ejercicios::findOne($id)) !== null) {
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
}
