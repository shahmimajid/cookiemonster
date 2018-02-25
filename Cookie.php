<?php

/*
Plugin Name: CookieMonster
Plugin URI: http://wordpress.org/#
Description: Define which URL parameters should be captured, and then creates a shortcode so that the value can be used in your Posts. 
Author: gsmith
Version: 1.51
Author URI: http://www.z-car.com/blog/2009/12/05/cookie-monster-wordpress-url-parameter-utility
*/

function cm_hello_cookie() {

    global $g_refcode;
    
    if ($cookies = cm_get_cookie_params()) {
	 if (count($cookies)>0) {
	 
		foreach ($cookies as $cookie => $default) {
			if ($cookie=='') break;
		    
			//$g_refcode = $_COOKIE[$cookie];
			
			if (isset($_GET[$cookie]) ) {
			if ($default[1]<>0)  {$cookie_time=time() + 60 * 60 * 24 * $default[1];} else { $cookie_time=0; }
			setcookie($cookie, $_GET[$cookie], $cookie_time, COOKIEPATH, COOKIE_DOMAIN);
			$g_refcode = $_GET[$cookie];
			$_COOKIE[$cookie] = $g_refcode;
			}
		}
     }
	}
}
add_action('init', 'cm_hello_cookie');

function cm_get_cookie_params() {

    return get_option("cm_cookie_list");
}

function cm_shortcode_handler($atts, $content, $code) {

    
    if ($cookies = cm_get_cookie_params()) {
	foreach ($cookies as $cookie => $default) {
	    
	    if ($cookie == $code) {
		$retval = isset($_COOKIE[$code]) ? $_COOKIE[$code] : $default[0];
	    }
	}
	return htmlspecialchars($retval);
    }
}

if ($cookies = cm_get_cookie_params()) {
    foreach ($cookies as $cookie => $default) {
	
	if ($cookie) add_shortcode($cookie, 'cm_shortcode_handler');
    }
}

if (!is_admin()) add_filter('widget_text', 'do_shortcode', 11);

if (!is_admin()) add_filter('widget_title', 'do_shortcode', 11);

//if (!is_admin()) add_filter('the_content', 'wpautop', 12);

if (!is_admin()) add_filter('the_title', 'do_shortcode', 11);

if (!is_admin()) add_filter('wp_title', 'do_shortcode', 11);

function cm_addPluginToSubmenu() {

    add_options_page("CookieMonster Options", "CookieMonster", "manage_options", "CookieMonster", "cm_admin");
}
add_action('admin_menu', 'cm_addPluginToSubmenu');

function cm_add_settings_link($links, $file) {

    static $this_plugin;
    
    if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);
    
    if ($file == $this_plugin) {
	$settings_link = '<a href="options-general.php?page=CookieMonster">' . "Settings". '</a>';
	array_unshift($links, $settings_link);
    }
    return $links;
}
add_filter('plugin_action_links', 'cm_add_settings_link', 10, 2);

function cm_admin() {
    $invalid = array('author','author_name','caller_get_posts','cat','category_name','category__and','category__in','category__not_in','day','hour','meta_compare','meta_key','meta_value','minute','monthnum','name','nopaging','order','orderby','p','paged','pagename','page_id','posts_per_page','post_parent','post_status','post_type','post__in','post__not_in','second','showposts','tag','tag_id','tag_slug__and','tag_slug__in','tag__and','tag__in','tag__not_in','w','year');
	
    $numcookies = isset($_POST["numcookies"]) ? $_POST["numcookies"] :0;
    
    if (isset($_POST['update_cookies']) && $_POST['update_cookies'] == 'Y') {
		
	for ($x = 1;$x <= $numcookies;$x++) {
	    if (in_array($_POST["cookie_param" . $x],$invalid)) {
		echo '<br> <font color = "red">Error!  Cannot set cookie to reserved keyword '.$_POST["cookie_param" . $x].'</font> <br>';
		continue;
	    }
	    if (strlen($_POST["cookie_time" . $x])>0) {$cookie_time=$_POST["cookie_time" . $x];} else {$cookie_time=30;}
	    $cookie_list[$_POST["cookie_param" . $x]] = array($_POST["cookie_default" . $x],$cookie_time);
	}
	update_option("cm_cookie_list", $cookie_list);
?>
	<div class="updated"><p><strong><?php echo 'Options saved.'; ?></strong></p></div>
	<?php
    }
?>

<div class="wrap">
<?php echo "<h2>" . 'CookieMonster Options' . "</h2>";
    $x = 1 ?>

<form name="cookie_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="update_cookies" value="Y">
<?php echo "<h4>" .'CookieMonster' . "</h4>";
  
    echo '<p>Enter new parameters to track (i.e. affcode) and click "Update Options".<br/>Leave the Parameter field empty and click "Update Options" to delete it.<br/>Default values will appear when the shortcode (i.e. [affcode]) is used and no cookie value has been set.</p>';
    
    if ($cookies = cm_get_cookie_params()) {
	foreach ($cookies as $cookie => $default) {
		$cookie_value='';
	    if (isset($_COOKIE[$cookie])) $cookie_value=$_COOKIE[$cookie];
	    if ($cookie) {
		echo "<p> URL Parameter " . $x . " : <input type='text' name='cookie_param" . $x . "' value='" . $cookie . "' size='20'> defaults to <input type='text' name='cookie_default" . $x . "' value='" . $default[0] . "' size='20'> cookie duration is (defaults to 30 days) <input type='text' name='cookie_time" . $x . "' value='" . $default[1] . "' size='20'> days.  Set to 0 for session cookie. <br> Your cookie is currently set to " . $cookie_value . "</p>\n";
		$x++;
	    }
	}
    }
    echo "<p> URL Parameter " . $x . " : <input type='text' name='cookie_param" . $x . "' size='20'> defaults to <input type='text' name='cookie_default" . $x . "' size='20'> cookie duration is (defaults to 30 days) <input type='text' name='cookie_time" . $x . "' value='' size='20'> days.  Set to 0 for session cookie. <br> Your cookie is currently set to </p>\n";
    echo "<input type='hidden' name='numcookies' value='$x'>\n";
?>
    <p class="submit">
    <input type="submit" name="Submit" value="<?php echo 'Update Options'; ?>" />
    </p>
</form>
<hr/>
</div>
<?php
}
?>