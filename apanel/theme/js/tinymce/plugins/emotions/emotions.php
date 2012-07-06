<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#emotions_dlg.title}</title>
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/emotions.js"></script>
</head>

<div style="text-align: center;">
                <div class="title">{#emotions_dlg.title}:<br /><br /></div>
        <table border="0" cellspacing="0" cellpadding="4">
            <tr>
<?php
    $current_dir = "img/";
    $dir = opendir($current_dir);
    $fileList = array();
    $i = 0;
    while ($file = readdir($dir)) {
        if (($file != ".") && 
            ($file != "..")) {
            $fileList[$i++] = $file;
        }
    }
    closedir($dir);
    sort($fileList);
    $counter = 0;
    foreach ($fileList as $file) {
        if (is_dir($current_dir.$file)) continue;
        if ($counter > 0) {
            if ($counter % 4 == 0) {
                print('</tr><tr>');
            }
        }
        $fileName = $file;
        $arrDesc = explode(".", $file);
        $fileDesc = $arrDesc[0];
        $tableRow = <<<tableRow
<td>
<a href="javascript:EmotionsDialog.insert('$fileName','$fileDesc');">
<img src="img/$fileName" border="0" alt="$fileDesc" title="$fileDesc" />
</a>
</td>
tableRow;
        print($tableRow);
        $counter++;
    }
?>
        </tr>
                </table>
        </div>
</body>
</html>
