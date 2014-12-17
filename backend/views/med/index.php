<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Meds';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="med-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Med', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'medlist_id',
            'rxnorm_id',
            'indication',
            'notes:ntext',
            // 'date_modified',
            // 'date_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
