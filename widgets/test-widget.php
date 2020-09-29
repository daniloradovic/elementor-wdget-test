<?php

class Elementor_Test_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'castos';
    }

    public function get_title() {
        return __( 'castos', 'elementor-castos-extension' );
    }

    public function get_icon() {
        return 'fa fa-podcast';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    public function getAllEpisodes() {
        $args = array(
            'post_type'=> 'podcast',
        );

        $query = new WP_Query( $args );

        $episodes = array();

        if($query->posts) {
            foreach ($query->posts as $post) {
                $episodes["'".$post->ID."'"] = "'".$post->post_title."'" ;
            }
        }

        return $episodes;
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor-castos-extension' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $episodes = $this->getAllEpisodes();

        $this->add_control(
            'show_elements',
            [
                'label' => __( 'Show Elements', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $episodes,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
//        echo print_r($settings['show_elements'], true);
        foreach ( $settings['show_elements'] as $element ) {
            echo '<div>' . $element . '</div>';
        }

    }

    protected function _content_template() {
        ?>
        <# _.each( settings.show_elements, function( element ) { #>
        <div>{{{ element }}}</div>
        <# } ) #>
        <?php
    }

}