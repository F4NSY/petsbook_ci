$("#loginForm").on("submit", function (e) {
	e.preventDefault();
	var email = $("#email");
	var password = $("#password");
	var input = [email, password];
	var emailRegex = new RegExp(
		"^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$"
	);
	var loginError = $("#loginError");

	for (var i = 0; i < input.length; i++) {
		if (input[i].val() == "") {
			loginError.addClass("alert alert-danger text-center p-1 fs-7");
			loginError.html("All fields are required!");
			input[i].focus();
			return false;
		}
	}
	if (!emailRegex.test(email.val())) {
		loginError.addClass("alert alert-danger text-center p-1 fs-7");
		loginError.html("Invalid email format");
		email.focus();
		return false;
	}
	loginError.removeClass("alert alert-danger text-center p-1 fs-7");
	loginError.html("");
	var formData = new FormData(this);
	$.ajax({
		url: environment.base_url + "api/login",
		type: "post",
		data: formData,
		processData: false,
		contentType: false,
		beforeSend: function () {
			createSpinner(true);
		},
		success: function () {
			window.location.href = environment.base_url + "home";
		},
		error: function (error) {
			var errorMessage;
			if (error.hasOwnProperty("responseJSON")) {
				if (error.responseJSON.message === "invalid-credentials") {
					errorMessage =
						"Incorrect email address or password. Please check your credentials and try again.";
				} else {
					errorMessage =
						"An unexpected error occurred when processing this request. Please try again.";
				}
			} else {
				errorMessage =
					"An unexpected error occurred when processing this request. Please try again.";
			}
			Swal.fire({
				title: "Oops!",
				text: errorMessage,
				icon: "error",
				confirmButtonColor: "#f93154",
			});
		},
		complete: function () {
			createSpinner(false);
		},
	});
});
function createSpinner(isDisabled) {
	var loginButton = "Sign in";
	var registerButton = "Sign up";
	var createAccountButton = "Create a new account";
	if (isDisabled) {
		loginButton = registerButton = createAccountButton = spinner;
	}

	$(":button").prop("disabled", isDisabled);
	$("#loginButton").html(loginButton);
	$("#registerButton").html(registerButton);
	$("#createAccountButton").html(createAccountButton);
}
