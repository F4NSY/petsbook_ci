var spinner = `<div class="spinner-border spinner-custom-size" role="status">
<span class="visually-hidden">Loading...</span>
</div>`;
var registerError = $("#registerError");
$("#registerModal").on("hidden.bs.modal", function () {
	$("#registerForm").trigger("reset");
	registerError.removeClass("alert alert-danger text-center p-1 fs-7");
	registerError.html("");
});
$("#registerForm").on("submit", function (e) {
	e.preventDefault();
	var firsNameRegister = $("#firstNameRegister");
	var lastNameRegister = $("#lastNameRegister");
	var emailRegister = $("#emailRegister");
	var passwordRegister = $("#passwordRegister");
	var confirmPasswordRegister = $("#confirmPasswordRegister");
	var birthdayRegister = $("#confirmPasswordRegister");
	var genderRegister = $("input[type = radio]");
	var input = [
		firsNameRegister,
		lastNameRegister,
		emailRegister,
		passwordRegister,
		confirmPasswordRegister,
		birthdayRegister,
	];
	var emailRegex = new RegExp(
		"^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$"
	);
	var passwordRegex = new RegExp(
		"((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))"
	);

	for (var i = 0; i < input.length; i++) {
		if (input[i].val() == "") {
			registerError.addClass("alert alert-danger text-center p-1 fs-7");
			registerError.html("All fields are required!");
			input[i].focus();
			return false;
		}
	}
	if (
		genderRegister.eq(0).is(":checked") == false &&
		genderRegister.eq(1).is(":checked") == false
	) {
		registerError.addClass("alert alert-danger text-center p-1 fs-7");
		registerError.html("All fields are required!");
		return false;
	}
	if (!emailRegex.test(emailRegister.val())) {
		registerError.addClass("alert alert-danger text-center p-1 fs-7");
		registerError.html("Invalid email format");
		emailRegister.focus();
		return false;
	}
	if (!passwordRegex.test(passwordRegister.val())) {
		registerError.addClass("alert alert-danger text-center p-1 fs-7");
		registerError.html("Your password is too weak");
		passwordRegister.focus();
		return false;
	}
	if (passwordRegister.val() != confirmPasswordRegister.val()) {
		registerError.addClass("alert alert-danger text-center p-1 fs-7");
		registerError.html("Password and confirm password doesn't match");
		confirmPasswordRegister.focus();
		return false;
	}
	registerError.removeClass("alert alert-danger text-center p-1 fs-7");
	registerError.html("");
	var formData = new FormData(this);
	$.ajax({
		url: environment.base_url + "api/register",
		type: "post",
		data: formData,
		processData: false,
		contentType: false,
		beforeSend: function () {
			createSpinner(true);
		},
		success: function () {
			Swal.fire({
				title: "Success!",
				text: "Your registration to PetsBook is successful.",
				icon: "success",
				confirmButtonColor: "#1266f1",
			}).then((result) => {
				if (result.isConfirmed) {
					$("#registerForm").trigger("reset");
					registerError.removeClass("alert alert-danger text-center p-1 fs-7");
					registerError.html("");
					$("#registerModal").modal("hide");
				}
			});
		},
		error: function (error) {
			var errorMessage;
			if (error.hasOwnProperty("responseJSON")) {
				if (error.responseJSON.message === "duplicate-email") {
					errorMessage =
						"This email is already in use. Please sign up with a different one.";
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
			}).then((result) => {
				if (result.isConfirmed) {
					$("#registerForm").trigger("reset");
					registerError.removeClass("alert alert-danger text-center p-1 fs-7");
					registerError.html("");
					$("#registerModal").modal("hide");
				}
			});
		},
		complete: function () {
			createSpinner(false);
		},
	});
});
