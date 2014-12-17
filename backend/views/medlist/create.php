<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Medlist */

$this->title = 'Create Medlist';
$this->params['breadcrumbs'][] = ['label' => 'Medlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
