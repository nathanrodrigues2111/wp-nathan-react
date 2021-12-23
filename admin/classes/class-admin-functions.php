<?php

class WpnatAdminFunctions
{
    public static $instance = null;

    public static function get_instance()
    {
        if (self::$instance !== null) {
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }

    public function __construct()
    {
        add_action('admin_menu', [ $this, 'wpnat_add_toplevel_menu' ]);
        add_action('admin_enqueue_scripts', [ $this, 'wpnat_enqueue_scripts' ]);
        add_action('rest_api_init', [ $this, 'wpnat_create_rest_routes' ]);
        register_deactivation_hook( WPNAT_MAIN_FILE, array( $this, 'wpnat_plugin_deactivate' ) );
    }

    /**
    * Enqueue admin styles and scripts
    */

    public function wpnat_enqueue_scripts($hook)
    {
        if ('toplevel_page_wpnat-settings' !== $hook) {
            return;
        }

        wp_enqueue_script('wp-nathan-react', WPNAT_URL . 'dist/bundle.js', [ 'jquery', 'wp-element' ], '', true);
        wp_localize_script('wp-nathan-react', 'appLocalizer', [
            'apiUrl' => home_url('/wp-json'),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
    }

    /**
    * Creating rest routes
    */
    public function wpnat_create_rest_routes()
    {
        register_rest_route('wpnat/v1', '/settings', [
            'methods' => 'GET',
            'callback' => [ $this, 'wpnat_get_settings' ],
            'permission_callback' => [ $this, 'wpnat_get_settings_permission' ]
        ]);
        register_rest_route('wpnat/v1', '/settings', [
            'methods' => 'POST',
            'callback' => [ $this, 'wpnat_save_settings' ],
            'permission_callback' => [ $this, 'wpnat_save_settings_permission' ]
        ]);
    }

    /**
    * Getting data
    */
    public function wpnat_get_settings()
    {
        $selected_theme = get_option('wpnat_selected_theme');
        $enable_comments  = get_option('wpnat_enable_comments');
        $response = [
            'selected_theme' => $selected_theme,
            'enable_comments'  => $enable_comments,
        ];

        return rest_ensure_response($response);
    }

    /**
    * Checking permissions
    */
    public function wpnat_get_settings_permission()
    {
        return true;
    }

    /**
    * Saving settings
    */
    public function wpnat_save_settings($req)
    {
        $selected_theme = isset($req['selected_theme']) ? sanitize_text_field($req['selected_theme']) : false;
        $enable_comments  = isset($req['enable_comments']) ? sanitize_text_field($req['enable_comments']) : false;
        update_option('wpnat_selected_theme', $selected_theme);
        update_option('wpnat_enable_comments', $enable_comments);
        return rest_ensure_response('success');
    }

    public function wpnat_save_settings_permission()
    {
        return current_user_can('publish_posts');
    }

    /**
    * Adding top level menu
    */
    public function wpnat_add_toplevel_menu()
    {

        $capability = 'manage_options';
        $slug = 'wpnat-settings';

        add_menu_page(
            __(WPNAT_PLUGIN_NAME, WPNAT_TETXDOMAIN),
            __(WPNAT_PLUGIN_NAME, WPNAT_TETXDOMAIN),
            $capability,
            $slug,
            [ $this, 'wpnat_display_settings_page' ],
            "",
        );
    }

    /**
    * Displays settings page in admin
    */
    public function wpnat_display_settings_page()
    {
        echo '<div class="wrap"><div id="wpnat-admin-app"></div></div>';
    }

    /**
    * Deactivation hook.
    */
    public function wpnat_plugin_deactivate() {
        delete_option('wpnat_selected_theme');
        delete_option('wpnat_enable_comments');
    }
    
}

WpnatAdminFunctions::get_instance();
