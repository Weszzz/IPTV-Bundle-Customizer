<?php
/**
 * Created by PhpStorm.
 * User: Wes
 * Date: 8-4-2017
 * Time: 22:59
 */

function rmdir_recursive($dir) {
    foreach(@scandir($dir) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
        else unlink("$dir/$file");
    }
    @rmdir($dir);
}

if(file_exists(__DIR__ . "/Package")) {
    rmdir_recursive(__DIR__ . "/Package/");
}

if(!file_exists(__DIR__ . "/Package"))
{
    echo '// Previously made bundle was deleted succesfully<br>';
}
else
{
    die('// Could not delete previously made bundle. Please do this manually.');
}

$zip = new ZipArchive;
if ($zip->open('IPTV.bundle-master.zip') === TRUE) {
    $zip->extractTo( __DIR__ . '/Package');
    $zip->close();
    echo '// Fresh bundle has been unzipped<br>';
} else {
    die('// Unzipping the bundle failed. Please check your permissions.<br>');
    echo __DIR__ . '\Package\\';
}

if(rename(__DIR__ . "/Package/IPTV.bundle-master", __DIR__ . "/Package/" . $_POST['bundlename'] . ".bundle"))
{
    echo '// -master addition in the foldername has been deleted<br>';
}
else
{
    die('// Could not rename bundle<br>');
}


//////////////////////// EDIT PLIST ////////////////////////

$oldLine = "<string>com.plexapp.plugins.iptv</string>";

$newLine = "<string>com.plexapp.plugins." . $_POST['bundlename'] . "</string>";

//read the entire string
$str=file_get_contents(__DIR__ . '/Package/' . $_POST['bundlename'] . '.bundle/Contents/Info.plist');

//replace something in the file string - this is a VERY simple example
$str=str_replace("$oldLine", "$newLine", $str);

//write the entire string
file_put_contents(__DIR__ . '/Package/' . $_POST['bundlename'] . '.bundle/Contents/Info.plist', $str);

echo '// edited plist<br>';

//////////////////////// EDIT INIT.PY ////////////////////////

$oldLine = "NAME = 'IPTV'";

$newLine = "NAME = '" . $_POST['bundlename'] . "'";

//read the entire string
$str=file_get_contents(__DIR__ . '/Package/' . $_POST['bundlename'] . '.bundle/Contents/Code/__init__.py');

//replace something in the file string - this is a VERY simple example
$str=str_replace("$oldLine", "$newLine", $str);

$oldLine = "PREFIX = '/video/iptv'";

$newLine = "PREFIX = '/video/" . $_POST['bundlename'] . "'";

$str=str_replace("$oldLine", "$newLine", $str);

//write the entire string
file_put_contents(__DIR__ . '/Package/' . $_POST['bundlename'] . '.bundle/Contents/Code/__init__.py', $str);

echo '// edited init.py<br>';

//////////////////////// EDIT PLAYLIST ////////////////////////

unlink(__DIR__ . '/Package/' . $_POST['bundlename'] . '.bundle/Contents/Resources/playlist.m3u');

file_put_contents(__DIR__ . '/Package/' . $_POST['bundlename'] . '.bundle/Contents/Resources/playlist.m3u', $_POST['playlist']);

echo '//aye, we done here, lets zip this bundle and provide you a download<br>';


//////////////////////// ZIP & DOWNLOAD THIS SHIZZLE ////////////////////////

$dir = __DIR__ . '/Package/';
$zip_file = __DIR__ . '/Download/' . $_POST['bundlename'] . '.zip';

// Get real path for our folder
$rootPath = realpath($dir);

// Initialize archive object
$zip = new ZipArchive();
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($zip_file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
readfile($zip_file);