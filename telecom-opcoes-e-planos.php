<?php
/**
 * Plugin Name:       Telecom Opções e Planos
 * Plugin URI:        https://www.saivercon.com/telecom-opcoes-e-planos
 * Description:       Plugin para gerenciar informações do provedor e seus planos.
 * Version:           1.0.1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Saivercon Tecnologia
 * Author URI:        https://www.saivercon.com/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       telecom-opcoes-e-planos
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Incluir arquivos necessários
require_once plugin_dir_path(__FILE__) . 'includes/top-options-page.php'; // Configurações do provedor
require_once plugin_dir_path(__FILE__) . 'includes/top-plan-post-type.php'; // Tipo de post para planos
require_once plugin_dir_path(__FILE__) . 'includes/top-elementor-integration.php'; // Integração com Elementor para informações do provedor

// Adicionar link de configurações na página de plugins
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'top_add_settings_link');

function top_add_settings_link($links) {
    $settings_link = '<a href="admin.php?page=company-settings">Configurações</a>';
    array_unshift($links, $settings_link);
    return $links;
}

// Adicionar aviso de versão Grátis
function top_admin_notice() {
    $screen = get_current_screen();

    // Exibir mensagem apenas nos menus "Provedor" e "Planos"
    if ($screen->id === 'toplevel_page_company-settings' || $screen->post_type === 'top_plan') {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>Atenção:</strong> Você está utilizando a versão grátis do plugin Telecom Opções e Planos. Para mais funcionalidades, visite <a href="https://www.saivercon.com/telecom-opcoes-e-planos" target="_blank">nosso site</a>.</p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'top_admin_notice');
?>
