var chatUrl = 'ws://192.168.1.105:9911';

function displayChatMessage(response) {
        var date = new Date();
        if(response.type == 'user-connected'){
            $('#chat').append('<p class="no-indent text-center">'+response.from.name+' подключился<p>');
            $('#chat').scrollTop = $('#chat').height;
            $('#message').val('');
            return;
        }
        console.log(response)
    	if(response.from.name == $('#username').text())
        	$('#chat').append('<div class="from-me" style="left:0;margin-bottom:5px;"><small>' + response.from.name + '</small><br />' + response.message+ '<br /><small>'+date.toLocaleString()+'</small></div><div class="clear"></div>');
        else
        	$('#chat').append('<div class="from-them"  style="right:0;margin-bottom:5px;"><small>' + response.from.name+ '</small><br />' + response.message + '<br /><small>'+date.toLocaleString()+'</small></div><div class="clear"></div>');
        $('#chat').scrollTop = $('#chat').height;
        $('#message').val('');
}
function displayUserTypingMessage(from) {
    $('#chat').append('<div class="from-them" style="right:0;margin-bottom:5px;">'+from+' печатает...</div><div class="clear"></div>');
}

function removeUserTypingMessage(from) {
    var nodeId = 'userTyping' + from.name.replace(' ', '');
    var node = document.getElementById(nodeId);
    if (node) {
        node.parentNode.removeChild(node);
    }
}

var conn;

function connectToChat(id = '2') {
    conn = new WebSocket(chatUrl);

    conn.onopen = function() {
        document.getElementById('connectFormDialog').style.display = 'none';
        document.getElementById('messageDialog').style.display = 'block';

        var params = {
            'roomId': id,
            'userName': $('#username').text(),
            'action': 'connect'
        };
        conn.send(JSON.stringify(params));
    };

    conn.onmessage = function(e) {
        var data = JSON.parse(e.data);

        if (data.hasOwnProperty('message') && data.hasOwnProperty('from')) {
            displayChatMessage(data);
        }
        else if (data.hasOwnProperty('message')) {
            displayChatMessage(data);
        }
        else if (data.hasOwnProperty('type')) {
            if (data.type == 'list-users' && data.hasOwnProperty('clients')) {
                displayChatMessage(data);
            }
            else if (data.type == 'user-started-typing') {
                displayUserTypingMessage(data)
            }
            else if (data.type == 'user-stopped-typing') {
                removeUserTypingMessage(data);
            }
        }
    };

    conn.onerror = function(e) {
        console.log(e);
    };

    return false;
}

function sendChatMessage() {
    var d = new Date();
    var params = {
        'message': $('#message').val(),
        'action': 'message',
        'timestamp': d.getTime()/1000
    };
    conn.send(JSON.stringify(params));

    $('#message').val('');
    return false;
}

function updateChatTyping() {
    var params = {};
    if ($('#message').val() > 0)
        params = {'action': 'start-typing'};
    conn.send(JSON.stringify(params));
}