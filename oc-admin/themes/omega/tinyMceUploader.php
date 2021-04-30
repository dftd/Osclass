<?php
define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
require_once ABS_PATH . 'oc-load.php';

$accepted_origins = array("http://localhost/", "http://192.168.1.1/", "<?php echo osc_base_url(); ?>");

$imageFolder = osc_base_path() . 'oc-content/uploads/page-images/';

reset ($_FILES);
$temp = current($_FILES);
if (is_uploaded_file($temp['tmp_name'])){

  /*
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    // same-origin requests won't set an origin. If the origin is set, it must be valid.
    if (in_array($_SERVER['HTTP_ORIGIN'] . '/', $accepted_origins)) {
      header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    } else {
      header("HTTP/1.1 403 Origin Denied");
      return;
    }
  }
  */


  /*
    If your script needs to receive cookies, set images_upload_credentials : true in
    the configuration and enable the following two headers.
  */
  // header('Access-Control-Allow-Credentials: true');
  // header('P3P: CP="There is no P3P policy."');

  // Sanitize input
  if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
      header("HTTP/1.1 400 Invalid file name.");
      return;
  }

  // Verify extension
  if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "jpeg", "png"))) {
      header("HTTP/1.1 400 Invalid extension.");
      return;
  }

  // Accept upload if there was no origin, or if it is an accepted origin
  $file_name = date('YmdHis') . '_' . $temp['name'];
  $filetowrite = $imageFolder . $file_name;
  move_uploaded_file($temp['tmp_name'], $filetowrite);

  // Respond to the successful upload with JSON.
  // Use a location key to specify the path to the saved image resource.
  // { location : '/your/uploaded/image/file'}
  echo json_encode(array('location' => osc_base_url() . 'oc-content/uploads/page-images/' . $file_name));
} else {
  // Notify editor that the upload failed
  header("HTTP/1.1 500 Server Error");
}
?>