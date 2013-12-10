<?php

class PiwikHooks {
	
	/**
	 * Initialize the Piwik Hook
	 * 
	 * @param Skin $skin
	 * @param string $text
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( Skin $skin, &$text ) {

		global $wgPiwikIDSite, $wgPiwikURL, $wgPiwikCustomJS, $wgPiwikDisableCookies;

		$user = $skin->getUser();

		// Is piwik disabled for bots?
		if ( $user->isAllowed( 'skip-piwik' ) ) {
			$text .= "<!-- Piwik tracking disabled for this user -->";
			return true;
		}

		// Missing configuration parameters
		if ( empty( $wgPiwikIDSite ) || empty( $wgPiwikURL ) ) {
			wfDebug( 'Piwik not configured correctly, make sure $wgPiwikIDSite and $wgPiwikURL are set' );
			$text .= "<!-- You need to set the settings for Piwik -->";
			return true;
		}

		$disableCookiesStr = $wgPiwikDisableCookies ? "\n" . '  _paq.push(["disableCookies"]);' : '';

		// Check if we have custom JS
		$customJs = '';
		if ( !empty( $wgPiwikCustomJS ) ) {

			// Check if array is given
			if ( !is_array( $wgPiwikCustomJS ) ) {
				$wgPiwikCustomJS = array( $wgPiwikCustomJS );
			}
			// Make empty string with a new line
			$customJs = "\n";
			// Store the lines in the $customJs line
			$customJs .= implode( '', $wgPiwikCustomJS );
		}

		// Piwik script
		$script = <<<PIWIK
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];{$disableCookiesStr}{$customJs}
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://{$wgPiwikURL}/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "{$wgPiwikIDSite}"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->

<!-- Piwik Image Tracker -->
<noscript><img src="http://{$wgPiwikURL}/piwik.php?idsite={$wgPiwikIDSite}&amp;rec=1" style="border:0" alt="" /></noscript>
<!-- End Piwik -->
PIWIK;

		$text .= $script;

		return true;
	}
}


