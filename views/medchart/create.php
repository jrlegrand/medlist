<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Medchart */

$this->title = 'Create Medchart';
$this->params['breadcrumbs'][] = ['label' => 'Medcharts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medchart-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
