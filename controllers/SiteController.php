<?php

namespace app\controllers;

use app\models\Images;
use app\models\UploadImagesForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImages()
    {
        $model = new UploadImagesForm();
        $count = 0;
        $timestamp = date('Y_m_d_H_i_s');
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                for ($i=0;$i<count($_FILES['UploadImagesForm']['name']['imageFiles']);$i++){
                    $images_model = new Images();
                    $file = pathinfo($_FILES['UploadImagesForm']['name']['imageFiles'][$i]);
                    $filename = UploadImagesForm::transliterate($file['filename']);
                    $images_model->name = $filename.'_'.$timestamp.'_'.$count;
                    $images_model->datetime = date('d.m.Y H:i:s');
                    $images_model->source = 'UploadImages/' . $filename.'_'.$timestamp.'_'.$count.'.'.$file['extension'];
                    $images_model->save(false);
                    $count +=1;
                }
                Yii::$app->session->setFlash('success', 'Файл(ы) успешно загружены');
                return $this->redirect(['images']);
            }else {
                Yii::$app->session->setFlash('error', 'Не удалось загрузить файл(ы)');
            }
        }
        $query = Images::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['datetime', 'name'],
            ],
        ]);


        return $this->render('images', ['model' => $model,'dataProvider'=>$dataProvider]);
    }


}
