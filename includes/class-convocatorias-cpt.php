<?php
/**
 * Custom Post Type para Convocatorias
 */

if (!defined('ABSPATH')) {
    exit;
}

class Convocatorias_CPT {

    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
    }

    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Convocatorias', 'Post type general name', 'convocatorias-manager'),
            'singular_name'         => _x('Convocatoria', 'Post type singular name', 'convocatorias-manager'),
            'menu_name'            => _x('Convocatorias', 'Admin Menu text', 'convocatorias-manager'),
            'name_admin_bar'       => _x('Convocatoria', 'Add New on Toolbar', 'convocatorias-manager'),
            'add_new'              => __('Añadir nueva', 'convocatorias-manager'),
            'add_new_item'         => __('Añadir nueva convocatoria', 'convocatorias-manager'),
            'new_item'             => __('Nueva convocatoria', 'convocatorias-manager'),
            'edit_item'            => __('Editar convocatoria', 'convocatorias-manager'),
            'view_item'            => __('Ver convocatoria', 'convocatorias-manager'),
            'all_items'            => __('Todas las convocatorias', 'convocatorias-manager'),
            'search_items'         => __('Buscar convocatorias', 'convocatorias-manager'),
            'parent_item_colon'    => __('Convocatoria padre:', 'convocatorias-manager'),
            'not_found'            => __('No se encontraron convocatorias.', 'convocatorias-manager'),
            'not_found_in_trash'   => __('No se encontraron convocatorias en la papelera.', 'convocatorias-manager'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'convocatorias'),
            'capability_type'   => 'post',
            'has_archive'       => true,
            'hierarchical'      => false,
            'menu_position'     => 20,
            'menu_icon'         => 'dashicons-clipboard',
            'supports'          => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'show_in_rest'      => true,
        );

        register_post_type('convocatoria', $args);
    }

    public function register_taxonomies() {
        // Taxonomía para el estado de la convocatoria
        $labels = array(
            'name'              => _x('Estados', 'taxonomy general name', 'convocatorias-manager'),
            'singular_name'     => _x('Estado', 'taxonomy singular name', 'convocatorias-manager'),
            'search_items'      => __('Buscar estados', 'convocatorias-manager'),
            'all_items'         => __('Todos los estados', 'convocatorias-manager'),
            'parent_item'       => __('Estado padre', 'convocatorias-manager'),
            'parent_item_colon' => __('Estado padre:', 'convocatorias-manager'),
            'edit_item'         => __('Editar estado', 'convocatorias-manager'),
            'update_item'       => __('Actualizar estado', 'convocatorias-manager'),
            'add_new_item'      => __('Añadir nuevo estado', 'convocatorias-manager'),
            'new_item_name'     => __('Nuevo nombre de estado', 'convocatorias-manager'),
            'menu_name'         => __('Estados', 'convocatorias-manager'),
        );

        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'estado-convocatoria'),
        );

        register_taxonomy('estado_convocatoria', array('convocatoria'), $args);

        // Crear términos por defecto
        $this->create_default_terms();
    }

    private function create_default_terms() {
        // Verificar si los términos ya existen
        if (!term_exists('vigente', 'estado_convocatoria')) {
            wp_insert_term(
                'Vigente',
                'estado_convocatoria',
                array(
                    'description' => 'Convocatoria actualmente vigente',
                    'slug' => 'vigente',
                )
            );
        }

        if (!term_exists('concluida', 'estado_convocatoria')) {
            wp_insert_term(
                'Concluida',
                'estado_convocatoria',
                array(
                    'description' => 'Convocatoria ya concluida',
                    'slug' => 'concluida',
                )
            );
        }
    }
}