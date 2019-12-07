<?php
$file = 'Archiv.zip';

$zip = new ZipArchive;
$res = $zip->open($file);
if ($res === TRUE) {
  $zip->extractTo(__DIR__);
  $zip->close();
  rmdir('__MACOSX');
  unlink('Archive.zip');
  echo "Whoot!";
} else {
  echo "Doh!";
}
?>
