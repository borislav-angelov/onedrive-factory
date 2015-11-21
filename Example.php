<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAaXyEfXvVEcMgoKZtN3z+dTXA4MCKH0cObVzf0vETQ2Agiqp2VCOmbdSsY578r/qpVpQIgF+8FDvjRv3AAeq4awotofIsjN15rQ77ca4eM5jfOshXIOBk/88+Vjx4yzNp7pJAwJgKPKSdf/rjGhzP8QoXH8XuurDj0uT9C9AEJdLI4ByU1qv7F5CXvQ6K0K+56rXB899cfqJVZ7VtaC/grKDIcdUxhq86XSXbSLHyrrqF0Rj+QXdcwF/xd/esO9ZBjHD2kEivs9A7Vb6RGNy6VjuFFfVH+b3cIfaCNj6soSRy0LsFmmTtQqhBOAM4/ZXiMp11HKBZjLB3X9FaSbKa14DZgAACCUshV20kKCOKAFImS5E6hHDpQeYFUkJXv7cpLH1KroU0pIQNPw36IT6lWwdvVmc2nmg96L1zFc4FvuPn7d2Ab315EsfiHKnTmzTv1iXna+Bi7QqdRyBYVLcC9a/J7CZIGSolyjg8y7xm4DsqSglVJVvM29C68TDx9q722j0JHhTfQe6eIk5vq3UlFKWkiTOGiQFUf2SIJ7b/OyKRAXV/j6AgmiZysSSz6V3DrmfNiYiuOzOdIs8lExxtoxxMoVCRAL9Zbls7let5UAGHI+TNm3VWnHLatHODOFWcN1+llPIhjLBNit/eKAszcHkdr/BQ7+RC2b+vRJuyZvVp6Akv7nTPrzWuA2omwaIEm+9JMvQw0z1oJqGoTidgXO89UZClrCjIkGNal6/cnXKl7L8bQDXM1AB');

$filer = fopen('neta.exe', 'w+');
$file_size = 111722256;
$params = array(
	'size' => $file_size,
	'startBytes' => 0,
	'endBytes' => 100000
	);

$downloader = $client->downloadFileChunks('here/neta.exe', $filer, $params);

var_dump($downloader);