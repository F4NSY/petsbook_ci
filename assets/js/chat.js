var getUsers;
var messagesToUserContainer;
var messagesToMessageContainer;
var user;
var messageSearchTerm = '';

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
function openConversation(event, conversationIdParam) {
	event.preventDefault();
	if ($(window).width() >= 768) {
		getChatUserForHeader(conversationIdParam, '#messages-container', false)
		clearInterval(messagesToMessageContainer);
		messagesToMessageContainer = setInterval(() => {
			getMessages(conversationIdParam)
		}, 500);
	} else {
		getChatUserForHeader(conversationIdParam, '#users-container', true)
		clearInterval(getUsers);
		messagesToUserContainer = setInterval(() => {
			getMessages(conversationIdParam)
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
function getMessages(conversationIdParam) {
	$.ajax({
		url: environment.base_url + "api/getMessages",
		type: "get",
		data: {
			conversationId: conversationIdParam
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
			$(container).html(createChatHeader(hasBack, response.data));
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
		formData.append('receiverId', user.userId);
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
