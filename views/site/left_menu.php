<?php

use yii\widgets\Menu;
?>
<div class="row m-t-30	">
<?= Menu::widget([
	'items' => [
		[
                        'label' => 'Лента',
                        'url' => ['site/index'],
                        'active' => (Yii::$app->controller->id == 'user' && Yii::$app->controller->action->id == 'index')
                ],
		// ['label' => 'Интеграция API', 'url' => ['user/compare-api']],
		[
                        'label' => 'Сообщения',
                        'url' => ['site/messages']
                ],
	],

	'options' => ['class' => 'nav nav-pills nav-stacked']
]) ?>
</div>