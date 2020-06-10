<?php
    //FileView class.
    class FileView implements LinkUrl {

        public function showFilesFolders($admin,$aPath) {
            //Check if aPath isset.
            if ($aPath === null) {
                $dirPath = "../assets";
                $dirPathFiles = "assets/";
            } else {
                $dirPath = "../" . join("/",$aPath);
                $dirPathFiles = LinkUrl::LINKURL . join("/",$aPath);
            }
            
            //Validation.
            if (is_dir($dirPath)) {
                $aFiles = scandir($dirPath);
                for($i=0;$i<count($aFiles);$i++) {
                    //File or Folder?
                    if (is_dir($dirPath . '/' . $aFiles[$i]))
                        $this->showFolder($admin, $aFiles[$i], $dirPath, $dirPathFiles); 
                    else 
                        $this->showFile($admin, $aFiles[$i], $dirPath, $dirPathFiles);
                }
            }
        }//showMediaChannels.

        public function showFolder($admin, string $file, string $dirPath) {
            //Remove the dots from current and parent directory.
            if ($file == "." || $file == "..") {}
            else {
                //See if admin == true/false.
                if ($admin == "true") 
                    $text = '<i class="fas fa-trash-alt files-hover-icons files-delete" onclick="askDeleteFileFolder(\''.$dirPath.'\',\''.$file.'\',\'folder\')"></i>';
                else 
                    $text = '';

                echo '
                    <div class="files-file-container">
                        <i class="fas fa-folder text-warning dir-icon files-icon" onclick="DirClick(\''.addslashes($file).'\',\''.$admin.'\')"></i>
                        '.$text.'
                        <p class="files-folder-file-name">'.$file.'</p>
                    </div>
                ';
            }
        }//Method showFolder.

        public function ShowFile(string $admin, string $file, string $dirPath, string $dirPathImg) {
            //Get filename and extension.
            $files = pathinfo($file);
            $extension = $files['extension'];
            $aExtensions = array("jpg","jpeg","png","pdf");

            //Check extension of the file.
            if(in_array(strtolower($extension), $aExtensions)) {
                //Look if file is image/pdf to change icon.
                if (strtolower($extension) == "pdf") 
                    $icon = '<i class="far fa-file-pdf pdf-icon files-icon text-danger"></i>';
                else 
                    $icon = '<i class="fas fa-image img-icon files-icon text-primary"></i>';

                //Look if admin function should be enabled.
                if ($admin == "true") {
                    $container = '<div class="files-file-container">';
                    $text = '<i class="fas fa-trash-alt files-hover-icons files-delete" onclick="askDeleteFileFolder(\''.$dirPath.'\',\''.$file.'\',\'file\')"></i>';
                } else {

                    //Create html content.
                    $container = '
                        <div class="files-file-container">
                        <div class="files-file-actions-container">
                            <button class="files-file-actions-buttons btn btn-secondary btn-sm" onclick="copyFile(\''.$dirPathImg.'\',\''.$file.'\',\''.$extension.'\')">Copy</button>
                            <button class="files-file-actions-buttons btn btn-secondary btn-sm" onclick="InsertFile(\''.$dirPathImg.'\',\''.$file.'\',\''.$extension.'\')">Insert</button>
                    ';
                    //Check if extension is pdf (no preview)
                    if (strtolower($extension) != "pdf") {
                        $container .= '   <button class="files-file-actions-buttons btn btn-secondary btn-sm" onclick="askPreviewImg(\''.$dirPathImg.'\',\''.$file.'\',\''.$extension.'\')">View</button>';
                    }
                    $container .= "  </div>";

                    $text = '';
                }//If $admin ==true.

                //Output on screen.
                echo $container, $icon, $text.'
                        <p class="files-folder-file-name">'.$file.'</p>
                    </div>
                ';
            }
        }//Method showFile.

    }//Class FileView.

?>