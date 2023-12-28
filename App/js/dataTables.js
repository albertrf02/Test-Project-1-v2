import $ from "jquery";
import "datatables.net";

function DataTables() {
  $(document).ready(function () {
    $("#userCards").DataTable({});
  });
}

export { DataTables };
