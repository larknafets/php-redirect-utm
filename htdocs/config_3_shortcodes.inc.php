<?php
// --- UTM SHORTCODES ---

/*

Parameter 'u' indicates shortcodes
Example:
http://www.domain.com/folder/file.html?u=111222333

111 -> utm_source
222 -> utm_medium
333 -> utm_campaign

Shortcodes will overwrite existing or set utm parameters  by config_2_redirects

*/

$utm['source']['001'] = 'facebook';
$utm['source']['002'] = 'twitter';
$utm['source']['003'] = 'instagram';
$utm['source']['004'] = 'google';
$utm['source']['005'] = 'bing';
$utm['source']['006'] = 'yahoo';
$utm['source']['007'] = 'pinterest';
$utm['source']['008'] = 'xing';
$utm['source']['009'] = 'linkedin';
$utm['source']['010'] = 'email';
$utm['source']['011'] = 'newsletter';
$utm['source']['012'] = 'youtube';
$utm['source']['013'] = 'vimeo';
$utm['source']['014'] = 'plakat';
$utm['source']['015'] = 'flyer';

$utm['medium']['001'] = 'referral';
$utm['medium']['002'] = 'redirect';
$utm['medium']['003'] = 'email';
$utm['medium']['004'] = 'post';
$utm['medium']['005'] = 'social';
$utm['medium']['006'] = 'banner';
$utm['medium']['007'] = 'cpc';
$utm['medium']['008'] = 'display';
$utm['medium']['009'] = 'affiliate';
$utm['medium']['010'] = 'ebook';
$utm['medium']['011'] = 'partner';
$utm['medium']['012'] = 'qr-code';
$utm['medium']['013'] = 'feed';
$utm['medium']['014'] = 'print';
$utm['medium']['015'] = 'offline';
$utm['medium']['016'] = 'profile';
$utm['medium']['017'] = 'bio-link';

$utm['campaign']['001'] = 'referrals';
$utm['campaign']['002'] = 'redirects';
$utm['campaign']['003'] = 'flyer-campaign';

$utm['source']['999'] = 'test';
$utm['medium']['999'] = 'test';
$utm['campaign']['999'] = 'test';

// --- /UTM SHORTCODES ---
?>
