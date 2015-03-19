<?php
define('CARBON_PLUGIN_ROOT', dirname(__FILE__));
define('CARBON_PLUGIN_URL', plugin_dir_url(__FILE__));

include_once 'carbon-i18n.php';
include_once 'Carbon_Exception.php';
include_once 'Carbon_DataStore.php';
include_once 'Carbon_Container.php';
include_once 'Carbon_Container_CustomFields.php';
include_once 'Carbon_Container_ThemeOptions.php';
include_once 'Carbon_Container_TermMeta.php';
include_once 'Carbon_Container_UserMeta.php';
include_once 'Carbon_Field.php';
include_once 'Carbon_Field_Complex.php';
include_once 'Carbon_Widget.php';
include_once 'carbon-functions.php';

# Add Actions
add_action('wp_loaded', 'carbon_trigger_fields_register');
add_action('carbon_after_register_fields', 'carbon_init_containers');