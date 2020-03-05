<?php

namespace Mini\Libs;
use SplFileInfo;

class Uploads {

    private function get_file_extension($orig_image) {

        $info = new SplFileInfo($orig_image);
        $file_extension = $info->getExtension();

        return $file_extension;
    }

    //models---------------------------------------------
    public function do_upload_multiple($field_name, $folder = "uploads") {
        $files = [];
        $path = IMAGE_FOLDER . $folder . DIRECTORY_SEPARATOR;

        $i = 0;

        foreach ($_FILES[$field_name]['name'] as $fileName) {
            $ext = $this->get_file_extension($fileName);
            $id = uniqid('FIL') . rand(0, 999999) . date("YmdHis");

            //Get the temp file path
            $tmpFilePath = $_FILES[$field_name]['tmp_name'][$i];

            //Make sure we have a filepath
            if ($tmpFilePath != "") {
                //Setup our new file path
                $newfilename = $path . $id . '.' . $ext;

                //Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $newfilename)) {
                    $files[$i] = $id . '.' . $ext;
                    //Handle other code here
                }
            }
            $i++;
        }

        return $files;
    }

    public function do_upload_single($field_name, $folder = "policies") {
        $result = '';
        $fileName = $_FILES[$field_name]["name"]; //The file name
        $fileTmpLoc = $_FILES[$field_name]["tmp_name"]; //File in the PHP tmp Folder
        //
        $ext = $this->get_file_extension($fileName);
        $id = uniqid('FIL') . rand(0, 999999) . date("YmdHis");
        $newfilename = $id . '.' . $ext;
        //$path = APP."uploads\\";
        $path = IMAGE_FOLDER . $folder . DIRECTORY_SEPARATOR;
        $moveResult = move_uploaded_file($fileTmpLoc, $path . $newfilename);

        if ($moveResult != true) {
            //echo "Error: File not Uploaded..Try Again";
            //unlink($fileTmpLoc);
            $result = array('error' => true, 'message' => 'Error: File not Uploaded..Try Again');
            //return $result;
            //exit();
        } else {
            $result = array('error' => false, 'message' => $newfilename);
        }

        return $result;
    }

}
