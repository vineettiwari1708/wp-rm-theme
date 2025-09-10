<?php 
    add_action('init', function () {
    $license_key = get_option('my_theme_license_key');
    $remote_url = 'https://api.yourserver.com/theme-config/?key=' . urlencode($license_key);

    $response = wp_remote_get($remote_url);

    if (!is_wp_error($response)) {
        $data = json_decode(wp_remote_retrieve_body($response), true);

        if (!empty($data['custom_css'])) {
            add_action('wp_head', function () use ($data) {
                echo '<style>' . esc_html($data['custom_css']) . '</style>';
            });
        }

        if (!empty($data['custom_js'])) {
            add_action('wp_footer', function () use ($data) {
                echo '<script>' . $data['custom_js'] . '</script>';
            });
        }
    }
});

