<?php

namespace DHL;

/**
 * Dhl Business Shipment API
 */
class Config
{
	protected static $configPath = __DIR__ . '/../etc/config.json';

	/**
	 * Constructor for Shipment SDK
	 *
	 * @param   boolean $sandbox use sandbox or production environment
	 */
	public function __construct($path = null) {

		if (!empty($path))
		{
			if (!file_exists($path))
			{
				throw new \InvalidArgumentException('Configuration file not found');
			}

			self::$configPath = $path;
		}
	}

	public static function getConfig(){
		if (!file_exists(self::$configPath)) {
			throw new \InvalidArgumentException('Configuration not found.');
		}

		return json_decode(file_get_contents(self::$configPath));
	}
}
