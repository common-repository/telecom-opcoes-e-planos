<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function top_register_custom_options_page() {
    add_menu_page(
        'Provedor',
        'Provedor',
        'manage_options',
        'company-settings',
        'top_display_custom_options_page',
        'dashicons-admin-generic',
        20
    );
}

add_action('admin_menu', 'top_register_custom_options_page');

// Função para exibir as configurações com abas (preparado para futuras abas)
function top_display_custom_options_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Desanexar e sanitizar o valor de $_GET['tab']
    $active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : 'provider_info';

    ?>
    <div class="wrap">
        <h1>Configurações do Provedor</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=company-settings&tab=provider_info" class="nav-tab <?php echo $active_tab == 'provider_info' ? 'nav-tab-active' : ''; ?>">Informações do Provedor</a>
            <?php
            // Aqui, novos plugins podem registrar suas abas, quando forem adicionados.
            do_action('top_register_additional_tabs', $active_tab);
            ?>
        </h2>

        <form method="post" action="options.php">
            <?php
            // Exibir conteúdo da aba ativa (apenas "Informações do Provedor" no momento)
            if ($active_tab == 'provider_info') {
                settings_fields('top_company_settings_group');
                do_settings_sections('company-settings');
            }

            // Formulários adicionais podem ser registrados aqui por plugins futuros
            do_action('top_display_additional_tab_content', $active_tab);

            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function top_setup_custom_options_settings() {
    register_setting('top_company_settings_group', 'company_name', 'sanitize_text_field');
    register_setting('top_company_settings_group', 'company_cnpj', 'sanitize_text_field');
    register_setting('top_company_settings_group', 'company_phone1', 'sanitize_text_field');
    register_setting('top_company_settings_group', 'company_phone2', 'sanitize_text_field');
    register_setting('top_company_settings_group', 'company_email', 'sanitize_email');
    register_setting('top_company_settings_group', 'company_whatsapp', 'sanitize_text_field');
    register_setting('top_company_settings_group', 'subscriber_center', 'sanitize_text_field');

    add_settings_section(
        'top_company_settings_section',
        'Informações do Provedor',
        null,
        'company-settings'
    );

    add_settings_field(
        'company_name',
        'Nome da Empresa',
        'top_display_company_name_field',
        'company-settings',
        'top_company_settings_section'
    );
    add_settings_field(
        'company_cnpj',
        'CNPJ',
        'top_display_company_cnpj_field',
        'company-settings',
        'top_company_settings_section'
    );
    add_settings_field(
        'company_phone1',
        'Telefone 1',
        'top_display_company_phone1_field',
        'company-settings',
        'top_company_settings_section'
    );
    add_settings_field(
        'company_phone2',
        'Telefone 2',
        'top_display_company_phone2_field',
        'company-settings',
        'top_company_settings_section'
    );
    add_settings_field(
        'company_email',
        'Email',
        'top_display_company_email_field',
        'company-settings',
        'top_company_settings_section'
    );
    add_settings_field(
        'company_whatsapp',
        'WhatsApp',
        'top_display_company_whatsapp_field',
        'company-settings',
        'top_company_settings_section'
    );
    add_settings_field(
        'subscriber_center',
        'Central do Assinante',
        'top_display_subscriber_center_field',
        'company-settings',
        'top_company_settings_section'
    );
}

add_action('admin_init', 'top_setup_custom_options_settings');

// Funções para exibir os campos e garantir o escape de saída
function top_display_company_name_field() {
    $company_name = esc_attr(get_option('company_name'));
    echo "<input type='text' name='company_name' value='" . esc_html($company_name) . "' />";
}

function top_display_company_cnpj_field() {
    $company_cnpj = esc_attr(get_option('company_cnpj'));
    echo "<input type='text' name='company_cnpj' value='" . esc_html($company_cnpj) . "' />";
}

function top_display_company_phone1_field() {
    $company_phone1 = esc_attr(get_option('company_phone1'));
    echo "<input type='text' name='company_phone1' value='" . esc_html($company_phone1) . "' />";
}

function top_display_company_phone2_field() {
    $company_phone2 = esc_attr(get_option('company_phone2'));
    echo "<input type='text' name='company_phone2' value='" . esc_html($company_phone2) . "' />";
}

function top_display_company_email_field() {
    $company_email = esc_attr(get_option('company_email'));
    echo "<input type='email' name='company_email' value='" . esc_html($company_email) . "' />";
}

function top_display_company_whatsapp_field() {
    $company_whatsapp = esc_attr(get_option('company_whatsapp'));
    echo "<input type='text' name='company_whatsapp' value='" . esc_html($company_whatsapp) . "' />";
}

function top_display_subscriber_center_field() {
    $subscriber_center = esc_attr(get_option('subscriber_center'));
    echo "<input type='url' name='subscriber_center' value='" . esc_html($subscriber_center) . "' />";
}
?>
