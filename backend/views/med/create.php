<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Med */

$this->title = 'Create Med';
$this->params['breadcrumbs'][] = ['label' => 'Meds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="med-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
