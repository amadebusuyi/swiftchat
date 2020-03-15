<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript">
	var uid = $('.uid').html();
	if(uid !== "" && uid !== null && uid !== undefined){
	function sendMessage(){
		var msg = $('#message').val();
		var rid = $('.profile-id').html();
		if (msg == "" || msg == "\\"){
			return false;
		}
		else{
		$('#message').val(""); 

		var str = makeId(rid).split("/");
		var relid = str[0];
		var storeid = str[1];

		$.post('messages.php', {
			sendmsg: true,
			sid: uid,
			rid: rid,
			msg: msg,
			relid: relid,
		}, function(data, status){
		$('#message').val(""); 
		if (data != 2){
		$('.lmid').remove();
		$('.chat-messages').append(data);
    	storeMsg(storeid);
		var d = $('.chat-box-body');
		d.scrollTop(d.prop("scrollHeight"));
		$('.new-msg').remove();

	}
	else{

	}

		});
	}
	}

	function getMessage(rid, rname, state){
		$('.chat-messages').html('<p style="text-align:center;">getting messages...</p>');
		$('.profile-name').html(rname);
		$('.profile-id').html(rid);
		if(state == 1){
			state = "online";
		}
		else if(state == 2){
			state = "away";
		}

		else{
			state = "offline";
		}

		$('.profile-status').html(state);
		$('#mcount-'+rid).hide()

		var str = makeId(rid).split("/");
		var relid = str[0];
		var storeid = str[1];

    		// Retrieve
    	var msgStored = localStorage.getItem(storeid);
    		if(msgStored != null || msgStored != undefined){
    			$('.chat-messages').html(msgStored);

			var d = $('.chat-box-body');
			d.scrollTop(d.prop("scrollHeight"));
    		}
    		else{

		$.post('messages.php', {
			getmsg: true,
			sid: uid,
			relid: relid,
			rid: rid
		}, function(data, status){
			if(data == "00"){
				$('.chat-messages').html('<p class="new-msg align-center">No previous message(s) found! Send a message to initiate chat with '+rname+'</p>');
			}
			else if(data == "01"){
				$('.chat-messages').html('<p class="new-msg align-center">Unable to fetch messages</p>');
			}
			else if(data == "02"){
				$('.chat-messages').html('<p class="new-msg align-center">Fatal error, kindly send a report message to Swift Instant Messenger App maker</p>');
			}
			else{
			$('.chat-messages').html(data);
			storeMsg(storeid);
			var d = $('.chat-box-body');
			d.scrollTop(d.prop("scrollHeight"));
		}
		});
}
	}


	setInterval(function(){
		var rid = $('.profile-id').html();
		var lmid = $('.lmid').last().html();

		if(rid == ''){
			return false;
		}
		else{

		var str = makeId(rid).split("/");
		var relid = str[0];
		var storeid = str[1];

		$.post('messages.php?update', {
			updatemsg: true,
			sid: uid,
			relid: relid,
			rid: rid,
			lmid: lmid
		}, function(data, status){
			if(data == "00" || data == "01" || data == "02"){
    	getRead();
    	storeMsg(storeid);
		}
			else{
			$('.lmid').remove();
			$('.chat-messages').append(data);
    		getRead();
			storeMsg(storeid);
			var d = $('.chat-box-body');
			d.scrollTop(d.prop("scrollHeight"));
			
			
		}
		}); }
	}, 3000); 


	setInterval(function(){
    	getCount();

}, 3000); 

function getCount(){
	var check = $('.display-active-chats').html();
	if(check == ""){return false}
	$.get('counter.php?get&uid='+uid, function(data, status){
		var count = JSON.parse(data);
		$(".display-uname").children(".uname-id").each(function(){
    	var sid = $(this).html();
    	
		var str = makeId(sid).split("/");
		var relid = str[0];
		var storeid = str[1];
		var mcount = count[relid];

		if(mcount == "0"){$('#mcount-'+sid).hide();}

		else if(mcount == undefined){$('#mcount-'+sid).hide();}

		else{
				var prevCount = $('#mcount-'+sid).html();
				if(prevCount == mcount){}
				else{
				$('#mcount-'+sid).show().html(mcount);
				$.post('messages.php', {
					newMsg: true,
					sid: sid,
					uid: uid,
					relid: relid

				}, function(data, status){
				if (data == "null")	{}
				else{	
					var msgStored = localStorage.getItem(storeid);
    				var store = msgStored+data;
					if (typeof(Storage) !== "undefined") {
    		// Store
    				localStorage.setItem(storeid, store); 
					} 
				}
			});
				
			}
			}
    });
		});
}

	setInterval(function(){
			var lid = $('#last-fchat-id').html();
			if(lid == undefined){return} 
				else{
    	$.get('friends.php?active='+uid+'&lid='+lid, function(data, status){
    		if(data == "00"){}
    		else{
			$('.display-active-chats').html(data);	
			getCount();}
		});
    }

    }, 3000);

    $(document).ready(function(){

   $.get('friends.php?active='+uid+'&lid=0', function(data, status){
   	var uid = $('.uid').html();
			$('.display-active-chats').html(data);
			getCount();
		});

});

function getRead(){
	$(".not-read").children(".unread").each(function(){
		var unread = $(this).html();
		$.get('messages.php?unread='+unread, function(data, status){
			if (data == '1'){
				$('#no-'+unread).removeClass('not-read').addClass('read');
			}
			else{}
		});
});
}

function storeMsg(storeid){
			var store = $('.chat-messages').html();
			if (typeof(Storage) !== "undefined") {
    		// Store
    		localStorage.setItem(storeid, store);
			}
}

function makeId(rid){
	if(rid > uid){
				var relid = "rel"+uid+rid;
			}
			else{
				var relid = "rel"+rid+uid;
			}
			var storeid = uid+relid;
			var str = relid+"/"+storeid;
			return str;
}

}

//Log users in
$("#swift-log").click(function(e){
	e.preventDefault();
	let uname = $("#swift-u").val();
	let upass = $("#swift-p").val();

	$.post("user.php", {
		uname: uname,
		upass: upass
	},
	function(data){
		if(data !== "" && data !== null && data !== undefined){
			if(data === "true"){
				window.location.assign("index.php");
			}
			else{
				$("#error").html("One or more information supplied is incorrect");
			}
		}
		else{
				$("#error").html("Connection error");
		}
	})

})

</script>