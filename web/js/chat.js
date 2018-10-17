var chatUrl = 'ws://localhost:9911';

function displayChatMessage(from, message) {
        var date = new Date();
    	if(from == $('#username').text())
        	$('#chat').append('<div class="from-me" style="left:0;margin-bottom:5px;"><small>' + from + '</small><br />' + message+ '<br /><small>'+date.toLocaleString()+'</small></div><div class="clear"></div>');
        else
        	$('#chat').append('<div class="from-them"  style="right:0;margin-bottom:5px;"><small>' + from+ '</small><br />' + message + '<br /><small>'+date.toLocaleString()+'</small></div><div class="clear"></div>');
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

function connectToChat() {
    conn = new WebSocket(chatUrl);

    conn.onopen = function() {
        document.getElementById('connectFormDialog').style.display = 'none';
        document.getElementById('messageDialog').style.display = 'block';

        var params = {
            'roomId': '1',
            'userName': $('#username').text(),
            'action': 'connect'
        };
        console.log(params);
        conn.send(JSON.stringify(params));
    };

    conn.onmessage = function(e) {
        var data = JSON.parse(e.data);

        if (data.hasOwnProperty('message') && data.hasOwnProperty('from')) {
            displayChatMessage(data.from.name, data.message);
        }
        else if (data.hasOwnProperty('message')) {
            displayChatMessage('ChatBOt', data.message);
        }
        else if (data.hasOwnProperty('type')) {
            if (data.type == 'list-users' && data.hasOwnProperty('clients')) {
                displayChatMessage('ChatBOt', 'Уже ' + data.clients.length + ' урод(а) в сети');
            }
            else if (data.type == 'user-started-typing') {
                displayUserTypingMessage(data.from)
            }
            else if (data.type == 'user-stopped-typing') {
                removeUserTypingMessage(data.from);
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