<?php

use yii\widgets\Menu;
?>
<div class="row">
<?= Menu::widget([
	'items' => [
		[
                        'label' => 'Профиль',
                        'url' => ['site/index'],
                ],
		// ['label' => 'Интеграция API', 'url' => ['user/compare-api']],
                [
                        'label' => 'Список Братков',
                        'url' => ['site/friends']
                ],
		[
                        'label' => 'Новости твоих тупых друзей',
                        'url' => ['site/news']
                ],
                [
                        'label' => 'Сообщения',
                        'url' => ['site/list-messages']
                ],
	],

	'options' => ['class' => 'nav nav-pills nav-stacked']
]) ?>
</div>