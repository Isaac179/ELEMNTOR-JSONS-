<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );

?>
<div class="wrap ipages">
	<div class="ipages-page-header">
		<div class="ipages-title"><?php _e('iPages Settings', IPGS_PLUGIN_NAME); ?></div>
	</div>
	<div class="ipages-messages" id="ipages-messages">
	</div>
	<!-- ipages app -->
	<div id="ipages-app-settings" class="ipages-app" style="display:none;">
		<div class="ipages-loader-wrap">
			<div class="ipages-loader">
				<div class="ipages-loader-bar"></div>
				<div class="ipages-loader-bar"></div>
				<div class="ipages-loader-bar"></div>
				<div class="ipages-loader-bar"></div>
			</div>
		</div>
		<div class="ipages-wrap">
			<div class="ipages-workplace">
				<div class="ipages-main-tabs ipages-clear-fix">
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.general" al-on.click="appData.fn.onTab(appData, 'general')"><?php _e('General', IPGS_PLUGIN_NAME); ?></div>
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.actions" al-on.click="appData.fn.onTab(appData, 'actions')"><?php _e('Actions', IPGS_PLUGIN_NAME); ?></div>
					<div class="ipages-tab">
						<div class="ipages-button ipages-blue" al-on.click="appData.fn.saveConfig(appData);"><?php _e('Save', IPGS_PLUGIN_NAME); ?></div>
					</div>
				</div>
				<div class="ipages-main-data">
					<div id="ipages-section-pages" al-if="appData.ui.tabs.general">
						<div class="ipages-stage">
							<div class="ipages-main-panel">
								<div class="ipages-data">
									<div class="ipages-control">
										<div class="ipages-helper"><div class="ipages-tooltip"><?php _e('Choose a default theme for your custom javascript editor', IPGS_PLUGIN_NAME); ?></div></div>
										<div class="ipages-label"><?php _e('JavaScript editor theme', IPGS_PLUGIN_NAME); ?></div>
										<select class="ipages-select" al-select="appData.config.themeJavaScript">
											<option al-option="null"><?php _e('default', IPGS_PLUGIN_NAME); ?></option>
											<option al-repeat="theme in appData.themes" al-option="theme.id">{{theme.title}}</option>
										</select>
									</div>
									<div class="ipages-control">
										<div class="ipages-helper"><div class="ipages-tooltip"><?php _e('Choose a default theme for your custom css editor', IPGS_PLUGIN_NAME); ?></div></div>
										<div class="ipages-label"><?php _e('CSS editor theme', IPGS_PLUGIN_NAME); ?></div>
										<select class="ipages-select" al-select="appData.config.themeCSS">
											<option al-option="null"><?php _e('default', IPGS_PLUGIN_NAME); ?></option>
											<option al-repeat="theme in appData.themes" al-option="theme.id">{{theme.title}}</option>
										</select>
									</div>
									<div class="ipages-control">
										<div class="ipages-helper" title="<?php _e('If set true, the progressive loading of a PDF document is enabled', IPGS_PLUGIN_NAME); ?>"></div>
										<div class="ipages-label"><?php _e('PDF progressive loading', IPGS_PLUGIN_NAME); ?></div>
										<div al-toggle="appData.config.pdfProgressiveLoading"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="ipages-section-actions" al-if="appData.ui.tabs.actions">
						<div class="ipages-stage">
							<div class="ipages-main-panel">
								<div class="ipages-data">
									<div class="ipages-control">
										<div class="ipages-helper" title="<?php _e('Delete all book items from database', IPGS_PLUGIN_NAME); ?>"></div>
										<div class="ipages-button ipages-red" al-on.click="appData.fn.deleteAllData(appData, '. <?php _e('Do you really want to delete all data?', IPGS_PLUGIN_NAME); ?> . ');"><?php _e('Delete all data', IPGS_PLUGIN_NAME); ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /end ipages app -->
</div>