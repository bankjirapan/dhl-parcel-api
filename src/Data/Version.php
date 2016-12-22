<?php
/**
 * File:        Version.php
 * Project:     dhl-parcel-api
 *
 * @author      Gunjan Patel
 * @version     0.1
 */

namespace DHL\Data;

/**
 * Set version information
 *
 * @package DHL\Data
 */
class Version
{
	public function get()
	{
		return ['majorRelease' => '2', 'minorRelease' => '0'];
	}
}
