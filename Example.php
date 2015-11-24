<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAbGM+VTv7A9MWpq1B5ecDNLOqCEu4tQzvbsRTDQ4uk4weLMyHB6IL0mPGT9BIIsYvbyG+Ej28ZpO5BzNmbvbEKd1Ibh+xy+zyzObodNhgc8gL+m6ixGAq9iU/96fN1yi3OC+8zTebaJK5oR1CWAol5aGs9KuMSqlFOw4T7qjxyMssHjAy/0JaDbamb/HFxFguzbzwoqIJ337YKTHAuf+mc/MBkgdJ673w/++e+hS9iyI1lFRL6yXyqxFk6pZQEk9D+VOmp2cV8bPMA0kSk79ZT9ISt/62GV+n4oyqnpClk5IiZMz+pzN2YIIZMdQNQVI75fkzmzUHZ/BUAjW7rmmEJgDZgAACH/9i/sYmyHtKAEB2Y/PlesNFO4pMV+It0nTSaMohm9cpzHqfJQnkrPnDoSOcVH/vw4Lncz5RMC+bVMUDtUrfCQ9U6C+pUQOD0qnpze36tDrsbHsjq00xId6Or6JNeGzb6DUQ8/Z10sSGAVB5TSl0imlAywMJi8vUWYWnXCFflCJ/Ac/+6YfdDirJrzubI4e5SSFOZ5vZNJKKo5B4Dswxac4HuX4OMl5457OfHLxbisPMVwNJ2g55TaBnf+0AgEIMgFwetWmkWdw9AEzkCwtR+KcE+EzyZpDObzkdhgh20szc30t7nnI1CM2RfFiDa5KgnSg01IRr+4ZNknIL6ldeIxIPWH0IB4AtOULkA6ETUojolWQl9cy745eLAG5j32oinsnYtgVqOGmIirSgjC8HT+TJ1AB');

$file = fopen('neta.exe', 'r');
$file_size = filesize('neta.exe');

$params = array(
	'size' => $file_size
	);

$uploader = $client->uploadFileChunk('here/neta.exe', $file, $params);


