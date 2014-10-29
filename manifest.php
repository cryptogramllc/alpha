<<<<<<< HEAD
<?php
header('Content-Type: text/cache-manifest');
$filesToCache = array(
    './index.html', 
    './js/todo7.js', 
    './css/todo7.css', 
    './img/bg.jpg', 
    '../../dist/js/framework7.min.js', 
    '../../dist/css/framework7.min.css'
=======

<?php
header('Content-Type: text/cache-manifest');
$filesToCache = array(

    // './index.html', 
    // './js/todo7.js', 
    // './css/todo7.css', 
    // './img/bg.jpg', 
    // '../../dist/js/framework7.min.js', 
    // '../../dist/css/framework7.min.css'

>>>>>>> a153e997866ab212f760a1ff680a1959e3ab9e68
);
?>
CACHE MANIFEST

CACHE:
<?php
// Print files that we need to cache and store hash data
$hashes = '';
foreach($filesToCache as $file) {
    echo $file."\n";
    $hashes.=md5_file($file);
};
?>

NETWORK:
*

<<<<<<< HEAD
# Hash Version: <?=md5($hashes)?>
=======
# Hash Version: <?=md5($hashes)
	
?>
>>>>>>> a153e997866ab212f760a1ff680a1959e3ab9e68
