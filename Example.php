<?php

header('Content-Type: text/html; charset=utf-8');

set_time_limit(0);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAY4RhWZx8JBBbgRKcKLyaF4cqCD7NH9DeR7Fz/nCNzS5Ee/SlqjrSsXwSQDHANMw/TdTvmkIdsCsJdNhAypY7/QDXsuaFgs2DuTzA+n9rJf0M1r2GjCJ66pcFNniTYz94KsXcmm12ibde7xuZuExhkmD53XmRdvGxf7aY5v0LCjEWAAMJzz/CEGJCjpRrBEYQH3zcQU+pUO6uDG7zxdp/aj7W9NMWzxLo04ZCTukvFF3zHuMYQ8w9Xuvar6RksE4yaGfMQt7cH7IR9xqkH89wJk3Je1xBZwqTEzf5tqcSsr3E0gFEHBnrdoTBVtE/Gu2n07zfpNgHN0mfw45cHb44mgDZgAACCtMMW1Qp6Z4KAG/rTbm9LrWrcpaMtcc1P4KScVEQxRjRk5bzWRQMy0IHqh8snf7PNIw0YWofEtagUJU67XrGL+QjLNTkqsJr7pXncb1nP5N67oSKCuO7QgvPpIMGIcQ81M7YjfoYGWx0zvpCjWrhPetHyJGZUrD3hxJwnw67TyH+ANHre1+X8BdamxlKnkY6HRenE2DHSxVk2/YLhffsGo2EI9x66oZ24zI74mojKpnF98or7dvawHVfb1pghvqIfrq8XuV33N7ai+EvInWfEBkIEg/CYd15JbI2huR7UT30Va0sot07omaXB9DXUSH53/eNULgeSpcscy7RE5O+KuhLSethcEZflbOMkV3JgkIDEQ9x82prbeiiBdgMaVE1GmPtKPAkkg+KsSvSruE0tsGUlAB');

$result = $client->uploadResumable('here/neta.exe');

$params = array();

// Set uploadUrl
$params['uploadUrl'] = $result['uploadUrl'];

// Get file
$file = fopen( 'neta.exe', 'rb' );

$params['totalBytes'] = filesize( 'neta.exe' );
$params['startBytes'] = 0;

// Read file chunk
while ( $chunk = fread( $file, OneDriveClient::CHUNK_SIZE ) ) {
	$params['endBytes'] = ftell( $file ) - 1;

	// Upload chunk
	$client->uploadFileChunk( $chunk, $params );

	$params['startBytes'] = $params['endBytes'] + 1;
}

