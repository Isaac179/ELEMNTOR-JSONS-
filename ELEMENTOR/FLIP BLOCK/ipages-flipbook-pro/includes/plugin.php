<?php
/**
 * Main class and entry point
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

if(!class_exists('iPages')) :

class iPages {
	private $pluginBasename = NULL;
	
	private $ajax_action_item_update = NULL;
	private $ajax_action_item_update_status = NULL;
	private $ajax_action_settings_update = NULL;
	private $ajax_action_settings_get = NULL;
	private $ajax_action_delete_data = NULL;
	
	private $shortcodes = array();
	
	function __construct($pluginBasename) {
		$this->pluginBasename = $pluginBasename;
	}
	
	function run() {
		$upload_dir = wp_upload_dir();
		$plugin_url = plugin_dir_url(dirname(__FILE__));
		
		define('IPGS_PLUGIN_UPLOAD_DIR', wp_normalize_path($upload_dir['basedir'] . '/' . IPGS_PLUGIN_NAME));
		define('IPGS_PLUGIN_UPLOAD_URL', $upload_dir['baseurl'] . '/' . IPGS_PLUGIN_NAME);
		
		define('IPGS_PLUGIN_PLAN', 'pro');
		
		
		if(is_admin()) {
			$this->ajax_action_item_update = IPGS_PLUGIN_NAME . '_ajax_item_update';
			$this->ajax_action_item_update_status = IPGS_PLUGIN_NAME . '_ajax_item_update_status';
			$this->ajax_action_settings_update = IPGS_PLUGIN_NAME . '_ajax_settings_update';
			$this->ajax_action_settings_get = IPGS_PLUGIN_NAME . '_ajax_settings_get';
			$this->ajax_action_delete_data =  IPGS_PLUGIN_NAME . '_ajax_delete_data';
			
			load_plugin_textdomain(IPGS_PLUGIN_NAME, false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/');
			
			add_action('admin_menu', array($this, 'admin_menu'));
			add_action('admin_notices', array($this, 'admin_notices'));
			add_action('wp_loaded', array($this, 'page_redirects'));
			
			// important, because ajax has another url
			add_action('wp_ajax_' . $this->ajax_action_item_update, array($this, 'ajax_item_update'));
			add_action('wp_ajax_' . $this->ajax_action_item_update_status, array($this, 'ajax_item_update_status'));
			add_action('wp_ajax_' . $this->ajax_action_settings_update, array($this, 'ajax_settings_update'));
			add_action('wp_ajax_' . $this->ajax_action_settings_get, array($this, 'ajax_settings_get'));
			add_action('wp_ajax_' . $this->ajax_action_delete_data, array($this, 'ajax_delete_data'));
		} else {
			add_shortcode(IPGS_SHORTCODE_NAME, array($this, 'shortcode'));
		}
	}
	
	function IsNullOrEmptyString($str) {
		return(!isset($str) || trim($str)==='');
	}
	
	/**
	 * Shortcode output for the plugin
	 */
	function shortcode($atts) {
		extract(shortcode_atts(array('id'=>0, 'class'=>NULL), $atts));
		
		if(!$id) {
			return '<p>' . __('Error: invalid ipages flipbook shortcode attributes', IPGS_PLUGIN_NAME) . '</p>';
		}
		
		global $wpdb;
		$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
		$upload_dir = wp_upload_dir();
		
		$query = $wpdb->prepare('SELECT * FROM ' . $table . ' WHERE id=%s', $id);
		$item = $wpdb->get_row($query, OBJECT);
		if($item) {
			if(!$item->active) {
				return;
			}
			
			$version = strtotime(mysql2date('d M Y H:i:s', $item->modified));
			$itemData = unserialize($item->data);
			$id = $item->id;
			$id_postfix = strtolower(wp_generate_password(5, false)); // generate unique postfix for $id to avoid clashes with multiple same shortcode use
			$id_element = 'ipages-' . $id . '-' . $id_postfix;
			
			array_push($this->shortcodes, array(
				'id'            => $item->id,
				'version'       => $version
			));
			
			if(sizeof($this->shortcodes) == 1) {
				$plugin_url = plugin_dir_url(dirname(__FILE__));
				wp_enqueue_script(IPGS_PLUGIN_NAME . '_pdf', $plugin_url . 'assets/js/lib/ipages/pdf.min.js', array(), IPGS_PLUGIN_VERSION, true );
				wp_enqueue_script(IPGS_PLUGIN_NAME . '_loader', $plugin_url . 'assets/js/loader.min.js', array(), IPGS_PLUGIN_VERSION, true);
				
				$globals = array(
					'plan' => IPGS_PLUGIN_PLAN,
					'font_url' => $plugin_url . 'assets/css/',
					'plugin_url' => $plugin_url . 'assets/js/lib/ipages/',
				);
				wp_localize_script(IPGS_PLUGIN_NAME . '_loader', IPGS_PLUGIN_NAME, $globals);
			}
			
			ob_start(); // turn on buffering
			
			echo '<!-- ipages flipbook begin -->' . PHP_EOL;
			if(!$this->IsNullOrEmptyString($itemData->backgroundColor) || !$this->IsNullOrEmptyString($itemData->backgroundImage->url)) {
				echo '<style>' . PHP_EOL;
				echo '#' .$id_element . ' {' . PHP_EOL;
				if(!$this->IsNullOrEmptyString($itemData->backgroundColor)) {
					echo 'background-color:' . $itemData->backgroundColor . ';' . PHP_EOL;
				}
				if(!$this->IsNullOrEmptyString($itemData->backgroundImage->url)) {
					$imageUrl = ($itemData->backgroundImage->relative ? $upload_dir['baseurl'] : '') . $itemData->backgroundImage->url;
					echo 'background-image:url(' . $imageUrl . ');' . PHP_EOL;
					echo ($itemData->backgroundSize ? 'background-size:' . $itemData->backgroundSize . ';' . PHP_EOL : '');
					echo ($itemData->backgroundRepeat ? 'background-repeat:' . $itemData->backgroundRepeat . ';' . PHP_EOL : '');
					echo ($itemData->backgroundPosition ? 'background-position:' . $itemData->backgroundPosition . ';' . PHP_EOL : '');
				}
				echo '}' . PHP_EOL;
				echo '</style>' . PHP_EOL;
			}
			if($itemData->customCSS->active) {
				echo '<style>' . PHP_EOL;
				echo '@import url("' . IPGS_PLUGIN_UPLOAD_URL . '/' . $item->id . '/custom.css?ver=' . $version . '");' . PHP_EOL;
				echo '</style>' . PHP_EOL;
			}
			if($itemData->bookTheme) {
				$plugin_url = plugin_dir_url(dirname(__FILE__));
				echo '<style>' . PHP_EOL;
				echo '@import url("' . $plugin_url . 'assets/themes/' . $itemData->bookTheme . '.min.css?ver=' . $version . '");' . PHP_EOL;
				echo '</style>' . PHP_EOL;
			}
			echo '<div ';
			echo 'id="' . $id_element . '" ';
			echo 'class="ipgs-flipbook' . 
				($itemData->bookTheme ? ' ipgs-theme-' . $itemData->bookTheme : '') . 
				($itemData->bookClass ? ' ' . $itemData->bookClass : '') . 
				($class ? ' ' . $class : '') . '"';
			echo 'data-json="'. IPGS_PLUGIN_UPLOAD_URL . '/' . $item->id . '/config.json?ver=' . $version . '" ';
			echo 'style="' . 
				(!$itemData->autoWidth && $itemData->containerWidth ? 'width:' . $itemData->containerWidth . ';' : '') . 
				(!$itemData->autoHeight && $itemData->containerHeight ? 'height:' . $itemData->containerHeight . ';' : '') . 
				'display:none;' . 
				'"';
			echo '>' . PHP_EOL;
			foreach($itemData->pages as $pageKey => $page) {
				if(!$page->active) {
					continue;
				}
				
				$showLayers = false;
				foreach($page->layers as $key => $layer) {
					if($layer->visible) {
						$showLayers = true;
						break;
					}
				}
				
				$imageUrl = ($page->image->url ? ($page->image->relative ? $upload_dir['baseurl'] : '') . $page->image->url : '');
				echo '<div ';
				echo ($imageUrl ? 'data-ipgs-image="' . $imageUrl . '" ' : '');
				echo ($page->pdfPageNumber>0 ? 'data-ipgs-pdf-page="' . $page->pdfPageNumber . '" ' : '');
				echo ($page->title ? 'data-ipgs-title="' . $page->title . '" ' : '');
				echo ($page->showCSSClass ? 'data-ipgs-showcssclass="' . $page->showCSSClass . '" ' : '');
				echo ($page->hideCSSClass ? 'data-ipgs-hidecssclass="' . $page->hideCSSClass . '" ' : '');
				echo '>' . PHP_EOL;
				
				if($showLayers) {
					echo '<div class="ipgs-layers">' . PHP_EOL;
					foreach($page->layers as $layerKey => $layer) {
						if(!$layer->visible) {
							continue;
						}
						
						$layeId = 'ipages-layer-' . $pageKey . '-' . $layerKey . '-' . $id_postfix;
						
						echo '<style>'. PHP_EOL;
						echo '#'. $layeId . ' {' . PHP_EOL;
							echo 'position:absolute;' . PHP_EOL;
							echo ($layer->y != NULL ? 'top:' . $layer->y . 'px;' . PHP_EOL : '');
							echo ($layer->x != NULL ? 'left:' . $layer->x . 'px;' . PHP_EOL : '');
							echo ($layer->width != NULL ? 'width:' . $layer->width . 'px;' . PHP_EOL : '');
							echo ($layer->height != NULL ? 'height:' . $layer->height . 'px;' . PHP_EOL : '');
							echo ($layer->angle != NULL ? 'transform:rotate(' . $layer->angle . 'deg);' . PHP_EOL : '');
							
							switch($layer->type) {
								case 'link': {
									echo ($layer->link->normalColor ? 'background-color:' . $layer->link->normalColor . ';' . PHP_EOL : '');
									echo ($layer->link->radius != NULL ? 'border-radius:' . $layer->link->radius . ';' . PHP_EOL : '');
								} break;
								case 'image': {
									if(!$this->IsNullOrEmptyString($layer->image->backgroundImage->url)) {
										$imageUrl = ($layer->image->backgroundImage->url ? ($layer->image->backgroundImage->relative ? $upload_dir['baseurl'] : '') . $layer->image->backgroundImage->url : '');
										echo ($imageUrl ? 'background-image:url(' . $imageUrl . ');' . PHP_EOL : '');
										echo ($layer->image->backgroundSize ? 'background-size:' . $layer->image->backgroundSize . ';' . PHP_EOL : '');
										echo ($layer->image->backgroundRepeat ? 'background-repeat:' . $layer->image->backgroundRepeat . ';' . PHP_EOL : '');
										echo ($layer->image->backgroundPosition ? 'background-position:' . $layer->image->backgroundPosition . ';' . PHP_EOL : '');
									}
								} break;
								case 'text': {
									echo ($layer->text->color ? 'color:' . $layer->text->color . ';' . PHP_EOL : '');
									echo ($layer->text->size != NULL ? 'font-size:' . $layer->text->size . 'px;' . PHP_EOL : '');
									echo ($layer->text->lineHeight != NULL ? 'line-height:' . $layer->text->lineHeight . 'px;' . PHP_EOL : '');
									echo ($layer->text->align ? 'text-align:' . $layer->text->align . ';' . PHP_EOL : '');
									echo ($layer->text->letterSpacing != NULL ? 'letter-spacing:' . $layer->text->letterSpacing . 'px;' . PHP_EOL : '');
								} break;
							}
						echo '}'. PHP_EOL;
						
						if($layer->type == 'link') {
							echo '#'. $layeId . ':hover {' . PHP_EOL;
								echo 'background-color:' . $layer->link->hoverColor . ';' . PHP_EOL;
							echo '}'. PHP_EOL;
							echo '#'. $layeId . ':visited {' . PHP_EOL;
								echo 'background-color:' . $layer->link->clickColor . ';' . PHP_EOL;
							echo '}'. PHP_EOL;
						}
						
						echo '</style>'. PHP_EOL;
						
						if($layer->type == 'link') {
							echo '<a ';
							echo 'href="' . $layer->link->url . '" rel="nofollow" ';
							echo 'target="' . ($layer->link->newWindow ? '_blank' : '_self') . '" ';
						} else {
							echo '<div ';
						}
						
						echo 'id="' . $layeId . '" ';
						echo 'class="ipgs-layer ';
						echo 'ipgs-layer-' . $layer->type;
						echo ($this->IsNullOrEmptyString($layer->elementClass) ? '' : ' ' . $layer->elementClass) . '" ' ;
						echo ($this->IsNullOrEmptyString($layer->title) ? '' : 'data-title="' . $layer->title . '"');
						echo '>';
						
						if($layer->type == 'text') {
							echo $layer->text->data;
						}
						
						if($layer->type == 'link') {
							echo '</a>' . PHP_EOL;
						} else {
							echo '</div>' . PHP_EOL;
						}
					}
					echo '</div>' . PHP_EOL;
				}
				
				echo '</div>' . PHP_EOL;
			}
			
			echo '</div>' . PHP_EOL;
			echo '<!-- ipages flipbook end -->' . PHP_EOL;
			
			$output = ob_get_contents(); // get the buffered content into a var
			ob_end_clean(); // clean buffer
			
			return $output;
		} else {
			return '<p>' . __('Error: invalid ipages flipbook database record', IPGS_PLUGIN_NAME) . '</p>';
		}
	}
	
	/**
	 * Prepare upload directory
	 */
	function admin_notices() {
		$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
		
		if(!($page===IPGS_PLUGIN_NAME ||
			 $page===IPGS_PLUGIN_NAME . '_settings')) {
				 return;
		}
		
		if(!file_exists(IPGS_PLUGIN_UPLOAD_DIR)) {
			wp_mkdir_p(IPGS_PLUGIN_UPLOAD_DIR);
		}
		
		if(!file_exists(IPGS_PLUGIN_UPLOAD_DIR)) {
			echo '<div class="notice notice-error is-dismissible">';
			echo '<p>' . sprintf(__('The "%s" directory could not be created', IPGS_PLUGIN_NAME), '<b>' . IPGS_PLUGIN_NAME . '</b>') . '</p>';
			echo '<p>' . __('Please run the following commands in order to make the directory', IPGS_PLUGIN_NAME) . '<br>';
			echo '<b>mkdir ' . IPGS_PLUGIN_UPLOAD_DIR . '</b><br>';
			echo '<b>chmod 777 ' . IPGS_PLUGIN_UPLOAD_DIR . '</b></p>';
			echo '</div>';
			return;
		}
		
		if(!wp_is_writable(IPGS_PLUGIN_UPLOAD_DIR)) {
			echo '<div class="notice notice-error is-dismissible">';
			echo '<p>' . sprintf(__('The "%s" directory is not writable, therefore the css and js files cannot be saved.', IPGS_PLUGIN_NAME), '<b>' . IPGS_PLUGIN_NAME . '</b>') . '</p>';
			echo '<p>' . __('Please run the following commands in order to make the directory', IPGS_PLUGIN_NAME) . '<br>';
			echo '<b>chmod 777 ' . IPGS_PLUGIN_UPLOAD_DIR . '</b></p>';
			echo '</div>';
			return;
		}
		
		if(!file_exists(IPGS_PLUGIN_UPLOAD_DIR . '/' . 'index.php')) {
			$data = '<?php' . PHP_EOL . '// silence is golden' . PHP_EOL . '?>';
			@file_put_contents(IPGS_PLUGIN_UPLOAD_DIR . '/' . 'index.php', $data);
		}
	}
	
	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 */
	function admin_menu() {
		// add "edit_posts" if we want to give access to author, editor and contributor roles
		add_menu_page(__('iPages Flipbook', IPGS_PLUGIN_NAME), __('iPages Flipbook', IPGS_PLUGIN_NAME), 'manage_options', IPGS_PLUGIN_NAME, array( $this, 'admin_menu_page_items' ), 'dashicons-book-alt');
		add_submenu_page(IPGS_PLUGIN_NAME, __('iPages Flipbook', IPGS_PLUGIN_NAME), __('All Books', IPGS_PLUGIN_NAME), 'manage_options', IPGS_PLUGIN_NAME, array( $this, 'admin_menu_page_items' ));
		add_submenu_page(IPGS_PLUGIN_NAME, __('iPages Flipbook', IPGS_PLUGIN_NAME), __('Add New', IPGS_PLUGIN_NAME), 'manage_options', IPGS_PLUGIN_NAME . '_item', array( $this, 'admin_menu_page_item' ));
		add_submenu_page(IPGS_PLUGIN_NAME, __('iPages Flipbook', IPGS_PLUGIN_NAME), __('Settings', IPGS_PLUGIN_NAME), 'manage_options', IPGS_PLUGIN_NAME . '_settings', array( $this, 'admin_menu_page_settings' ));
	}
	
	/**
	 * Custom redirects
	 */
	function page_redirects() {
		$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
		
		if($page===IPGS_PLUGIN_NAME) {
			$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
			if($action == 'duplicate' || $action == 'delete') {
				$url = admin_url('admin.php?page=' . $page);
				header('Refresh:0; url="' . $url . '"', true, 303);
				//wp_redirect($url); // does not work delete and dublicate operations on XAMPP
			}
		}
	}
	
	/**
	 * Show admin menu items page
	 */
	function admin_menu_page_items() {
		$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
		
		if($page===IPGS_PLUGIN_NAME) {
			$plugin_url = plugin_dir_url( dirname(__FILE__) );
			$upload_dir = wp_upload_dir();
			
			// styles
			wp_enqueue_style(IPGS_PLUGIN_NAME . '_admin_css', $plugin_url . 'assets/css/admin.min.css', array(), IPGS_PLUGIN_VERSION, 'all' );
			wp_enqueue_style(IPGS_PLUGIN_NAME . '_ipages_icons_css', $plugin_url . 'assets/css/ipages-font-icons.min.css', array(), IPGS_PLUGIN_VERSION, 'all' );
			
			// scripts
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_ace', $plugin_url . 'assets/js/lib/ace/ace.js', array(), IPGS_PLUGIN_VERSION, false );
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_admin_js', $plugin_url . 'assets/js/admin.min.js', array('jquery'), IPGS_PLUGIN_VERSION, false );
			
			// global settings to help ajax work
			$globals = array(
				'plan' => IPGS_PLUGIN_PLAN,
				'msg_pro_title' => __('Available only in Pro version', IPGS_PLUGIN_NAME),
				'upload_url' => $upload_dir['baseurl'],
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( IPGS_PLUGIN_NAME . '_ajax' ),
				'ajax_msg_error' => __('Uncaught Error', IPGS_PLUGIN_NAME) //Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information
			);
			
			$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
			$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
			$nonce = filter_input(INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING);
			
			if($action && $nonce && wp_verify_nonce($nonce, IPGS_PLUGIN_NAME)) {
				global $wpdb;
				$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
				
				if($action == 'duplicate') {
					$result = false;
					
					$query = $wpdb->prepare( 'SELECT * FROM ' . $table . ' WHERE id=%s', $id);
					$item = $wpdb->get_row($query, OBJECT);
					
					if($item && (current_user_can('administrator') || get_current_user_id()==$item->author) ) {
						$itemData = unserialize($item->data);
						$itemData->title = __('[Duplicate] ', IPGS_PLUGIN_NAME) . $itemData->title;
						$itemConfig = unserialize($item->config);
						
						$result = $wpdb->insert(
							$table,
							array(
								'title' => $itemData->title,
								'active' => $itemData->active,
								'data' => serialize($itemData),
								'config' => serialize($itemConfig),
								'author' => get_current_user_id(),
								'date' => current_time('mysql', 1),
								'modified' => current_time('mysql', 1)
						));
						
						//======================================
						// [filemanager] create an external file
						if($result && wp_is_writable(IPGS_PLUGIN_UPLOAD_DIR)) {
							$file_json = 'config.json';
							$file_css = 'custom.css';
							$file_root_path = IPGS_PLUGIN_UPLOAD_DIR . '/' . $wpdb->insert_id . '/';
							
							if(!is_dir($file_root_path)) {
								mkdir($file_root_path);
							}
							
							@file_put_contents($file_root_path . $file_json, json_encode($itemConfig));
							@file_put_contents($file_root_path . $file_css, $itemData->customCSS->data);
						}
						//======================================
						exit;
					}
				}
				if($action=='delete') {
					$result = false;
					
					$query = $wpdb->prepare('SELECT * FROM ' . $table . ' WHERE id=%s', $id);
					$item = $wpdb->get_row($query, OBJECT);
					if($item && (current_user_can('administrator') || get_current_user_id()==$item->author) ) {
						$result = $wpdb->delete( $table, ['id'=>$id], ['%d']);
						
						//======================================
						// [filemanager] delete file
						if($result && wp_is_writable(IPGS_PLUGIN_UPLOAD_DIR)) {
							$file_json = 'config.json';
							$file_css = 'custom.css';
							$file_root_path = IPGS_PLUGIN_UPLOAD_DIR . '/' . $id . '/';
							
							wp_delete_file($file_root_path . $file_json);
							wp_delete_file($file_root_path . $file_css);
							
							if(is_dir($file_root_path)) {
								rmdir($file_root_path);
							}
						}
						//======================================
						exit;
					}
				}
			}
			
			$globals['ajax_action_update'] = $this->ajax_action_item_update_status;
			
			require_once( plugin_dir_path( dirname(__FILE__) ) . 'includes/list-table-items.php' );
			require_once( plugin_dir_path( dirname(__FILE__) ) . 'includes/page-items.php' );
			
			// set global settings
			wp_localize_script(IPGS_PLUGIN_NAME . '_admin_js', IPGS_PLUGIN_NAME, $globals);
		}
	}
	
	/**
	 * Show admin menu item page
	 */
	function admin_menu_page_item() {
		$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
		
		if($page===IPGS_PLUGIN_NAME . '_item') {
			$plugin_url = plugin_dir_url(dirname(__FILE__));
			$upload_dir = wp_upload_dir();
			
			// styles
			wp_enqueue_style(IPGS_PLUGIN_NAME . '_admin_css', $plugin_url . 'assets/css/admin.min.css', array(), IPGS_PLUGIN_VERSION, 'all' );
			wp_enqueue_style(IPGS_PLUGIN_NAME . '_ipages_font_icons_css', $plugin_url . 'assets/css/ipages-font-icons.min.css', array(), IPGS_PLUGIN_VERSION, 'all' );
			
			// scripts
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_ace', $plugin_url . 'assets/js/lib/ace/ace.js', array(), IPGS_PLUGIN_VERSION, false );
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_pdf', $plugin_url . 'assets/js/lib/ipages/pdf.min.js', array(), IPGS_PLUGIN_VERSION, false );
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_pdf_worker', $plugin_url . 'assets/js/lib/ipages/pdf.worker.min.js', array(), IPGS_PLUGIN_VERSION, false );
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_admin_js', $plugin_url . 'assets/js/admin.min.js', array('jquery'), IPGS_PLUGIN_VERSION, false );
			wp_enqueue_media();
			
			// global settings to help ajax work
			$globals = array(
				'plan' => IPGS_PLUGIN_PLAN,
				'msg_pro_title' => __('Available only in Pro version', IPGS_PLUGIN_NAME),
				'msg_edit_text' => __('Edit your text here', IPGS_PLUGIN_NAME),
				'msg_custom_js_error' => __('Custom js code error', IPGS_PLUGIN_NAME),
				'upload_url' => $upload_dir['baseurl'],
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( IPGS_PLUGIN_NAME . '_ajax' ),
				'ajax_msg_error' => __('Uncaught Error', IPGS_PLUGIN_NAME) //Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information
			);
			
			$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
			
			$globals['ajax_action_get'] = $this->ajax_action_settings_get;
			$globals['ajax_action_update'] = $this->ajax_action_item_update;
			$globals['ajax_item_id'] = $id;
			$globals['settings'] = NULL;
			$globals['config'] = NULL;
			
			$settings_key = IPGS_PLUGIN_NAME . '_settings';
			$settings_value = get_option($settings_key);
			if($settings_value) {
				$globals['settings'] = json_encode(unserialize($settings_value));
			}
			
			// get item data from DB
			if($id) {
				global $wpdb;
				$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
				
				$query = $wpdb->prepare('SELECT * FROM ' . $table . ' WHERE id=%s', $id);
				$item = $wpdb->get_row($query, OBJECT);
				if($item) {
					//{
					//id: null,
					//title: null,
					//active: true,
					//config: {...}
					//}
					$globals['config'] = json_encode(unserialize($item->data));
				}
			} else {
				// new item
				$item = (object) array(
					'author' => get_current_user_id(),
					'date' => current_time('mysql', 1),
					'modified' => current_time('mysql', 1)
				);
			}
			
			require_once( plugin_dir_path( dirname(__FILE__) ) . 'includes/page-item.php' );
			
			// set global settings
			wp_localize_script(IPGS_PLUGIN_NAME . '_admin_js', IPGS_PLUGIN_NAME, $globals);
		}
	}
	
	/**
	 * Show admin menu settings page
	 */
	function admin_menu_page_settings() {
		$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
		
		if($page===IPGS_PLUGIN_NAME . '_settings') {
			$plugin_url = plugin_dir_url(dirname(__FILE__));
			
			// styles
			wp_enqueue_style(IPGS_PLUGIN_NAME . '_admin_css', $plugin_url . 'assets/css/admin.min.css', array(), IPGS_PLUGIN_VERSION, 'all' );
			
			// scripts
			wp_enqueue_script(IPGS_PLUGIN_NAME . '_admin_js', $plugin_url . 'assets/js/admin.min.js', array('jquery'), IPGS_PLUGIN_VERSION, false );
			
			// global settings to help ajax work
			$globals = array(
				'plan' => IPGS_PLUGIN_PLAN,
				'msg_pro_title' => __('Available only in Pro version', IPGS_PLUGIN_NAME),
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( IPGS_PLUGIN_NAME . '_ajax' ),
				'ajax_msg_error' => __('Uncaught Error', IPGS_PLUGIN_NAME) //Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information
			);
			
			$globals['ajax_action_update'] = $this->ajax_action_settings_update;
			$globals['ajax_action_get'] = $this->ajax_action_settings_get;
			$globals['ajax_action_delete_data'] = $this->ajax_action_delete_data;
			$globals['config'] = NULL;
			
			// read settings
			$settings_key = IPGS_PLUGIN_NAME . '_settings';
			$settings_value = get_option($settings_key);
			if($settings_value) {
				$globals['config'] = json_encode(unserialize($settings_value));
			}
			
			require_once(plugin_dir_path( dirname(__FILE__) ) . 'includes/page-settings.php' );
			
			// set global settings
			wp_localize_script(IPGS_PLUGIN_NAME . '_admin_js', IPGS_PLUGIN_NAME, $globals);
		}
	}
	
	/**
	 * Ajax update item state
	 */
	function ajax_item_update_status() {
		$error = false;
		$data = array();
		$config = filter_input(INPUT_POST, 'config', FILTER_UNSAFE_RAW);
		
		if(check_ajax_referer(IPGS_PLUGIN_NAME . '_ajax', 'nonce', false)) {
			global $wpdb;
			
			$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
			$config = json_decode($config);
			$result = false;
			
			if(isset($config->id) && isset($config->active)) {
				$query = $wpdb->prepare('SELECT * FROM ' . $table . ' WHERE id=%s', $config->id);
				$item = $wpdb->get_row($query, OBJECT );
				
				if($item && (current_user_can('administrator') || get_current_user_id()==$item->author) ) {
					$itemData = unserialize($item->data);
					$itemData->active = $config->active;
					
					$result = $wpdb->update(
						$table,
						array(
							'active'=> $itemData->active,
							'data' => serialize($itemData)
						),
						array('id'=>$config->id));
				}
			}
			
			if($result) {
				$data['id'] = $config->id;
				$data['msg'] = __('Item updated', IPGS_PLUGIN_NAME);
			} else {
				$error = true;
				$data['msg'] = __('The operation failed, can\'t update item', IPGS_PLUGIN_NAME);
			}
		} else {
			$error = true;
			$data['msg'] = __('The operation failed', IPGS_PLUGIN_NAME);
		}
		
		if($error) {
			wp_send_json_error($data);
		} else {
			wp_send_json_success($data);
		}
		
		wp_die(); // this is required to terminate immediately and return a proper response
	}
	
	/**
	 * Ajax update item data
	 */
	function ajax_item_update() {
		$error = false;
		$data = array();
		
		if(check_ajax_referer(IPGS_PLUGIN_NAME . '_ajax', 'nonce', false)) {
			global $wpdb;
			$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
			
			$inputId = filter_input(INPUT_POST, 'id', FILTER_UNSAFE_RAW);
			$inputData = filter_input(INPUT_POST, 'data', FILTER_UNSAFE_RAW);
			$inputConfig = filter_input(INPUT_POST, 'config', FILTER_UNSAFE_RAW);
			$itemData = json_decode($inputData);
			$itemConfig = json_decode($inputConfig);
			$flag = true;
			
			if(IPGS_PLUGIN_PLAN == 'lite') {
				$rowcount = $wpdb->get_var('SELECT COUNT(*) FROM ' . $table );
				
				if(!($rowcount == 0 || ($rowcount == 1 && $inputId))) {
					$flag = false;
					$error = true;
					$data['msg'] = __('The operation failed, you can work only with one book. To create more, buy the pro version.', IPGS_PLUGIN_NAME);
				}
			}
			
			if($flag) {
				if($inputId) {
					$result = false;
					
					$query = $wpdb->prepare('SELECT * FROM ' . $table . ' WHERE id=%s', $inputId);
					$item = $wpdb->get_row($query, OBJECT);
					if($item && (current_user_can('administrator') || get_current_user_id()==$item->author) ) {
						$result = $wpdb->update(
							$table,
							array(
								'title' => $itemData->title,
								'active' => $itemData->active,
								'data' => serialize($itemData),
								'config' => serialize($itemConfig),
								'author' => get_current_user_id(),
								//'date' => NULL,
								'modified' => current_time('mysql', 1)
							),
							array('id'=>$inputId));
					}
					
					if($result) {
						$data['id'] = $inputId;
						$data['msg'] = __('Item updated', IPGS_PLUGIN_NAME);
					} else {
						$error = true;
						$data['msg'] = __('The operation failed, can\'t update item', IPGS_PLUGIN_NAME);
					}
				} else {
					$result = $wpdb->insert(
						$table,
						array(
							'title' => $itemData->title,
							'active' => $itemData->active,
							'data' => serialize($itemData),
							'config' => serialize($itemConfig),
							'author' => get_current_user_id(),
							'date' => current_time('mysql', 1),
							'modified' => current_time('mysql', 1)
						));
					
					if($result) {
						$data['id'] = $inputId = $wpdb->insert_id;
						$data['msg'] = __('Item created', IPGS_PLUGIN_NAME);
					} else {
						$error = true;
						$data['msg'] = __('The operation failed, can\'t create item', IPGS_PLUGIN_NAME);
					}
				}
			}
			
			//======================================
			// [filemanager] create an external file
			if(!$error && wp_is_writable(IPGS_PLUGIN_UPLOAD_DIR)) {
				$file_json = 'config.json';
				$file_css = 'custom.css';
				$file_root_path = IPGS_PLUGIN_UPLOAD_DIR . '/' . $inputId . '/';
				
				if(!is_dir($file_root_path)) {
					mkdir($file_root_path);
				}
				
				@file_put_contents($file_root_path . $file_json, json_encode($itemConfig));
				@file_put_contents($file_root_path . $file_css, $itemData->customCSS->data);
			}
			//======================================
		} else {
			$error = true;
			$data['msg'] = __('The operation failed', IPGS_PLUGIN_NAME);
		}
		
		if($error) {
			wp_send_json_error($data);
		} else {
			wp_send_json_success($data);
		}
		
		wp_die(); // this is required to terminate immediately and return a proper response
	}
	
	/**
	 * Ajax update settings data
	 */
	function ajax_settings_update() {
		$error = false;
		$data = array();
		$config = filter_input(INPUT_POST, 'config', FILTER_UNSAFE_RAW);
		
		if(check_ajax_referer(IPGS_PLUGIN_NAME . '_ajax', 'nonce', false)) {
			$settings_key = IPGS_PLUGIN_NAME . '_settings';
			$settings_value = serialize(json_decode($config));
			$result = false;
			
			if(get_option($settings_key) == false) {
				$deprecated = null;
				$autoload = 'no';
				$result = add_option($settings_key, $settings_value, $deprecated, $autoload);
			} else {
				$old_settings_value = get_option($settings_key);
				if($old_settings_value === $settings_value) {
					$result = true;
				} else {
					$result = update_option($settings_key, $settings_value);
				}
			}
			
			if($result) {
				$data['msg'] = __('Settings updated', IPGS_PLUGIN_NAME);
			} else {
				$error = true;
				$data['msg'] = __('The operation failed, can\'t update settings', IPGS_PLUGIN_NAME);
			}
		}
		
		if($error) {
			wp_send_json_error($data);
		} else {
			wp_send_json_success($data);
		}
		
		wp_die(); // this is required to terminate immediately and return a proper response
	}
	
	/**
	 * Ajax settings get data
	 */
	function ajax_settings_get() {
		$error = false;
		$data = array();
		$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
		
		if(check_ajax_referer(IPGS_PLUGIN_NAME . '_ajax', 'nonce', false)) {
			switch($type) {
				case 'book-themes': {
					$data['list'] = array();
					$files = glob(plugin_dir_path( dirname(__FILE__) ) . 'assets/themes/*.min.css');
					
					foreach($files as $file) {
						$filename = basename($file, '.min.css');
						array_push($data['list'], array('id' => $filename, 'title' => str_replace('-', ' ', $filename)));
					}
				}
				break;
				case 'editor-themes': {
					$data['list'] = array();
					$files = glob(plugin_dir_path( dirname(__FILE__) ) . 'assets/js/lib/ace/theme-*.js');
					
					foreach($files as $file) {
						$filename = str_replace('theme-','',basename($file, '.js'));
						array_push($data['list'], array('id' => $filename, 'title' => str_replace('_', ' ', $filename)));
					}
				}
				break;
				default: {
					$error = true;
					$data['msg'] = __('The operation failed', IPGS_PLUGIN_NAME);
				}
				break;
			}
		} else {
			$error = true;
			$data['msg'] = __('The operation failed', IPGS_PLUGIN_NAME);
		}
		
		if($error) {
			wp_send_json_error($data);
		} else {
			wp_send_json_success($data);
		}
		
		wp_die(); // this is required to terminate immediately and return a proper response
	}
	
	/**
	 * Ajax delete all data from tables
	 */
	function ajax_delete_data() {
		$error = true;
		$data = array();
		$data['msg'] = __('The operation failed, can\'t delete data', IPGS_PLUGIN_NAME);
		
		if(check_ajax_referer(IPGS_PLUGIN_NAME . '_ajax', 'nonce', false)) {
			global $wpdb;
			$table = $wpdb->prefix . IPGS_PLUGIN_NAME;
			
			foreach($wpdb->get_results('SELECT id FROM ' . $table) as $key=>$item) {
				//======================================
				// [filemanager] delete file
				if(wp_is_writable(IPGS_PLUGIN_UPLOAD_DIR)) {
					$file_json = 'config.json';
					$file_css = 'custom.css';
					$file_root_path = IPGS_PLUGIN_UPLOAD_DIR . '/' . $item->id . '/';
					
					wp_delete_file($file_root_path . $file_json);
					wp_delete_file($file_root_path . $file_css);
					
					if(is_dir($file_root_path)) {
						rmdir($file_root_path);
					}
				}
				//======================================
			}
			
			$query = 'TRUNCATE TABLE ' . $table;
			$result = $wpdb->query($query);
			
			if($result) {
				$error = false;
				$data['msg'] = __('All data deleted', IPGS_PLUGIN_NAME);
			}
		}
		
		if($error) {
			wp_send_json_error($data);
		} else {
			wp_send_json_success($data);
		}
		
		wp_die(); // this is required to terminate immediately and return a proper response
	}
}

endif;

?>