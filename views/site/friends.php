<?php

/* @var $this yii\web\View */

$this->title = 'ЧАТ';
$this->registerJs('connectToChat();', \yii\web\View::POS_READY);
?>


<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-10">
                <h1>NAMA Братки.</h1>

			<section>
				<div id="chat"></div>
			</section>

    		<span style="display: none;" id="username"><?= (@Yii::$app->user->identity->username) ? : 'какой то левый чел незареганный' ?></span>
			
			<form id="messageForm" action="#" class="form-input-message"  onsubmit="return sendChatMessage();">
				 <input id="message" type="text" class="search input-message" onkeyup="//updateChatTyping()">
				 <input type="submit" class="submit-message" value="Отправить" />
				 <!-- <button id="btnSend" class="submit-message">Отправить</button> -->
			</form>
        </div>
    </div>
</div>
    <section class="dialog" id="connectFormDialog">
    </section>
    <section id="messageDialog">
        <ul id="messageList"></ul>

        
    </section>