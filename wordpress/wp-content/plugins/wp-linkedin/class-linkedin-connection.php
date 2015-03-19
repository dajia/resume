<?php

if (!defined('WP_LINKEDIN_PROFILE_CACHE_TIMEOUT')) {
	if (defined('WP_LINKEDIN_CACHETIMEOUT')) {
		define('WP_LINKEDIN_PROFILE_CACHE_TIMEOUT', WP_LINKEDIN_CACHETIMEOUT);
	} else {
		define('WP_LINKEDIN_PROFILE_CACHE_TIMEOUT', 43200); // 12 hours
		define('WP_LINKEDIN_CACHETIMEOUT', WP_LINKEDIN_PROFILE_CACHE_TIMEOUT); // compatibility for extensions
	}
}

if (!defined('WP_LINKEDIN_UPDATES_CACHE_TIMEOUT')) {
	define('WP_LINKEDIN_UPDATES_CACHE_TIMEOUT', 1800); // 30 minutes
}

// Let people define their own APPKEY if needed
if (!defined('WP_LINKEDIN_APPKEY')) {
	define('WP_LINKEDIN_APPKEY', get_option('wp-linkedin_appkey'));
	define('WP_LINKEDIN_APPSECRET', get_option('wp-linkedin_appsecret'));
}

class WPLinkedInConnection {

	public function __construct() {
		$this->app_key = WP_LINKEDIN_APPKEY;
		$this->app_secret = WP_LINKEDIN_APPSECRET;
	}

	public function set_cache($key, $value, $expires=0) {
		return update_option($key, $value);
	}

	public function get_cache($key, $default=false) {
		return get_option($key, $default);
	}

	public function delete_cache($key) {
		return delete_option($key);
	}

	public function set_last_error($error=false) {
		if ($error) {
			if (is_wp_error($error)) $error = $error->get_error_message();

			$this->set_cache('wp-linkedin_last_error', $error);
			error_log('[WP LinkedIn] ' . $error);
		} else {
			$this->delete_cache('wp-linkedin_last_error');
		}
	}

	public function get_last_error() {
		return $this->get_cache('wp-linkedin_last_error');
	}

	public function get_access_token() {
		return $this->get_cache('wp-linkedin_oauthtoken');
	}

	public function invalidate_access_token() {
		$this->delete_cache('wp-linkedin_oauthtoken');
	}

	public function get_token_process_url($r=false) {
		$query = array();
		$rules = get_option('rewrite_rules');

		if (is_array($rules) and !empty($rules)) {
			// we have rewrite rules activated
			$url = home_url('/oauth/linkedin/');
		} else {
			$url = home_url();
			$query['oauth'] = 'linkedin';
		}

		if ($r) {
			// cleanup the url
			$clean = array('settings-updated' => false, 'clear_cache' => false,
						'message' => false, 'oauth_status' => false,
						'oauth_message' => false);
			$r = add_query_arg($clean, $r);
			$query['r'] = $r;
		}

		if (empty($query)) {
			return $url;
		} else {
			return $url . '?' . http_build_query($query);
		}
	}

	public function set_access_token($code, $redirect_uri=false) {
		if (!$redirect_uri) $redirect_uri = $_SERVER["REQUEST_URI"];
		$redirect_uri = $this->get_token_process_url($redirect_uri);

		$this->set_last_error();
		$url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query(array(
			'grant_type' => 'authorization_code',
			'code' => $code,
			'redirect_uri' => $redirect_uri,
			'client_id' => $this->app_key,
			'client_secret' => $this->app_secret), '', '&');

		if (LI_DEBUG) echo '<!-- token access url: ' . $url . ' -->';

		$response = wp_remote_get($url, array('sslverify' => LINKEDIN_SSL_VERIFYPEER));
		if (!is_wp_error($response)) {
			$body = json_decode($response['body']);

			if (isset($body->access_token)) {
				$this->set_cache('wp-linkedin_invalid_token_mail_sent', false);
				return $this->set_cache('wp-linkedin_oauthtoken', $body->access_token, $body->expires_in);
			} elseif (isset($body->error)) {
				return new WP_Error('set_access_token', $body->error . ': ' . $body->error_description);
			} else {
				return new WP_Error('set_access_token', __('An unknown error has occured and no token was retrieved.', 'wp-linkedin'));
			}
		} else {
			return $response;
		}
	}

	public function is_access_token_valid() {
		return $this->get_access_token() !== false;
	}

	public function get_state_token() {
		$time = intval(time() / 172800);
		$salt = (defined('NONCE_SALT')) ? NONCE_SALT : SECRET_KEY;
		return sha1('linkedin-oauth' . $salt . $time);
	}

	public function check_state_token($token) {
		return ($token == $this->get_state_token());
	}

	public function get_authorization_url($redirect_uri=false) {
		$scope = array('r_fullprofile', 'rw_nus');
		$scope = apply_filters('linkedin_scope', $scope);

		if (!$redirect_uri) $redirect_uri = $_SERVER["REQUEST_URI"];
		$redirect_uri = $this->get_token_process_url($redirect_uri);

		return 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query(array(
				'response_type' => 'code',
				'client_id' => $this->app_key,
				'scope' => implode(' ', $scope),
				'state' => $this->get_state_token(),
				'redirect_uri' => $redirect_uri), '', '&');
	}

	public function clear_cache() {
		$this->delete_cache('wp-linkedin_profile_cache');
		$this->delete_cache('wp-linkedin_updates_cache');
	}

	public function get_profile($options='id', $lang='') {
		$profile = false;
		$cache_key = sha1($options.$lang);

		$cache = $this->get_cache('wp-linkedin_profile_cache');
		if (!is_array($cache)) $cache = array();

		// Do we have an up-to-date profile?
		if (isset($cache[$cache_key])) {
			$expires = $cache[$cache_key]['expires'];
			$profile = $cache[$cache_key]['profile'];
			// If yes let's return it.
			if (time() < $expires) return $profile;
		}

		// Else, let's try to fetch one.
		$url = "https://api.linkedin.com/v1/people/~:($options)";
		$fetched = $this->api_call($url, $lang);

		if (!is_wp_error($fetched)) {
			$profile = $fetched;

			$cache[$cache_key] = array(
					'expires' => time() + WP_LINKEDIN_PROFILE_CACHE_TIMEOUT,
					'profile' => $profile);
			$this->set_cache('wp-linkedin_profile_cache', $cache);
			return $profile;
		} elseif ($profile) {
			// If we cannot fetch one, let's return the outdated one if any.
			return $profile;
		} else {
			// Else just return the error
			return $fetched;
		}
	}

	public function get_network_updates($count=50, $only_self=true) {
		$updates = false;
		$cache = $this->get_cache('wp-linkedin_updates_cache');

		if ($cache && is_array($cache)) {
			if ($cache['count'] == $count &&
					$cache['only_self'] == $only_self) {
				$expires = $cache['expires'];
				$updates = $cache['updates'];
				if (time() < $expires) return $updates;
			}
		}

		$params = array('count' => $count);
		if ($only_self) $params['scope'] = 'self';
		$fetched = $this->api_call('https://api.linkedin.com/v1/people/~/network/updates', '', $params);

		if (!is_wp_error($fetched)) {
			$updates = $fetched;

			$cache = array(
					'count' => $count,
					'only_self' => $only_self,
					'expires' => time() + WP_LINKEDIN_UPDATES_CACHE_TIMEOUT,
					'updates' => $updates);
			$this->set_cache('wp-linkedin_updates_cache', $cache);
			return $updates;
		} elseif ($updates) {
			// If we cannot fetch one, let's return the outdated one if any.
			return $updates;
		} else {
			// Else just return the error
			return $fetched;
		}
	}

	public function api_call($url, $lang='', $params=false) {
		$access_token = $this->get_access_token();

		if ($access_token) {
			if (!is_array($params)) $params = array();
			$params['oauth2_access_token'] = $access_token;
			$url .= '?' . http_build_query($params, '', '&');

			$headers = array(
					'Content-Type' => 'text/plain; charset=UTF-8',
					'x-li-format' => 'json');

			if (!empty($lang)) {
				$headers['Accept-Language'] = str_replace('_', '-', $lang);
			}

			$response = wp_remote_get($url, array('sslverify' => LINKEDIN_SSL_VERIFYPEER, 'headers' => $headers));
			if (!is_wp_error($response)) {
				$return_code = $response['response']['code'];
				$body = json_decode($response['body']);

				if ($return_code == 200) {
					$this->set_last_error();
					return $body;
				} else{
					if ($return_code == 401) {
						// Invalidate token
						$this->invalidate_access_token();
						$this->send_invalid_token_email();
					}

					if (isset($body->message)) {
						$error = new WP_Error('api_call', $body->message);
					} else {
						$error = new WP_Error('api_call', sprintf(__('HTTP request returned error code %d.', 'wp-linkedin'), $return_code));
					}

					$this->set_last_error($error);
					return $error;
				}
			} else {
				$this->set_last_error($response);
				return new WP_Error('api_call', $response->get_error_message());
			}
		} else {
			$this->send_invalid_token_email();
			return new WP_Error('api_call', __('No token or token has expired.', 'wp-linkedin'));
		}
	}

	public function send_invalid_token_email() {
		if (LINKEDIN_SENDMAIL_ON_TOKEN_EXPIRY && !$this->get_cache('wp-linkedin_invalid_token_mail_sent')) {
			$blog_name = get_option('blogname');
			$admin_email = get_option('admin_email');
			$header = array("From: $blog_name <$admin_email>");
			$subject = '[WP LinkedIn] ' . __('Invalid or expired access token', 'wp-linkedin');

			$message = __('The access token for the WP LinkedIn plugin is either invalid or has expired, please click on the following link to renew it.', 'wp-linkedin');
			$message .= "\n\n" . $this->get_authorization_url();
			$message .= "\n\n" . __('This link will only be valid for a limited period of time.', 'wp-linkedin');
			$message .= "\n" . __('-Thank you.', 'wp-linkedin');

			$sent = wp_mail($admin_email, $subject, $message, $header);
			$this->set_cache('wp-linkedin_invalid_token_mail_sent', $sent);
		}
	}

}

function wp_linkedin_connection() {
	return apply_filters('linkedin_connection', new WPLinkedInConnection());
}