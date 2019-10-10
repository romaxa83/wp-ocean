<?php

namespace backend\controllers\api;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\helpers\Json;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     basePath="/admin",
 *     produces={"application/json"},
 *     consumes={"application/json"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="5 Ocean API",
 *         description="Api description..."
 *     )
 * )
 */
class IndexController extends Controller {

    public function actions(): array {
        return [
            'index' => [
                'class' => \yii2mod\swagger\SwaggerUIRenderer::class,
                'restUrl' => Url::to(['api/index/json-schema']),
            ],
            'json-schema' => [
                'class' => \yii2mod\swagger\OpenAPIRenderer::class,
                'cacheDuration' => 1,
                'scanDir' => [
                    Yii::getAlias('@backend/controllers/api')
                ],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @SWG\Get(path="/api/test",
     *     tags={"Test"},
     *     summary="Тестовый метод проверки Swagger",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Ok",
     *         @SWG\Schema(ref = "#/")
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "Bad Request",
     *         @SWG\Schema(ref = "#/")
     *     ),
     *     @SWG\Response(
     *         response = 404,
     *         description = "Not Found",
     *         @SWG\Schema(ref = "#/")
     *     ),
     *     @SWG\Response(
     *         response = 500,
     *         description = "Internal Server Error"
     *     )
     * )
     */
    public function actionTest() {
        return 1;
    }

}
