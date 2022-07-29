var calculatePostTimeInterval;
getPosts();
const swiper = new Swiper(".swiper", {
	// Navigation arrows
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
});
function getPosts() {
	$.ajax({
		url: environment.base_url + "api/getPosts",
		type: "get",
		success: function (response) {
			$("#home-page-contents").html(response.html);
			calculatePostTimeInterval = setInterval(() => {
				$(".post-time").each(function () {
					var postTime = $(this).data("post-time");
					if (calculatePostTime(postTime) == postTime)
						$(this).removeClass("post-time");
					$(this).text(calculatePostTime(postTime));
				});
				$(".like-post").each(function () {
					$(this).click(function (event) {
						event.stopImmediatePropagation();
						$(this).toggleClass("liked");
					});
				});
			}, 1000);
		},
		error: function (error) {
			console.log(error);
		},
	});
}
function comment(postIdParam) {
	$(`#comment-${postIdParam}`).focus();
}
$("#postingForm").submit(function (e) {
	e.preventDefault();
	if (
		$("#postContent").val() != "" ||
		$("#postImage").val() != "" ||
		$("#postVideo").val() != ""
	) {
		var formData = new FormData(this);
		$.ajax({
			url: environment.base_url + "api/insertPost",
			type: "post",
			data: formData,
			processData: false,
			contentType: false,
			success: function () {
				$("#postingForm").trigger("reset");
				getPosts();
			},
			error: function (error) {
				console.log(error);
			},
		});
	}
});
function calculatePostTime(data) {
	var { hours, min } = calculateTime(data);
	if (days > 0) {
		return `${data}`;
	} else {
		return hours > 0
			? `${hours} hours ago`
			: min > 0
			? min + " minutes ago"
			: "Just now";
	}
}
