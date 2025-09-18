<?php
/**
 * Plugin Name: Convocatorias Manager
 * Plugin URI: https://tu-sitio.com/
 * Description: Plugin para gestionar convocatorias vigentes y concluidas con ACF
 * Version: 1.0.1
 * Author: Tu Nombre
 * License: GPL v2 or later
 * Text Domain: convocatorias-manager
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes del plugin
define('CM_VERSION', '1.0.1');
define('CM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CM_PLUGIN_URL', plugin_dir_url(__FILE__));

// Incluir archivos necesarios
require_once CM_PLUGIN_DIR . 'includes/class-convocatorias-cpt.php';
require_once CM_PLUGIN_DIR . 'includes/class-convocatorias-acf.php';
require_once CM_PLUGIN_DIR . 'includes/class-convocatorias-shortcodes.php';
require_once CM_PLUGIN_DIR . 'includes/class-convocatorias-estados.php';

// Inicializar las clases inmediatamente
new Convocatorias_CPT();
new Convocatorias_ACF();
new Convocatorias_Shortcodes();
new Convocatorias_Estados();

// Activación del plugin
function cm_activate() {
    // Registrar el CPT temporalmente para el flush
    $cpt = new Convocatorias_CPT();

    // Limpiar los permalinks
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'cm_activate');

// Desactivación del plugin
function cm_deactivate() {
    // Limpiar los permalinks
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'cm_deactivate');

// Cargar estilos del plugin
function cm_enqueue_styles() {
    wp_enqueue_style('convocatorias-manager', CM_PLUGIN_URL . 'assets/css/convocatorias.css', array(), CM_VERSION);
}
add_action('wp_enqueue_scripts', 'cm_enqueue_styles');