<?php
// --- CUSTOM UTM REDIRECTS ---

/*
Priority:
3. UTM set by URL parameter
2. UTM overwritten by custom redirects
1. UTM overwritten by short UTM

Write utm string to append to redirect url, fill variables if any
=> https://ga-dev-tools.appspot.com/campaign-url-builder/
Infos:
https://www.121watt.de/analyse-optimierung/kampagnentagging-google-analytics/

Source:
- facebook
- twitter
- instagram
- google
- bing
- yahoo
- t-online
- xing
- linkedin
- email
- newsletter
- youtube
- vimeo
- plakat
- flyer

Medium:
- direct => Direktzugriff (nicht nutzen!)
- organic => natürliche Suche (nicht nutzen!)
- referral
- redirect
- email
- post
- cpa
- cpc => bezahlte Werbung
- cpm
- cpv
- print
- offline
- social
- feed
- banner
- display
- affiliate
- ebook
- partner
- qr-code
- profile

Term: // optionl - Keyword, Zielgruppe o.ä, Datum Newsletter Sendout, bspw. auch link.description bei post
- 2020-09-15 // e.g. for newsletter

----------------------------------

$utm_source = 'pic-time';
$utm_medium = 'email';
$utm_content = ''; // optional - Kurzbegriff Inhalt, AB-Testing
$utm_term = ''; // optionl - Keyword, Zielgruppe o.ä, bspw. auch link-description bei post
$utm_campaign = 'referrals';
$redirect_base = 'https://www.hochzeitsfotograf-butjadingen.de/';
$redirect_path = 'fotonutzung/'; // "subsite/"
$no_utm = 'no' // yes/no
$no_par = 'no' // yes/no

Für extern nur:
$redirect_external = 'https://twitter.com/farbgelichtet/';
*/

// REDIRECTs based on domain
if ($httphost=='domain2.com') {
  $redirect_base = 'https://www.domain.com/';
  $redirect_path = '';
} else if ($httphost=='domain3.com') {
  $redirect_base = 'https://www.domain.com/';
  $redirect_path = 'page';
} else if ($httphost=='domain4.com') {
  $redirect_base = 'https://www.domain.com/';
  //$redirect_path = ''; // keep existing folder/page structure
}

// REDIRECTs based on page/path ('/' stripped)
if ($path_stripped=='instagram' && ($httphost=='domain2.com' || $httphost=='domain3.com')) {
  $redirect_external = 'https://www.instagram.com/domain3-insta/';
} elseif ($path_stripped=='instagram') {
  $redirect_external = 'https://www.instagram.com/domain1-insta/';
} elseif ($path_stripped=='facebook') {
    $redirect_external = 'https://www.facebook.com/domain1-fb/';
} elseif ($path_stripped=='pinterest') {
  $redirect_external = 'https://www.pinterest.de/domain1-pinterest/';
} elseif ($path_stripped=='twitter') {
  $redirect_external = 'https://twitter.com/domain1-twitter/';
} elseif ($path_stripped=='with-utm') {
  $redirect_external = 'https://www.domain3.de/folder?utm_source=facebook';
} elseif ($path_stripped=='another-path') {
  $utm_source = 'the-source';
  $utm_medium = 'the-medium';
  $utm_campaign = 'the-cumpaign';
  $redirect_path = 'page/'; // "subsite/"
}

// REDIRECTs based on referer domain
/*if ($httpreferer=='instagram.com' && $path_stripped=='hi') {
  $utm_source = 'instagram';
  $utm_medium = 'bio-link';
  $utm_campaign = 'referrals';
  $redirect_path = 'links/instagram/';
}*/

// REDIRECTs based on parameter (?parameter)
if (isset($_GET['tw'])) {
  $utm_source = 'twitter';
  $utm_medium = 'referral';
  $utm_campaign = 'referrals';
  $redirect_path = ''; // "subsite/"
} else
if (isset($_GET['fb'])) {
  $utm_source = 'facebook';
  $utm_medium = 'referral';
  $utm_campaign = 'referrals';
  $redirect_path = ''; // "subsite/"
} else
if (isset($_GET['ig'])) {
  $utm_source = 'instagram';
  $utm_medium = 'referral';
  $utm_campaign = 'referrals';
  $redirect_path = ''; // "subsite/"
} else
if (isset($_GET['gmb'])) {
  $utm_source = 'google';
  $utm_medium = 'my-business';
  $utm_campaign = 'referrals';
  $redirect_path = ''; // "subsite/"
} else
if (isset($_GET['email'])) {
  $utm_source = 'signature';
  $utm_medium = 'email';
  $utm_campaign = 'referrals';
  $redirect_path = ''; // "subsite/"
} else
}

// --- /CUSTOM UTM REDIRECTS ---
?>
