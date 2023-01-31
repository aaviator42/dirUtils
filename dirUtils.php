<?php
// dirUtils.php
// v1.0: 2023-01-30
// by @aaviator42

namespace dirUtils;
//---------------------------------------

// DELETE DIRECTORIES
// based on
// https://stackoverflow.com/a/3349792/
 function deleteDir($path) {
	$it = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS);
	$files = new \RecursiveIteratorIterator($it,
				 \RecursiveIteratorIterator::CHILD_FIRST);
	foreach($files as $file) {
		if ($file->isDir()){
			rmdir($file->getRealPath());
		} else {
			unlink($file->getRealPath());
		}
	}
	rmdir($path);
}

// COPY DIRECTORIES
// based on
// https://stackoverflow.com/a/2050909/
function copyDir(string $source, string $destination, string $child = '') {
	$directory = opendir($source);

    if (is_dir($destination) === false) {
        mkdir($destination);
    }

    if ($child !== '') {
        if (is_dir("$destination/$child") === false) {
            mkdir("$destination/$child");
        }

        while (($file = readdir($directory)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            if (is_dir("$source/$file") === true) {
                copyDir("$source/$file", "$destination/$child/$file");
            } else {
                copy("$source/$file", "$destination/$child/$file");
            }
        }

        closedir($directory);
        return;
    }

    while (($file = readdir($directory)) !== false) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        if (is_dir("$source/$file") === true) {
            copyDir("$source/$file", "$destination/$file");
        }
        else {
            copy("$source/$file", "$destination/$file");
        }
    }

    closedir($directory);
	return 1;
}

// COMPRESS DIRECTORIES INTO ZIP FILES
// based on
// https://stackoverflow.com/a/4914807/9112039
function zipDir($source, $zipfile){

	// Get real path for our folder
	$rootPath = realpath($source);

	// Initialize archive object
	$zip = new \ZipArchive();
	$zip->open($zipfile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

	// Create recursive directory iterator
	/** @var SplFileInfo[] $files */
	$files = new \RecursiveIteratorIterator(
		new \RecursiveDirectoryIterator($rootPath),
		\RecursiveIteratorIterator::LEAVES_ONLY
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
	return 1;
}

// EXTRACT DIRECTORIES FROM ZIP FILES
// based on
// https://stackoverflow.com/a/8889126/9112039
function unzipDir($zipfile, $destination){
	if(!is_dir($destination)){
		mkdir($destination);
	}
	$zip = new \ZipArchive;
	$res = $zip->open($zipfile);
	if ($res === TRUE) {
		$zip->extractTo($destination);
		$zip->close();
		return 1;
	}
	return 0;
}