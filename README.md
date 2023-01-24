# dirUtils
A collection of PHP functions for working with directories. 

`v1.0`: `2023-01-24`  
License: `AGPLv3`

## Functions:
All functions are contained within the namespace `dirUtils`.

### `copyDir($source, $destination, $child)`
All contents of `$source` are recursively copied into `$destination`. `$destination` is created if it doesn't exist. If `$child` is specified, then contents of `$source` are copied into the directory `$destination/$child/`.

### `deleteDir($path)`
The folder located at `$path` is deleted along with all contents.

### `zipDir($source, $zipfile)`
All contents of `$source` are compressed into zip file `$zipfile`.

### `unzipDir($zipfile, $destination)`
All contents of `$zipfile` are extracted into `$destination`.

## Example usage

```php
<?php
require 'dirUtils.php';

$dir1 = 'my_folder_1/';
$dir2 = 'my_folder_2/';
$zip = 'my_folder.zip';

//copy contents of my_folder_1/ into my_folder_2/
\dirUtils\copyDir($dir1, $dir2);

//delete my_folder_1/
\dirUtils\deleteDir($dir1);

//compress my_folder_2/ into my_folder.zip
\dirUtils\zipDir($dir2, $zip);

//extract my_folder.zip into my_folder_3/
\dirUtils\unzipDir($zip, 'my_folder_3/');

```

<br>
<br>

----
Documentation updated: `2023-01-24`

