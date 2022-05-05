<?php
/*

Here is the code for the Wordpress Costumize controls.

*/
   
	//======== Editors Order Controller  =========
    // Manual select
    // add panel footer
    $wp_customize->add_panel('weil_footer', array(
        'priority' => 160,
        'title' => 'Footer',
    ));
    // add section
    $wp_customize->add_section('Editors', array(
        'title' => 'Editors',
        'priority' => 2,
        'panel' => 'weil_footer'

    ));

    //add setting
    $wp_customize->add_setting('Editors_setting', array(
        'default' => '',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));

    //add control CheckBox
    $wp_customize->add_control('Editors_setting', array(
        'description' => '<p>If you want to manually select editors, please uncheck the option above.</p>',
        'label' => 'Auto - Alphabetic Order',
        'section' => 'Editors',
        'type' => 'checkbox',
        'default' => '0',
        'priority' => 1,

    ));

    $editors = get_users(array(
        'role' => 'editor'
    ));

    foreach ($editors as $editor)
    {
        $wp_customize->add_setting('editor_' . $editor->ID, array(
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control('editor_' . $editor->ID, array(
            'label' => $editor->display_name,
            'section' => 'Editors',
            'type' => 'number',
            'default' => '0',

            'input_attrs' => array(
                'style' => 'width: 80px;',
                'min' => 1,
                'max' => count($editors) ,
                'step' => 1,
            ) ,
        ));
    } // End
    
}
add_action('customize_register', 'weil_customize_register');
?>
