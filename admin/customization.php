<?php
/*Examplte Customization*/
class ThemeCustomize {
    public function __construct() {
        add_action( 'customize_register' , array( &$this , 'register' ) );
    }

    public static function register ( $wp_customize ) {
        $wp_customize->add_setting( 'tarif_bdc' );
        $wp_customize->add_section( 'formulaire_contact_bdc' , array(
          'title'      => __('Formulaire de contact', 'theme'),
          'priority'   => 150,
        ));
        $wp_customize->add_control( new WP_Customize_Upload_Control(
            $wp_customize,
            'tarif_bdc',
            array(
                'label'          => __( 'Tarif et bdc', 'theme' ),
                'section'        => 'formulaire_contact_bdc',
                'settings'       => 'tarif_bdc',

            )
        ));

    }
}
// Instanciation de la class 'ThemeCustomize'
if(class_exists('ThemeCustomize')) {
    $theme_customize = new ThemeCustomize(__FILE__);
}