<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedlistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medlists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medlist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Medlist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created',
            'updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
