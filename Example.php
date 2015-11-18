<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAWy5zG2AigpBYALUtOnulC1O9z2A8leqFD8JlSMapz193QILwz1IC7dXO0WFGYp8JX4LZ3lWtvF92lgC73QyLOaqORss4FqYPHv6CrlqKUBuTlpyqvRY3JwF879qwDLDQ2zuK1UDWQ6oFc7uJZnYJKCPTu+YFiwPcJwxles865h2R7vi3/ZL3ZMa72aZZnZYRh7H1U834RY8xSM3zf5zD2yEmOjEWnITGv7q++gpmVUGzuLY8ZpM5I/nVjMfI8x2zAFmY386FqgFol/9jTExqeZDfqisVSUg5ZmQnrr90VBdK+bxzzIEYZyHqZlZlnpiDlIl8T9hvsprimN6Go3MIkIDZgAACNWF3jEarJAgKAG7EO4ld5dfd4NM5dgUdmaQp/j1d0CAxhGSvnt7jogQ7AZugwzylJFKFY8ZzDqwf97wVCI8LwnMSK+SEXJAQPUv3h+aDEPakp+WaZa6SUtR0Lm5RU8kvPrSMoyNbFYhMUlBRsUT6uat/79mTeqjOKLkqvxxVwLwIMjN2tXTw07lj96f/jS2I5P24AhP2w3H7YNymu4+TrfZIVr+UAEcgn6omcF7Aw0/yHjsOuS/JTCY+TslEbO1HztItAgR6xUqXUqzseJlF+7gvYsY2D8l+zLy3++13y2Y2Y8UHnDwvqa2GQWl6qCoVem1V/MqInJlx7kZk+aputsGIrev9rndJKV4e8WNNRFSuGld5B2Dv87H5ZQWTaNAlvUwb67SESdC4aE/xjkshzt2gVAB');

$list_folder = $client->listFolder('folder_name');

$create_folder = $client->createFolder('folder_name');

$upload_file = $client->uploadFile('directory_to_get_from', 'file_name');

$download_file = $client->downloadFile('file_name', 'directory_to_upload_for');
