<?php
/**
 * File:        Soap.php
 * Project:     dhl-parcel-api
 *
 * @author      Gunjan Patel
 * @version     0.1
 */

namespace DHL\Client;

use DHL\Config;
use \DHL\Request\RequestInterface as Request;

/**
 * DHL API SOAP Client
 *
 * @package DHL\Client
 */
class Soap
{
	/**
	 * DHL Soap Api url
	 *
	 * @var string
	 */
	protected $apiUrl = 'https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/geschaeftskundenversand-api/2.2/geschaeftskundenversand-api-2.2.wsdl';

	/**
	 * DHL Soap Api authentication sandbox location
	 *
	 * @var string
	 */
	protected $sandboxUrl = 'https://cig.dhl.de/services/sandbox/soap';

	/**
	 * DHL Soap Api authentication sandbox location
	 *
	 * @var string
	 */
	protected $productionUrl = 'https://cig.dhl.de/services/production/soap';

	/**
	 * DHL Soap Api connection object
	 *
	 * @var object
	 */
	protected $client;

	/**
	 * Using Sandbox environment or production
	 *
	 * @var bool
	 */
	protected $sandbox;

	/**
	 * SOAP Client constructor
	 *
	 * @param   boolean $sandbox use sandbox or production environment
	 */
	public function __construct($sandbox = false)
	{
		$this->sandbox = $sandbox;
	}

	/**
	 * Get authentication location based for sandbox or production
	 *
	 * @return string
	 */
	protected function getAuthUrl()
	{
		return ($this->sandbox) ? $this->sandboxUrl : $this->productionUrl;
	}

	/**
	 * Get valid soap authentication header
	 *
	 * @return \SoapHeader
	 */
	protected function getHeader()
	{
		$params = array(
			'user'      => Config::getConfig()->user,
			'signature' => Config::getConfig()->signature,
			'type'      => 0
		);

		return new \SoapHeader('http://dhl.de/webservice/cisbase', 'Authentification', $params);
	}

	/**
	 * Execute final soap function
	 *
	 * @param Request $request  Valid shipment request object
	 *
	 * @return mixed
	 */
	public function call(Request $request)
	{

		$params = [
			'login'    => Config::getConfig()->apiUser,
			'password' => Config::getConfig()->apiPassword,
			'location' => $this->getAuthUrl(),
			'trace'    => 1
		];

		$this->client = new \SoapClient($this->apiUrl, $params);
		$this->client->__setSoapHeaders($this->getHeader());

		// Get service name
		$serviceName = $request->serviceName;

		// Send service request
		$response = $this->client->$serviceName($request->toArray());

		return $response;
	}
}
