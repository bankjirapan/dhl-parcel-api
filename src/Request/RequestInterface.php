<?php
/**
 * File:        RequestInterface.php
 * Project:     dhl-parcel-api
 *
 * @author      Gunjan Patel
 * @version     0.1
 */

namespace DHL\Request;

/**
 * Interface RequestInterface
 *
 * @package DHL\Request
 */
Interface RequestInterface
{
	/**
	 * Prepare array to send in post
	 *
	 * @return array
	 */
	public function toArray();
}
