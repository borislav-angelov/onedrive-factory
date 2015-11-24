<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAYxhIIOdjpt6bomvd26GQFhppZ8zU6WOOwWsShFiJb8HKd6VGgL1WUBEJobzorEC4Un6ZpoytTAm7TaoNtzOGVnrsHiKx8CNmhsy1eAXakmIJoLTAwu2Gq9jSXA+nXm7seyxah+IryvDhV5jpizEcMwdxLmuqTY0Yl/xzihLnPBujkRzUiWHBPcJ9WkoxJK8vmrcucVujYU6D4g/zeTT2xss3ts7JmCno9M+wtK+kKNd6JLESro0YE+Amt152pv/KWOk04/sTqJ3irfKj+asP5AriUMeRx+8I9lJ63nEXqMnIvUXZMrw1K9WANG9Fnk0UWWH6qEXCVTmg1vGkHgn4i0DZgAACBBFDaGqV1vFKAHnS/LuYdhZOvunUIyQfxwLLPjpGDeY68H4uiRFMJQa4dlU4fE+PqHmKyoUns5GlKYC1ikKl1BXki2qoO1w1/Iwz5cOzcWo0cZTtFqyDSvoqDqwZA6YN96OpnTKa6HzccHAvt6IlUkz8QfFOUGnHc5hGLK+Ou+3FwMm4rPXi+UqaVqSQoXv8GEUR3gBl8xAvcqS2LPBtN5KONyb0NIb/0kwLCn4CK6Uw5A4uGFZAGyyX5QNJt0PSLfIx3Rlq5uQu9U29ZdutHPI2lq8dP+++IxcGseUP4+5iLv8GpFusrFhYRhkCMBLT7Va2+aT06FfyCsXXPL3MIwzPR2xl2dXEQ++BJbrcEI8CmE0uavFyfkcBtgmF1IKsXzXSQ0Jfl171qJ1PkrU9F3H6VAB');

$file = fopen('neta.exe', 'r');
$file_size = filesize('neta.exe');

$params = array(
	'size' => $file_size
	);

$uploader = $client->uploadFileChunk('here/neta.exe', $file, $params);


