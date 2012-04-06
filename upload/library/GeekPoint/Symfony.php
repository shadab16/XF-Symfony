<?php

/**
 * A helper class for use in the Symfony Framework. Although there's no restriction to use it in
 * any other framework or script. Just the autoloader needs to be setup before using this class.
 * Sample code for initializing XenForo from your own script:
 *
 * <code>
 * $startTime = microtime(true);
 * $xenforoRoot = '/absolute/path/to/xenforo/root/directory';
 *
 * require_once($xenforoRoot . '/library/XenForo/Autoloader.php');
 * XenForo_Autoloader::getInstance()->setupAutoloader($xenforoRoot . '/library');
 *
 * GeekPoint_Symfony::initializeXenforo($xenforoRoot, $startTime);
 * </code>
 *
 * @package GeekPoint_Symfony
 * @author Shadab Ansari
 */
class GeekPoint_Symfony
{
	/**
	 * The dependencies object
	 *
	 * @var XenForo_Dependencies_Abstract
	 */
	static protected $_dependencies = null;

	/**
	 * Initialize the XenForo Framework and setup the session;
	 * for use from outside the MVC framework.
	 *
	 * @param string $xenforoRoot The path to your XenForo instance
	 * @param float $startTime The current time as Unix Timestamp (Optional Param)
	 */
	public static function initializeXenforo($xenforoRoot, $startTime = NULL)
	{
		if (!$startTime)
		{
			$startTime = microtime(true);
		}

		// Initialize the XenForo application
		XenForo_Application::initialize($xenforoRoot . '/library', $xenforoRoot);
		XenForo_Application::set('page_start_time', $startTime);

		// Preload the dependencies for XenForo
		self::$_dependencies = new XenForo_Dependencies_Public();
		self::$_dependencies->preLoadData();

		// Initialize the Session using XenForo
		XenForo_Session::startPublicSession();
	}

	/**
	 * Get the internal dependencies object
	 *
	 * @return XenForo_Dependencies_Abstract
	 */
	public static function getDependencies()
	{
		return self::$_dependencies;
	}
}