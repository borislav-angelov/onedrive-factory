<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAARM7M7tJiriJWMo5+noVhs6xylWtx9v+EcyKg4LI1zJ1hyhx5cY6x4pJfSlEimoaJ6dMg/3ftvWxssP8Y68QLWA8zlqCgrz2N0d3VcjDKWhZF8bOZGgSBdSjk1vCAKrx8qVmoHwT0M3o3kOB8fa+MrYJ7tVrhiejbqFh4YRb6Ju5ALiLZMEdZyLsNbgXR+UA2fZ36gnAYldFAkOz3QhXBFdZKiNhyxio4QV9vHXirAg7GFQINtdAqfDDbRJJapkUzn6Yo/zkR5oEPmHLekrVgoAZVPL82W4HVGvDD9Q/tCc6p1Ba9g9OXMiVfBZyNmkLOT42Zs/cVWUP+HM+D91Fc6gDZgAACGK7rq6vsOcVKAHWbFbs35QOtXYVDGZGcLsOol+1Jebbyv9Hjxwup3KiwxpFVS5cfWaLgVvqVBdtWyYsyhmr0Ob8vpm/dRLaBhahzzsoZR756UBU+Zh7wCz2qXzBb7uh+ZHR+EvkqgYh86UnZf6RHSNYAhP7ach9BX4n578U8uDZvlFrERfXHi419RJvCQE95KefNh3HIP177E5APAKhnMPXUya2vCcFzhkOw0vriJF37oZkMz6GKA+V2HOzBabqIle5zPOLcAstPsILUVSsijZlTPmFFF3oEJPONlrQxqgjb5fFvFhDqVn2UiWEn2/rH9hG2KjAGBN/PvcxJvyu38Hwi3BQ38KbawNiO/rEhIicILZ4+LQHvuqTObWUUE5nCmHCSzxkm8GzIzfAI02a7Ef+nVAB');
/*
$list_folder = $client->listFolder('here');
*/

$file = fopen('my_file.txt', 'w+');

$downloadFile = $client->downloadFile($file, 'here/file.txt');

var_dump($downloadFile);
/*
$upload_file = $client->uploadFile('here', 'xaxa.txt');

$download_file = $client->downloadFile('opa.txt', 'onedrive-factory');*/