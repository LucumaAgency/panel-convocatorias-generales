<?php
/**
 * Configuración de campos ACF para Convocatorias
 */

if (!defined('ABSPATH')) {
    exit;
}

class Convocatorias_ACF {

    public function __construct() {
        add_action('acf/init', array($this, 'register_fields'));
    }

    public function register_fields() {
        if (function_exists('acf_add_local_field_group')) {

            acf_add_local_field_group(array(
                'key' => 'field_convocatorias',
                'title' => 'Convocatorias',
                'fields' => array(
                    array(
                        'key' => 'field_nombre_convocatoria',
                        'label' => 'Nombre de la convocatoria',
                        'name' => 'nombre_convocatoria',
                        'type' => 'text',
                        'instructions' => 'Ingrese el nombre de la convocatoria',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '100',
                        ),
                    ),
                    array(
                        'key' => 'field_descripcion',
                        'label' => 'Descripción',
                        'name' => 'descripcion',
                        'type' => 'textarea',
                        'instructions' => 'Descripción de la convocatoria',
                        'rows' => 4,
                    ),
                    array(
                        'key' => 'field_convocatoria',
                        'label' => 'Convocatoria',
                        'name' => 'convocatoria',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de la convocatoria',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_convocatoria_accion',
                        'label' => 'Convocatoria - Acción',
                        'name' => 'convocatoria_accion',
                        'type' => 'text',
                        'instructions' => 'Acción relacionada con la convocatoria',
                    ),
                    array(
                        'key' => 'field_entrega_bases',
                        'label' => 'Entrega de bases',
                        'name' => 'entrega_bases',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de entrega de bases',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_entrega_bases_accion1',
                        'label' => 'Entrega de bases - Acción 1',
                        'name' => 'entrega_bases_accion1',
                        'type' => 'text',
                        'instructions' => 'Primera acción de entrega de bases',
                    ),
                    array(
                        'key' => 'field_entrega_bases_accion2',
                        'label' => 'Entrega de bases - Acción 2',
                        'name' => 'entrega_bases_accion2',
                        'type' => 'text',
                        'instructions' => 'Segunda acción de entrega de bases',
                    ),
                    array(
                        'key' => 'field_entrega_bases_accion3',
                        'label' => 'Entrega de bases - Acción 3',
                        'name' => 'entrega_bases_accion3',
                        'type' => 'text',
                        'instructions' => 'Tercera acción de entrega de bases',
                    ),
                    array(
                        'key' => 'field_registro_participantes',
                        'label' => 'Registro de participantes',
                        'name' => 'registro_participantes',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de registro de participantes',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_registro_participantes_accion1',
                        'label' => 'Registro de participantes - Acción 1',
                        'name' => 'registro_participantes_accion1',
                        'type' => 'text',
                        'instructions' => 'Acción relacionada con el registro de participantes',
                    ),
                    array(
                        'key' => 'field_formulacion_consultas',
                        'label' => 'Formulación de consultas y aclaraciones a las bases',
                        'name' => 'formulacion_consultas',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de formulación de consultas',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_68cac1c070781',
                        'label' => 'Formulacion de consultas - Accion 1',
                        'name' => 'formulacion_consultas_accion1',
                        'type' => 'text',
                        'instructions' => 'Acción relacionada con la formulación de consultas',
                    ),
                    array(
                        'key' => 'field_absolucion_consultas',
                        'label' => 'Absolución de consultas y observaciones a las bases',
                        'name' => 'absolucion_consultas',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de absolución de consultas',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_68cac134efd79',
                        'label' => 'Absolucion de consultas - Accion 1',
                        'name' => 'absolucion_consultas_accion1',
                        'type' => 'text',
                        'instructions' => 'Primera acción de absolución de consultas',
                    ),
                    array(
                        'key' => 'field_68cacae99f567',
                        'label' => 'Absolucion de consultas - Accion 2',
                        'name' => 'absolucion_consultas_accion2',
                        'type' => 'text',
                        'instructions' => 'Segunda acción de absolución de consultas',
                    ),
                    array(
                        'key' => 'field_integracion_bases',
                        'label' => 'Integración de bases',
                        'name' => 'integracion_bases',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de integración de bases',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_presentacion_ofertas',
                        'label' => 'Presentación de ofertas solo en físico',
                        'name' => 'presentacion_ofertas',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de presentación de ofertas',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
                    ),
                    array(
                        'key' => 'field_evaluacion_adjudicacion',
                        'label' => 'Evaluación y adjudicación de Buena Pro',
                        'name' => 'evaluacion_adjudicacion',
                        'type' => 'date_picker',
                        'instructions' => 'Fecha de evaluación y adjudicación',
                        'display_format' => 'd/m/Y',
                        'return_format' => 'd/m/Y',
                        'first_day' => 1,
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
                'hide_on_screen' => '',
                'active' => true,
                'description' => 'Campos para gestionar las convocatorias',
            ));
        }
    }
}