<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Org_Heigl\Wordpress;

class SapifSettings
{

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'Show after post IF',
            'manage_options',
            'sapif-setting-admin',
            [$this, 'create_admin_page']
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option('sapif_items');
        ?>
        <div class="wrap">
            <h2>My Settings</h2>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields('sapif_option_group');
                do_settings_sections('sapif-setting-admin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'sapif_option_group', // Option group
            'sapif_items', // Option name
            [$this, 'sanitize'] // Sanitize
        );

        add_settings_section(
            'sapif_1', // ID
            'First item', // Title
            [$this, 'print_section_info'], // Callback
            'sapif-setting-admin' // Page
        );

        add_settings_field(
            'equation', // ID
            'Equation', // Title
            [$this, 'equation_callback'], // Callback
            'sapif-setting-admin', // Page
            'sapif_1' // Section
        );

        add_settings_field(
            'results',
            'Results',
            [$this, 'results_callback'],
            'sapif-setting-admin',
            'sapif_1'
        );
        add_settings_field(
            'content',
            'Content',
            [$this, 'content_callback'],
            'sapif-setting-admin',
            'sapif_1'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['equation'])) {
            $new_input['equation'] = filter_var($input['equation'],
                FILTER_SANITIZE_STRING);
        }
        if( isset( $input['results'] ) ) {
            $new_input['results'] = array_map(function ($item) {
                return trim($item);
            }, explode("\n", $input['results']));
        }

        if ( isset($input['content'])) {
            $new_input['content'] = $input['content'];
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function equation_callback()
    {
        printf(
            '<input type="text" id="equation" name="sapif_items[equation]" value="%s" />',
            isset($this->options['equation']) ? esc_attr( $this->options['equation']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function results_callback()
    {
        printf(
            '<textarea id="results" rows="5" cols="80" name="sapif_items[results]">%s</textarea>',
            isset ($this->options['results']) ? esc_attr(implode("\n", $this->options['results'])) : ''
        );
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function content_callback()
    {
        printf(
            '<textarea id="content"  rows="5" cols="80" name="sapif_items[content]">%s</textarea>',
            isset ($this->options['content']) ? esc_attr($this->options['content']) : ''
        );
    }
}