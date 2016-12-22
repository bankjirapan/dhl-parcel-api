<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \DHL\Client\Soap as DhlSoapClient;
use DHL\Request\Business\Label;

class Dhl {

	public function init() {

		$client = new DhlSoapClient(true);

		try {
			$label = new Label('1234567890987654321');
			$response = $client->call($label);

			echo "<pre>";
			print_r($response);
			echo "</pre>";

		} catch (\Exception $e) {
			echo "<pre>";
			print_r($e);
			echo "</pre>";
		}
	}
}

$dhl = new Dhl();
$dhl->init();
