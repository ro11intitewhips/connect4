function initChat() {
	var message = $("#chatBox").val();
	
	$("#chatSendBtn").click(function() {
		initChatAjax('startChat', message);
	});
	
	//setInterval(getChat, 1500);
	function getChat() {
	  ajaxCall('get', {method:'getChat', a:'chat'}, callbackGetChat);
	}
	
	function callbackGetChat(data) {
	  var h = '';
	  
	  for(i = 0; i < data.length; i++) {
		h += data[i].name + ' says: ' + data[i].message + '<br />';
	  }
	  
	  $('h5').html(h);
	}
}