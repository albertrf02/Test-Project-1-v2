import { login } from "./login.js";
import { cookie } from "./cookies.js";
import {
  DataTables,
  showImage,
  hideModal,
  hideUploadModal,
  showUploadModal,
} from "./dataTables.js";

login();
cookie();
DataTables();
showImage();
window.showUploadModal = showUploadModal;
window.hideModal = hideModal;
window.hideUploadModal = hideUploadModal;
