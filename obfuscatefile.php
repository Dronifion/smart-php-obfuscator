<?php
/**
 * @author Lester Soo
 */
try
{
    //Require obfucation class
    require "class.obfuscator.php";

    //Define source file path
    $fullfilename_source = "F:\\Dev\\functions.php";

    //Open file for reading
    $handle_source = fopen($fullfilename_source, 'r') or die("file doesnt exist");

    //for entire read of doc use file_get_contents($fullfilename)
    $readtext_source = fread($handle_source, 30000); //read 30000 chars of doc 

    //Close a file session
    fclose($handle_source);

    /*
    * To detect PHP code block <?php ... ?> and then replace it with obfuscated text block
    * Make sure the last line of each php file is exclosed with ?>
    */
    $php_blocks = array();
    preg_match_all("/<\?php(.*)?(.*)?\?>/sU", $readtext_source, $matches);
    foreach ($matches[0] as $php_block) {
        $readtext_source = str_replace($php_block, SmartObfuscator::obfuscate($php_block), $readtext_source);
    }

    //Define a target file
    $fullfilename_target = 'F:\\Dev\\obfuscated-functions.php';

    //Write to the target file
    $handle_target = fopen($fullfilename_target, 'w') or die('Cannot open file:  '.$fullfilename_target);
    fwrite($handle_target, $readtext_source);

    //Close a file session
    fclose($handle_target);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

