<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DHL\Client\Soap as DhlSoapClient;
use DHL\Data\Shipper;
use DHL\Data\Receiver;
use DHL\Data\Shipment as ShipmentDetail;
use DHL\Request\Business\CreateShipment;

class Dhl {

	public function init() {

		// Our company info
		$shipper = new Shipper(
			[
				'company_name'   => 'Garnio Aps',
				'street_name'    => 'Clayallee',
				'street_number'  => '241',
				'zip'            => '14165',
				'city'           => 'Berlin',
				'email'          => 'gunjan@hobbii.dk',
				'phone'          => '01788338795',
				'contact_person' => 'Gunjan Patel',
				'comment'        => '',
			]
		);

		$customer_details = [
			'name'           => 'Gunjan Patel',
			'street_name'    => 'Clayallee',
			'street_number'  => '12',
			'zip'            => 14165,
			'city'           => 'Berlin',
			'email'          => 'gunjan@hobbii.dk',
			'phone'          => '1234567890',
			'contact_person' => 'Gunjan Patel',
			'comment'        => 'Just test',
		];

		$receiver = new Receiver($customer_details);

		$detail = new ShipmentDetail(
			[
				'product'       => 'V01PAK',
				'accountNumber' => '2222222222220101',
				// 'customerReference'           => '',     // Optional
				'shipmentDate'  => date('Y-m-d'),
				// 'returnShipmentAccountNumber' => $this->credentials['ekp'],       // Optional
				// 'returnShipmentReference'     => '',     // Optional
			]
		);

		// Needs to convert weight into KG
		$detail->item(['weight' => 10])
			->notify('gunjan@hobbii.dk');

		$shipment = new CreateShipment;
		$shipment->setOrderId(123456)
			->detail($detail)
			->shipper($shipper)
			->receiver($receiver)
			->labelType('B64');

		$client = new DhlSoapClient(true);

		try {
			$response = $client->call($shipment);

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
