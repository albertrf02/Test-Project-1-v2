import $ from "jquery";
import "datatables.net";

function DataTables() {
  $(document).ready(function () {
    $("#userCards").DataTable({});
    showImage();
  });
}

function showImage() {
  $(".image-link").click(function () {
    var imagePath = $(this).data("path");
    $("#modalImage").attr("src", imagePath);
    showModal();
  });
}

function showModal() {
  $("#imageModal").removeClass("hidden");
  $("body").addClass("overflow-hidden");
}

function hideModal() {
  $("#imageModal").addClass("hidden");
  $("body").removeClass("overflow-hidden");
}

function showUploadModal() {
  document.getElementById("uploadModal").classList.remove("hidden");
}

function hideUploadModal() {
  document.getElementById("uploadModal").classList.add("hidden");
}

export { DataTables };
export { showImage };
export { hideModal };
export { hideUploadModal };
export { showUploadModal };
