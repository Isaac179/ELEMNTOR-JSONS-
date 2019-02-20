<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

$page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
$author = get_the_author_meta('display_name', $item->author);
$modified = mysql2date(get_option('date_format'), $item->modified) . ' at ' . mysql2date(get_option('time_format'), $item->modified);

?>
<div class="wrap ipages">
	<div class="ipages-page-header">
		<div class="ipages-title"><?php _e('iPages Flipbook Item', IPGS_PLUGIN_NAME); ?></div>
		<div class="ipages-actions">
			<a href="?page=<?php echo IPGS_PLUGIN_NAME . '_item'; ?>"><?php _e('Add Book', IPGS_PLUGIN_NAME); ?></a>
		</div>
	</div>
	<div class="ipages-messages" id="ipages-messages">
	</div>
	<!-- ipages app -->
	<div id="ipages-app-item" class="ipages-app" style="display:none;">
		<input id="ipages-load-config-from-file" type="file" style="display:none;" />
		<div class="ipages-loader-wrap">
			<div class="ipages-loader">
				<div class="ipages-loader-bar"></div>
				<div class="ipages-loader-bar"></div>
				<div class="ipages-loader-bar"></div>
				<div class="ipages-loader-bar"></div>
			</div>
		</div>
		<div class="ipages-wrap">
			<div class="ipages-main-header">
				<input class="ipages-title" type="text" al-text="appData.config.title" placeholder="<?php _e('Title', IPGS_PLUGIN_NAME); ?>">
			</div>
			<div class="ipages-workplace">
				<div class="ipages-main-menu">
					<div class="ipages-left-panel">
						<a class="ipages-version-lite" href="https://1.envato.market/c/1288327/275988/4415?u=https%3A%2F%2Fcodecanyon.net%2Fitem%2Fipages-flipbook-pdf-viewer-for-wordpress%2F22488858" al-if="appData.plan=='lite'"><?php _e('Buy pro version', IPGS_PLUGIN_NAME); ?></a>
						<!--<a class="ipages-version-lite" href="#" al-if="appData.plan=='lite'"><?php _e('Lite version', IPGS_PLUGIN_NAME); ?></a>-->
						<a class="ipages-version-pro" href="https://codecanyon.net/user/avirtum/portfolio?ref=avirtum" al-if="appData.plan=='pro'"><?php _e('Pro Version', IPGS_PLUGIN_NAME); ?></a>
					</div>
					<div class="ipages-right-panel">
						<div class="ipages-item">
							<i class="ipages-icon ipages-icon-menu"></i>
							<div class="ipages-menu-list">
								<a href="#" al-on.click="appData.fn.loadConfigFromFile(appData)"><i class="ipages-icon ipages-icon-from-file"></i><?php _e('Load Config From File', IPGS_PLUGIN_NAME); ?></a>
								<a href="#" al-on.click="appData.fn.saveConfigToFile(appData)"><i class="ipages-icon ipages-icon-to-file"></i><?php _e('Save Config To File', IPGS_PLUGIN_NAME); ?></a>
							</div>
						</div>
						<div class="ipages-item" al-on.click="appData.fn.toggleFullscreen(appData)">
							<i class="ipages-icon ipages-icon-size-fullscreen" al-if="!appData.ui.fullscreen"></i>
							<i class="ipages-icon ipages-icon-size-actual" al-if="appData.ui.fullscreen"></i>
						</div>
					</div>
				</div>
				<div class="ipages-main-tabs ipages-clear-fix">
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.general" al-on.click="appData.fn.onTab(appData, 'general')"><?php _e('General', IPGS_PLUGIN_NAME); ?><div class="ipages-status" al-if="appData.config.active"></div></div>
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.pages" al-on.click="appData.fn.onTab(appData, 'pages')"><?php _e('Pages', IPGS_PLUGIN_NAME); ?></div>
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.customCSS" al-on.click="appData.fn.onTab(appData, 'customCSS')"><?php _e('Custom CSS', IPGS_PLUGIN_NAME); ?><div class="ipages-status" al-if="appData.config.customCSS.active"></div></div>
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.customJS" al-on.click="appData.fn.onTab(appData, 'customJS')"><?php _e('Custom JS', IPGS_PLUGIN_NAME); ?><div class="ipages-status" al-if="appData.config.customJS.active"></div></div>
					<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.tabs.shortcode" al-on.click="appData.fn.onTab(appData, 'shortcode')" al-if="appData.wp_item_id"><?php _e('Shortcode', IPGS_PLUGIN_NAME); ?></div>
					<div class="ipages-tab">
						<div id="ipages-pdf-loading" class="ipages-pdf-loading"><?php _e('Loading PDF', IPGS_PLUGIN_NAME); ?><span class="ipages-pdf-loading-percent"></span></div>
						<div class="ipages-button ipages-blue" al-on.click="appData.fn.saveConfig(appData);"><?php _e('Save', IPGS_PLUGIN_NAME); ?></div>
					</div>
				</div>
				<div class="ipages-main-data">
					<div class="ipages-section" al-attr.class.ipages-active="appData.ui.tabs.general">
						<div class="ipages-stage">
							<div class="ipages-main-panel">
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.settings">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'settings')">
										<div class="ipages-block-title"><?php _e('Main settings', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable book', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Enable book', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.active"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Choose a book style', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Book mode', IPGS_PLUGIN_NAME); ?></div>
											<select class="ipages-select" al-select="appData.config.bookEngine">
												<option al-option="null"><?php _e('default', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'TwoPageFlip'"><?php _e('Two page flip', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'OnePageFlip'"><?php _e('One page flip', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'OnePageSwipe'"><?php _e('One page swipe', IPGS_PLUGIN_NAME); ?></option>
											</select>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Page width (if not set then default page width will be used)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page width', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-integer="appData.config.pageWidth" placeholder="<?php _e('Default: 300', IPGS_PLUGIN_NAME); ?>" al-attr.class.ipages-attention="appData.config.containerHeight">
											<div class="ipages-advice" al-if="appData.pdfPageWidth"><?php _e('use {{appData.pdfPageWidth}} based on loaded PDF', IPGS_PLUGIN_NAME); ?></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Page height (if not set then default page height will be used)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page height', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-integer="appData.config.pageHeight" placeholder="<?php _e('Default: 360', IPGS_PLUGIN_NAME); ?>" al-attr.class.ipages-attention="appData.config.containerHeight">
											<div class="ipages-advice" al-if="appData.pdfPageHeight"><?php _e('use {{appData.pdfPageHeight}} based on loaded PDF', IPGS_PLUGIN_NAME); ?></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Page number to show after the book is ready', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page start', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-integer="appData.config.pageStart" placeholder="<?php _e('Default: 1', IPGS_PLUGIN_NAME); ?>">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Preload page neighbours for faster loading', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Preload neighbours', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.preloadNeighbours"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Make the book look good on all devices', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Responsive', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.responsive"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Auto fill all available space inside of the book container', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Autofit', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.autoFit"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable prevention of the default behavior on the mouseWheel event', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Mouse wheel, prevent the default behavior', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.mouseWheelPreventDefault"></div>
										</div>
									</div>
								</div>
								
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.pdf">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'pdf')">
										<div class="ipages-block-title"><?php _e('PDF settings', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set pdf document url', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('PDF url', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-input-group">
												<div class="ipages-input-group-cell">
													<input class="ipages-text ipages-long" type="text" al-text="appData.config.pdfUrl" placeholder="<?php _e('Select a pdf document', IPGS_PLUGIN_NAME); ?>">
												</div>
												<div class="ipages-input-group-cell">
													<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.selectPDFDocument(appData)" title="<?php _e('Select a pdf document', IPGS_PLUGIN_NAME); ?>">...</div>
												</div>
												<div class="ipages-input-group-cell">
													<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.generatePDFPages(appData)" title="<?php _e('Create pages from a pdf document', IPGS_PLUGIN_NAME); ?>"><span><i class="ipages-icon ipages-icon-plus"></i></span></div>
												</div>
											</div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('If set true, all book pages will be automatically created from PDF document', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Auto create pages', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.pdfAutoCreatePages"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('If set true, the book page sizes will be automatically taken from PDF document, otherwise, the plugin will be use pageWidth and pageHeight parameters', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Book size from the selected document', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.pdfBookSizeFromDocument"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('If set true, the progressive loading of a PDF document is enabled', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Progressive loading', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.pdfProgressiveLoading"></div>
										</div>
									</div>
								</div>
								
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.view">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'view')">
										<div class="ipages-block-title"><?php _e('View settings', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Specifies the theme of the book', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Book theme', IPGS_PLUGIN_NAME); ?></div>
											<select class="ipages-select ipages-capitalize" al-select="appData.config.bookTheme">
												<option al-option="null"><?php _e('none', IPGS_PLUGIN_NAME); ?></option>
												<!--<option al-option="'default'"><?php _e('default', IPGS_PLUGIN_NAME); ?></option>-->
												<option al-repeat="theme in appData.bookThemes" al-option="theme.id">{{theme.title}}</option>
											</select>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set additional css classes to the book container', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Additional book CSS class', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text" type="text" al-text="appData.config.bookClass">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Choose a book style for the portrait mode', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Book portrait mode', IPGS_PLUGIN_NAME); ?></div>
											<select class="ipages-select" al-select="appData.config.bookEnginePortrait">
												<option al-option="null"><?php _e('default', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'TwoPageFlip'"><?php _e('Two page flip', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'OnePageFlip'"><?php _e('One page flip', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'OnePageSwipe'"><?php _e('One page swipe', IPGS_PLUGIN_NAME); ?></option>
											</select>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Choose a book style for the landscape mode', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Book landscape mode', IPGS_PLUGIN_NAME); ?></div>
											<select class="ipages-select" al-select="appData.config.bookEngineLandscape">
												<option al-option="null"><?php _e('default', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'TwoPageFlip'"><?php _e('Two page flip', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'OnePageFlip'"><?php _e('One page flip', IPGS_PLUGIN_NAME); ?></option>
												<option al-option="'OnePageSwipe'"><?php _e('One page swipe', IPGS_PLUGIN_NAME); ?></option>
											</select>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('The ratio value (w/h), if less than enable portrait type, if more then enable landscape type', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Ratio coefficient (portrait or landscape)', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-float="appData.config.ratioPortraitToLandscape" placeholder="<?php _e('Default: 1.3', IPGS_PLUGIN_NAME); ?>">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable auto container width', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Auto container width', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.autoWidth"></div>
										</div>
										
										<div class="ipages-control" al-if="!appData.config.autoWidth">
											<div class="ipages-helper" title="<?php _e('Sets the book container width, can be any valid CSS units, not just pixels', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Container Width', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text" type="text" al-text="appData.config.containerWidth">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable auto container height, if sets true, the height will be depends on the book size', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Auto container height', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.autoHeight"></div>
										</div>
										
										<div class="ipages-control" al-if="!appData.config.autoHeight">
											<div class="ipages-helper" title="<?php _e('Sets the book container height, can be any valid CSS units, not just pixels, if not set, the height will be calculated automatic', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Container Height', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text" type="text" al-text="appData.config.containerHeight">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Generate space around the book\'s content', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Padding (top, right, bottom, left)', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number ipages-quarter" placeholder="<?php _e('top', IPGS_PLUGIN_NAME); ?>" al-integer="appData.config.padding.top">
											<input class="ipages-number ipages-quarter" placeholder="<?php _e('right', IPGS_PLUGIN_NAME); ?>" al-integer="appData.config.padding.right">
											<input class="ipages-number ipages-quarter" placeholder="<?php _e('bottom', IPGS_PLUGIN_NAME); ?>" al-integer="appData.config.padding.bottom">
											<input class="ipages-number ipages-quarter" placeholder="<?php _e('left', IPGS_PLUGIN_NAME); ?>" al-integer="appData.config.padding.left">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Give a turn-over page some perspective', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Perspective', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-integer="appData.config.perspective" placeholder="<?php _e('Default: 1500', IPGS_PLUGIN_NAME); ?>">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set time in milliseconds (1000 = 1sec)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Flip duration (ms)', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-integer="appData.config.flipDuration" placeholder="<?php _e('Default: 300', IPGS_PLUGIN_NAME); ?>">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable page flip sound', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page flip sound', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.flipSound"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set page flip sound url (mp3 or ogg format)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page flip sound url', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-input-group">
												<div class="ipages-input-group-cell">
													<input class="ipages-text ipages-long" type="text" al-text="appData.config.flipSoundUrl" placeholder="<?php _e('Select a sound file', IPGS_PLUGIN_NAME); ?>">
												</div>
												<div class="ipages-input-group-cell">
													<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.playFlipSound(appData)" title="<?php _e('Play a flip sound', IPGS_PLUGIN_NAME); ?>"><span><i class="ipages-icon ipages-icon-play"></i></span></div>
												</div>
												<div class="ipages-input-group-cell">
													<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.selectFlipSound(appData)" title="<?php _e('Select a flip sound', IPGS_PLUGIN_NAME); ?>">...</div>
												</div>
											</div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Background color in hexadecimal format (#fff or #555555)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Background color', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text" type="text" al-text="appData.config.backgroundColor" placeholder="<?php _e('Example: #ffffff', IPGS_PLUGIN_NAME); ?>">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set background image (jpeg or png format)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Background image', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-input-group">
												<div class="ipages-input-group-cell">
													<input class="ipages-text ipages-long" type="text" al-text="appData.config.backgroundImage.url" placeholder="<?php _e('Select an image', IPGS_PLUGIN_NAME); ?>">
												</div>
												<div class="ipages-input-group-cell">
													<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.selectBackgroundImage(appData)" title="<?php _e('Select a background image', IPGS_PLUGIN_NAME); ?>">...</div>
												</div>
											</div>
											<div class="ipages-input-group">
												<div class="ipages-input-group-cell pages-pinch">
													<div al-checkbox="appData.config.backgroundImage.relative"></div>
												</div>
												<div class="ipages-input-group-cell">
													<?php _e('Use relative path', IPGS_PLUGIN_NAME); ?>
												</div>
											</div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Specifies the size of the background images', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Background size', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-select" al-backgroundsize="appData.config.backgroundSize"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('How a background image will be repeated', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Background repeat', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-select" al-backgroundrepeat="appData.config.backgroundRepeat"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Sets the starting position of a background image', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Background position', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text" type="text" al-text="appData.config.backgroundPosition" placeholder="<?php _e('Example: 50% 50%', IPGS_PLUGIN_NAME); ?>">
										</div>
									</div>
								</div>
								
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.zoom">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'zoom')">
										<div class="ipages-block-title"><?php _e('Zoom', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('The current book zoom level', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Zoom level', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-float="appData.config.zoom">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('The maximum book zoom level', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Max zoom level', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-float="appData.config.zoomMax">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('The minimum book zoom level', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Min zoom level', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-float="appData.config.zoomMin">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('The number of the zoom step', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Zoom step', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-float="appData.config.zoomStep">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable the focal point on the book on which to zoom', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Zoom focal', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.zoomFocal"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Sets the scaling of the book to default after double click or tap event', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Zoom default after double click or tap', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.dblClickZoomDefault"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Sets the scaling of the book with the mouse wheel', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Mouse wheel zoom', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.mouseWheelZoom"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Sets the scaling of the book with the keyboard (+ and - keys)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Keyboard zoom', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.keyboardZoom"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Sets the scaling of the book with multi-touch gestures', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Pinch zoom', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.pinchZoom"></div>
										</div>
										
										<div class="ipages-control" al-if="appData.config.pinchZoom">
											<div class="ipages-helper" title="<?php _e('The number by which the book is zoomed', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Pinch zoom step', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-float="appData.config.pinchZoomCoef">
										</div>
									</div>
								</div>
								
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.navigation">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'navigation')">
										<div class="ipages-block-title"><?php _e('Navigation', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Show/hide prev & next navigation buttons', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Prev & next buttons', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.prevnextButtons"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable navigation via mouse drag', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Mouse drag navigation', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.mouseDragNavigation"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable navigation via mouse click on a page', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page click navigation', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.mousePageClickNavigation"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable navigation with touch events', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Touch navigation', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.touchNavigation"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable navigation via keyboard', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Keyboard navigation', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.keyboardNavigation"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable navigation via mouse wheel', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Mouse wheel navigation', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.mouseWheelNavigation"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Show/hide page numbers', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page numbers', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.pageNumbers"></div>
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Initial page numbering value', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Page number first', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number" al-integer="appData.config.pageNumbersFirst">
										</div>
										
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Numbers of pages to be hidden (-1 is the last page)', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Hide page numbers', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text" type="text" al-text="appData.config.pageNumbersHidden" placeholder="<?php _e('Example: 1;-1', IPGS_PLUGIN_NAME); ?>">
										</div>
									</div>
								</div>
								
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.toolbar">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'toolbar')">
										<div class="ipages-block-title"><?php _e('Toolbar', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Show/hide the toolbar control', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Enable toolbar', IPGS_PLUGIN_NAME); ?></div>
											<div al-toggle="appData.config.toolbar"></div>
										</div>
										
										<div al-if="appData.config.toolbar">
											<div class="ipages-control">
												<div class="ipages-helper" title="<?php _e('Show/hide the thumbnails controls after the book init', IPGS_PLUGIN_NAME); ?>"></div>
												<div class="ipages-label"><?php _e('Auto-show thumbnails', IPGS_PLUGIN_NAME); ?></div>
												<div al-toggle="appData.config.autoEnableThumbnails"></div>
											</div>
											
											<div class="ipages-control">
												<div class="ipages-helper" title="<?php _e('Show/hide the outline controls with bookmarks after the book init', IPGS_PLUGIN_NAME); ?>"></div>
												<div class="ipages-label"><?php _e('Auto-show outline', IPGS_PLUGIN_NAME); ?></div>
												<div al-toggle="appData.config.autoEnableOutline"></div>
											</div>
											
											<div class="ipages-control">
												<div class="ipages-helper" title="<?php _e('Show/hide the share dialog box after the book init', IPGS_PLUGIN_NAME); ?>"></div>
												<div class="ipages-label"><?php _e('Auto-show share', IPGS_PLUGIN_NAME); ?></div>
												<div al-toggle="appData.config.autoEnableShare"></div>
											</div>
										
											<div class="ipages-book-controls-wrap">
												<div class="ipages-book-controls-toolbar">
													<div class="ipages-left-panel">
														<span al-if="appData.ui.activeBookControl != null">
														<i class="ipages-icon ipages-icon-edit" al-on.click="appData.fn.editBookControlTitle(appData)" title="<?php _e('Edit book control title', IPGS_PLUGIN_NAME); ?>"></i>
														<i class="ipages-separator"></i>
														<i class="ipages-icon ipages-icon-arrow-up" al-on.click="appData.fn.updownBookControl(appData, 'up')" title="<?php _e('Move up', IPGS_PLUGIN_NAME); ?>"></i>
														<i class="ipages-icon ipages-icon-arrow-down" al-on.click="appData.fn.updownBookControl(appData, 'down')" title="<?php _e('Move down', IPGS_PLUGIN_NAME); ?>"></i>
														</span>
													</div>
													<div class="ipages-right-panel">
													</div>
												</div>
												<div class="ipages-book-control"
												 al-attr.class.ipages-active="appData.fn.isBookControlActive(appData, control)"
												 al-attr.class.ipages-edit="appData.fn.isBookControlEdit(appData, control)"
												 al-on.click="appData.fn.selectBookControl(appData, control)"
												 al-on.dblclick="appData.fn.editBookControlTitle(appData, control, $element)"
												 al-repeat="control in appData.config.toolbarControls"
												>
													<i class="ipages-icon" al-init="appData.fn.initBookControlIcon(appData, control, $element)" title="{{control.type}}"></i>
													<div class="ipages-label">{{control.title}}</div>
													<input class="ipages-text" type="text" al-text="control.title" placeholder="<?php _e('Title', IPGS_PLUGIN_NAME); ?>" al-on.keypress="appData.fn.onBookControlEnter(appData, $event)">
													<input class="ipages-text" type="text" al-text="control.icon" placeholder="<?php _e('Icon class', IPGS_PLUGIN_NAME); ?>" al-on.keypress="appData.fn.onBookControlEnter(appData, $event)">
													<div class="ipages-actions">
														<i class="ipages-icon" al-attr.class.ipages-icon-not-blank="control.optional" al-attr.class.ipages-icon-blank="!control.optional" al-on.click="appData.fn.toggleBookControlOptional(appData, control)" title="<?php _e('Make the book control optional or not', IPGS_PLUGIN_NAME); ?>"></i>
														<i class="ipages-icon" al-attr.class.ipages-icon-eye="control.active" al-attr.class.ipages-icon-eye-off="!control.active" al-on.click="appData.fn.toggleBookControlActive(appData, control)" title="<?php _e('Enable/disable book control', IPGS_PLUGIN_NAME); ?>"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="ipages-block" al-attr.class.ipages-block-folded="appData.ui.generalTab.bookmarks">
									<div class="ipages-block-header" al-on.click="appData.fn.onGeneralTab(appData,'bookmarks')">
										<div class="ipages-block-title"><?php _e('Outline/bookmarks', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-block-state"></div>
									</div>
									<div class="ipages-block-data">
										<div class="ipages-bookmarks-wrap">
											<div class="ipages-bookmarks-toolbar">
												<div class="ipages-left-panel">
													<i class="ipages-icon ipages-icon-plus" al-on.click="appData.fn.addBookmark(appData)" title="<?php _e('Add new', IPGS_PLUGIN_NAME); ?>"></i>
													<span al-if="appData.ui.activeBookmark != null">
													<i class="ipages-icon ipages-icon-copy" al-on.click="appData.fn.copyBookmark(appData)" title="<?php _e('Copy', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-edit" al-on.click="appData.fn.editBookmark(appData)" title="<?php _e('Edit', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-separator"></i>
													<i class="ipages-icon ipages-icon-arrow-up" al-on.click="appData.fn.updownBookmark(appData, 'up')" title="<?php _e('Move up', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-arrow-down" al-on.click="appData.fn.updownBookmark(appData, 'down')" title="<?php _e('Move down', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-separator"></i>
													<i class="ipages-icon ipages-icon-arrow-left" al-on.click="appData.fn.levelBookmark(appData, 'left')" title="<?php _e('Increase level', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-arrow-right" al-on.click="appData.fn.levelBookmark(appData, 'right')" title="<?php _e('Decrease level', IPGS_PLUGIN_NAME); ?>"></i>
													</span>
												</div>
												<div class="ipages-right-panel">
													<i class="ipages-icon ipages-icon-trash ipages-icon-red" al-if="appData.ui.activeBookmark != null" al-on.click="appData.fn.deleteBookmark(appData)" title="<?php _e('Delete', IPGS_PLUGIN_NAME); ?>"></i>
												</div>
											</div>
											<div class="ipages-bookmarks"
												 al-style.margin-left="appData.fn.getBookmarkLevel(appData, bookmark)"
												 al-repeat="bookmark in appData.config.bookmarks">
												<div class="ipages-bookmark"
												 al-attr.class.ipages-active="appData.fn.isBookmarkActive(appData, bookmark)"
												 al-attr.class.ipages-edit="appData.fn.isBookmarkEdit(appData, bookmark)"
												 al-on.click="appData.fn.selectBookmark(appData, bookmark)"
												 al-on.dblclick="appData.fn.editBookmark(appData, bookmark, $element)"
												>
													<i class="ipages-icon" al-attr.class.ipages-icon-link="bookmark.target!='page'" al-attr.class.ipages-icon-document="bookmark.target=='page'"></i>
													<div class="ipages-label">{{appData.fn.getBookmarkLabel(appData, bookmark)}}</div>
													<input class="ipages-text" type="text" al-text="bookmark.text" placeholder="<?php _e('Title', IPGS_PLUGIN_NAME); ?>" al-on.keypress="appData.fn.onBookmarkEnter(appData, $event)">
													<input class="ipages-text" type="text" al-text="bookmark.link" placeholder="<?php _e('Page number or url', IPGS_PLUGIN_NAME); ?>" al-on.keypress="appData.fn.onBookmarkEnter(appData, $event)">
													<select class="ipages-select" al-select="bookmark.target">
														<option al-option="'page'"><?php _e('Go to page', IPGS_PLUGIN_NAME); ?></option>
														<option al-option="'self'"><?php _e('Go to url (self)', IPGS_PLUGIN_NAME); ?></option>
														<option al-option="'blank'"><?php _e('Go to url (blank)', IPGS_PLUGIN_NAME); ?></option>
													</select>
													<div class="ipages-actions">
														<i class="ipages-icon" al-attr.class.ipages-icon-eye="bookmark.active" al-attr.class.ipages-icon-eye-off="!bookmark.active" al-on.click="appData.fn.toggleBookmarkActive(appData, bookmark)" title="<?php _e('Enable/disable bookmark', IPGS_PLUGIN_NAME); ?>"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ipages-section" al-attr.class.ipages-active="appData.ui.tabs.pages">
						<div class="ipages-stage">
							<div class="ipages-main-panel">
								<div class="ipages-edit-pages" al-attr.class.ipages-active="appData.ui.editPage == null">
									<div class="ipages-toolbar">
										<div class="ipages-left-panel">
											<div class="ipages-button ipages-violet" al-on.click="appData.fn.addPage(appData);"><?php _e('Add empty page', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-button ipages-azure" al-on.click="appData.fn.addPageWithImage(appData);"><?php _e('Add page with image', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-button ipages-default" al-on.click="appData.fn.selectAllPages(appData)" al-if="appData.config.pages.length>0"><div class="ipages-checkbox" al-attr.class.ipages-selected="appData.fn.isAllPagesSelected(appData)"><i class="ipages-icon ipages-icon-check"></i></div><?php _e('Select all', IPGS_PLUGIN_NAME); ?></div>
										</div>
										<div class="ipages-right-panel">
											<div class="ipages-button ipages-red" al-on.click="appData.fn.deletePages(appData)" al-if="appData.ui.selectedPages.length>0"><?php _e('Delete', IPGS_PLUGIN_NAME); ?></div>
										</div>
									</div>
									<div class="ipages-images-wrap">
										<div class="ipages-image"
											 al-attr.class.ipages-active="appData.fn.isPageActive(appData, page)"
											 al-attr.class.ipages-selected="appData.fn.isPageSelected(appData, page)"
											 al-repeat="page in appData.config.pages"
											 al-on.click="appData.fn.selectPage(appData, page)"
											 al-dragdrop="page"
											 get-drag-element="appData.fn.getPageDragElement(appData)"
											 on-drag="appData.fn.onPageDrag(appData, item)"
											 on-drop="appData.fn.onPageDrop(appData, item, before)">
											<div class="ipages-back"></div>
											<div class="ipages-front" al-page-image="page" on-page-image-update="appData.fn.onPageImageUpdate(appData, page, $element, 'page')"></div>
											<div class="ipages-overlay" al-if="!page.active"></div>
											<div class="ipages-checkbox" al-on.click="appData.fn.pickPage(appData, page);"><i class="ipages-icon ipages-icon-check"></i></div>
											<div class="ipages-edit" al-on.click="appData.fn.editPage(appData, page);" title="<?php _e('Edit layers', IPGS_PLUGIN_NAME); ?>"><i class="ipages-icon ipages-icon-regions"></i></div>
											<div class="ipages-layers-count" al-if="page.layers.length>0" title="<?php _e('Layers count', IPGS_PLUGIN_NAME); ?>">{{page.layers.length}}</div>
											<div class="ipages-number">{{$index+1}}</div>
										</div>
									</div>
								</div>
								<div class="ipages-edit-layer" al-if="appData.ui.editPage != null">
									<div id="ipages-layer-canvas" class="ipages-layer-canvas">
										<div id="ipages-layer-page" class="ipages-layer-page" al-page-image="appData.ui.editPage" on-page-image-update="appData.fn.onPageImageUpdate(appData, page, $element, 'layer')">
											<div class="ipages-layer"
											 tabindex="1"
											 al-on.click="appData.fn.onLayerClick(appData, layer)"
											 al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'drag', $event)"
											 al-on.keydown="appData.fn.onEditLayerKeyDown(appData, layer, $event)"
											 al-attr.class.ipages-active="appData.fn.isLayerActive(appData, layer)"
											 al-attr.class.ipages-hidden="!layer.visible"
											 al-attr.class.ipages-lock="layer.lock"
											 al-attr.class.ipages-layer-link="layer.type == 'link'"
											 al-attr.class.ipages-layer-image="layer.type == 'image'"
											 al-attr.class.ipages-layer-text="layer.type == 'text'"
											 al-style.top="appData.fn.getLayerStyle(appData, layer, 'y')"
											 al-style.left="appData.fn.getLayerStyle(appData, layer, 'x')"
											 al-style.width="appData.fn.getLayerStyle(appData, layer, 'width')"
											 al-style.height="appData.fn.getLayerStyle(appData, layer, 'height')"
											 al-style.transform="appData.fn.getLayerStyle(appData, layer, 'angle')"
											 al-repeat="layer in appData.ui.editPage.layers"
											 al-init="appData.fn.initLayer(appData, layer, $element)"
											>
												<div class="ipages-layer-inner"
													 al-on.dblclick="appData.fn.onEditLabelText(appData, layer, $element, $event)"
													 spellcheck="false"
													 al-style.border-radius="appData.fn.getLayerStyle(appData, layer, 'border-radius')"
													 al-style.background-color="appData.fn.getLayerStyle(appData, layer, 'background-color')"
													 al-style.background-image="appData.fn.getLayerStyle(appData, layer, 'background-image')"
													 al-style.background-size="appData.fn.getLayerStyle(appData, layer, 'background-size')"
													 al-style.background-repeat="appData.fn.getLayerStyle(appData, layer, 'background-repeat')"
													 al-style.background-position="appData.fn.getLayerStyle(appData, layer, 'background-position')"
													 al-style.color="appData.fn.getLayerStyle(appData, layer, 'color')"
													 al-style.font-size="appData.fn.getLayerStyle(appData, layer, 'font-size')"
													 al-style.line-height="appData.fn.getLayerStyle(appData, layer, 'line-height')"
													 al-style.text-align="appData.fn.getLayerStyle(appData, layer, 'text-align')"
													 al-style.letter-spacing="appData.fn.getLayerStyle(appData, layer, 'letter-spacing')"
													 al-init="appData.fn.initLayerInner(appData, layer, $element)"
												>
												</div>
												<div class="ipages-layer-resizer">
													<div class="ipages-layer-coord">X: {{layer.x}} <br>Y: {{layer.y}} <br>L: {{appData.fn.floor(appData, layer.angle)}}</div>
													<div class="ipages-layer-rotator" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'rotate', $event)">
														<div class="ipages-layer-line"></div>
													</div>
													<div class="ipages-layer-dragger-tl" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'tl', $event)"></div>
													<div class="ipages-layer-dragger-tm" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'tm', $event)"></div>
													<div class="ipages-layer-dragger-tr" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'tr', $event)"></div>
													<div class="ipages-layer-dragger-rm" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'rm', $event)"></div>
													<div class="ipages-layer-dragger-br" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'br', $event)"></div>
													<div class="ipages-layer-dragger-bm" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'bm', $event)"></div>
													<div class="ipages-layer-dragger-bl" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'bl', $event)"></div>
													<div class="ipages-layer-dragger-lm" al-on.mousedown="appData.fn.onEditLayerStart(appData, layer, 'lm', $event)"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="ipages-layer-close" al-on.click="appData.fn.editPage(appData, appData.ui.editPage)"><i class="ipages-icon ipages-icon-cross"></i></div>
								</div>
							</div>
							<div class="ipages-sidebar-panel" al-if="appData.config.pages.length>0">
								<div al-if="appData.ui.activePage == null">
									<div class="ipages-data">
										<div class="ipages-info"><?php _e('Please, select a page to view its settings', IPGS_PLUGIN_NAME); ?></div>
									</div>
								</div>
								<div al-if="appData.ui.activePage != null">
									<div class="ipages-tabs ipages-clear-fix">
										<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.pageTabs.page" al-on.click="appData.fn.onPageTab(appData, 'page')"><?php _e('Page', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.pageTabs.layers" al-on.click="appData.fn.onPageTab(appData, 'layers')"><?php _e('Layers', IPGS_PLUGIN_NAME); ?></div>
										<div class="ipages-tab" al-attr.class.ipages-active="appData.ui.pageTabs.layer" al-on.click="appData.fn.onPageTab(appData, 'layer')"><?php _e('Layer', IPGS_PLUGIN_NAME); ?></div>
									</div>
									<div class="ipages-data" al-if="appData.ui.pageTabs.page">
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Enable/disable page', IPGS_PLUGIN_NAME); ?>"></div>
											<div al-toggle="appData.ui.activePage.active"></div>
										</div>
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set page title', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Title', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activePage.title">
										</div>
										<div class="ipages-control" al-if="appData.pdf != null">
											<div class="ipages-helper" title="<?php _e('Set PDF page number', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('PDF page number', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-number ipages-long" al-integer="appData.ui.activePage.pdfPageNumber">
										</div>
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Set page image url', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Image Url', IPGS_PLUGIN_NAME); ?></div>
											<div class="ipages-input-group ipages-long">
												<div class="ipages-input-group-cell">
													<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activePage.image.url">
												</div>
												<div class="ipages-input-group-cell">
													<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.selectPageImage(appData)">...</div>
												</div>
											</div>
											<div class="ipages-input-group">
												<div class="ipages-input-group-cell pages-pinch">
													<div al-checkbox="appData.ui.activePage.image.relative"></div>
												</div>
												<div class="ipages-input-group-cell">
													<?php _e('Use relative path', IPGS_PLUGIN_NAME); ?>
												</div>
											</div>
										</div>
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Add class when element becomes visible', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Show CSS class', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activePage.showCSSClass">
										</div>
										<div class="ipages-control">
											<div class="ipages-helper" title="<?php _e('Add class when element becomes hidden', IPGS_PLUGIN_NAME); ?>"></div>
											<div class="ipages-label"><?php _e('Hide CSS class', IPGS_PLUGIN_NAME); ?></div>
											<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activePage.hideCSSClass">
										</div>
									</div>
									<div class="ipages-data" al-if="appData.ui.pageTabs.layers">
										<div class="ipages-layers-wrap">
											<div class="ipages-layers-toolbar">
												<div class="ipages-left-panel">
													<i class="ipages-icon ipages-icon-link" al-on.click="appData.fn.addLayerLink(appData)" title="<?php _e('Add link', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-image" al-on.click="appData.fn.addLayerImage(appData)" title="<?php _e('Add image', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-text" al-on.click="appData.fn.addLayerText(appData)" title="<?php _e('Add text', IPGS_PLUGIN_NAME); ?>"></i>
													<span al-if="appData.ui.activeLayer != null">
													<i class="ipages-separator"></i>
													<i class="ipages-icon ipages-icon-copy" al-on.click="appData.fn.copyLayer(appData)" title="<?php _e('Copy', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-arrow-up" al-on.click="appData.fn.updownLayer(appData, 'up')" title="<?php _e('Move up', IPGS_PLUGIN_NAME); ?>"></i>
													<i class="ipages-icon ipages-icon-arrow-down" al-on.click="appData.fn.updownLayer(appData, 'down')" title="<?php _e('Move down', IPGS_PLUGIN_NAME); ?>"></i>
													</span>
												</div>
												<div class="ipages-right-panel">
													<i class="ipages-icon ipages-icon-trash ipages-icon-red" al-if="appData.ui.activeLayer != null" al-on.click="appData.fn.deleteLayer(appData)" title="<?php _e('Delete', IPGS_PLUGIN_NAME); ?>"></i>
												</div>
											</div>
											<div class="ipages-layer"
											 al-attr.class.ipages-active="appData.fn.isLayerActive(appData, layer)"
											 al-on.click="appData.fn.selectLayer(appData, layer)"
											 al-repeat="layer in appData.ui.activePage.layers"
											 >
												<i class="ipages-icon ipages-icon-link" al-if="layer.type == 'link'"></i>
												<i class="ipages-icon ipages-icon-image" al-if="layer.type == 'image'"></i>
												<i class="ipages-icon ipages-icon-text" al-if="layer.type == 'text'"></i>
												<div class="ipages-label">{{layer.title ? layer.title : layer.type}}</div>
												<div class="ipages-actions">
													<i class="ipages-icon" al-attr.class.ipages-icon-eye="layer.visible" al-attr.class.ipages-icon-eye-off="!layer.visible" al-on.click="appData.fn.toggleLayerVisible(appData, layer)"></i>
													<i class="ipages-icon" al-attr.class.ipages-icon-lock-open="!layer.lock" al-attr.class.ipages-icon-lock="layer.lock" al-on.click="appData.fn.toggleLayerLock(appData, layer)"></i>
												</div>
											</div>
										</div>
									</div>
									<div class="ipages-data" al-if="appData.ui.pageTabs.layer">
										<div al-if="appData.ui.activeLayer == null">
											<div class="ipages-info"><?php _e('Please, select a layer to view its settings', IPGS_PLUGIN_NAME); ?></div>
										</div>
										<div al-if="appData.ui.activeLayer != null">
											<div class="ipages-block ipages-block-flat" al-attr.class.ipages-block-folded="appData.ui.layerTab.common">
												<div class="ipages-block-header" al-on.click="appData.fn.onLayerTab(appData,'common')">
													<div class="ipages-block-title"><?php _e('Common settings', IPGS_PLUGIN_NAME); ?></div>
													<div class="ipages-block-state"></div>
												</div>
												<div class="ipages-block-data">
													<div class="ipages-control">
														<div class="ipages-helper" title="<?php _e('Set layer title', IPGS_PLUGIN_NAME); ?>"></div>
														<div class="ipages-label"><?php _e('Title', IPGS_PLUGIN_NAME); ?></div>
														<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.title">
													</div>
													
													<div class="ipages-control">
														<div class="ipages-helper" title="<?php _e('Set layer position', IPGS_PLUGIN_NAME); ?>"></div>
														<div class="ipages-input-group ipages-long">
															<div class="ipages-input-group-cell ipages-rgap">
																<div class="ipages-label"><?php _e('X [px]', IPGS_PLUGIN_NAME); ?></div>
																<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.x">
															</div>
															<div class="ipages-input-group-cell ipages-lgap">
																<div class="ipages-label"><?php _e('Y [px]', IPGS_PLUGIN_NAME); ?></div>
																<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.y">
															</div>
														</div>
													</div>
													
													<div class="ipages-control">
														<div class="ipages-helper" title="<?php _e('Set layer size', IPGS_PLUGIN_NAME); ?>"></div>
														<div class="ipages-input-group ipages-long">
															<div class="ipages-input-group-cell ipages-rgap">
																<div class="ipages-label"><?php _e('Width [px]', IPGS_PLUGIN_NAME); ?></div>
																<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.width">
															</div>
															<div class="ipages-input-group-cell ipages-lgap">
																<div class="ipages-label"><?php _e('Height [px]', IPGS_PLUGIN_NAME); ?></div>
																<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.height">
															</div>
														</div>
													</div>
													
													<div class="ipages-control">
														<div class="ipages-helper" title="<?php _e('Set layer angle', IPGS_PLUGIN_NAME); ?>"></div>
														<div class="ipages-label"><?php _e('Angle [deg]', IPGS_PLUGIN_NAME); ?></div>
														<input class="ipages-number ipages-long" al-float="appData.ui.activeLayer.angle">
													</div>
													
													<div class="ipages-control">
														<div class="ipages-helper" title="<?php _e('Specifies the horizontal and vertical alignment of the layer inside a page', IPGS_PLUGIN_NAME); ?>"></div>
														<div class="ipages-label"><?php _e('Alignment', IPGS_PLUGIN_NAME); ?></div>
														<div class="ipages-input-group ipages-long">
															<div class="ipages-input-group-cell ipages-text-center">
																<i class="ipages-icon ipages-icon-btn ipages-icon-align-top" al-on.click="appData.fn.editLayerAlign(appData, 'top')" title="<?php _e('Align top', IPGS_PLUGIN_NAME); ?>"></i>
															</div>
															<div class="ipages-input-group-cell ipages-text-center">
																<i class="ipages-icon ipages-icon-btn ipages-icon-align-middle" al-on.click="appData.fn.editLayerAlign(appData, 'middle')" title="<?php _e('Align middle', IPGS_PLUGIN_NAME); ?>"></i>
															</div>
															<div class="ipages-input-group-cell ipages-text-center">
																<i class="ipages-icon ipages-icon-btn ipages-icon-align-bottom" al-on.click="appData.fn.editLayerAlign(appData, 'bottom')" title="<?php _e('Align bottom', IPGS_PLUGIN_NAME); ?>"></i>
															</div>
															<div class="ipages-input-group-cell ipages-text-center">
																<i class="ipages-icon ipages-icon-btn ipages-icon-align-left" al-on.click="appData.fn.editLayerAlign(appData, 'left')" title="<?php _e('Align left', IPGS_PLUGIN_NAME); ?>"></i>
															</div>
															<div class="ipages-input-group-cell ipages-text-center">
																<i class="ipages-icon ipages-icon-btn ipages-icon-align-center" al-on.click="appData.fn.editLayerAlign(appData, 'center')" title="<?php _e('Align center', IPGS_PLUGIN_NAME); ?>"></i>
															</div>
															<div class="ipages-input-group-cell ipages-text-center">
																<i class="ipages-icon ipages-icon-btn ipages-icon-align-right" al-on.click="appData.fn.editLayerAlign(appData, 'right')" title="<?php _e('Align right', IPGS_PLUGIN_NAME); ?>"></i>
															</div>
														</div>
													</div>
													
													<div class="ipages-control">
														<div class="ipages-helper" title="<?php _e('Set additional css classes to a layer', IPGS_PLUGIN_NAME); ?>"></div>
														<div class="ipages-label"><?php _e('Additional CSS class', IPGS_PLUGIN_NAME); ?></div>
														<input class="ipages-number ipages-long" type="text" al-text="appData.ui.activeLayer.elementClass">
													</div>
												</div>
											</div>
											
											<div class="ipages-block ipages-block-flat" al-attr.class.ipages-block-folded="appData.ui.layerTab.special">
												<div class="ipages-block-header" al-on.click="appData.fn.onLayerTab(appData,'special')">
													<div class="ipages-block-title" al-if="appData.ui.activeLayer.type == 'link'"><?php _e('Link settings', IPGS_PLUGIN_NAME); ?></div>
													<div class="ipages-block-title" al-if="appData.ui.activeLayer.type == 'image'"><?php _e('Image settings', IPGS_PLUGIN_NAME); ?></div>
													<div class="ipages-block-title" al-if="appData.ui.activeLayer.type == 'text'"><?php _e('Text settings', IPGS_PLUGIN_NAME); ?></div>
													<div class="ipages-block-state"></div>
												</div>
												<div class="ipages-block-data">
													<div al-if="appData.ui.activeLayer.type == 'link'">
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Set a link to a web resource', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Url', IPGS_PLUGIN_NAME); ?></div>
															<div class="ipages-input-group ipages-long">
																<div class="ipages-input-group-cell">
																	<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.link.url" placeholder="http://">
																</div>
															</div>
															<div class="ipages-input-group">
																<div class="ipages-input-group-cell pages-pinch">
																	<div al-checkbox="appData.ui.activeLayer.link.newWindow"></div>
																</div>
																<div class="ipages-input-group-cell">
																	<?php _e('Open in a new window', IPGS_PLUGIN_NAME); ?>
																</div>
															</div>
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Normal color in hexadecimal format (#fff or #555555)', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Normal color', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.link.normalColor" placeholder="<?php _e('Example: #ffffff', IPGS_PLUGIN_NAME); ?>">
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Hover color in hexadecimal format (#fff or #555555)', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Hover color', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.link.hoverColor" placeholder="<?php _e('Example: #ffffff', IPGS_PLUGIN_NAME); ?>">
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Click color in hexadecimal format (#fff or #555555)', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Click color', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.link.clickColor" placeholder="<?php _e('Example: #ffffff', IPGS_PLUGIN_NAME); ?>">
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Set radius (5px or 50%)', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Radius', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-number ipages-long" type="text" al-text="appData.ui.activeLayer.link.radius" placeholder="<?php _e('Example: 10px', IPGS_PLUGIN_NAME); ?>">
														</div>
													</div>
													
													<div al-if="appData.ui.activeLayer.type == 'image'">
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Set background image (jpeg or png format)', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Background image', IPGS_PLUGIN_NAME); ?></div>
															<div class="ipages-input-group ipages-long">
																<div class="ipages-input-group-cell">
																	<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.image.backgroundImage.url" placeholder="<?php _e('Select an image', IPGS_PLUGIN_NAME); ?>">
																</div>
																<div class="ipages-input-group-cell">
																	<div class="ipages-btn ipages-default ipages-no-bl" al-on.click="appData.fn.selectLayerBackgroundImage(appData)">...</div>
																</div>
															</div>
															<div class="ipages-input-group ipages-long">
																<div class="ipages-input-group-cell pages-pinch">
																	<div al-checkbox="appData.ui.activeLayer.image.backgroundImage.relative"></div>
																</div>
																<div class="ipages-input-group-cell">
																	<?php _e('Use relative path', IPGS_PLUGIN_NAME); ?>
																</div>
															</div>
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Specifies the size of the background images', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Background size', IPGS_PLUGIN_NAME); ?></div>
															<div class="ipages-select ipages-long" al-backgroundsize="appData.ui.activeLayer.image.backgroundSize"></div>
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('How a background image will be repeated', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Background repeat', IPGS_PLUGIN_NAME); ?></div>
															<div class="ipages-select ipages-long" al-backgroundrepeat="appData.ui.activeLayer.image.backgroundRepeat"></div>
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Sets the starting position of a background image', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Background position', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.image.backgroundPosition" placeholder="<?php _e('Example: 50% 50%', IPGS_PLUGIN_NAME); ?>">
														</div>
													</div>
													
													<div al-if="appData.ui.activeLayer.type == 'text'">
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Text color in hexadecimal format (#fff or #555555)', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Text color', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-text ipages-long" type="text" al-text="appData.ui.activeLayer.text.color" placeholder="<?php _e('Example: #ffffff', IPGS_PLUGIN_NAME); ?>">
														</div>
														
														<div class="ipages-control">
															<div class="ipages-input-group ipages-long">
																<div class="ipages-input-group-cell ipages-rgap">
																	<div class="ipages-helper" title="<?php _e('Set the text size in px', IPGS_PLUGIN_NAME); ?>"></div>
																	<div class="ipages-label"><?php _e('Text size [px]', IPGS_PLUGIN_NAME); ?></div>
																	<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.text.size" placeholder="<?php _e('Example: 18', IPGS_PLUGIN_NAME); ?>">
																</div>
																<div class="ipages-input-group-cell ipages-lgap">
																	<div class="ipages-helper" title="<?php _e('Set the text line height in px', IPGS_PLUGIN_NAME); ?>"></div>
																	<div class="ipages-label"><?php _e('Line height [px]', IPGS_PLUGIN_NAME); ?></div>
																	<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.text.lineHeight" placeholder="<?php _e('Example: 18', IPGS_PLUGIN_NAME); ?>">
																</div>
															</div>
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Specifies the horizontal alignment of the text', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Text align', IPGS_PLUGIN_NAME); ?></div>
															<div class="ipages-select ipages-long" al-textalign="appData.ui.activeLayer.text.align"></div>
														</div>
														
														<div class="ipages-control">
															<div class="ipages-helper" title="<?php _e('Specifies the spacing behavior between text characters', IPGS_PLUGIN_NAME); ?>"></div>
															<div class="ipages-label"><?php _e('Letter spacing [px]', IPGS_PLUGIN_NAME); ?></div>
															<input class="ipages-number ipages-long" al-integer="appData.ui.activeLayer.text.letterSpacing" placeholder="<?php _e('Example: 1', IPGS_PLUGIN_NAME); ?>">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ipages-section" al-attr.class.ipages-active="appData.ui.tabs.customCSS" al-if="appData.ui.tabs.customCSS">
						<div class="ipages-stage">
							<div class="ipages-main-panel">
								<div class="ipages-data">
									<div class="ipages-control">
										<div class="ipages-helper" title="<?php _e('Enable/disable custom styles', IPGS_PLUGIN_NAME); ?>"></div>
										<div class="ipages-input-group">
											<div class="ipages-input-group-cell pages-pinch">
												<div al-toggle="appData.config.customCSS.active"></div>
											</div>
											<div class="ipages-input-group-cell">
												<div class="ipages-label"><?php _e('Enable styles', IPGS_PLUGIN_NAME); ?></div>
											</div>
										</div>
									</div>
									<div class="ipages-control">
										<pre id="ipages-notepad-css" class="ipages-notepad"></pre>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ipages-section" al-attr.class.ipages-active="appData.ui.tabs.customJS" al-if="appData.ui.tabs.customJS">
						<div class="ipages-stage">
							<div class="ipages-main-panel">
								<div class="ipages-data">
									<div class="ipages-control">
										<div class="ipages-helper" title="<?php _e('Enable/disable custom javascript code', IPGS_PLUGIN_NAME); ?>"></div>
										<div class="ipages-input-group">
											<div class="ipages-input-group-cell pages-pinch">
												<div al-toggle="appData.config.customJS.active"></div>
											</div>
											<div class="ipages-input-group-cell">
												<div class="ipages-label"><?php _e('Enable javascript code', IPGS_PLUGIN_NAME); ?></div>
											</div>
										</div>
									</div>
									<div class="ipages-control">
										<pre id="ipages-notepad-js" class="ipages-notepad"></pre>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="ipages-section" al-attr.class.ipages-active="appData.ui.tabs.shortcode" al-if="appData.wp_item_id">
						<div class="ipages-main-panel">
							<div class="ipages-data">
								<h3><?php _e('Use a shortcode like the one below, simply copy and paste it into a post or page.', IPGS_PLUGIN_NAME); ?></h3>
								<p>[ipages id="{{appData.wp_item_id}}"]</p>
								<p>[ipages id="{{appData.wp_item_id}}" class="your-css-custom-class"]</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /end ipages app -->
</div>