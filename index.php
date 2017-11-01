<?php
/*
Plugin Name: Add WooCommerce Filters to Menu with Product Category
Plugin URI: https://martinpollock.co.uk
Description: Adds a new metabox item to WordPress's menu builder. Provides a simple way to Add WooCommerce Filters to a menu with a product category
Version: 1.0.0
Author: Martin Pollock
Author URI: https://martinpollock.co.uk
Text Domain: woocommerce-filters-in-menu
Domain Path: /languages
*/

//main plugin class
class mp_wc_filter_menu{

    public function __construct() {
        add_action('admin_init', array($this, 'add_meta_box'));
    }

    public function add_meta_box() {
        add_meta_box(
            'mp_wc_filter_menu_metabox',
            __('WooCommerce Filters', 'wc-filters-to-menu'),
            array($this, 'display_meta_box'),
            'nav-menus',
            'side',
            'low'
        );
    }

    public function display_meta_box() {

        ?>
        <style>
        #woocommerce-attribute-filters select {
            width: 100%;
        }
        </style>
        <div id="woocommerce-attribute-filters" class="">
            <div id="tabs-panel-woocommerce-attribute-filters" class="tabs-panel tabs-panel-active form-no-clear">

                <div id="mp_category">
                    <label for="mp_wc_filter_menu_category">Category: </label>
                    <select name='mp_wc_filter_menu_category' id='mp_wc_filter_menu_category'>
                        <option value="" disabled selected></option>
                        <?php $categories=get_categories( 'taxonomy=product_cat&hide_empty=0&hierarchical=0' ); foreach ($categories as $category): ?>
                        <option value="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br />

                <div id="mp_attribute">
                    <label for="mp_wc_filter_menu_attribute">Attribute: </label>
                    <select name='mp_wc_filter_menu_attribute' id='mp_wc_filter_menu_attribute'>
                        <option value="" disabled selected></option>
                        <?php $attributes=wc_get_attribute_taxonomies(); foreach ($attributes as $attribute): ?>
                            <?php if (strpos($attribute->attribute_name, 'filter-') !== false): ?>
                                <option value="<?php echo esc_attr($attribute->attribute_name); ?>"><?php echo esc_html($attribute->attribute_label); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br />

                <div id="mp_filter">
                    <label for="mp_wc_filter_menu_filter">Filter: </label>
                    <select name='mp_wc_filter_menu_filter' id='mp_wc_filter_menu_filter'>
                        <option value="" disabled selected></option>
                        <?php $attributes=wc_get_attribute_taxonomies(); foreach ($attributes as $attribute): ?>
                            <?php if (strpos($attribute->attribute_name, 'filter-') !== false): ?>
                                <?php $filters=get_terms( 'pa_'.esc_attr($attribute->attribute_name) ); foreach ($filters as $filter): ?>
                                    <option value="<?php echo esc_attr($filter->slug); ?>" class="<?php echo esc_attr($attribute->attribute_name); ?>"><?php echo esc_html($filter->name); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <ul id="woocommerce-attribute-filter-input" class="categorychecklist form-no-clear">
                    <li>
                        <label class="menu-item-title">
                            <input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="-1"/> Add to menu?
                        </label>
                        <input id="menu-item-type" type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="custom"/>
                        <input id="menu-item-title" type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value=""/>
                        <input id="menu-item-url" type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value=""/>
                        <input id="menu-item-classes" type="hidden" class="menu-item-classes" name="menu-item[-1][menu-item-classes]"/>
                    </li>
                </ul>

            </div>
            <p class="button-controls">
                <span class="add-to-menu">
                    <input type="submit" class="button-secondary submit-add-to-menu right" value="<?php _e('Add to Menu', 'wc-filters-to-menu') ?>" name="add-filter-menu-item" id="submit-woocommerce-attribute-filters">
                    <span class="spinner"></span>
                </span>
            </p>
        </div>
        <?php
    }

}
$mp_wc_filter_menu = new mp_wc_filter_menu();



function mp_wc_filter_scripts() {
    wp_enqueue_script( 'mp_wc_filter_scripts', plugins_url( 'scripts.js', __FILE__ ), array('jquery'));
}
add_action('admin_enqueue_scripts','mp_wc_filter_scripts');
