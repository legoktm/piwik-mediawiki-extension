<?php
/**
 * Inserts Piwik script into MediaWiki pages for tracking and adds some stats
 *
 * @file
 * @ingroup Extensions
 * @author Isb1009 <isb1009 at gmail dot com>
 * @author DaSch <dasch@daschmedia.de>
 * @author Youri van den Bogert <yvdbogert@archixl.nl>
 * @author Kunal Mehta <legoktm@gmail.com>
 * @copyright © 2008-2010 Isb1009
 * @licence GNU General Public Licence 2.0
 * @package Extensions
 */

if ( !defined( 'MEDIAWIKI' ) )  {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * site id in Piwik
 * @var string
 */
$wgPiwikIDSite = "";

/**
 * URL to Piwik installation
 * @var string
 */
$wgPiwikURL = "";

/**
 * @see README for full information
 * This can be either an array or a string
 * if a string, it will automatically be converted
 * into an array
 * @var string|array
 */
$wgPiwikCustomJS = "";

/**
 * Whether to disable cookies
 * @see README for more information
 * @var bool
 */
$wgPiwikDisableCookies = false;


$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Piwik Integration',
	'version'        => '3.0',
	'author'         => array(
		'Isb1009',
		'[http://www.daschmedia.de DaSch]',
		'[https://github.com/YOUR1 Youri van den Bogert]',
		'Kunal Mehta',
	),
	'description'	 => 'Adding Piwik Tracking Code',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Piwik_Integration',
);

$wgAutoloadClasses['PiwikHooks'] = __DIR__ . '/Piwik.hooks.php';

$wgHooks['SkinAfterBottomScripts'][]  = 'PiwikHooks::ononSkinAfterBottomScripts';

$wgGroupPermissions['sysop']['skip-piwik'] = true;
$wgGroupPermissions['bot']['skip-piwik'] = true;
$wgAvailableRights[] = 'skip-piwik';
