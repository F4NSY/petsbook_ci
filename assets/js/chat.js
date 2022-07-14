var getUsers;
var messagesToUserContainer;
var messagesToMessageContainer;
var messageSearchTerm = '';

if(user.length != 0) {
	if ($(window).width() >= 768) {
		$('#messages-container').removeClass(messageContainerClass);
		$('#messages-container').html(createChatHeader(false, user[0]));
		clearInterval(messagesToMessageContainer);
		messagesToMessageContainer = setInterval(() => {
			getMessages(user[0].userId)
		}, 500);
	} else {
		$('#messages-container').removeClass(messageContainerClass);
		$('#users-container').html(createChatHeader(true, user[0]));
		clearInterval(getUsers);
		messagesToUserContainer = setInterval(() => {
			getMessages(user[0].userId)
		}, 500);
	}
}
setGetUsers();
$('#messageSearchBox')
    .focusin(function() {
        clearInterval(getUsers);
        $("#user-list").html('');
    })
    .focusout(function() {
        setGetUsers();
		$(this).val('');
    })
$(window).resize(function () {
	if ($(this).width() < 768) {
		clearInterval(messagesToMessageContainer);
        $('#messages-container').addClass(messageContainerClass);
		$("#messages-container").html(chatWelcomeTemplate);
	} else {
		backToUsers();
	}
});
function openConversation(event, conversationIdParam, userId) {
	event.preventDefault();
	history.replaceState('', '', `${ environment.base_url }chat/${ userId }`);
	if ($(window).width() >= 768) {
		getChatUserForHeader(conversationIdParam, '#messages-container', false)
		clearInterval(messagesToMessageContainer);
		messagesToMessageContainer = setInterval(() => {
			getMessages(userId)
		}, 500);
	} else {
		getChatUserForHeader(conversationIdParam, '#users-container', true)
		clearInterval(getUsers);
		messagesToUserContainer = setInterval(() => {
			getMessages(userId)
		}, 500);
	}
}
function backToUsers() {
	if ($(window).width() < 768) {
		clearInterval(messagesToMessageContainer);
	}
	clearInterval(messagesToUserContainer);
	clearInterval(getUsers);
	$('#users-container').html(userContainerHeader);
	setGetUsers();
}
function setGetUsers() {
    getUsers = setInterval(() => {
		$.ajax({
			url: environment.base_url + "api/getConversations",
			type: "get",
			success: function (response) {
				$('#user-list').html(response.html);
			},
			error: function (error) {
				console.log(error);
			},
		})
	}, 500);
}
function getMessages(userIdParam) {
	$.ajax({
		url: environment.base_url + "api/getMessages",
		type: "get",
		data: {
			userId: userIdParam
		},
		success: function (response) {
			$('#chat-box').html(response.html);
		},
		error: function (error) {
			console.log(error);
		},
	})
}
function getChatUserForHeader(conversationIdParam, container, hasBack) {
	$.ajax({
		url: environment.base_url + "api/getUser",
		type: "get",
		data: {
			getUserParam: conversationIdParam
		},
		success: function (response) {
			user = response.data;
			$('#messages-container').removeClass(messageContainerClass);
			$(container).html(createChatHeader(hasBack, user[0]));
		},
		error: function (error) {
			console.log(error);
		},
	})
}
$(document).on('submit', '#chatForm', function(e) {
	e.preventDefault();
	if(($('#chatContent').val() != "") || ($('#chatImage').val() != "")) {
		var formData = new FormData(this);
		formData.append('receiverId', user[0].userId);
		$.ajax({
			url: environment.base_url + "api/sendMessage",
			type: "post",
			data: formData,
			processData: false,
			contentType: false,
			success: function () {
				$('#chatForm').trigger('reset');
			},
			error: function (error) {
				console.log(error);
			},
		});
	}
})
function viewChatImage(imageFileName) {
	$('#imageModal img').addClass('chatModalImage');
	$('#imageModal').modal('show');
	$("#imageModal img").attr('src', `${ environment.base_url }uploads/messages/${ imageFileName }`);
}
$("#imageModal").on("hidden.bs.modal", function () {
	$('#imageModal img').removeClass('chatModalImage');
	$("#imageModal img").attr('src', '');
});
