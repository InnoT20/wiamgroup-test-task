<?php

use App\Domain\Image\Entity\Image;
use App\Infrastructure\Service\RandomImage\Dimension;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;

/** @var Dimension $dimension */
$dimension = \Yii::$app->params['dimension'];
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'imageId',
                'format' => 'raw',
                'value' => fn(Image $model): string => Html::a(
                    text: $model->imageId,
                    url: "https://picsum.photos/id/{$model->imageId}/{$dimension->getWidth()}/{$dimension->getHeight()}",
                    options: ['target' => '_blank']
                ),
            ],
            'status',
            [
                'class' => ActionColumn::class,
                'template' => '{delete}',
                'urlCreator' => fn($action, Image $model): string => Url::toRoute([
                    $action,
                    'token' => Yii::$app->request->get('token'),
                    'id' => $model->id
                ])
            ],
        ],
    ]); ?>

</div>
