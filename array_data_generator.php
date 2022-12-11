<?php

function file_get_contents_chunked($fp, $file, $chunk_size, $queryValuePrefix, $callback)
{
    try {
        $handle = fopen($file, "r");
        $i = 0;
        while (! feof($handle)) {
            call_user_func_array($callback, array(
                $fp,
                fread($handle, $chunk_size),
                &$handle,
                $i,
                &$queryValuePrefix,
                $fp,
            ));
            $i ++;
        }
        fclose($handle);
    } catch (Exception $e) {
        trigger_error("file_get_contents_chunked::" . $e->getMessage(), E_USER_NOTICE);
        return false;
    }

    return true;
}
//$link = mysqli_connect("localhost", "root", "pass", "huge-csv");
$fp = fopen('data.txt', 'a');
$success = file_get_contents_chunked($fp, 'BusinessFinance.csv', 2048, '', function ($fp, $chunk, &$handle, $iteration, &$queryValuePrefix) {
    $TABLENAME = 'tbl_lead';
    $chunk = $queryValuePrefix . $chunk;

    // split the chunk of string by newline. Not using PHP's EOF
    // as it may not work for content stored on external sources
    $lineArray = preg_split("/\r\n|\n|\r/", $chunk);
//    $query = 'INSERT INTO ' . $TABLENAME . '(id, name, email) VALUES ';
    $numberOfRecords = count($lineArray);
    for ($i = 0; $i < $numberOfRecords - 2; $i ++) {
        // split single CSV row to columns
        $colArray = explode(',', $lineArray[$i]);
        $data = "['id' => \"{$colArray[0]}\", 'title' => \"{$colArray[1]}\", 'url' => \"{$colArray[2]}\", 'isPaid' => \"{$colArray[3]}\", 'price' => \"{$colArray[4]}\", 'numSubscribers' => \"{$colArray[5]}\", 'numReviews' => \"{$colArray[6]}\", 'numPublishedLectures' => \"{$colArray[7]}\", 'instructionalLevel' => \"{$colArray[8]}\", 'contentInfo' => \"{$colArray[9]}\", 'publishedTime' => \"{$colArray[10]}\"],\n";
        echo $data;
        fwrite($fp, $data);
//        $query = $query . '(' . $colArray[0] . ',"' . $colArray[1] . '","' . $colArray[2] . '"),';
    }
    // last row without a comma
//    $colArray = explode(',', $lineArray[$i]);
//    $query = $query . '(' . $colArray[0] . ',"' . $colArray[1] . '","' . $colArray[2] . '")';
    $i = $i + 1;

    // storing the last truncated record and this will become the
    // prefix in the next run
    $queryValuePrefix = $lineArray[$i];
//    mysqli_query($link, $query) or die(mysqli_error($link));

    /*
     * {$handle} is passed in case you want to seek to different parts of the file
     * {$iteration} is the section of the file that has been read so
     * ($i * 4096) is your current offset within the file.
     */
});

if (! $success) {
    // It Failed
}


