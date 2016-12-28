# DHL Parcel Business customer shipping API

[![Latest Stable Version](https://poser.pugx.org/gunjanpatel/dhl-parcel-api/version)](https://packagist.org/packages/gunjanpatel/dhl-parcel-api) [![Total Downloads](https://poser.pugx.org/gunjanpatel/dhl-parcel-api/downloads)](https://packagist.org/packages/gunjanpatel/dhl-parcel-api) [![Latest Unstable Version](https://poser.pugx.org/gunjanpatel/dhl-parcel-api/v/stable)](//packagist.org/packages/gunjanpatel/dhl-parcel-api) [![License](https://poser.pugx.org/gunjanpatel/dhl-parcel-api/license)](https://packagist.org/packages/gunjanpatel/dhl-parcel-api) 

### Setup

#### You can use composer to use this library.

```json
{
    "require": {
        "gunjanpatel/dhl-parcel-api": "*"
    }
}
```

#### or you may install using `composer` command.

	composer require gunjanpatel/dhl-parcel-api:*

### Configuration

Set configuration variables at `etc/config.json`.

```bash
cp etc/config.dist.json etc/config.json
```

### Examples of sending request to DHL

#### Request a shipment - `html/shipment.php`

```php

require_once __DIR__ . '/vendor/autoload.php';

use DHL\Client\Soap as DhlSoapClient;
use DHL\Data\Shipper;
use DHL\Data\Receiver;
use DHL\Data\Shipment as ShipmentDetail;
use DHL\Request\Business\CreateShipment;

// Our company info
$shipper = new Shipper(
	[
		'company_name'   => 'Garnio Aps',
		'street_name'    => 'Clayallee',
		'street_number'  => '241',
		'zip'            => '14165',
		'city'           => 'Berlin',
		'email'          => 'company@hello.dk',
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
	'email'          => 'user@hello.dk',
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
		// 'returnShipmentAccountNumber' => $config['ekp'],       // Optional
		// 'returnShipmentReference'     => '',     // Optional
	]
);

// Needs to convert weight into KG
$detail->item(['weight' => 10])
	->notify('user@hello.dk');

$shipment = new CreateShipment;
$shipment->setOrderId(123456)
	->detail($detail)
	->shipper($shipper)
	->receiver($receiver)
	->labelType('B64');

$client = new DhlSoapClient(true);

$response = $client->call($shipment);

echo "<pre>";
print_r($response);
echo "</pre>";

```

#### Get Label - PDF - `html/label.php`

```php

require_once __DIR__ . '/vendor/autoload.php';

use DHL\Client\Soap as DhlSoapClient;
use DHL\Request\Business\Label;

$client = new DhlSoapClient(true);

$label = new Label('1234567890987654321');
$response = $client->call($label);

echo "<pre>";
print_r($response);
echo "</pre>";
```
