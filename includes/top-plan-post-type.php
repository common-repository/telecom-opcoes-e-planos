<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Registrar o tipo de post para planos, sem o editor de texto
function top_register_plan_post_type() {
    $labels = array(
        'name'                  => 'Planos',
        'singular_name'         => 'Plano',
        'menu_name'             => 'Planos',
        'name_admin_bar'        => 'Plano',
        'add_new'               => 'Adicionar Novo',
        'add_new_item'          => 'Adicionar Novo Plano',
        'new_item'              => 'Novo Plano',
        'edit_item'             => 'Editar Plano',
        'view_item'             => 'Ver Plano',
        'all_items'             => 'Todos os Planos',
        'search_items'          => 'Buscar Planos',
        'not_found'             => 'Nenhum plano encontrado.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'plan'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-admin-site',
        'supports'           => array('title'),
    );

    register_post_type('top_plan', $args);
}

add_action('init', 'top_register_plan_post_type');

// Adicionar metaboxes para os campos adicionais
function top_add_plan_metaboxes() {
    add_meta_box(
        'top_plan_details',
        'Detalhes do Plano',
        'top_display_plan_metaboxes',
        'top_plan',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'top_add_plan_metaboxes');

// Exibir campos no metabox
function top_display_plan_metaboxes($post) {
    // Recuperar os metadados
    $velocidade = get_post_meta($post->ID, '_top_plan_velocidade', true);
    $preco = get_post_meta($post->ID, '_top_plan_preco', true);
    $tecnologia = get_post_meta($post->ID, '_top_plan_tecnologia', true);
    $diferencial1 = get_post_meta($post->ID, '_top_plan_diferencial1', true);
    $diferencial2 = get_post_meta($post->ID, '_top_plan_diferencial2', true);
    $diferencial3 = get_post_meta($post->ID, '_top_plan_diferencial3', true);
    $destaque = get_post_meta($post->ID, '_top_plan_destaque', true);

    // Campo de segurança nonce
    wp_nonce_field('top_save_plan_details', 'top_plan_details_nonce');

    // Campos de entrada
    echo '<p><label for="top_plan_velocidade">Velocidade:</label> <input type="text" id="top_plan_velocidade" name="top_plan_velocidade" value="' . esc_attr($velocidade) . '" /></p>';
    echo '<p><label for="top_plan_preco">Preço:</label> <input type="text" id="top_plan_preco" name="top_plan_preco" value="' . esc_attr($preco) . '" /></p>';
    echo '<p><label for="top_plan_tecnologia">Tecnologia:</label> <input type="text" id="top_plan_tecnologia" name="top_plan_tecnologia" value="' . esc_attr($tecnologia) . '" /></p>';
    echo '<p><label for="top_plan_diferencial1">Diferencial 1:</label> <input type="text" id="top_plan_diferencial1" name="top_plan_diferencial1" value="' . esc_attr($diferencial1) . '" /></p>';
    echo '<p><label for="top_plan_diferencial2">Diferencial 2:</label> <input type="text" id="top_plan_diferencial2" name="top_plan_diferencial2" value="' . esc_attr($diferencial2) . '" /></p>';
    echo '<p><label for="top_plan_diferencial3">Diferencial 3:</label> <input type="text" id="top_plan_diferencial3" name="top_plan_diferencial3" value="' . esc_attr($diferencial3) . '" /></p>';
    echo '<p><label for="top_plan_destaque">Destaque:</label> <input type="checkbox" id="top_plan_destaque" name="top_plan_destaque" value="1"' . checked($destaque, '1', false) . ' /> Marcar como destaque</p>';
}

// Função para salvar os campos adicionais
function top_save_plan_details($post_id) {
    // Verificar nonce
    if (!isset($_POST['top_plan_details_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['top_plan_details_nonce'])), 'top_save_plan_details')) {
        return;
    }

    // Verificar permissões do usuário
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Salvando os dados
    $velocidade = isset($_POST['top_plan_velocidade']) ? sanitize_text_field(wp_unslash($_POST['top_plan_velocidade'])) : '';
    $preco = isset($_POST['top_plan_preco']) ? sanitize_text_field(wp_unslash($_POST['top_plan_preco'])) : '';
    $tecnologia = isset($_POST['top_plan_tecnologia']) ? sanitize_text_field(wp_unslash($_POST['top_plan_tecnologia'])) : '';
    $diferencial1 = isset($_POST['top_plan_diferencial1']) ? sanitize_text_field(wp_unslash($_POST['top_plan_diferencial1'])) : '';
    $diferencial2 = isset($_POST['top_plan_diferencial2']) ? sanitize_text_field(wp_unslash($_POST['top_plan_diferencial2'])) : '';
    $diferencial3 = isset($_POST['top_plan_diferencial3']) ? sanitize_text_field(wp_unslash($_POST['top_plan_diferencial3'])) : '';
    $destaque = isset($_POST['top_plan_destaque']) ? '1' : '0';

    // Atualizar os metadados
    update_post_meta($post_id, '_top_plan_velocidade', $velocidade);
    update_post_meta($post_id, '_top_plan_preco', $preco);
    update_post_meta($post_id, '_top_plan_tecnologia', $tecnologia);
    update_post_meta($post_id, '_top_plan_diferencial1', $diferencial1);
    update_post_meta($post_id, '_top_plan_diferencial2', $diferencial2);
    update_post_meta($post_id, '_top_plan_diferencial3', $diferencial3);
    update_post_meta($post_id, '_top_plan_destaque', $destaque);
}

add_action('save_post', 'top_save_plan_details');
?>
