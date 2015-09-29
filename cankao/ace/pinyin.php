<?php

 function rf($file)
{
    $arr=array();
     $handle = fopen($file, 'r');
            if ($handle) {
                // while ($line = fgetcsv($handle)) 
                  while ($line = fgets($handle)) 
                {
                    $arr[]=$line;
                }
        }
        return $arr;
}

$ret=rf("pinyin.txt");
foreach($ret as $line)
{
     
    preg_match('/([^-]*)-*([^\s]*)/', $line,$matches);
    echo "\"{$matches[2]}\"=>\"{$matches[1]}\",\n";
    
}