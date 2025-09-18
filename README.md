# Convocatorias Manager - Plugin WordPress

Plugin para gestionar convocatorias con estados vigente/concluida usando Advanced Custom Fields (ACF).

## Instalación

1. Sube la carpeta `convocatorias-manager` al directorio `/wp-content/plugins/`
2. Activa el plugin desde el panel de WordPress
3. Asegúrate de tener ACF (Advanced Custom Fields) instalado y activado

## Características

- **Custom Post Type**: Crea un tipo de contenido personalizado "Convocatorias"
- **Estados**: Maneja dos estados principales (Vigente y Concluida)
- **Campos ACF**: Configuración completa de campos personalizados
- **Renderizado Automático**: Se muestra automáticamente en las páginas configuradas
- **Shortcodes**: Disponibles para usar en cualquier página

## Uso

### Renderizado Automático

El plugin renderiza automáticamente las convocatorias en:
- **Página ID 6344**: Convocatorias Vigentes
- **Página ID 6348**: Convocatorias Concluidas

### Shortcodes

También puedes usar los shortcodes en cualquier página o entrada:

```
[convocatorias_vigentes]
[convocatorias_concluidas]
```

### Parámetros de Shortcode (opcionales)

```
[convocatorias_vigentes limit="5" orderby="date" order="DESC"]
```

- `limit`: Número de convocatorias a mostrar (-1 para todas)
- `orderby`: Campo para ordenar (date, title, menu_order)
- `order`: Dirección (ASC o DESC)

## Campos ACF Incluidos

- Nombre de la convocatoria
- Descripción
- Convocatoria (fecha)
- Convocatoria - Acción
- Entrega de bases (fecha)
- Entrega de bases - Acciones (1, 2, 3)
- Registro de participantes (fecha)
- Registro de participantes - Acción 1
- Formulación de consultas (fecha)
- Formulación de consultas - Acción 1
- Absolución de consultas (fecha)
- Absolución de consultas - Acciones (1, 2)
- Integración de bases (fecha)
- Presentación de ofertas (fecha)
- Evaluación y adjudicación de Buena Pro (fecha)

## Gestión de Estados

### En el Admin

1. Ve a **Convocatorias** en el menú de WordPress
2. Al crear/editar una convocatoria, asigna el estado desde la taxonomía "Estados"
3. Puedes filtrar convocatorias por estado en la lista

### Cambio de Estado Manual

En la edición de cada convocatoria, selecciona:
- **Vigente**: Para convocatorias activas
- **Concluida**: Para convocatorias finalizadas

## Personalización de Estilos

Los estilos están en `/assets/css/convocatorias.css`. Las clases principales son:

- `.convocatorias-wrapper`: Contenedor principal
- `.convocatoria-item`: Cada convocatoria individual
- `.convocatoria-table`: Tabla con la información
- `.estado-vigente`: Badge de estado vigente
- `.estado-concluida`: Badge de estado concluida

## Estructura de Archivos

```
convocatorias-manager/
├── convocatorias-manager.php          # Archivo principal
├── includes/
│   ├── class-convocatorias-cpt.php    # Custom Post Type
│   ├── class-convocatorias-acf.php    # Campos ACF
│   ├── class-convocatorias-estados.php # Gestión de estados
│   └── class-convocatorias-shortcodes.php # Shortcodes
├── assets/
│   └── css/
│       └── convocatorias.css          # Estilos
└── README.md
```

## Requisitos

- WordPress 5.0 o superior
- PHP 7.2 o superior
- Plugin ACF (Advanced Custom Fields) instalado

## Soporte

Para reportar problemas o solicitar nuevas características, contacta con el desarrollador.