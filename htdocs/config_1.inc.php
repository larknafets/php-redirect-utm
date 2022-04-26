<?php
// --- MAIN CONFIG / DEFAULTS ---

/*

Parameters:
- debug -> activates debug mode, no redirect, no google analytics
- noutm -> no UTM parameters will be forwarded/redirected at all
- nopar -> no parameters will be forwarded/redirected at all
can be overwritten in other config files

*/

// Rediret base protocol-sub-domain
$redirect_base_default = 'https://sub.domain.com/'; // protocoll://sub.domain.com/
// UTM defaults
$utm_medium_default = '301';
$utm_campaign_default = 'redirects';
// Google Analytics Tracking (PHP)
$ga_do_tracking = 'yes'; // yes/no
$ga_tracking_id = ''; // tracking ID: UA-12345678-9
$ga_document_host = 'domain.com'; // host name/domain used in Google Analytics, eg. domain.com
$ga_anonymize_ip = 'yes'; // anonymize IP - yes/no
// URL parameters to forward
$par[] = 'utm_id'; // Campaign ID
$par[] = 'fbclid'; // Facebook Click ID
$par[] = 'gclsrc'; // Google Search Ads 360
$par[] = 'epik'; // Pinterest ID
$par[] = 'pt'; // Pic-Time embedded Slideshows/Videos: pt=ed

// --- /MAIN CONFIG / DEFAULTS ---
?>
