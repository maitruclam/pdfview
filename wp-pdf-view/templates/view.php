<div class="pdf-gallery-container">
    <div class="pdf-gallery-filters">
        <div class="filters-row">
            <div class="filter-group">
                <!-- Use custom label for main folder -->
                <label for="main-folder"><?php echo esc_html($labels['main_folder']); ?></label>
                <select id="main-folder" class="pdf-filter-select">
                    <option value="">-- All --</option>
                    <?php foreach ($folders_with_names as $folder => $data): ?>
                        <option value="<?php echo esc_attr($folder); ?>">
                            <?php echo esc_html($data['display_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <!-- Use custom label for sub folder -->
                <label for="sub-folder"><?php echo esc_html($labels['sub_folder']); ?></label>
                <select id="sub-folder" class="pdf-filter-select" disabled>
                    <option value="">-- All --</option>
                </select>
            </div>
            
            <div class="filter-group filter-actions">
                <label>&nbsp;</label>
                <button id="reset-filters" class="pdf-reset-btn">RESET FILTERS</button>
            </div>
        </div>
    </div>
    
    <div class="pdf-gallery-results">
        <div class="results-header">
            <h3>Document List</h3>
            <span class="results-count">Loading...</span>
        </div>
        
        <div id="pdf-grid" class="pdf-grid">
            <div class="loading-spinner">
                <div class="spinner"></div>
                <p>Loading documents...</p>
            </div>
        </div>
    </div>
</div>

<!-- PDF Viewer Modal -->
<div id="pdf-modal" class="pdf-modal">
    <div class="pdf-modal-content">
        <div class="pdf-modal-header">
            <h3 id="pdf-modal-title">View Document</h3>
            <button class="pdf-modal-close">&times;</button>
        </div>
        <div class="pdf-modal-body">
            <iframe id="pdf-viewer" src="" frameborder="0"></iframe>
        </div>
    </div>
</div>

<script type="text/javascript">
window.folderStructure = <?php echo json_encode($folders_with_names); ?>;
window.wpPdfView = window.wpPdfView || {};
</script>

