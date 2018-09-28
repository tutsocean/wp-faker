<?php
$wpfkrAllThumbnailsObj = wpfkrGetFakeThumbnailsList();
$wpfkrAllThumbnails = $wpfkrAllThumbnailsObj->posts;
$wpfkrActual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(isset($_GET['action']) && $_GET['action'] == 'wpfkr_deletethumbnails'){
    wpfkrDeleteFakeThumbnails();
    wp_redirect("admin.php?page=wpfkr-thumbnails&status=success");
}
?>
<!-- new code -->
<div class="wrap wpfkr_wrapper" id="wp-media-grid" data-search="">
    <h1 class="wp-heading-inline"><?php echo  WPFKR_PLUGIN_NAME ?> <span> - All thumbnails</span></h1>
    <?php if(!empty($wpfkrAllThumbnails)){ ?>
        <a onclick="return confirm('Are you sure you want to delete all fake thumbnails?')" href="<?=$wpfkrActual_link?>&action=wpfkr_deletethumbnails" class="page-title-action aria-button-if-js" role="button" aria-expanded="false">Delete dummy thumbnails</a>
    <?php } ?>
    <hr class="wp-header-end">
    <?php 
    if(isset($_GET['status'])){
        if($_GET['status'] == 'success'){
            echo '<div class="wpfkr-success-msg">All thumbnails deleted successfully.</div>';
        }else{
            echo '<div class="wpfkr-error-msg">Something went wrong.</div>';
        } ?>
        <hr class="wp-header-end">
        <?php
    } ?>
    <div class="media-frame wp-core-ui mode-grid mode-edit hide-menu">
        <div class="media-frame-content" data-columns="7">
            <div class="attachments-browser hide-sidebar sidebar-for-errors">
                <?php if(!empty($wpfkrAllThumbnails)){ ?>
                    <ul tabindex="-1" class="attachments ui-sortable ui-sortable-disabled" id="__attachments-view-42">
                        <?php 
                            foreach ($wpfkrAllThumbnails as $key => $wpfkrAllThumbnail) { ?>
                                
                                <li tabindex="0" role="checkbox" aria-label="wpfkr_1866" aria-checked="false" data-id="1867" class="attachment save-ready">
                                    <div class="attachment-preview js--select-attachment type-image subtype-jpg landscape">
                                        <div class="thumbnail">
                                            <div class="centered">
                                                <img class="wpfkrThumbnailsImage" src="<?=wp_get_attachment_url($wpfkrAllThumbnail->ID)?>" draggable="false" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                    </ul>
                <?php }else{ ?>
                        <p class="no-media">No media files found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- new code -->