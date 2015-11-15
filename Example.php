<?php

header('Content-Type: text/html; charset=utf-8');

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveClient.php';

$client = new OneDriveClient('EwBYAq1DBAAUGCCXc8wU/zFu9QnLdZXy+YnElFkAAYta0tfIVifFyIemKH+7rXu2/Bs+YRezTWAqm2sWfkRTXqLPs32yb2B9oCMGyvqgZnAjfRt+CX3zEzu0NfOQ6Ro0krGP+3tyB8SpNX4pJe2eA0+fWoTUO9DGcDoc80sIj31Z0oGgf+Tm6K57/NFiMN+en6XN27fvsifVrYWUxT7qXSasbXhl38aQOOUy/trFa/ChwIFO5FpZPJic+8GI6CNKshCwocEHY6C2FqqelcehUAWdw5xIpdX6/a2hjulFpDTLS3anTLR2j4g5xvlPutR/5SOYtOUG4J126shQCMyxH+fcfVY06s/ivB9ar+URNFlYrKRIZTSlRyC6ENBwIlADZgAACNT3ww//SI5TKAFSqN63Y9Fdbbt+uADczYetyHP+LL0s55iFRhT6v+WB9h3t5febnZoxhNt4lwmzr7BFA1IQFtgz4MH0TtFI7fM7UIaei2Z3QZfrZbEEtDPZ28nrwNUPYnkb7fTRfwZqjMNzhBVJMYG2HAKY4BDnABUQxSHNKnSuCxWIgwt1LgtLyzS01K11n6IlDX2R5N0lbiheUW+5dx3C0ikiZtFRxle8luoy2xeqKx2DDGiRDKFcEj+Z19rO8xQ/5mBxETo8oc2IbdGBtVYKCs9VuNCdS4eyHrYdJxLrIl3kvM6bON3QlmgHX/Hc8nEztEOGHsGanA+EUxVxfSDAjEezyGmTBCVbLu86drymS692dfCD0B/nTd4tBt3LR9Aqa6VwUKntdAVdZpbkiBbFbVAB');

$response = $client->listDrive();

foreach ($response['value'] as $item) {
	echo $item['name'] . '<br />';
}

//print_r($response);

//var_dump($response);