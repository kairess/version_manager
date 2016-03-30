<?php
function get_profile_picture($user_id) {
	$profile_picture = get_usermeta_value('profile_picture', $user_id);
	if(!$profile_picture) {
		$profile_picture = base_url('static/img/e_logo.png');
	} else {
		$profile_picture = base_url('uploads/profile/'.$profile_picture);
	}
	return $profile_picture;
}

function get_username($user_id) {
	$CI = &get_instance();
	$CI->db->where('id', $user_id);
	$user = $CI->db->get('user')->row();
	if(empty($user)) {
		return 'nonamed';
	} else {
		return $user->username;
	}
}
/* metadata helper */

function add_usermeta($key, $value, $user_id) {
	$CI = &get_instance();

	if(exist_usermeta($key, $user_id)) {
		$CI->db->set('value', $value);
		$CI->db->set('date', 'NOW()', FALSE);
		$CI->db->where(array('key'=>$key, 'user_id'=>$user_id));
		$CI->db->update('usermeta');
	} else {
		$CI->db->set('user_id', $user_id);
		$CI->db->set('key', $key);
		$CI->db->set('value', $value);
		$CI->db->set('date', 'NOW()', FALSE);
		$CI->db->insert('usermeta');
		return $CI->db->insert_id();
	}
}

function get_usermeta($key, $user_id) {
	$CI = &get_instance();
	
	$result = $CI->db->get_where('usermeta', array('key'=>$key, 'user_id'=>$user_id))->row();
	return $result;
}

function get_usermeta_value($key, $user_id) {
	$CI = &get_instance();

	$usermeta = get_usermeta($key, $user_id);
	if(isset($usermeta->key)) {
		return $usermeta->value;
	} else {
		return false;
	}
}

function exist_usermeta($key, $user_id) {
	$CI = &get_instance();

	$usermeta = get_usermeta($key, $user_id);
	if(isset($usermeta->key)) {
		return true;
	} else {
		return false;
	}
}

function add_postmeta($key, $value, $post_id) {
	$CI = &get_instance();

	if(exist_postmeta($key, $post_id)) {
		$CI->db->set('value', $value);
		$CI->db->set('date', 'NOW()', FALSE);
		$CI->db->where(array('key'=>$key, 'post_id'=>$post_id));
		$CI->db->update('postmeta');
	} else {
		$CI->db->set('post_id', $post_id);
		$CI->db->set('key', $key);
		$CI->db->set('value', $value);
		$CI->db->set('date', 'NOW()', FALSE);
		$CI->db->insert('postmeta');
		return $CI->db->insert_id();
	}
}

function get_postmeta($key, $post_id) {
	$CI = &get_instance();
	
	$result = $CI->db->get_where('postmeta', array('key'=>$key, 'post_id'=>$post_id))->row();
	return $result;
}

function get_postmeta_value($key, $post_id) {
	$CI = &get_instance();

	$postmeta = get_postmeta($key, $post_id);
	if(isset($postmeta->key)) {
		return $postmeta->value;
	} else {
		return false;
	}
}

function exist_postmeta($key, $post_id) {
	$CI = &get_instance();

	$postmeta = get_postmeta($key, $post_id);
	if(isset($postmeta->key)) {
		return true;
	} else {
		return false;
	}
}

/* end of meta functions */

function get_pretty_time($from, $to = null) {

	$output = '';
	$and = '';

	$from = strtotime($from);

	$to = (($to === null) ? (time()) : ($to));
	$to = ((is_int($to)) ? ($to) : (strtotime($to)));
	$from = ((is_int($from)) ? ($from) : (strtotime($from)));

	$units = array(
		"year"   => 29030400, // seconds in a year   (12 months)
		"month"  => 2419200,  // seconds in a month  (4 weeks)
		"week"   => 604800,   // seconds in a week   (7 days)
		"day"    => 86400,    // seconds in a day    (24 hours)
		"hour"   => 3600,     // seconds in an hour  (60 minutes)
		"minute" => 60,       // seconds in a minute (60 seconds)
		"second" => 1         // 1 second
	);

	$diff = abs($from - $to);
	$suffix = (($from > $to) ? ("from now") : ("ago"));

	if($diff > $units["week"]) {
		return date('Y-m-d', $from);
	} else if ($diff < 10) {
		return "just now";
	}
	foreach($units as $unit => $mult)
		if($diff >= $mult) {
			$output .= ", ".$and.intval($diff / $mult)." ".$unit.((intval($diff / $mult) == 1) ? ("") : ("s"));
			$diff -= intval($diff / $mult) * $mult;
			break;
		}

	$output .= " ".$suffix;
	$output = substr($output, strlen(", "));

	return $output;
}

/* curl request */
function curl_file_get_contents($URL, $is_post = false, $post = array(), $headers = array()) {
	$c = curl_init();
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	if($is_post) {
		curl_setopt( $c, CURLOPT_POST, true );
	}
	if(!empty($headers)) {
		curl_setopt( $c, CURLOPT_HTTPHEADER, $headers );
	}
	if(!empty($post)) {
		curl_setopt( $c, CURLOPT_POSTFIELDS, json_encode( $post ) );
	}

	curl_setopt($c, CURLOPT_URL, $URL);
	$contents = curl_exec($c);
	curl_close($c);

	if ($contents) return $contents;
	else return FALSE;
}

/* for debug */
function print_r_pre($result) {
	echo '<pre style="margin-left: 250px;">';
	print_r($result);
	echo '</pre>';
}

function get_hex($input) {
	preg_match_all('!\d+!', hash('haval128,3', $input), $numbers);
	$numbers_string = implode('', $numbers[0]);
	$numbers_hex = substr(dechex($numbers_string), -6);
	$result = str_pad($numbers_hex, 6, '0', STR_PAD_LEFT);

	return $result;
}