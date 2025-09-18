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
                                    $this->render_table_row_smart(
                                        'Entrega de bases',
                                        get_field('entrega_bases', $post_id),
                                        array(
                                            array('content' => get_field('entrega_bases_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/docs-1.png'),
                                            array('content' => get_field('entrega_bases_accion2', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/planos_docuementos_anexos_formatos.png'),
                                            array('content' => get_field('entrega_bases_accion3', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/planos_docuementos_anexos_formatos.png')
                                        )
                                    );

                                    // Registro de participantes
                                    $this->render_table_row_smart(
                                        'Registro de participantes',
                                        get_field('registro_participantes', $post_id),
                                        array(
                                            array('content' => get_field('registro_participantes_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/enlace.png')
                                        )
                                    );

                                    // Formulación de consultas
                                    $this->render_table_row_smart(
                                        'Formulación de consultas y aclaraciones a las bases',
                                        get_field('formulacion_consultas', $post_id),
                                        array(
                                            array('content' => get_field('formulacion_consultas_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/enlace.png')
                                        )
                                    );

                                    // Absolución de consultas
                                    $this->render_table_row_smart(
                                        'Absolución de consultas y observaciones a las bases',
                                        get_field('absolucion_consultas', $post_id),
                                        array(
                                            array('content' => get_field('absolucion_consultas_accion1', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/docs-1.png'),
                                            array('content' => get_field('absolucion_consultas_accion2', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/planos_docuementos_anexos_formatos.png')
                                        )
                                    );

                                    // Integración de bases
                                    $this->render_table_row(
                                        'Integración de bases',
                                        get_field('integracion_bases', $post_id),
                                        ''
                                    );

                                    // Presentación de ofertas
                                    $this->render_table_row_smart(
                                        'Presentación de ofertas solo en físico',
                                        get_field('presentacion_ofertas', $post_id),
                                        array(
                                            array('content' => get_field('presentacion_ofertas_url', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/comunicado.png')
                                        )
                                    );

                                    // Evaluación y adjudicación
                                    $this->render_table_row_smart(
                                        'Evaluación y adjudicación de Buena Pro',
                                        get_field('evaluacion_adjudicacion', $post_id),
                                        array(
                                            array('content' => get_field('evaluacion_adjudicacion_url', $post_id), 'icon' => 'https://fospibay.org.pe/inicio/wp-content/uploads/2020/07/docs-1.png')
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
     * Renderizar fila inteligente que detecta si es URL o texto
     */
    private function render_table_row_smart($etapa, $fecha, $items) {
        ?>
        <tr>
            <td class="etapa-cell"><?php echo esc_html($etapa); ?></td>
            <td class="fecha-cell">
                <?php echo $fecha ? esc_html($fecha) : '-'; ?>
            </td>
            <td class="acciones-cell">
                <?php
                if (is_array($items) && !empty($items)) {
                    $has_content = false;
                    $all_urls = true;

                    // Verificar si hay contenido y si todos son URLs
                    foreach ($items as $item) {
                        if (!empty($item['content'])) {
                            $has_content = true;
                            if (!filter_var($item['content'], FILTER_VALIDATE_URL)) {
                                $all_urls = false;
                            }
                        }
                    }

                    if ($has_content) {
                        if ($all_urls) {
                            // Si todos son URLs, mostrar iconos
                            echo '<div class="iconos-wrapper">';
                            foreach ($items as $item) {
                                if (!empty($item['content']) && !empty($item['icon'])) {
                                    ?>
                                    <a href="<?php echo esc_url($item['content']); ?>" target="_blank" class="icono-link">
                                        <img src="<?php echo esc_url($item['icon']); ?>" alt="Documento" class="icono-documento">
                                    </a>
                                    <?php
                                }
                            }
                            echo '</div>';
                        } else {
                            // Si hay texto, mostrar como lista
                            echo '<ul class="acciones-list">';
                            foreach ($items as $item) {
                                if (!empty($item['content'])) {
                                    // Si es URL, mostrar como link con icono inline
                                    if (filter_var($item['content'], FILTER_VALIDATE_URL)) {
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url($item['content']); ?>" target="_blank" class="icono-link">
                                                <img src="<?php echo esc_url($item['icon']); ?>" alt="Documento" class="icono-documento" style="display: inline; width: 20px; height: 20px; vertical-align: middle; margin-right: 5px;">
                                                Ver documento
                                            </a>
                                        </li>
                                        <?php
                                    } else {
                                        // Si es texto, mostrar como texto
                                        echo '<li>' . esc_html($item['content']) . '</li>';
                                    }
                                }
                            }
                            echo '</ul>';
                        }
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