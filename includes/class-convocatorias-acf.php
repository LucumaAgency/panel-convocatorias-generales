<?php
/**
 * Configuración de campos ACF para Convocatorias
 */

if (!defined('ABSPATH')) {
    exit;
}

class Convocatorias_ACF {

    private static $fields_registered = false;

    public function __construct() {
        // Verificar que ACF esté disponible
        if (!class_exists('ACF')) {
            add_action('admin_notices', array($this, 'acf_missing_notice'));
            return;
        }

        // DESACTIVADO: No registrar campos programáticamente
        // Los campos ya existen en ACF con el grupo field_convocatorias
        // add_action('acf/init', array($this, 'register_fields'));
    }

    /**
     * Mostrar aviso si ACF no está instalado
     */
    public function acf_missing_notice() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="notice notice-warning">
            <p><?php _e('El plugin Convocatorias Manager requiere Advanced Custom Fields (ACF) para funcionar correctamente. Por favor, instala y activa ACF.', 'convocatorias-manager'); ?></p>
        </div>
        <?php
    }

    /**
     * Registrar campos de ACF
     */
    public function register_fields() {
        // Evitar registro múltiple
        if (self::$fields_registered) {
            return;
        }

        if (function_exists('acf_add_local_field_group')) {

            acf_add_local_field_group(array(
                'key' => 'group_convocatorias_campos',  // Corregido: debe ser group_XXX
                'title' => 'Datos de la Convocatoria',
                'fields' => array(
                    // Información básica
                    array(
                        'key' => 'field_cm_nombre_convocatoria',
                        'label' => 'Nombre de la convocatoria',
                        'name' => 'nombre_convocatoria',
                        'type' => 'text',
                        'instructions' => 'Ingrese el nombre completo de la convocatoria',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '100',
                        ),
                    ),
                    array(
                        'key' => 'field_cm_descripcion',
                        'label' => 'Descripción',
                        'name' => 'descripcion',
                        'type' => 'textarea',
                        'instructions' => 'Descripción detallada de la convocatoria',
                        'rows' => 4,
                        'new_lines' => 'wpautop',
                    ),

                    // Tab de Fechas y Etapas
                    array(
                        'key' => 'field_cm_tab_fechas',
                        'label' => 'Fechas y Etapas',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),

                    // Convocatoria
                    array(
                        'key' => 'field_cm_convocatoria',
                        'label' => 'Convocatoria',
                        'name' => 'convocatoria',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de la convocatoria',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_cm_convocatoria_accion',
                        'label' => 'Convocatoria - Acción',
                        'name' => 'convocatoria_accion',
                        'type' => 'text',
                        'instructions' => 'Acción o nota relacionada con la convocatoria',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Entrega de bases
                    array(
                        'key' => 'field_cm_entrega_bases',
                        'label' => 'Entrega de bases',
                        'name' => 'entrega_bases',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de entrega de bases',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Tab de Documentos
                    array(
                        'key' => 'field_cm_tab_documentos',
                        'label' => 'Documentos y Enlaces',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),

                    // Grupo de URLs de Entrega de Bases
                    array(
                        'key' => 'field_cm_grupo_entrega_bases',
                        'label' => 'Documentos de Entrega de Bases',
                        'type' => 'group',
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_cm_entrega_bases_doc1',
                                'label' => 'Documento principal',
                                'name' => 'entrega_bases_accion1',
                                'type' => 'url',
                                'instructions' => 'URL del documento principal de entrega de bases',
                                'wrapper' => array(
                                    'width' => '33',
                                ),
                            ),
                            array(
                                'key' => 'field_cm_entrega_bases_doc2',
                                'label' => 'Planos/Anexos',
                                'name' => 'entrega_bases_accion2',
                                'type' => 'url',
                                'instructions' => 'URL de planos, documentos anexos y formatos',
                                'wrapper' => array(
                                    'width' => '33',
                                ),
                            ),
                            array(
                                'key' => 'field_cm_entrega_bases_doc3',
                                'label' => 'Documento adicional',
                                'name' => 'entrega_bases_accion3',
                                'type' => 'url',
                                'instructions' => 'URL adicional de planos/documentos',
                                'wrapper' => array(
                                    'width' => '33',
                                ),
                            ),
                        ),
                    ),

                    // Registro de participantes
                    array(
                        'key' => 'field_cm_registro_participantes',
                        'label' => 'Registro de participantes',
                        'name' => 'registro_participantes',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de registro de participantes',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_cm_registro_participantes_url',
                        'label' => 'URL Registro de participantes',
                        'name' => 'registro_participantes_accion1',
                        'type' => 'url',
                        'instructions' => 'URL para el registro de participantes',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Tab de Consultas
                    array(
                        'key' => 'field_cm_tab_consultas',
                        'label' => 'Consultas y Aclaraciones',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),

                    // Formulación de consultas
                    array(
                        'key' => 'field_cm_formulacion_consultas',
                        'label' => 'Formulación de consultas y aclaraciones',
                        'name' => 'formulacion_consultas',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha límite para formulación de consultas',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_cm_formulacion_consultas_url',
                        'label' => 'URL Formulación de consultas',
                        'name' => 'formulacion_consultas_accion1',
                        'type' => 'url',
                        'instructions' => 'URL para la formulación de consultas',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Absolución de consultas
                    array(
                        'key' => 'field_cm_absolucion_consultas',
                        'label' => 'Absolución de consultas y observaciones',
                        'name' => 'absolucion_consultas',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de absolución de consultas',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Grupo de URLs de Absolución
                    array(
                        'key' => 'field_cm_grupo_absolucion',
                        'label' => 'Documentos de Absolución',
                        'type' => 'group',
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_cm_absolucion_doc1',
                                'label' => 'Documento de absolución',
                                'name' => 'absolucion_consultas_accion1',
                                'type' => 'url',
                                'instructions' => 'URL del documento de absolución de consultas',
                                'wrapper' => array(
                                    'width' => '50',
                                ),
                            ),
                            array(
                                'key' => 'field_cm_absolucion_doc2',
                                'label' => 'Planos/Anexos de absolución',
                                'name' => 'absolucion_consultas_accion2',
                                'type' => 'url',
                                'instructions' => 'URL de planos/anexos de absolución',
                                'wrapper' => array(
                                    'width' => '50',
                                ),
                            ),
                        ),
                    ),

                    // Tab de Ofertas y Evaluación
                    array(
                        'key' => 'field_cm_tab_ofertas',
                        'label' => 'Ofertas y Evaluación',
                        'type' => 'tab',
                        'placement' => 'top',
                    ),

                    // Integración de bases
                    array(
                        'key' => 'field_cm_integracion_bases',
                        'label' => 'Integración de bases',
                        'name' => 'integracion_bases',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de integración de bases',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Presentación de ofertas
                    array(
                        'key' => 'field_cm_presentacion_ofertas',
                        'label' => 'Presentación de ofertas (solo en físico)',
                        'name' => 'presentacion_ofertas',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha límite de presentación de ofertas',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_cm_presentacion_ofertas_url',
                        'label' => 'URL Comunicado presentación',
                        'name' => 'presentacion_ofertas_url',
                        'type' => 'url',
                        'instructions' => 'URL del comunicado de presentación de ofertas',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),

                    // Evaluación y adjudicación
                    array(
                        'key' => 'field_cm_evaluacion_adjudicacion',
                        'label' => 'Evaluación y adjudicación de Buena Pro',
                        'name' => 'evaluacion_adjudicacion',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de evaluación y adjudicación (determina cuando pasa a concluida)',
                        'required' => 0,
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                    array(
                        'key' => 'field_cm_evaluacion_adjudicacion_url',
                        'label' => 'URL Documento de adjudicación',
                        'name' => 'evaluacion_adjudicacion_url',
                        'type' => 'url',
                        'instructions' => 'URL del documento de evaluación y adjudicación',
                        'wrapper' => array(
                            'width' => '50',
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'convocatoria',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => array('the_content'),
                'active' => true,
                'description' => 'Campos para gestionar las convocatorias vigentes y concluidas',
            ));

            self::$fields_registered = true;
        }
    }

    /**
     * Helper para obtener valor de campo con fallback
     */
    public static function get_field_value($field_name, $post_id, $default = '') {
        if (!function_exists('get_field')) {
            return $default;
        }

        $value = get_field($field_name, $post_id);
        return $value !== false ? $value : $default;
    }

    /**
     * Verificar si ACF está activo
     */
    public static function is_acf_active() {
        return class_exists('ACF');
    }
}