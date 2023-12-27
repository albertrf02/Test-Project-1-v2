import $ from "jquery";
import Swal from "sweetalert2";

function login() {
  $(document).ready(function () {
    $("#loginAJAX").submit(function (e) {
      e.preventDefault();

      var formData = $("#username").val();

      console.log(formData);
      $.ajax({
        type: "POST",
        url: "/loginAJAX",
        data: { formData: formData },
        success: function (response) {
          console.log(response);
          var user = response["user"];
          if (user) {
            Swal.fire({
              icon: "success",
              title: "S'ha iniciat sessió correctament",
              html: `Nom: ${user.nom}<br>Cognoms: ${user.cognoms}<br>Grup: ${user.grup}`,
              confirmButtonText: "OK",
            }).then(() => {
              window.location.href = "/";
            });
          } else {
            console.error("Error en les dades rebudes");
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Error al processar la resposta del servidor",
              confirmButtonText: "OK",
            }).then(() => {
              window.location.href = "/login";
            });
          }
        },
        error: function (error) {
          console.log("Error:", error);
        },
      });
    });
  });
}

export { login };
