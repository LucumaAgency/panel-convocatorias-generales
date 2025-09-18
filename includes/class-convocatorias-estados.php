<?php
/**
 * Gestión de estados de las convocatorias
 */

if (!defined('ABSPATH')) {
    exit;
}

class Convocatorias_Estados {

    public function __construct() {
        // Añadir columnas personalizadas en el admin
        add_filter('manage_convocatoria_posts_columns', array($this, 'add_admin_columns'));
        add_action('manage_convocatoria_posts_custom_column', array($this, 'render_admin_columns'), 10, 2);

        // Hacer las columnas ordenables
        add_filter('manage_edit-convocatoria_sortable_columns', array($this, 'sortable_columns'));

        // Añadir filtro por estado en el admin
        add_action('restrict_manage_posts', array($this, 'add_estado_filter'));
        add_filter('parse_query', array($this, 'filter_by_estado'));
    }

    /**
     * Obtener el estado de una convocatoria
     */
    public static function get_estado($post_id) {
        $terms = wp_get_post_terms($post_id, 'estado_convocatoria');
        if (!empty($terms) && !is_wp_error($terms)) {
            return $terms[0]->slug;
        }
        return 'vigente'; // Estado por defecto
    }

    /**
     * Establecer el estado de una convocatoria
     */
    public static function set_estado($post_id, $estado) {
        $valid_estados = array('vigente', 'concluida');

        if (in_array($estado, $valid_estados)) {
            wp_set_object_terms($post_id, $estado, 'estado_convocatoria');
            return true;
        }

        return false;
    }

    /**
     * Obtener convocatorias por estado
     */
    public static function get_convocatorias_by_estado($estado = 'vigente', $args = array()) {
        $default_args = array(
            'post_type' => 'convocatoria',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'estado_convocatoria',
                    'field' => 'slug',
                    'terms' => $estado,
                ),
            ),
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $query_args = wp_parse_args($args, $default_args);
        return new WP_Query($query_args);
    }

    /**
     * Verificar si una convocatoria está vigente
     */
    public static function is_vigente($post_id) {
        return self::get_estado($post_id) === 'vigente';
    }

    /**
     * Verificar si una convocatoria está concluida
     */
    public static function is_concluida($post_id) {
        return self::get_estado($post_id) === 'concluida';
    }

    /**
     * Añadir columnas en el admin
     */
    public function add_admin_columns($columns) {
        $new_columns = array();

        foreach ($columns as $key => $value) {
            if ($key === 'title') {
                $new_columns[$key] = $value;
                $new_columns['estado'] = __('Estado', 'convocatorias-manager');
                $new_columns['nombre_convocatoria'] = __('Nombre Convocatoria', 'convocatorias-manager');
            } else {
                $new_columns[$key] = $value;
            }
        }

        return $new_columns;
    }

    /**
     * Renderizar contenido de las columnas
     */
    public function render_admin_columns($column, $post_id) {
        switch ($column) {
            case 'estado':
                $estado = self::get_estado($post_id);
                $class = ($estado === 'vigente') ? 'vigente' : 'concluida';
                $label = ($estado === 'vigente') ? 'Vigente' : 'Concluida';
                echo '<span class="estado-badge estado-' . esc_attr($class) . '" style="
                    padding: 3px 8px;
                    border-radius: 3px;
                    font-size: 12px;
                    font-weight: bold;
                    background-color: ' . ($estado === 'vigente' ? '#d4edda' : '#f8d7da') . ';
                    color: ' . ($estado === 'vigente' ? '#155724' : '#721c24') . ';
                ">' . esc_html($label) . '</span>';
                break;

            case 'nombre_convocatoria':
                $nombre = get_field('field_nombre_convocatoria', $post_id);
                echo esc_html($nombre ? $nombre : '-');
                break;
        }
    }

    /**
     * Hacer columnas ordenables
     */
    public function sortable_columns($columns) {
        $columns['estado'] = 'estado';
        return $columns;
    }

    /**
     * Añadir filtro por estado
     */
    public function add_estado_filter() {
        global $typenow;

        if ($typenow == 'convocatoria') {
            $selected = isset($_GET['estado_convocatoria']) ? $_GET['estado_convocatoria'] : '';

            $terms = get_terms(array(
                'taxonomy' => 'estado_convocatoria',
                'hide_empty' => false,
            ));

            if (!empty($terms) && !is_wp_error($terms)) {
                echo '<select name="estado_convocatoria">';
                echo '<option value="">Todos los estados</option>';

                foreach ($terms as $term) {
                    $selected_attr = selected($selected, $term->slug, false);
                    echo '<option value="' . esc_attr($term->slug) . '"' . $selected_attr . '>' . esc_html($term->name) . '</option>';
                }

                echo '</select>';
            }
        }
    }

    /**
     * Filtrar por estado
     */
    public function filter_by_estado($query) {
        global $pagenow, $typenow;

        if ($pagenow == 'edit.php' && $typenow == 'convocatoria' && isset($_GET['estado_convocatoria']) && !empty($_GET['estado_convocatoria'])) {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'estado_convocatoria',
                    'field' => 'slug',
                    'terms' => $_GET['estado_convocatoria'],
                ),
            ));
        }
    }

    /**
     * Cambiar automáticamente el estado según fechas (opcional)
     */
    public static function auto_update_estados() {
        $convocatorias = get_posts(array(
            'post_type' => 'convocatoria',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ));

        foreach ($convocatorias as $convocatoria) {
            // Obtener la fecha de evaluación y adjudicación
            $fecha_evaluacion = get_field('field_evaluacion_adjudicacion', $convocatoria->ID);

            if ($fecha_evaluacion) {
                // Convertir la fecha al formato timestamp
                $fecha_timestamp = strtotime(str_replace('/', '-', $fecha_evaluacion));
                $hoy = time();

                // Si la fecha ya pasó, marcar como concluida
                if ($fecha_timestamp < $hoy) {
                    self::set_estado($convocatoria->ID, 'concluida');
                }
            }
        }
    }
}