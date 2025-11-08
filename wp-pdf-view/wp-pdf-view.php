<?php
/**
 * Plugin Name: MTL PDF View Gallery
 * Plugin URI: https://maitruclam.com
 * Description: Display and manage PDF files with filters and popup viewer - by maitruclam.com
 * Version: 1.3.0
 * Author: maitruclam.com
 * Text Domain: mtl-pdf-view-gallery
 */

if (!defined('ABSPATH')) {
    exit;
}

class WP_PDF_View {
    private $base_path = '2025/10/so hoa TTHC';
    
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_shortcode('pdf_view', [$this, 'render_view']);
        add_action('wp_ajax_get_pdf_files', [$this, 'ajax_get_files']);
        add_action('wp_ajax_nopriv_get_pdf_files', [$this, 'ajax_get_files']);
        
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'MTL PDF View Gallery Settings',
            'MTL PDF View',
            'manage_options',
            'wp-pdf-view',
            [$this, 'render_admin_page'],
            'dashicons-media-document',
            30
        );
    }
    
    public function register_settings() {
        register_setting('wp_pdf_view_settings', 'wp_pdf_view_folder_names');
        register_setting('wp_pdf_view_settings', 'wp_pdf_view_labels');
        register_setting('wp_pdf_view_settings', 'wp_pdf_view_base_path');
        register_setting('wp_pdf_view_settings', 'wp_pdf_view_grid_columns');
    }
    
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_wp-pdf-view') {
            return;
        }
        
        wp_enqueue_style('wp-pdf-view-admin', plugins_url('assets/admin-style.css', __FILE__), [], '1.3.0');
    }
    
    public function render_admin_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Save settings
        if (isset($_POST['wp_pdf_view_save'])) {
            check_admin_referer('wp_pdf_view_settings');
            
            $folder_names = [];
            if (isset($_POST['folder_names']) && is_array($_POST['folder_names'])) {
                foreach ($_POST['folder_names'] as $key => $value) {
                    $folder_names[sanitize_text_field($key)] = sanitize_text_field($value);
                }
            }
            update_option('wp_pdf_view_folder_names', $folder_names);
            
            $labels = [
                'main_folder' => sanitize_text_field($_POST['label_main_folder'] ?? 'Thư mục chính:'),
                'sub_folder' => sanitize_text_field($_POST['label_sub_folder'] ?? 'Thư mục con (nếu có):')
            ];
            update_option('wp_pdf_view_labels', $labels);
            
            $base_path = sanitize_text_field($_POST['base_path'] ?? '2025/10/so hoa TTHC');
            update_option('wp_pdf_view_base_path', $base_path);
            $this->base_path = $base_path;
            
            $grid_columns = [
                'mobile' => intval($_POST['grid_columns_mobile'] ?? 1),
                'tablet' => intval($_POST['grid_columns_tablet'] ?? 2),
                'desktop' => intval($_POST['grid_columns_desktop'] ?? 3)
            ];
            update_option('wp_pdf_view_grid_columns', $grid_columns);
            
            echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
        }
        
        $saved_base_path = get_option('wp_pdf_view_base_path', '2025/10/so hoa TTHC');
        $this->base_path = $saved_base_path;
        
        $folders = $this->get_folder_structure();
        $folder_names = get_option('wp_pdf_view_folder_names', []);
        $labels = get_option('wp_pdf_view_labels', [
            'main_folder' => 'Main folder:',
            'sub_folder' => 'Sub folder (if any):'
        ]);
        $grid_columns = get_option('wp_pdf_view_grid_columns', [
            'mobile' => 1,
            'tablet' => 2,
            'desktop' => 3
        ]);
        
        include plugin_dir_path(__FILE__) . 'templates/admin-page.php';
    }
    
    private function get_folder_display_name($folder_key) {
        $folder_names = get_option('wp_pdf_view_folder_names', []);
        return isset($folder_names[$folder_key]) && !empty($folder_names[$folder_key]) 
            ? $folder_names[$folder_key] 
            : $folder_key;
    }
    
    public function enqueue_assets() {
        $saved_base_path = get_option('wp_pdf_view_base_path', '2025/10/so hoa TTHC');
        $this->base_path = $saved_base_path;
        
        wp_enqueue_style('wp-pdf-view', plugins_url('assets/style.css', __FILE__), [], '1.3.0');
        wp_enqueue_script('wp-pdf-view', plugins_url('assets/script.js', __FILE__), ['jquery'], '1.3.0', true);
        
        $upload_dir = wp_upload_dir();
        $full_path = $upload_dir['basedir'] . '/' . $this->base_path . '/';
        
        $grid_columns = get_option('wp_pdf_view_grid_columns', [
            'mobile' => 1,
            'tablet' => 2,
            'desktop' => 3
        ]);
        
        wp_localize_script('wp-pdf-view', 'wpPdfView', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pdf_view_nonce'),
            'basePath' => $this->base_path,
            'fullPath' => $full_path,
            'pathExists' => file_exists($full_path) ? 'yes' : 'no',
            'gridColumns' => $grid_columns
        ]);
    }
    
    public function render_view($atts) {
        $saved_base_path = get_option('wp_pdf_view_base_path', '2025/10/so hoa TTHC');
        $this->base_path = $saved_base_path;
        
        $atts = shortcode_atts([
            'base_folder' => 'so hoa TTHC'
        ], $atts);
        
        $folders = $this->get_folder_structure();
        
        $labels = get_option('wp_pdf_view_labels', [
            'main_folder' => 'Main folder:',
            'sub_folder' => 'Sub folder (if any):'
        ]);
        
        $folder_names = get_option('wp_pdf_view_folder_names', []);
        $folders_with_names = [];
        foreach ($folders as $key => $subfolders) {
            $display_name = $this->get_folder_display_name($key);
            $folders_with_names[$key] = [
                'display_name' => $display_name,
                'subfolders' => []
            ];
            
            foreach ($subfolders as $subfolder) {
                $subfolder_key = $key . '/' . $subfolder;
                $subfolder_display = $this->get_folder_display_name($subfolder_key);
                $folders_with_names[$key]['subfolders'][$subfolder] = $subfolder_display;
            }
        }
        
        ob_start();
        include plugin_dir_path(__FILE__) . 'templates/view.php';
        return ob_get_clean();
    }
    
    private function get_folder_structure() {
        $upload_dir = wp_upload_dir();
        $full_path = $upload_dir['basedir'] . '/' . $this->base_path . '/';
        
        if (!file_exists($full_path)) {
            error_log('[MTL PDF View] Path does not exist: ' . $full_path);
            return [];
        }
        
        $folders = [];
        $items = @scandir($full_path);
        
        if ($items === false) {
            error_log('[MTL PDF View] Cannot read directory: ' . $full_path);
            return [];
        }
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            
            $item_path = $full_path . $item;
            if (is_dir($item_path)) {
                $subfolders = $this->get_subfolders($item_path);
                $folders[$item] = $subfolders;
            }
        }
        
        return $folders;
    }
    
    private function get_subfolders($path) {
        $subfolders = [];
        $items = @scandir($path);
        
        if ($items === false) {
            return [];
        }
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            
            $item_path = $path . '/' . $item;
            if (is_dir($item_path)) {
                $subfolders[] = $item;
            }
        }
        
        return $subfolders;
    }
    
    public function ajax_get_files() {
        check_ajax_referer('pdf_view_nonce', 'nonce');
        
        $saved_base_path = get_option('wp_pdf_view_base_path', '2025/10/so hoa TTHC');
        $this->base_path = $saved_base_path;
        
        $main_folder = isset($_POST['main_folder']) ? sanitize_text_field($_POST['main_folder']) : '';
        $sub_folder = isset($_POST['sub_folder']) ? sanitize_text_field($_POST['sub_folder']) : '';
        
        error_log('[MTL PDF View] AJAX Request - Main folder: ' . $main_folder . ', Sub folder: ' . $sub_folder);
        
        $upload_dir = wp_upload_dir();
        $base_path = $upload_dir['basedir'] . '/' . $this->base_path . '/';
        $base_url = $upload_dir['baseurl'] . '/' . $this->base_path . '/';
        
        $search_path = $base_path;
        $search_url = $base_url;
        
        if ($main_folder) {
            $search_path .= $main_folder . '/';
            $search_url .= rawurlencode($main_folder) . '/';
        }
        
        if ($sub_folder) {
            $search_path .= $sub_folder . '/';
            $search_url .= rawurlencode($sub_folder) . '/';
        }
        
        error_log('[MTL PDF View] Search path: ' . $search_path);
        error_log('[MTL PDF View] Path exists: ' . (file_exists($search_path) ? 'yes' : 'no'));
        
        if (!file_exists($search_path)) {
            error_log('[MTL PDF View] Path does not exist: ' . $search_path);
            wp_send_json_error('Path does not exist: ' . $search_path);
            return;
        }
        
        $files = $this->scan_for_pdfs($search_path, $search_url);
        
        error_log('[MTL PDF View] Files found: ' . count($files));
        
        wp_send_json_success($files);
    }
    
    private function scan_for_pdfs($path, $url, $recursive = true) {
        $files = [];
        
        if (!file_exists($path)) {
            return $files;
        }
        
        $items = @scandir($path);
        
        if ($items === false) {
            return $files;
        }
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            
            $item_path = $path . $item;
            $item_url = $url . rawurlencode($item);
            
            if (is_file($item_path) && strtolower(pathinfo($item, PATHINFO_EXTENSION)) === 'pdf') {
                $filename = pathinfo($item, PATHINFO_FILENAME);
                $cover_url = null;
                
                // Try multiple naming patterns
                $patterns = [
                    $filename . '-pdf.jpg',
                    $filename . '-pdf.png',
                    $filename . '.jpg',
                    $filename . '.png'
                ];
                
                foreach ($patterns as $pattern) {
                    $cover_path = $path . $pattern;
                    if (file_exists($cover_path)) {
                        $cover_url = $url . rawurlencode($pattern);
                        break;
                    }
                }
                
                $files[] = [
                    'name' => $filename,
                    'url' => $item_url,
                    'path' => $item_path,
                    'cover' => $cover_url,
                    'size' => $this->format_bytes(filesize($item_path))
                ];
            } elseif (is_dir($item_path) && $recursive) {
                $files = array_merge($files, $this->scan_for_pdfs($item_path . '/', $item_url . '/', true));
            }
        }
        
        return $files;
    }
    
    private function format_bytes($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
    
}

new WP_PDF_View();

