<?php

/* @var $this yii\web\View */

$this->title = 'ЧАТ';
?>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-10">
                <h1>NAMA</h1>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script>
    $(function() {
        var chat = new WebSocket('ws://localhost:8082');
        chat.onmessage = function(e) {
            $('#response').text('');

            var response = JSON.parse(e.data);
            var date = new Date();
            if (response.type && response.type == 'chat') {

            	if(response.from == $('#username').text())
                	$('#chat').append('<div class="from-me" style="left:0;margin-bottom:5px;"><small>' + response.from + '</small><br />' + response.message + '<br /><small>'+date.toLocaleString()+'</small></div><div class="clear"></div>');
                else
                	$('#chat').append('<div class="from-them"  style="right:0;margin-bottom:5px;"><small>' + response.from + '</small><br />' + response.message + '<br /><small>'+date.toLocaleString()+'</small></div><div class="clear"></div>');
                $('#chat').scrollTop = $('#chat').height;
                $('#message').val('');
            } else if (response.message) {
                console.log(response.message);
            }
        };
        chat.onopen = function(e) {
            $('#response').text("Connection established! Please, set your username.");
            chat.send( JSON.stringify({'action' : 'setName', 'name' : $('#username').text(), 'room' : '1'}) );
        };
        $('#btnSend').click(function() {
            if ($('#message').val()) {
                chat.send( JSON.stringify({'action' : 'chat', 'message' : $('#message').val(), 'room' : '1'}) );
            } else {
                alert('Enter the message')
            }
        })
    })
</script>
<style type="text/css">
</style>
<div class="container  wrap">
    <div class="row">
        <div class="col-md-2">
            <?= $this->render('_left_menu') ?>
        </div>
        <div class="col-md-8"><span style="display: none;" id="username"><?= (@Yii::$app->user->identity->username) ? : 'какой то левый чел незареганный' ?></span><br />
			<section>
				<div id="chat"></div>
			</section>
			
			<form action="#" class="form-input-message">
				 <input id="message" type="text" class="search input-message">
				 <button id="btnSend" class="submit-message">Отправить</button>
			</form>
        </div>

        <div class="col-md-2  sticky bottom-0">
        	asdasdasd
        </div>
    </div>
</div>

