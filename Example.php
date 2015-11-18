<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAZ3bGTVf69CcFIH6EJGgcgPYyeWufM54YNLR3FJQAivbyj7Espbtd2ARFrfdXwSXMUjweszhicqsracU0uuww5FU+CnKrliFtiFr8ZHKduRts9J/gckDh2jQvNgfE2ytatRELV3xNVkRP15leOLFJTQCA7Zmxz9FEG44lyZGnKd3ElW0EfO1ExjeXUN8ny3+JOzRKqlFNSOb0r7ONRcUKVtqRGDRKdOxk9MJ6FzCo6VGl/Yp/AvtsRytgDC2NLmJ/UwAL18RAly70LwglBBYitFCSAPj45JfWoZOZX7ub19JDtEGlo/mVbvcafbQ5IJAA2TcE5iiTc6ythCb4T3m0I8DZgAACCQshycFBnhfKAHlPZ7aIyLWEwOHg8MFU/4dgkAp93+aEz/vXjgAvC6kosH3mTgAgBEFuxR14YEFWo5QYPFDseA7Ly6s1EyunyBEBUcWWP6N8h6T4LJ/DTZtWJSuqrrRkELZWfYlxv4Ftj6DDLOdlsKlK5kCWv/txukOCk6CVq5JynDUnAMLcngPAtTTmcOpRr9OvfUb2XavSezMHoXGHkgzBKIb0f2XvqhF9rM4fBAX04rNb71myajHOGqU3lLzaGCF7TeR8Puifeooqlojc+UATTHWt6v+whtWVCi0J9MG/QN+MoF7wvj7B/AWklkLYEvoo0JPxIpTk77cVfFwbZitH1YN9HKonNOo4U0XtusNa/ZZF1hAxlwJlGQ7vq/DPXBTVzSASUwSYNN2wAvg6WZBTVAB');
/*
$list_folder = $client->listFolder('here');
*/
$createFolder = $client->createFolder('test123');

var_dump($createFolder);
/*
$upload_file = $client->uploadFile('here', 'xaxa.txt');

$download_file = $client->downloadFile('opa.txt', 'onedrive-factory');*/