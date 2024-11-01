<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Plugin;

class TOP_Elementor_Provider_Info_Tags extends Tag {
    public function get_name() {
        return 'top_provider_info';
    }

    public function get_title() {
        return __('Informações do Provedor', 'telecom-opcoes-e-planos');
    }

    public function get_group() {
        return 'site';
    }

    // Adicionar as categorias TEXT e URL para garantir que as tags funcionem em links
    public function get_categories() {
        return [
            \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
            \Elementor\Modules\DynamicTags\Module::URL_CATEGORY,
        ];
    }

    protected function register_controls() {
        $this->add_control(
            'field',
            [
                'label' => __('Campo', 'telecom-opcoes-e-planos'),
                'type' => Controls_Manager::SELECT,
                'default' => 'company_name',
                'options' => [
                    'company_name' => __('Nome da Empresa', 'telecom-opcoes-e-planos'),
                    'company_cnpj' => __('CNPJ', 'telecom-opcoes-e-planos'),
                    'company_phone1' => __('Telefone 1', 'telecom-opcoes-e-planos'),
                    'company_phone2' => __('Telefone 2', 'telecom-opcoes-e-planos'),
                    'company_email' => __('Email', 'telecom-opcoes-e-planos'),
                    'company_whatsapp' => __('WhatsApp', 'telecom-opcoes-e-planos'),
                    'subscriber_center' => __('Central do Assinante', 'telecom-opcoes-e-planos'),
                ],
            ]
        );
    }

    public function render() {
        $field = $this->get_settings('field');
        $value = get_option($field);

        // Se o campo for um URL, usar esc_url() para garantir que funcione corretamente
        if (in_array($field, ['subscriber_center', 'company_email', 'company_whatsapp'])) {
            $value = esc_url($value);
        }

        echo wp_kses_post($value);
    }
}

function top_register_custom_elementor_tags($dynamic_tags) {
    $dynamic_tags->register(new \TOP_Elementor_Provider_Info_Tags());
}

add_action('elementor/dynamic_tags/register', 'top_register_custom_elementor_tags');
