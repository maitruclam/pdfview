<div class="wrap wp-pdf-view-admin">
    <!-- Updated title to full plugin name -->
    <h1>MTL PDF View Gallery - Settings</h1>
    <p class="description" style="margin-bottom: 20px;">by <a href="https://maitruclam.com" target="_blank">maitruclam.com</a></p>
    
    <div class="admin-container">
        <!-- Add section for base path configuration -->
        <div class="admin-card">
            <h2>Path Configuration</h2>
            <p class="description">Change the PDF folder path (relative to uploads directory)</p>
            
            <form method="post" action="">
                <?php wp_nonce_field('wp_pdf_view_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="base_path">PDF Folder Path:</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="base_path"
                                name="base_path" 
                                value="<?php echo esc_attr($saved_base_path ?? '2025/10/so hoa TTHC'); ?>"
                                class="regular-text"
                            >
                            <p class="description">
                                Example: 2025/10/so hoa TTHC<br>
                                Full path: <?php echo esc_html(wp_upload_dir()['basedir']); ?>/<?php echo esc_html($saved_base_path ?? '2025/10/so hoa TTHC'); ?>
                            </p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" name="wp_pdf_view_save" class="button button-primary">
                        Save Changes
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Added new section for grid layout configuration -->
        <div class="admin-card">
            <h2>Grid Display Configuration</h2>
            <p class="description">Set the number of PDF files displayed per row on different devices</p>
            
            <form method="post" action="">
                <?php wp_nonce_field('wp_pdf_view_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="grid_columns_mobile">Columns on mobile:</label>
                        </th>
                        <td>
                            <input 
                                type="number" 
                                id="grid_columns_mobile"
                                name="grid_columns_mobile" 
                                value="<?php echo esc_attr($grid_columns['mobile'] ?? 1); ?>"
                                min="1"
                                max="4"
                                class="small-text"
                            >
                            <p class="description">Screens smaller than 768px (recommended: 1-2 columns)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="grid_columns_tablet">Columns on tablet:</label>
                        </th>
                        <td>
                            <input 
                                type="number" 
                                id="grid_columns_tablet"
                                name="grid_columns_tablet" 
                                value="<?php echo esc_attr($grid_columns['tablet'] ?? 2); ?>"
                                min="1"
                                max="6"
                                class="small-text"
                            >
                            <p class="description">Screens from 768px to 1024px (recommended: 2-3 columns)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="grid_columns_desktop">Columns on desktop:</label>
                        </th>
                        <td>
                            <input 
                                type="number" 
                                id="grid_columns_desktop"
                                name="grid_columns_desktop" 
                                value="<?php echo esc_attr($grid_columns['desktop'] ?? 3); ?>"
                                min="1"
                                max="8"
                                class="small-text"
                            >
                            <p class="description">Screens larger than 1024px (recommended: 3-4 columns)</p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" name="wp_pdf_view_save" class="button button-primary">
                        Save Changes
                    </button>
                </p>
            </form>
        </div>
        
        <!-- Add section for custom labels -->
        <div class="admin-card">
            <h2>Custom Display Labels</h2>
            <p class="description">Change the text displayed for filters</p>
            
            <form method="post" action="">
                <?php wp_nonce_field('wp_pdf_view_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="label_main_folder">Main folder label:</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="label_main_folder"
                                name="label_main_folder" 
                                value="<?php echo esc_attr($labels['main_folder'] ?? 'Main folder:'); ?>"
                                class="regular-text"
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="label_sub_folder">Sub folder label:</label>
                        </th>
                        <td>
                            <input 
                                type="text" 
                                id="label_sub_folder"
                                name="label_sub_folder" 
                                value="<?php echo esc_attr($labels['sub_folder'] ?? 'Sub folder (if any):'); ?>"
                                class="regular-text"
                            >
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" name="wp_pdf_view_save" class="button button-primary">
                        Save Changes
                    </button>
                </p>
            </form>
        </div>
        
        <div class="admin-card">
            <h2>Change Folder Display Names</h2>
            <p class="description">Change the display names of folders (since actual folder names are abbreviations). Leave empty to keep original name.</p>
            
            <form method="post" action="">
                <?php wp_nonce_field('wp_pdf_view_settings'); ?>
                
                <table class="form-table">
                    <thead>
                        <tr>
                            <th>Original Folder Name</th>
                            <th>Display Name</th>
                            <th>Subfolders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($folders as $folder_key => $subfolders): ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($folder_key); ?></strong>
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="folder_names[<?php echo esc_attr($folder_key); ?>]" 
                                        value="<?php echo esc_attr(isset($folder_names[$folder_key]) ? $folder_names[$folder_key] : ''); ?>"
                                        placeholder="<?php echo esc_attr($folder_key); ?>"
                                        class="regular-text"
                                    >
                                </td>
                                <td>
                                    <?php if (!empty($subfolders)): ?>
                                        <details>
                                            <summary><?php echo count($subfolders); ?> subfolders</summary>
                                            <div style="margin-top: 10px;">
                                                <?php foreach ($subfolders as $subfolder): ?>
                                                    <?php $subfolder_key = $folder_key . '/' . $subfolder; ?>
                                                    <div style="margin-bottom: 8px;">
                                                        <label style="display: inline-block; width: 150px; font-weight: normal;">
                                                            <?php echo esc_html($subfolder); ?>:
                                                        </label>
                                                        <input 
                                                            type="text" 
                                                            name="folder_names[<?php echo esc_attr($subfolder_key); ?>]" 
                                                            value="<?php echo esc_attr(isset($folder_names[$subfolder_key]) ? $folder_names[$subfolder_key] : ''); ?>"
                                                            placeholder="<?php echo esc_attr($subfolder); ?>"
                                                            class="regular-text"
                                                        >
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </details>
                                    <?php else: ?>
                                        <span class="subfolder-count">No subfolders</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <p class="submit">
                    <button type="submit" name="wp_pdf_view_save" class="button button-primary">
                        Save Changes
                    </button>
                </p>
            </form>
        </div>
        
        <div class="admin-card">
            <h2>Usage Instructions</h2>
            <ol>
                <li>Add shortcode <code>[pdf_view]</code> to page or post</li>
                <li>Place cover image file with name: <code>FileName-pdf.jpg</code> or <code>FileName-pdf.png</code></li>
                <li>Example: PDF named <code>QT.CN41.TTr3_23.pdf</code> should have cover image <code>QT.CN41.TTr3_23-pdf.jpg</code></li>
                <li>Cover image will automatically display on the interface</li>
                <li>Users can click on image to view PDF in popup</li>
                <li>Click outside PDF area (black area) to close popup</li>
            </ol>
            
            <h3>Path Information</h3>
            <p><strong>Base Path:</strong> <code><?php echo esc_html($saved_base_path ?? '2025/10/so hoa TTHC'); ?></code></p>
            <p><strong>Number of Folders:</strong> <?php echo count($folders); ?></p>
        </div>
    </div>
</div>
