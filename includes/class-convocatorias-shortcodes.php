<?php
/**
 * Shortcodes para mostrar las convocatorias
 */

if (!defined('ABSPATH')) {
    exit;
}

class Convocatorias_Shortcodes {

    public function __construct() {
        // Registrar shortcodes
        add_shortcode('convocatorias_vigentes', array($this, 'render_convocatorias_vigentes'));
        add_shortcode('convocatorias_concluidas', array($this, 'render_convocatorias_concluidas'));

        // Renderizar automáticamente en las páginas específicas
        add_filter('the_content', array($this, 'auto_render_convocatorias'));
    }

    /**
     * Auto-renderizar en páginas específicas
     */
    public function auto_render_convocatorias($content) {
        if (is_page()) {
            $page_id = get_the_ID();

            // Página 6344 - Convocatorias Vigentes
            if ($page_id == 6344) {
                $content .= $this->render_convocatorias_vigentes();
            }

            // Página 6348 - Convocatorias Concluidas
            if ($page_id == 6348) {
                $content .= $this->render_convocatorias_concluidas();
            }
        }

        return $content;
    }

    /**
     * Shortcode para convocatorias vigentes
     */
    public function render_convocatorias_vigentes($atts = array()) {
        $atts = shortcode_atts(array(
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ), $atts);

        $query = Convocatorias_Estados::get_convocatorias_by_estado('vigente', array(
            'posts_per_page' => $atts['limit'],
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
        ));

        return $this->render_convocatorias_table($query, 'vigentes');
    }

    /**
     * Shortcode para convocatorias concluidas
     */
    public function render_convocatorias_concluidas($atts = array()) {
        $atts = shortcode_atts(array(
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ), $atts);

        $query = Convocatorias_Estados::get_convocatorias_by_estado('concluida', array(
            'posts_per_page' => $atts['limit'],
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
        ));

        return $this->render_convocatorias_table($query, 'concluidas');
    }

    /**
     * Renderizar tabla de convocatorias
     */
    private function render_convocatorias_table($query, $tipo = 'vigentes') {
        ob_start();

        if ($query->have_posts()) {
            ?>
            <div class="convocatorias-wrapper convocatorias-<?php echo esc_attr($tipo); ?>">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    ?>
                    <div class="convocatoria-item">
                        <div class="convocatoria-table-wrapper">
                            <table class="convocatoria-table">
                                <thead>
                                    <tr>
                                        <th>Etapas</th>
                                        <th>Fecha</th>
                                        <th>Acciones/Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Convocatoria
                                    $this->render_table_row(
                                        'Convocatoria',
                                        get_field('convocatoria', $post_id),
                                        array(get_field('convocatoria_accion', $post_id))
                                    );

                                    // Entrega de bases
                                    $this->render_table_row_with_icons(
                                        'Entrega de bases',
                                        get_field('entrega_bases', $post_id),
                                        array(
                                            array('url' => get_field('entrega_bases_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/docs-1.png'),
                                            array('url' => get_field('entrega_bases_accion2', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/planos_docuementos_anexos_formatos.png'),
                                            array('url' => get_field('entrega_bases_accion3', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/planos_docuementos_anexos_formatos.png')
                                        )
                                    );

                                    // Registro de participantes
                                    $this->render_table_row_with_icons(
                                        'Registro de participantes',
                                        get_field('registro_participantes', $post_id),
                                        array(
                                            array('url' => get_field('registro_participantes_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/enlace.png')
                                        )
                                    );

                                    // Formulación de consultas
                                    $this->render_table_row_with_icons(
                                        'Formulación de consultas y aclaraciones a las bases',
                                        get_field('formulacion_consultas', $post_id),
                                        array(
                                            array('url' => get_field('formulacion_consultas_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/enlace.png')
                                        )
                                    );

                                    // Absolución de consultas
                                    $this->render_table_row_with_icons(
                                        'Absolución de consultas y observaciones a las bases',
                                        get_field('absolucion_consultas', $post_id),
                                        array(
                                            array('url' => get_field('absolucion_consultas_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/docs-1.png'),
                                            array('url' => get_field('absolucion_consultas_accion2', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/planos_docuementos_anexos_formatos.png')
                                        )
                                    );

                                    // Integración de bases
                                    $this->render_table_row(
                                        'Integración de bases',
                                        get_field('integracion_bases', $post_id),
                                        ''
                                    );

                                    // Presentación de ofertas
                                    $this->render_table_row_with_icons(
                                        'Presentación de ofertas solo en físico',
                                        get_field('presentacion_ofertas', $post_id),
                                        array(
                                            array('url' => get_field('presentacion_ofertas_url', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/comunicado.png')
                                        )
                                    );

                                    // Evaluación y adjudicación
                                    $this->render_table_row_with_icons(
                                        'Evaluación y adjudicación de Buena Pro',
                                        get_field('evaluacion_adjudicacion', $post_id),
                                        array(
                                            array('url' => get_field('evaluacion_adjudicacion_url', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/docs-1.png')
                                        )
                                    );
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php
        } else {
            ?>
            <div class="convocatorias-empty">
                <p>No hay convocatorias <?php echo $tipo === 'vigentes' ? 'vigentes' : 'concluidas'; ?> en este momento.</p>
            </div>
            <?php
        }

        return ob_get_clean();
    }

    /**
     * Renderizar fila de la tabla
     */
    private function render_table_row($etapa, $fecha, $acciones) {
        ?>
        <tr>
            <td class="etapa-cell"><?php echo esc_html($etapa); ?></td>
            <td class="fecha-cell">
                <?php echo $fecha ? esc_html($fecha) : '-'; ?>
            </td>
            <td class="acciones-cell">
                <?php
                if (is_array($acciones)) {
                    $acciones_filtradas = array_filter($acciones);
                    if (!empty($acciones_filtradas)) {
                        echo '<ul class="acciones-list">';
                        foreach ($acciones_filtradas as $accion) {
                            if ($accion) {
                                echo '<li>' . esc_html($accion) . '</li>';
                            }
                        }
                        echo '</ul>';
                    } else {
                        echo '-';
                    }
                } else {
                    echo $acciones ? esc_html($acciones) : '-';
                }
                ?>
            </td>
        </tr>
        <?php
    }

    /**
     * Renderizar fila con iconos - Solo URLs
     */
    private function render_table_row_with_icons($etapa, $fecha, $items) {
        ?>
        <tr>
            <td class="etapa-cell"><?php echo esc_html($etapa); ?></td>
            <td class="fecha-cell">
                <?php echo $fecha ? esc_html($fecha) : '-'; ?>
            </td>
            <td class="acciones-cell">
                <?php
                if (is_array($items) && !empty($items)) {
                    $has_urls = false;

                    // Verificar si hay URLs válidas
                    foreach ($items as $item) {
                        if (!empty($item['url']) && filter_var($item['url'], FILTER_VALIDATE_URL)) {
                            $has_urls = true;
                            break;
                        }
                    }

                    if ($has_urls) {
                        echo '<div class="iconos-wrapper">';
                        foreach ($items as $item) {
                            if (!empty($item['url']) && filter_var($item['url'], FILTER_VALIDATE_URL) && !empty($item['icon'])) {
                                ?>
                                <a href="<?php echo esc_url($item['url']); ?>" target="_blank" class="icono-link">
                                    <img src="<?php echo esc_url($item['icon']); ?>" alt="Documento" class="icono-documento">
                                </a>
                                <?php
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '-';
                    }
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <?php
    }
}