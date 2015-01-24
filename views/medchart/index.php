<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedchartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medcharts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medchart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Medchart', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_created',
            'date_updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
