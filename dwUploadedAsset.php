<?php
$upload_asset = 'uploads';
$files_asset = "files";
$zip_file_name = 'dwuploadedAssets.zip';

class FlxZipArchive extends ZipArchive {
        /** Add a Dir with Files and Subdirs to the archive;;;;; @param string $location Real Location;;;;  @param string $name Name in Archive;;; @author Nicolas Heimann;;;; @access private  **/
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
         $this->addDirDo($location, $name);
     } // EO addDir;

        /**  Add Files & Dirs to archive;;;; @param string $location Real Location;  @param string $name Name in Archive;;;;;; @author Nicolas Heimann * @access private   **/
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
      // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
          // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}

$za = new FlxZipArchive;
$res = $za->open($zip_file_name, ZipArchive::CREATE);
$isfolderexists = false;
if($res === TRUE)    {
    if(file_exists($upload_asset)) {
        $za->addDir($upload_asset, basename($upload_asset));
        $isfolderexists = true;    
    } 

    if(file_exists($files_asset)) {
        $za->addDir($files_asset, basename($files_asset)); 
        $isfolderexists = true;   
    } 

    $za->close();

    if($isfolderexists == true) {
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$zip_file_name"); 
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile("$zip_file_name");    
    }
    
    exit;
}
else  { echo 'Could not create a zip archive';}
?>