<?php
// clean GET arrays
$R = filter_input_array(INPUT_GET);
// include the Gallery class
require_once 'Gallery.php';
// get requested file type
// check if file type it is allowed - listed in an array here Gallery::_validFiles
// If no file type requested default to "all"
$requestFileType = (in_array($R['type'], Gallery::_validFiles)) ? $R['type'] : 'all';
// create new Gallery object
$gallery = new Gallery('./images', $requestFileType);
// Loads images to gallary object
$gallery->load();
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--lightbox css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
        <title>Image Gallery</title>
        <style>
            .table {
                background-color: #eee; 
                margin: 50px 0;
            }
            .table th {
                padding: .75rem;
                background-color: #ddd; 
                border-top: 1px solid #555;
                border-bottom: 1px solid #555;
            }       
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Image Gallery</h1>  
            <!-- filter by file type -->
            <form action="index.php" method="get">
                <select name="type">
                    <option>all</option>
                    <?php
                        // Display all file types that are allowed
                        // Make sure the current file type is active
                        foreach (Gallery::_validFiles as $t) {
                            $active = ($R['type'] == $t) ? 'selected' : '';
                            echo "<option $active>$t</option>";
                        }
                    ?>
                </select>
                <input type="submit" />
            </form>    
            <?php
            // Render class HTML output
            $gallery->render();
            ?>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- lightbox JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox-plus-jquery.js"></script>
    </body>
</html>