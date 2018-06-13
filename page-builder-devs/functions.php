<?php
    /*
     * Load Page Builder with TGM Plugin Activation.
     */

    // Include the TGM_Plugin_Activation class.
    require_once get_template_directory() . '/class-tgm-plugin-activation.php';
    add_action('tgmpa_register', 'pb_register');

    // Register the Page Builder plugin.
    function pb_register() {
        // Plugin list.
        $plugins = array(
            array(
                'name'     => 'WPBakery Page Builder',
                'slug'     => 'js_composer',
                'source'   => get_template_directory() . '/plugins/js_composer.zip',
                'required' => true,
                'version'  => '5'
            )
        );

        // Settings list.
        $config = array(
            'id'           => 'wpbpb',                 
            'is_automatic' => false
        );

        tgmpa($plugins, $config);
    }



    if (function_exists('vc_map')) {
    /*
     * Add a custom element to Page Builder.
     */

    // Define a new shortcode.
    add_shortcode('custom_button', 'custom_button_shortcode');

    function custom_button_shortcode($atts, $content = null) {
        extract(shortcode_atts(array(
            'color' => 'primary',
            'size'  => 'small',
            'url'   => ''
        ), $atts));

        return "<a href='". esc_attr($url) ."' class='$color $size' target='blank'>$content</a>";
    }

    add_action('vc_before_init', 'pb_new_element');

    function pb_new_element() {
        vc_map(array(
            'name'        => 'Custom button',
            'base'        => 'custom_button',
            'description' => 'Custom button for Page Builder',
            'icon'        => get_template_directory_uri() . "/pb_extend/icon-custom-button.svg",
            'class'       => '',
            'category'    => 'Custom elements',
            'params'      => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => 'Button text',
                    'param_name' => 'content',
                    'value' => 'Click me',
                    'description' => 'The button text'
                ),
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => 'Color class',
                    'param_name' => 'color',
                    'value' => array('primary', 'secondary', 'tertiary'),
                    'description' => 'The color class'
                ),
                array(
                    'type' => 'dropdown',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => 'Size class',
                    'param_name' => 'size',
                    'value' => array('small', 'large'),
                    'description' => 'The size class'
                ),
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => 'Button link',
                    'param_name' => 'url',
                    'value' => '',
                    'description' => 'Button link'
                )
            )
        ));
    }





    /*
     * Remove elements from Page Builder.
     */
    vc_remove_element( "vc_message" );
    vc_remove_element( "vc_pie" );





    /*
     * Add parameters to elements.
     */
    $attributes = array(
        'type' => 'dropdown',
        'holder' => 'div',
        'class' => '',
        'heading' => 'Style class',
        'param_name' => 'style',
        'value' => array('solid', 'ghost'),
        'description' => 'The style class'
    );

    vc_add_param('custom_button', $attributes);





    /*
     * Remove parameters from existing elements.
     */
    vc_remove_param( "custom_button", "color" );
    vc_remove_param( "vc_zigzag", "align" );





    /*
     * Adding default templates.
     */
    add_action('vc_load_default_templates_action', 'pb_add_default_templates');

    function pb_add_default_templates() {
        vc_add_default_templates(array(
            'name' => 'Tutsplus template',
            'weight' => 0,
            'image_path' => get_template_directory_uri() . "/pb_extend/new-template.jpg",
            'custom_class' => '',
            'content' => <<<CONTENT
            [vc_row][vc_column][vc_column_text][vc_message]I am message box. Click edit button to change this text.[/vc_message][/vc_column_text][/vc_column][/vc_row][vc_row][vc_column][vc_column_text]I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column][custom_button url="http://www.envato.com" style="ghost"]Go to Envato[/custom_button][/vc_column][/vc_row]
CONTENT
        ));
    }




    /*
     * Smaller tweaks and settings.
     */

    // Disable front-end editor.
    vc_disable_frontend();

    // Hide "Design Options" and "Custom CSS" tabs in the admin page.
    vc_set_as_theme();

    // Set default editor post types.
    vc_set_default_editor_post_types(array(
        'page',
        'post',
        'custom_post'
    ));
    }

?>