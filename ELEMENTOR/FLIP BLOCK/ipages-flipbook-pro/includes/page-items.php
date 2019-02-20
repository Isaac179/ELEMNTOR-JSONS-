<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

$list_table = new iPages_List_Table_Items();
$list_table->prepare_items();

?>
<div class="wrap ipages">
	<div class="ipages-page-header">
		<div class="ipages-title"><?php _e('iPages Flipbook Items', IPGS_PLUGIN_NAME); ?></div>
		<div class="ipages-actions">
			<a href="?page=<?php echo IPGS_PLUGIN_NAME . '_item'; ?>"><?php _e('Add Book', IPGS_PLUGIN_NAME); ?></a>
		</div>
	</div>
	<!-- ipages app -->
	<div id="ipages-app-items" class="ipages-app">
		<form method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
			<?php $list_table->display() ?>
		</form>
	</div>
	<!-- /end ipages app -->
</div>