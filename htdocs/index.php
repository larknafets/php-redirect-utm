<?php

$redirect_base_dir = dirname(__FILE__).'/';

// --- TEST ---
$debug='no';
if (isset($_GET['debug'])) { $debug = 'yes'; }

// Init variables #1
$par = array();
$utm = array();

// --- MAIN CONFIG / DEFAULTS ---
require_once($redirect_base_dir.'config_1.inc.php');
// --- /MAIN CONFIG / DEFAULTS ---

// Init variables #2 - Reset variables
$redirect_external = '';
$no_utm = '';
$no_par = '';
$redirect_base = $redirect_base_default;
$redirect_path = '';
$parameter_string = '';
$par_misc = '';

// Get host/domain (without www)
$httphost = str_replace('www.','',strtolower($_SERVER['HTTP_HOST']));

// Get referer (without www)
$httpreferer = str_replace('www.','',parse_url($_SERVER['HTTP_REFERER'],PHP_URL_HOST));

// Get UTM (Urchin Tracking Module) parameters if exist, else set to default
$utm_source = (get_get_var('utm_source')!='') ? get_get_var('utm_source') : $httphost;
$utm_medium = (get_get_var('utm_medium')!='') ? get_get_var('utm_medium') : $utm_medium_default;
$utm_campaign = (get_get_var('utm_campaign')!='') ? get_get_var('utm_campaign') : $utm_campaign_default;
$utm_content = get_get_var('utm_content');
$utm_term = get_get_var('utm_term');
// Get Google Ads ID - will be passed to Google Analytics
$par_gclid = get_get_var('gclid');
// Get Google Display Ads ID (former DoubleClick) - will be passed to Google Analytics
$par_dclid = get_get_var('dclid');
// Get encoded UTM parameters
$utm_encoded = (strlen(get_get_var('u'))==9 && is_numeric(get_get_var('u'))) ? get_get_var('u') : '';

// Get path
if (isset($_GET['path']) && $_GET['path']!='') {
  $redirect_path = $_GET['path'];
  $path_stripped = str_replace('/','',$_GET['path']); // strips out ALL "/"
  $ga_document_path = '/'.$redirect_path;
} else {
  $path_stripped = '';
  $ga_document_path = '/';
}

// Get parameters for no utm and no other parameters variable (can be overwritten)
if (isset($_GET['noutm'])) { $no_utm = 'yes'; }
if (isset($_GET['nopar'])) { $no_par = 'yes'; }

// Get miscellaneous above defined URL paramaters to forward/redirect/refer
foreach ($par as $misc) {
  if (get_get_var($misc)!='') {
    $par_misc .= $misc.'='.get_get_var($misc).'&';
  }
}

// --- TEST ---
if ($debug=='yes') {
  echo '<p>REQUEST_URI: '.$_SERVER['REQUEST_URI'].'</p>';
  echo '<p>$httphost: '.$httphost.'</p>';
  echo '<p>$httpreferer: '.$httpreferer.'</p>';
  echo '<p>$redirect_path: '.$redirect_path.'</p>';
  echo '<p>$path_stripped: '.$path_stripped.'</p>';
  echo '<p>$ga_document_path: '.$ga_document_path.'</p>';
  echo '<p>$utm_source: '.$utm_source.'</p>';
  echo '<p>$utm_medium: '.$utm_medium.'</p>';
  echo '<p>$utm_content: '.$utm_content.'</p>';
  echo '<p>$utm_term: '.$utm_term.'</p>';
  echo '<p>$utm_campaign: '.$utm_campaign.'</p>';
  echo '<p>$par_gclid: '.$par_gclid.'</p>';
  echo '<p>$par_dclid: '.$par_dclid.'</p>';
  echo '<p>$par_misc: '.$par_misc.'</p>';
  echo '<p>$utm_encoded: '.$utm_encoded.'</p>';
}
// --- /TEST ---

// --- GOOGLE ANALYTICS TRACKING ---
send_ga_pageview();
// --- /GOOGLE ANALYTICS TRACKING ---

// --- CUSTOM UTM REDIRECTS ---
require_once($redirect_base_dir.'config_2_redirects.inc.php');
// --- /CUSTOM UTM REDIRECTS ---

// --- UTM SHORTCODES ---
// E.g. http://domain.com/folder/file.html?u=111222333 )SrcMedCam
$utm['source']['000'] = '';
$utm['medium']['000'] = '';
$utm['campaign']['000'] = '';
require_once($redirect_base_dir.'config_3_shortcodes.inc.php');
// Check encoded UTM parameters
if ($utm_encoded!='') {
  $utm_source = get_short_utm_params('source',$utm_encoded);
  $utm_medium = get_short_utm_params('medium',$utm_encoded);
  $utm_campaign = get_short_utm_params('campaign',$utm_encoded);
}
// --- /UTM SHORTCODES ---

// --- CUSTOM RULES ---
require_once($redirect_base_dir.'config_4_customrules.inc.php');
// --- /CUSTOM RULES ---

// --- REDIRECT ---
// Write utm string to append to redirect url; at least utm_source for Google Analytics is needed
$par_sep = (strpos($redirect_path,'?')!==false) ? '&' : '?';
if ($no_utm!='yes' && $utm_source!='') {
  $parameter_string = 'utm_source='.$utm_source.'&';
  if ($utm_medium!='') { $parameter_string .= 'utm_medium='.$utm_medium.'&'; }
  if ($utm_content!='') { $parameter_string .= 'utm_content='.$utm_content.'&'; }
  if ($utm_term!='') { $parameter_string .= 'utm_term='.$utm_term.'&'; }
  if ($utm_campaign!='') { $parameter_string .= 'utm_campaign='.$utm_campaign.'&'; }
}
if ($no_par!='yes') {
  if ($par_gclid!='') { $parameter_string .= 'gclid='.$par_gclid.'&'; }
  if ($par_dclid!='') { $parameter_string .= 'dclid='.$par_dclid.'&'; }
  $parameter_string .= $par_misc;
}
if ($parameter_string!='') {
  $parameter_string = $par_sep.rtrim($parameter_string,'&');
}
// Put it all together
if ($redirect_external!='') {
  $location_redirect = $redirect_external;
} else {
  $location_redirect = $redirect_base.$redirect_path.$parameter_string;
}
// --- TEST ---
if ($debug=='yes') {
  echo '<p>$no_utm: '.$no_utm.'</p>';
  echo '<p>$utm_source: '.$utm_source.'</p>';
  echo '<p>$utm_medium: '.$utm_medium.'</p>';
  echo '<p>$utm_content: '.$utm_content.'</p>';
  echo '<p>$utm_term: '.$utm_term.'</p>';
  echo '<p>$utm_campaign: '.$utm_campaign.'</p>';
  echo '<p>$par_gclid: '.$par_gclid.'</p>';
  echo '<p>$par_dclid: '.$par_dclid.'</p>';
  echo '<p>$redirect_base: '.$redirect_base.'</p>';
  echo '<p>$redirect_path: '.$redirect_path.'</p>';
  echo '<p>$parameter_string: '.$parameter_string.'</p>';
  die($location_redirect);
}
// --- /TEST ---
// Output redirect header
header('X-Redirect-By: '.strtolower($_SERVER['HTTP_HOST']));
header('Content-Type: text/html; charset=UTF-8');
header('Date: '.gmdate('D, d M Y H:i:s', time()).' GMT');
header('Expires: '.gmdate('D, d M Y H:i:s', time()-(60*60*24)).' GMT');
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate, s-maxage=0, proxy-revalidate');
header('Referrer-Policy: unsafe-url');
header('Location: '.$location_redirect,true,301);
header('Connection: close');
// --- /REDIRECT ---

// --- EXIT ---
exit;

// --- FUNCTIONS ---
function show_error_page($the_http_error) {
  if ($the_http_error=='200') {
    header('HTTP/1.1 200 Found',true,200);
    $error_text = '200 Found';
  } elseif ($the_http_error=='401') {
      header('HTTP/1.1 401 Unauthorized',true,401);
      $error_text = '401 Unauthorized';
  } elseif ($the_http_error=='403') {
    header('HTTP/1.1 403 Forbidden',true,403);
    $error_text = '403 Forbidden';
  } elseif ($the_http_error=='500') {
    header('HTTP/1.1 500 Internal Server Error',true,500);
    $error_text = '500 Internal Server Error';
  } else {
    header('HTTP/1.1 404 Not Found',true,404);
    $error_text = '404 Not Found';
  }
	header('X-Robots-Tag: none');
  header('Content-Type: text/html; charset=UTF-8');
	header('Date: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	header('Expires: '.gmdate('D, d M Y H:i:s', time()-(60*60*24)).' GMT');
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate, s-maxage=0, proxy-revalidate');
	header('Connection: close');
	echo '<!DOCTYPE html>
<html><head>
<meta http-equiv="cache-control" content="private, no-cache, no-store, max-age=0, must-revalidate, s-maxage=0, proxy-revalidate" />
<meta name="robots" content="none">
<title>'.$error_text.'</title></head><body>'.$error_text.'</body></html>
';
  exit;
}

function get_short_utm_params($utmkey,$utmcode) {
  global $utm;
  $utmvalues = str_split($utmcode,3);
  switch ($utmkey) {
    case 'source':
      $utmvalue = $utmvalues[0];
      break;
    case 'medium':
      $utmvalue = $utmvalues[1];
      break;
    case 'campaign':
      $utmvalue = $utmvalues[2];
      break;
    default:
      $utmvalue = 'not set';
  }
  $the_utm_value = $utm[$utmkey][$utmvalue];
  if (isset($the_utm_value) && $the_utm_value!='') {
    return $the_utm_value;
  } else {
    return;
  }
}

function send_ga_pageview() {
  global $ga_do_tracking, $ga_tracking_id, $ga_document_host, $ga_anonymize_ip, $ga_document_path, $debug;
  if ($debug!='yes' && $ga_do_tracking=='yes' && $ga_tracking_id!='' && $ga_document_host!='') {
    $fields_string = '';
    $fields = array (
      'v' => 1,
      'tid' => $ga_tracking_id,
      'cid' => gen_uuid(),
      't' => 'pageview',
      'dh' => $ga_document_host,
      'dp' => urlencode($ga_document_path)
    );
    if ($ga_anonymize_ip=='yes') {
      $fields['aip'] = 1;
    } else {
      $fields['uip'] = get_user_ip();
    }
    $fields['cs'] = urlencode(get_get_var('utm_source'));
    $fields['cm'] = urlencode(get_get_var('utm_medium'));
    $fields['cn'] = urlencode(get_get_var('utm_campaign'));
    $fields['ck'] = urlencode(get_get_var('utm_term'));
    $fields['cc'] = urlencode(get_get_var('utm_content'));
    $fields['dr'] = urlencode($_SERVER['HTTP_REFERER']);
    $fields['gclid'] = get_get_var('gclid');
    $fields['dclid'] = get_get_var('dclid');
    foreach($fields as $key=>$value) {
      if ($value!='') {
        $fields_string .= $key.'='.$value.'&';
      }
    }
    rtrim($fields_string,'&');
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_POST,count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS,utf8_encode($fields_string));
    curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    if ($debug=='yes') {
      $ch_url = 'https://ssl.google-analytics.com/debug/collect';
    } else {
      $ch_url = 'https://ssl.google-analytics.com/collect';
    }
    curl_setopt($ch,CURLOPT_URL,$ch_url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
    curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $ch_return = curl_exec($ch);
    curl_close($ch);
    // --- TEST ---
    if ($debug=='yes') {
      echo '<p>';
      var_dump($ch_return);
      echo '</p>';
    }
    // --- /TEST ---
  }
}

// get the current user ip due to proxies
function get_user_ip() {
  if(!isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    return $_SERVER['REMOTE_ADDR'];
  } else {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
}

// get a get-parameter or return empty string
function get_get_var($getvar) {
  if(isset($_GET[$getvar])) {
    return $_GET[$getvar];
  } else {
    return '';
  }
}

function gen_uuid() {
  return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0,0xffff), mt_rand(0,0xffff), mt_rand(0,0xffff),
    mt_rand(0,0x0fff) | 0x4000,
    mt_rand(0,0x3fff) | 0x8000,
    mt_rand(0,0xffff), mt_rand(0,0xffff), mt_rand(0,0xffff )
  );
}

// --- THE END ---
?>
