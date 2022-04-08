<?php
// --- CUSTOM RULES ---

// Wordpress check: "wp-" in path
if (strpos($path_stripped,'wp-')!==false) {
  show_error_page('404');
}

// Short URLs from Wordpress plugin (digits) will have no utm parameters
if (ctype_digit($path_stripped) && strlen($path_stripped)==5) {
  $no_utm = 'yes';
}

// --- /CUSTOM RULES ---
?>
