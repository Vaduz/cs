<?php
/**
 * HLTV Demo viewer
 *
 * @version    0.1
 * @copyright  Copyright (c) 2009 Satoru Yoshihara
 *             http://vaduz.tk
 * @license    GNU public license
 *             http://www.fsf.org/copyleft/gpl.html 
 * @author     Satoru Yoshihara
 * @contact    vaduz@vaduz.tk
 */

/**
 * get demo file information as array of array in current directory
 *
 * return array of array
 */
function get_fileinfo()
{
    $fileinfo = array();
    foreach(glob('*.dem') as $filename) {
        $filesize = ceil(filesize($filename) / 1048576) . ' MB';
        array_push($fileinfo, array(
            'size'      => $filesize,
            'timestamp' => filemtime($filename),
            'name'      => $filename,
            )
        );
    }
    array_pop($fileinfo);
    return $fileinfo;
}

/**
 * count up the time difference and return formatted time
 * 
 * return string
 */
function get_timelength($t1, $t2)
{
    $delta = $t1 - $t2;
    $hours = floor($delta / 3600);
    $minutes = floor(($delta % 3600) / 60);
    $seconds = $delta % 60;
    return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
}

/**
 * parse hltv demo filename and return unix timestamp
 * 
 * return integer
 */
function parse_filename2timestamp($filename)
{
    eregi('.*-([0-9]{10})-.*\.dem$', $filename, $regs);
    return (int)strtotime("20$regs[1]00");
}

/**
 * helper function for creating formatted html link code
 * 
 * return string
 */
function a($name, $url = null)
{
    $url = empty($url) ? $name : $url;
    return '<a href="' . $url . '" about="_blank">' . $name . '</a>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$_SERVER['HTTP_HOST']?> HLTV Demos</title>
</head>
<body>
<h1>HLTV Demos</h1>
<p>You can download HLTV demo by clicking filename link.</p>
<p>timestamp | filename | filesize | timelength</p>
<ul>
<?php
foreach(get_fileinfo() as $file) {
    echo '<li>';
    echo date('Y-m-d H:i:s', $file['timestamp']);
    echo ' | ';
    echo a($file['name']);
    echo ' | ';
    echo $file['size'];
    echo ' | ';
    echo get_timelength($file['timestamp'], parse_filename2timestamp($file['name']));
    echo '</li>';
    echo PHP_EOL;
}
?>
</ul>
<hr />
<center>&copy; 2009 <a href="http://vaduz.tk">vaduz.tk</a></center>
</body>
</html>
