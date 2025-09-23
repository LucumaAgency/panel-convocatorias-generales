<?php
/**
 * Script de limpieza para eliminar grupos ACF duplicados
 * USAR UNA SOLA VEZ y luego ELIMINAR este archivo
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    // Si se ejecuta directamente, cargar WordPress
    require_once('../../../wp-load.php');
}

// Verificar permisos
if (!current_user_can('manage_options')) {
    wp_die('No tienes permisos para ejecutar este script');
}

function cm_cleanup_duplicate_acf_groups() {
    global $wpdb;

    // Buscar TODOS los grupos ACF duplicados/problemáticos
    // EXCEPTO el grupo original con título "Convocatorias"
    $problematic_groups = $wpdb->get_results(
        "SELECT ID, post_title, post_name, post_excerpt
         FROM {$wpdb->posts}
         WHERE post_type = 'acf-field-group'
         AND (
              (post_excerpt = 'group_convocatorias_campos')
              OR (post_excerpt = 'field_convocatorias' AND post_title = '')
              OR (post_excerpt LIKE '%field_convocatorias%' AND post_title = '')
              OR (post_title = 'Datos de la Convocatoria')
              OR (post_name = 'group_convocatorias_campos')
         )"
    );

    $deleted_count = 0;
    $groups_info = array();

    if ($problematic_groups) {
        foreach ($problematic_groups as $group) {
            // Guardar info antes de eliminar
            $groups_info[] = array(
                'ID' => $group->ID,
                'title' => $group->post_title,
                'key' => $group->post_excerpt
            );

            // Eliminar el grupo y sus campos hijos
            $fields = get_posts(array(
                'post_type' => 'acf-field',
                'post_parent' => $group->ID,
                'posts_per_page' => -1,
                'post_status' => 'any'
            ));

            foreach ($fields as $field) {
                wp_delete_post($field->ID, true);
            }

            // Eliminar el grupo
            wp_delete_post($group->ID, true);
            $deleted_count++;
        }
    }

    // Limpiar caché de ACF si existe
    if (function_exists('acf_get_store')) {
        $store = acf_get_store('field-groups');
        if ($store) {
            $store->reset();
        }
    }

    // Limpiar transients relacionados
    $wpdb->query(
        "DELETE FROM {$wpdb->options}
         WHERE option_name LIKE '_transient_acf_%'
         OR option_name LIKE '_transient_timeout_acf_%'"
    );

    return array(
        'deleted' => $deleted_count,
        'groups' => $groups_info
    );
}

// Ejecutar limpieza
$result = cm_cleanup_duplicate_acf_groups();

// Mostrar resultado
?>
<!DOCTYPE html>
<html>
<head>
    <title>Limpieza ACF - Convocatorias Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .deleted-item {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border-left: 3px solid #dc3545;
        }
        code {
            background: #f8f9fa;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h1>🧹 Limpieza de Grupos ACF Duplicados</h1>

    <?php if ($result['deleted'] > 0): ?>
        <div class="success">
            <h2>✅ Limpieza completada</h2>
            <p>Se eliminaron <strong><?php echo $result['deleted']; ?></strong> grupo(s) ACF problemático(s).</p>
        </div>

        <h3>Grupos eliminados:</h3>
        <?php foreach ($result['groups'] as $group): ?>
            <div class="deleted-item">
                <strong>ID:</strong> <?php echo $group['ID']; ?><br>
                <strong>Título:</strong> <?php echo esc_html($group['title']); ?><br>
                <strong>Key:</strong> <code><?php echo esc_html($group['key']); ?></code>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="success">
            <h2>✅ No se encontraron duplicados</h2>
            <p>No hay grupos ACF problemáticos en la base de datos.</p>
        </div>
    <?php endif; ?>

    <div class="warning">
        <h3>⚠️ IMPORTANTE</h3>
        <ol>
            <li><strong>ELIMINA este archivo</strong> después de usarlo</li>
            <li>Limpia el caché de tu sitio</li>
            <li>Verifica que los campos ACF funcionen correctamente</li>
            <li>El plugin ahora registrará los campos correctamente en memoria</li>
        </ol>
    </div>

    <p>
        <a href="<?php echo admin_url('edit.php?post_type=acf-field-group'); ?>">
            Ver grupos ACF restantes →
        </a>
    </p>
</body>
</html>