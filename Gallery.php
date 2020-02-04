<?php
class Gallery {

    private $directory;
    private $files = array();

    public function __construct($directory) {
        $this->directory = $directory;
    }

    public function load() {
        // get dir path
        $directory  = dir($this->directory);
        // search dir recursively
        $it = new RecursiveDirectoryIterator($this->directory);
        // for each file found
        foreach(new RecursiveIteratorIterator($it) as $item){    
            // keep only images
            if (@in_array(strtolower(array_pop(explode('.', $item))), Array ('jpeg','jpg','png'))){ 
                $imageDetails   = getimagesize($item);
                $imageSize      = $imageDetails[3];
                $imageType      = $imageDetails['mime'];
                $this->files[]  = array($item,$imageSize,$imageType);
            }
        }
        $directory->close();
    }

    public function render() {
        // create basic (Very basic output for images)
        echo'<table class="table">';
        echo'<th></th><th>Size</th><th>Image type</th> ';
        // crate a id for each image to keep lightbox happy
        $imageId = 'id'.uniqid();
        // out put a table row for each image
        foreach ($this->files as $file) {
            echo "<tr>"; 
                echo '<td><a href="' . htmlspecialchars($file[0]) . '" data-lightbox="' . $imageId . '" title="' . htmlspecialchars($file[1]) . '"><img src="' . htmlspecialchars($file[0]) . '" alt="" style="width:200px;"></a></td>';
                echo '<td>'. $file[1]. '</td>';
                echo '<td>'. $file[2].'</td>';
            echo '</tr>'; 
        }
        echo'</table>';
    }

}