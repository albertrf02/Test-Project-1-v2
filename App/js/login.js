import $ from "jquery";

function login() {
  var username = $("#username").val();
  var password = $("#password").val();
  var data = {
    username: username,
    password: password,
  };
  $.ajax({
    url: "/login",
    type: "POST",
    data: JSON.stringify(data),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (data) {
      if (data.success) {
        window.location.href = "/";
      } else {
        $("#error").html(data.error);
      }
    },
    error: function () {
      $("#error").html("Error logging in.");
    },
  });
}

export { login };
