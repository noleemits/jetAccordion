<?php
// Shortcode to generate the dynamic accordion using JetEngine fields
function wpe_dynamic_accordion_shortcode($atts) {
    // Ensure JetEngine functions exist
    if (!function_exists('jet_engine')) {
        return '<p>JetEngine is not active or installed. Please enable it to use this shortcode.</p>';
    }

    // Get the repeater field data
    $repeater_items = jet_engine()->listings->data->get_meta('wpe_faq_repeater'); // Replace with your actual repeater field key

    if (empty($repeater_items)) {
        return '<p>No data available for the accordion.</p>';
    }

    // Get the metabox values
    $title_tab_color = jet_engine()->listings->data->get_meta('title_tab_color');
    $title_text_color = jet_engine()->listings->data->get_meta('title_text_color');
    $content_background_color = jet_engine()->listings->data->get_meta('content_background_color');
    $content_text_color = jet_engine()->listings->data->get_meta('content_text_color');
    $border_color = jet_engine()->listings->data->get_meta('border_color') ?: '#D1D5DB';

    ob_start();

    echo '<div class="wpe-accordion" role="region" aria-label="Dynamic Accordion">';

    foreach ($repeater_items as $item) {
        // Extract item fields safely
        $title_image = !empty($item['title_image']) ? esc_url($item['title_image']) : '';
        $title_text = !empty($item['title_text']) ? esc_html($item['title_text']) : 'Untitled';
        $content_image = !empty($item['content_image']) ? esc_url($item['content_image']) : '';
        $content_text = !empty($item['content_text']) ? wp_kses_post($item['content_text']) : '';

        // Render each accordion item
        echo '<div class="wpe-accordion-item" style="--border-color: ' . esc_attr($border_color) . '">';
        echo '<div class="wpe-accordion-header" role="button" tabindex="0" aria-expanded="false">';
        if ($title_image) {
            echo '<img class="wpe-header-image" src="' . esc_url($title_image) . '" alt="Title Image" style="border-color: ' . esc_attr($border_color) . '">';
        }
        echo '<div class="wpe-title-box" style="background-color: ' . esc_attr($title_tab_color) . '; color: ' . esc_attr($title_text_color) . '; border-color: ' . esc_attr($border_color) . '">';
        echo '<h3>' . esc_html($title_text) . '</h3>';
        echo '<div class="wpe-toggle-icon"></div>';
        echo '</div>'; // .wpe-title-box
        echo '</div>'; // .wpe-accordion-header

        echo '<div class="wpe-accordion-content">';
        echo '<div class="wpe-content-container">';
        if ($content_image) {
            echo '<img class="wpe-content-image" src="' . esc_url($content_image) . '" alt="Content Image" style="border-color: ' . esc_attr($border_color) . '">';
        }
        echo '<div class="wpe-content-box" style="background-color: ' . esc_attr($content_background_color) . '; border-color: ' . esc_attr($border_color) . '; color: ' . esc_attr($content_text_color) . '">';
        echo '<p>' . wp_kses_post($content_text) . '</p>';
        echo '</div>'; // .wpe-content-box
        echo '</div>'; // .wpe-content-container
        echo '</div>'; // .wpe-accordion-content

        echo '</div>'; // .wpe-accordion-item
    }

    echo '</div>'; // .wpe-accordion

    return ob_get_clean();
}

add_shortcode('wpe_dynamic_accordion', 'wpe_dynamic_accordion_shortcode');
