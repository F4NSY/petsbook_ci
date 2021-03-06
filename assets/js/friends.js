getFriends(currentPath);
function openOptions(event, currentPathParam) {
	event.preventDefault();
	history.replaceState('', '', `${ environment.base_url }friends/${ currentPathParam }`);
	getFriends(currentPathParam);
}
function getFriends(currentPathParam) {
	$.ajax({
		url: environment.base_url + "api/getFriends",
		type: "get",
		data: {
			query: currentPathParam,
		},
		success: function (response) {
			$("#friend-list").html(response.html);
		},
		error: function (error) {
			console.log(error);
		},
	})
}
function addFriend(userIdParam, currentPathParam) {
	$.ajax({
		url: environment.base_url + "api/addFriend",
		type: "post",
		data: {
			receiverId: userIdParam,
		},
		success: function () {
			getFriends(currentPathParam);
		},
		error: function (error) {
			console.log(error);
		},
	})
}
function confirmFriend(userIdParam, currentPathParam) {
	$.ajax({
		url: environment.base_url + "api/confirmFriend",
		type: "post",
		data: {
			senderId: userIdParam,
		},
		success: function () {
			getFriends(currentPathParam);
		},
		error: function (error) {
			console.log(error);
		},
	})
}
