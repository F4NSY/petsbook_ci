var getUsers;
var getUserStatus;
var messagesToUserContainer;
var messagesToMessageContainer;
var messageSearchTerm = "";

if (user.length != 0) {
	if ($(window).width() >= 768) {
		getChatUserForHeader(user[0].userId, "#messages-container", false);
		setGetUserStatus(user[0].userId);
		clearInterval(messagesToMessageContainer);
		messagesToMessageContainer = setInterval(() => {
			getMessages(user[0].userId);
		}, 500);
	} else {
		getChatUserForHeader(user[0].userId, "#users-container", true);
		setGetUserStatus(user[0].userId);
		clearInterval(getUsers);
		messagesToUserContainer = setInterval(() => {
			getMessages(user[0].userId);
		}, 500);
	}
}
setGetUsers();
$("#messageSearchBox")
	.focusin(function () {
		clearInterval(getUsers);
		$("#user-list").html("");
	})
	.focusout(function () {
		setGetUsers();
		$(this).val("");
	});
$(window).resize(function () {
	if ($(this).width() < 768) {
		clearInterval(messagesToMessageContainer);
		$("#messages-container").addClass(messageContainerClass);
		$("#messages-container").html(chatWelcomeTemplate);
	} else {
		backToUsers();
	}
});
function openConversation(event, userId) {
	event.preventDefault();
	history.replaceState("", "", `${environment.base_url}chat/${userId}`);
	if ($(window).width() >= 768) {
		getChatUserForHeader(userId, "#messages-container", false);
		setGetUserStatus(userId);
		clearInterval(messagesToMessageContainer);
		messagesToMessageContainer = setInterval(() => {
			getMessages(userId);
		}, 500);
	} else {
		getChatUserForHeader(userId, "#users-container", true);
		setGetUserStatus(userId);
		clearInterval(getUsers);
		messagesToUserContainer = setInterval(() => {
			getMessages(userId);
		}, 500);
	}
}
function backToUsers() {
	if ($(window).width() < 768) {
		clearInterval(messagesToMessageContainer);
	}
	clearInterval(messagesToUserContainer);
	clearInterval(getUsers);
	$("#users-container").html(userContainerHeader);
	setGetUsers();
}
function setGetUsers() {
	getUsers = setInterval(() => {
		$.ajax({
			url: environment.base_url + "api/getConversations",
			type: "get",
			success: function (response) {
				$("#user-list").html(response.html);
			},
			error: function (error) {
				console.log(error);
			},
		});
	}, 500);
}
function getMessages(userIdParam) {
	$.ajax({
		url: environment.base_url + "api/getMessages",
		type: "get",
		data: {
			userId: userIdParam,
		},
		success: function (response) {
			$("#chat-box").html(response.html);
		},
		error: function (error) {
			console.log(error);
		},
	});
}
function getChatUserForHeader(userIdParam, container, hasBack) {
	$.ajax({
		url: environment.base_url + "api/getUser",
		type: "get",
		data: {
			userId: userIdParam,
		},
		success: function (response) {
			user = response.data;
			$("#messages-container").removeClass(messageContainerClass);
			$(container).html(createChatHeader(hasBack, user[0]));
		},
		error: function (error) {
			console.log(error);
		},
	});
}
function setGetUserStatus(userIdParam) {
	clearInterval(getUserStatus);
	getUserStatus = setInterval(() => {
		$.ajax({
			url: environment.base_url + "api/getUser",
			type: "get",
			data: {
				userId: userIdParam,
			},
			success: function (response) {
				user = response.data;
				if (user[0]["status"] == "active") {
					$("#lastSeen").html("Active now");
					$("#statusSpan").html(
						'<span id="status" class="status-dot me-1"><i class="fas fa-circle"></i></span>'
					);
				} else {
					$("#statusSpan").html(
						'<span id="status" class="status-dot offline me-1"><i class="fas fa-circle"></i></span>'
					);
					getLastSeen(user[0]["lastSeen"]);
				}
			},
		});
	}, 500);
}
function getLastSeen(data) {
	var { hours, min } = calculateTime(data);
	if (days > 0) {
		$("#lastSeen").html(`Last active on ${data}`);
	} else {
		hours > 0
			? $("#lastSeen").html(`${hours} hours ago`)
			: min > 0
			? $("#lastSeen").html(min + " minutes ago")
			: $("#lastSeen").html("Last seen just now");
	}
}
function calculateTime(data) {
	oldDate = new Date(data).getTime();
	newDate = new Date().getTime();
	differ = newDate - oldDate;
	days = Math.floor(differ / (1000 * 60 * 60 * 24));
	hours = Math.floor((differ % (1000 * 60 * 60 * 24)) / (60 * 60 * 1000));
	min = Math.floor((differ % (1000 * 60 * 60)) / (60 * 1000));
	sec = Math.floor((differ % (1000 * 60)) / 1000);
	var obj = {
		hours: hours,
		min: min,
		sec: sec,
	};
	return obj;
}
$(document).on("submit", "#chatForm", function (e) {
	e.preventDefault();
	if ($("#chatContent").val() != "" || $("#chatImage").val() != "") {
		var formData = new FormData(this);
		formData.append("receiverId", user[0].userId);
		$.ajax({
			url: environment.base_url + "api/sendMessage",
			type: "post",
			data: formData,
			processData: false,
			contentType: false,
			success: function () {
				$("#chatForm").trigger("reset");
			},
			error: function (error) {
				console.log(error);
			},
		});
	}
});
function viewChatImage(imageFileName) {
	$("#imageModal img").addClass("chatModalImage");
	$("#imageModal").modal("show");
	$("#imageModal img").attr(
		"src",
		`${environment.base_url}uploads/messages/${imageFileName}`
	);
}
$("#imageModal").on("hidden.bs.modal", function () {
	$("#imageModal img").removeClass("chatModalImage");
	$("#imageModal img").attr("src", "");
});
