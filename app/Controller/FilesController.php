<?php

class FilesController extends AppController {

  public function initialize() {

    parent::initialize();

    // Include the FlashComponent
    $this->loadComponent('Flash');

    // Load Files model
    $this->loadModel('Files');

    // Set the layout
    $this->layout = 'frontend';
  }

  public function index() {

    // Load Files model
    $this->loadModel('Files');

    $uploadData = '';

    if ($this->request->is('post')) {

      if(!empty($this->request->data['File']['file']['name'])) {

        $fileName = $this->request->data['File']['file']['name'];
        $uploadPath = 'files/';
        $uploadFile = $uploadPath . $fileName;

        if(move_uploaded_file($this->request->data['File']['file']['tmp_name'], $uploadFile)) {
          $ipaddress = '';

          if (isset($_SERVER['HTTP_CLIENT_IP'])) {
              $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
          } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
              $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
          } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
              $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
          } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
              $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
          } else if (isset($_SERVER['HTTP_FORWARDED'])) {
              $ipaddress = $_SERVER['HTTP_FORWARDED'];
          } else if (isset($_SERVER['REMOTE_ADDR'])) {
              $ipaddress = $_SERVER['REMOTE_ADDR'];
          } else {
              $ipaddress = 'UNKNOWN';
          }

          $uploadData = array(
              'name' => $fileName,
              'path' => $uploadPath,
              'created' => date("Y-m-d H:i:s"),
              'ip_address' => $ipaddress
            );

          if ($this->Files->save($uploadData)) {

            $this->Flash->success(__('File has been uploaded and inserted successfully.'));

          } else {

            $this->Flash->error(__('Unable to upload file, please try again.'));
          }
        } else {

          $this->Flash->error(__('Unable to upload file, please try again.'));
        }
      } else {

        $this->Flash->error(__('Please choose a file to upload.'));
      }
    }

    $this->set('uploadData', $uploadData);

    $files = $this->Files->find('all', ['order' => ['Files.created' => 'DESC']]);
    $filesRowNum = count($files);
    $this->set('files', $files);
    $this->set('filesRowNum', $filesRowNum);
  }

}
