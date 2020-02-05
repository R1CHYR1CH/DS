<?php
class Gallery {

    private $directory;
    private $files = [];
    private $temp = [];
    
    const _validFiles = ['jpeg','jpg','png'];
    
    public function __construct($directory, $fileType) {
        $this->directory = $directory;
        $this->fileType = $fileType;
    }

    public function load() {
        // get dir path
        $directory  = dir($this->directory);
        // search dir recursively
        $it = new RecursiveDirectoryIterator($this->directory);
        // for each file found
        foreach(new RecursiveIteratorIterator($it) as $item){    
            // filter by image type
            $filter = (!$this->fileType || $this->fileType == 'all' ) ? self::_validFiles : [$this->fileType];
            // read the file extention and check if it's allowed. 
            $parts = explode('.', $item);
            $fileExtention = end($parts);
            if (in_array($fileExtention, $filter)){
                // extention is ok 
                // get image details
                $imageDetails = getimagesize($item);
                $imageSize = $imageDetails[3];
                //$imageType = $imageDetails['mime']; // Use the file type from mime data
                $imageType = $fileExtention; // Use the file type from extention
                // get image dir location as required
                $info = new SplFileInfo($item);
                $parent_info = $info->getPathInfo();
                $imageDir = $parent_info->getRealPath();
                // add the required details to the files array.
                $this->temp[] = [$item, $imageSize, $imageType, $imageDir];
            }
            // group array by $imageDir - this make the $this->files array
            foreach ($this->temp as $key => $item) {
               $this->files[$item[3]][$key] = $item;
            }
            // alphabetically sort for no particular reason!
            ksort($this->files, SORT_STRING );
        }
        $directory->close();
    }
    
    public function render() {
        // for each dir crate a new table
        foreach ($this->files as $file) {
            // use dir as title
            echo '<table class="table">';
            echo '<th></th><th>Dir</th><th>Size</th><th>Type</th> ';            
                // for each file
                foreach ($file as $f) {
                // crate a id for each image to keep lightbox happy
                $imageId = 'id' . uniqid();
                // out put a table row for each image
                echo "<tr>"; 
                    echo '<td><a href="' . htmlspecialchars($f[0]) . '" data-lightbox="' . $imageId . '" title="' . htmlspecialchars($f[1]) . '"><img src="' . htmlspecialchars($f[0]) . '" alt="" style="width:150px;"></a></td>';
                    echo '<td>' . htmlspecialchars($f[3]) . '</td>';
                    echo '<td>' . htmlspecialchars($f[1]) . '</td>';
                    echo '<td>' . htmlspecialchars($f[2]) . '</td>';
                echo '</tr>'; 
            }
        }
        echo'</table>';
    }

}