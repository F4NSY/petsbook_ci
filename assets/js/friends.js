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
