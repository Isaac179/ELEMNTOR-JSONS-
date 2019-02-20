<?php
/*
Widget Name: Elegant Tabs
Description: Add unique tab designs to your page using elegant tabs.
Author: InfiWebs
Author URI: https://www.infiwebs.com
*/

namespace ElegantTabs\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class for elegant card element.
 *
 * @access public
 * @since 1.0
 * @return void
 */
class Elegant_Tabs_Widget extends Widget_Base {

	/**
	 * Get element name.
	 *
	 * @access public
	 * @since 1.0
	 * @return string
	 */
	public function get_name() {
		return 'elegant_tabs';
	}

	/**
	 * Get element title.
	 *
	 * @access public
	 * @since 1.0
	 * @return string
	 */
	public function get_title() {
		return __( 'Elegant Tabs', 'elegant-tabs' );
	}

	/**
	 * Get element icon.
	 *
	 * @access public
	 * @since 1.0
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Get element script dependencies.
	 *
	 * @access public
	 * @since 1.0
	 * @return string
	 */
	public function get_script_depends() {
		return [
			'elegant_tabs',
		];
	}

	/**
	 * Register element controls.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_elegant_tabs',
			[
				'label' => __( 'Elegant Tabs', 'elegant-tabs' ),
			]
		);

		$this->add_control(
			'elegant_tabs',
			[
				'label'       => __( 'Tabs Items', 'elegant-tabs' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => [
					[
						'tab_title'   => __( 'Tab #1', 'elegant-tabs' ),
						'tab_content' => __( 'I am first tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elegant-tabs' ),
					],
					[
						'tab_title'   => __( 'Tab #2', 'elegant-tabs' ),
						'tab_content' => __( 'I am second tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elegant-tabs' ),
					],
					[
						'tab_title'   => __( 'Tab #3', 'elegant-tabs' ),
						'tab_content' => __( 'I am third tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elegant-tabs' ),
					],
				],
				'fields'      => [
					[
						'type'        => Controls_Manager::TEXT,
						'name'        => 'tab_title',
						'label'       => __( 'Tab Title', 'elegant-tabs' ),
						'default'     => __( 'Tab Title', 'elegant-tabs' ),
						'placeholder' => __( 'Tab Title', 'elegant-tabs' ),
						'label_block' => true,
					],
					[
						'type'        => Controls_Manager::TEXT,
						'name'        => 'tab_id',
						'label'       => __( 'Tab ID', 'elegant-tabs' ),
						'label_block' => true,
					],
					[
						'type'        => Controls_Manager::SELECT,
						'name'        => 'icon_type',
						'label'       => __( 'Icon Type', 'elegant-tabs' ),
						'description' => esc_attr__( 'Do you like to use font icons or custom image icon?', 'elegant-tabs' ),
						'default'     => 'icon',
						'options'     => [
							'icon'     => 'Font Icon',
							'img_icon' => 'Image Icon',
						],
					],
					[
						'type'        => Controls_Manager::ICON,
						'name'        => 'icon',
						'label'       => __( 'Icon', 'elegant-tabs' ),
						'description' => esc_attr__( 'Select the icon you would like to use for this tab.', 'elegant-tabs' ),
						'default'     => 'icon',
						'condition'   => [
							'icon_type' => 'icon',
						],
					],
					[
						'type'        => Controls_Manager::MEDIA,
						'name'        => 'icon_img',
						'label'       => __( 'Custom Image Icon', 'elegant-tabs' ),
						'description' => esc_attr__( 'Upload the custom image icon you would like to use for this tab.', 'elegant-tabs' ),
						'default'     => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition'   => [
							'icon_type' => 'img_icon',
						],
					],
					[
						'type'        => Controls_Manager::MEDIA,
						'name'        => 'icon_img_hover',
						'label'       => __( 'Custom Image Icon on Hover & Active', 'elegant-tabs' ),
						'description' => esc_attr__( 'Upload the custom image icon you would like to use for this tab to display on hover and active state.', 'elegant-tabs' ),
						'default'     => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'condition'   => [
							'icon_type' => 'img_icon',
						],
					],
					[
						'type'        => Controls_Manager::NUMBER,
						'name'        => 'icon_img_width',
						'label'       => __( 'Image Icon Width', 'elegant-tabs' ),
						'description' => __( 'Set the custom image icon width. Default is - 32px.', 'elegant-tabs' ),
						'default'     => 32,
						'min'         => 10,
						'max'         => 500,
						'step'        => 1,
						'condition'   => [
							'icon_type' => 'img_icon',
						],
					],
					[
						'type'        => Controls_Manager::NUMBER,
						'name'        => 'icon_img_height',
						'label'       => __( 'Image Icon Height', 'elegant-tabs' ),
						'description' => __( 'Set the custom image icon height. Default is - 32px.', 'elegant-tabs' ),
						'default'     => 32,
						'min'         => 10,
						'max'         => 500,
						'step'        => 1,
						'condition'   => [
							'icon_type' => 'img_icon',
						],
					],
					[
						'type'       => Controls_Manager::WYSIWYG,
						'name'       => 'tab_content',
						'label'      => __( 'Content', 'elegant-tabs' ),
						'default'    => __( 'Tab Content', 'elegant-tabs' ),
						'show_label' => false,
					],
					[
						'type'        => Controls_Manager::NUMBER,
						'name'        => 'tab_content_columns',
						'label'       => __( 'Content Columns', 'elegant-tabs' ),
						'description' => __( 'Set the number of columns the content can be divided.', 'elegant-tabs' ),
						'default'     => 1,
						'min'         => 1,
						'max'         => 6,
						'step'        => 1,
					],
					[
						'type'        => Controls_Manager::NUMBER,
						'name'        => 'tab_content_column_gap',
						'label'       => __( 'Column Spacing', 'elegant-tabs' ),
						'description' => __( 'Controls the gap between the columns. In pixels (px).', 'elegant-tabs' ),
						'default'     => 20,
						'min'         => 1,
						'max'         => 100,
						'step'        => 1,
					],
					[
						'type'        => Controls_Manager::SELECT,
						'name'        => 'tab_content_column_border',
						'label'       => _x( 'Border Type', 'Border Control', 'elegant-tabs' ),
						'description' => __( 'Select border around content columns.', 'elegant-tabs' ),
						'options'     => [
							''       => __( 'None', 'elegant-tabs' ),
							'solid'  => _x( 'Solid', 'Border Control', 'elegant-tabs' ),
							'double' => _x( 'Double', 'Border Control', 'elegant-tabs' ),
							'dotted' => _x( 'Dotted', 'Border Control', 'elegant-tabs' ),
							'dashed' => _x( 'Dashed', 'Border Control', 'elegant-tabs' ),
						],
					],
					[
						'type'        => Controls_Manager::NUMBER,
						'name'        => 'tab_content_column_border_width',
						'label'       => _x( 'Border Width', 'Border Control', 'elegant-tabs' ),
						'description' => __( 'Select border width. In pixels (px).', 'elegant-tabs' ),
						'default'     => 0,
						'min'         => 1,
						'max'         => 10,
						'step'        => 1,
						'condition'   => [
							'tab_content_column_border!' => '',
						],
					],
					[
						'type'        => Controls_Manager::COLOR,
						'name'        => 'tab_content_column_border_color',
						'label'       => _x( 'Border Color', 'Border Control', 'elegant-tabs' ),
						'description' => '<br/>' . __( 'Select border color.', 'elegant-tabs' ),
						'default'     => '',
						'condition'   => [
							'tab_content_column_border!' => '',
						],
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_elegant-tabs-settings',
			[
				'label' => __( 'Elegant Tabs Settings', 'elegant-tabs' ),
			]
		);

		$this->add_control(
			'tab_style',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Tab Style', 'elegant-tabs' ),
				'description' => esc_attr__( 'Choose the tabs layout you would like to use.', 'elegant-tabs' ),
				'default'     => 'bars',
				'options'     => [
					'bars'             => 'Bar Style',
					'iconbox'          => 'Icon Box Style',
					'underline'        => 'Underline Style',
					'topline'          => 'Top Line Style',
					'iconfall'         => 'Falling Icon Style',
					'line'             => 'Line Style',
					'linebox'          => 'Line Box Style',
					'flip'             => 'Flip Style',
					'tzoid'            => 'Trapezoid Style',
					'fillup'           => 'Fillup Style',
					'iconbox-iconlist' => 'Icon Box List Style',
				],
			]
		);

		$this->add_control(
			'icon_font_size',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'Icon Font Size', 'elegant-tabs' ),
				'description' => __( 'Set the tab icon font size. In pixels (px).', 'elegant-tabs' ),
				'default'     => 16,
				'min'         => 10,
				'max'         => 100,
				'step'        => 1,
				'selectors'   => [
					'{{WRAPPER}} .et-tabs nav ul li a.et-anchor-tag .iw-icons' => 'font-size:{{ VALUE }}px; line-height: 1.5em;',
				],
			]
		);

		$this->add_control(
			'auto_switch',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => __( 'Auto Switch Tabs', 'elegant-tabs' ),
				'description'  => __( 'Check if you want to auto switch tabs with interval.', 'elegant-tabs' ),
				'default'      => 'no',
				'label_on'     => __( 'Yes', 'elegant-tabs' ),
				'label_off'    => __( 'No', 'elegant-tabs' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'switch_interval',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'Auto Switch Interval', 'elegant-tabs' ),
				'description' => __( 'Enter the interval in seconds you want the tabs to auto switch. eg. 5.', 'elegant-tabs' ),
				'default'     => 5,
				'min'         => 5,
				'max'         => 100,
				'step'        => 1,
				'condition'   => [
					'auto_switch' => 'yes',
				],
			]
		);

		$this->add_control(
			'active_tab',
			[
				'type'        => Controls_Manager::NUMBER,
				'label'       => __( 'Default Active Tab Number', 'elegant-tabs' ),
				'description' => __( 'Enter the number of the tab to be active on load. Enter 0 to hide all tab content on load.', 'elegant-tabs' ),
				'default'     => 1,
				'min'         => 0,
				'max'         => 50,
				'step'        => 1,
			]
		);

		$this->add_control(
			'tab_type',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Tab Type', 'elegant-tabs' ),
				'description' => esc_attr__( 'Choose the tabs layout you would like to use.', 'elegant-tabs' ),
				'default'     => 'horizontal',
				'options'     => [
					'horizontal' => __( 'Horizontal Tabs', 'elegant-tabs' ),
					'vertical'   => __( 'Vertical Tabs', 'elegant-tabs' ),
				],
			]
		);

		$this->add_control(
			'justified',
			[
				'type'         => Controls_Manager::SWITCHER,
				'label'        => __( 'Justified Tabs', 'elegant-tabs' ),
				'description'  => __( 'This will set all tabs with same justified width. Only works with horizontal tabs.', 'elegant-tabs' ),
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'elegant-tabs' ),
				'label_off'    => __( 'No', 'elegant-tabs' ),
				'return_value' => 'yes',
				'condition'    => [
					'tab_type' => 'horizontal',
				],
			]
		);

		$this->add_control(
			'tab_align',
			[
				'type'        => Controls_Manager::CHOOSE,
				'label'       => __( 'Tab Alignment', 'elegant-tabs' ),
				'description' => esc_attr__( 'Align your tabs. Works only for horizontal tab type.', 'elegant-tabs' ),
				'default'     => 'left',
				'options'     => [
					'left'   => [
						'title' => __( 'Left', 'elegant-tabs' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elegant-tabs' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'elegant-tabs' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'condition'   => [
					'justified!' => 'yes',
					'tab_type'   => 'horizontal',
				],
			]
		);

		$this->add_control(
			'tab_animation',
			[
				'label'        => __( 'Tab Content Animation', 'elegant-tabs' ),
				'description'  => __( 'Animate your tab content when it appears!', 'elegant-tabs' ),
				'type'         => Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
				'selector'     => '{{WRAPPER}} section.tab',
			]
		);

		$this->add_control(
			'tab_to_mobile',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Tabs on mobile devices', 'elegant-tabs' ),
				'description' => __( 'Select how tabs should behave on mobile devices.', 'elegant-tabs' ),
				'default'     => 'accordion',
				'options'     => [
					'select'    => __( 'Dropdown Select', 'elegant-tabs' ),
					'accordion' => __( 'Tabs to Accordion', 'elegant-tabs' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_elegant-tabs-style',
			[
				'label' => __( 'Elegant Tabs', 'elegant-tabs' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_title_typography',
				'selector' => '{{WRAPPER}} .et-tabs nav ul li a span, {{WRAPPER}} .et-tabs nav ul li a',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_normal',
			[
				'label'     => __( 'Normal State', 'elegant-tabs' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color_tab_txt',
			[
				'label'       => __( 'Tab Text Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The font color of the inactive Tab in this set.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#74777b',
			]
		);

		$this->add_control(
			'color_tab_bg',
			[
				'label'       => __( 'Tab Background Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The background color of the inactive Tab in this set.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#EBEBEB',
			]
		);

		$this->add_control(
			'heading_active',
			[
				'label'     => __( 'Active State', 'elegant-tabs' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color_act_txt',
			[
				'label'       => __( 'Active Tab Text Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The font color of the active Tab in this set.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#333333',
			]
		);

		$this->add_control(
			'color_act_bg',
			[
				'label'       => __( 'Active Tab Background Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The background color of the active Tab in this set.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#61ce70',
			]
		);

		$this->add_control(
			'heading_hover',
			[
				'label'     => __( 'Hover State', 'elegant-tabs' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color_hover_txt',
			[
				'label'       => __( 'Tab Hover Text Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The font color of the tab on hover.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'color_hover_bg',
			[
				'label'       => __( 'Tab Hover Background Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The background color of the tab on hover.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'heading_content',
			[
				'label'     => __( 'Content', 'elegant-tabs' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'color_content_bg',
			[
				'label'       => __( 'Tab Content Background Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The background color of the tab content area.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'color_content_txt',
			[
				'label'       => __( 'Tab Content Text Color', 'elegant-tabs' ),
				'description' => '<br/>' . __( 'The text color of the tab content.', 'elegant-tabs' ),
				'type'        => Controls_Manager::COLOR,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_typography',
				'selector' => '{{WRAPPER}} .et-content-wrap',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render element output.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	protected function render() {
		$tab_style   = $tab_type = $color_act_txt = $color_act_bg = $color_hover_txt = $color_hover_bg = '';
		$style       = $color_content_bg = $color_content_txt = $tab_animation = $tab_align = $tab_to_mobile = '';
		$auto_switch = $switch_interval = '';
		$html        = '';

		$args = $this->get_settings();
		extract( shortcode_atts( array(
			'tab_style'         => 'bars',
			'tab_type'          => 'horizontal',
			'tab_align'         => 'left',
			'justified'         => false,
			'active_tab'        => 1,
			'auto_switch'       => 'no',
			'switch_interval'   => 5,
			'color_tab_txt'     => '#74777b',
			'color_tab_bg'      => '#EBEBEB',
			'color_act_txt'     => '#ffffff',
			'color_act_bg'      => '#2A90DA',
			'color_hover_txt'   => '',
			'color_hover_bg'    => '',
			'color_content_bg'  => '',
			'color_content_txt' => '',
			'tab_animation'     => '',
			'tab_to_mobile'     => 'select',
		), $args ) );

		$default_active_tab = ( isset( $args['active_tab'] ) && '' !== $args['active_tab'] ) ? $args['active_tab'] - 1 : 0;

		$switch_interval = (int) $switch_interval;

		$shortcode_tabs = $this->get_settings( 'elegant_tabs' ); // Get all tabs.

		$tabs_nav     = '';
		$tabs_content = '';
		$anchor_style = '';

		$tabs_count = count( $shortcode_tabs );
		$id_int     = substr( $this->get_id_int(), 0, 3 );

		$i = 0;
		$n = 0;

		if ( 'line' !== $tab_style && '' !== $color_tab_bg ) {
			$style .= 'background:' . $color_tab_bg . ';';
		}
		if ( '' !== $color_tab_txt ) {
			$style .= 'color:' . $color_tab_txt . ';';
		}
		if ( '' !== $color_tab_txt ) {
			$anchor_style = 'color:' . $color_tab_txt . ';';
		}

		$default_icon_image = esc_attr( Utils::get_placeholder_image_src() );

		foreach ( $shortcode_tabs as $tab ) {
			$i++;
			$tab_icon = '';
			$has_icon = '';

			if ( '' === $tab['tab_id'] ) {
				$tab['tab_id'] = $tab['_id'];
			}

			if ( 'icon' === $tab['icon_type'] && '' !== $tab['icon'] && 'icon' !== $tab['icon'] ) {
				$tab_icon = '<i class="iw-icons ' . $tab['icon'] . '" style="color:' . $color_tab_txt . ';"></i>';
				$has_icon = 'has-icon';
			} elseif ( 'img_icon' === $tab['icon_type'] && isset( $tab['icon_img'] ) ) {
				$img_icon       = $tab['icon_img']['url'];
				$img_icon_hover = ( isset( $tab['icon_img_hover'] ) && '' !== $tab['icon_img_hover']['url'] ) ? $tab['icon_img_hover']['url'] : $img_icon;

				if ( $default_icon_image === $img_icon_hover ) {
					$img_icon_hover = $img_icon;
				}

				$image_icon_width  = ( isset( $tab['icon_img_width'] ) ) ? $tab['icon_img_width'] . 'px' : '32px';
				$image_icon_height = ( isset( $tab['icon_img_height'] ) ) ? $tab['icon_img_height'] . 'px' : '32px';

				$img_css  = 'width: ' . $image_icon_width . ';';
				$img_css .= 'height: ' . $image_icon_height;

				$img_icon_original = $img_icon;

				if ( 1 === $i && $img_icon !== $img_icon_hover ) {
					$img_icon = $img_icon_hover;
				}

				$tab_icon = '<img class="elegant-tabs-image-icon" data-hover-src="' . $img_icon_hover . '" data-original-src="' . $img_icon_original . '" src="' . $img_icon . '" style=" ' . $img_css . ' " />';
				$has_icon = 'has-icon';
			} else {
				$has_icon = 'no-icon';
			}
			$tab_title = ( isset( $tab['tab_title'] ) ) ? $tab['tab_title'] : '';
			$tabs_nav .= '<li data-id="' . $tab['_id'] . '" style="' . $style . '">';
			$tabs_nav .= '<a class="et-anchor-tag" style="' . $anchor_style . '" href="javascript:void();" data-href="#section-' . $tab['tab_id'] . '">';
			$tabs_nav .= $tab_icon;
			$tabs_nav .= '<span class="' . $has_icon . '">' . $tab_title . '</span></a></li>';

			if ( 'accordion' === $tab_to_mobile ) :
				$active_class = '';
				if ( 1 === $n ) {
					$active_class = ' infi-active-tab';
					$n++;
				}

				$tabs_content .= '<div class="infi-responsive-tabs" data-tab_style="' . esc_attr( $tab_style ) . '" data-active-bg="' . esc_attr( $color_act_bg ) . '" data-active-text="' . esc_attr( $color_act_txt ) . '" data-hover-bg="' . esc_attr( $color_hover_bg ) . '" data-hover-text="' . esc_attr( $color_hover_txt ) . '">
					<div class="infi-tab-accordion' . esc_attr( $active_class ) . '">
						<div class="' . esc_attr( $tab['tab_id'] ) . '_tab infi_accordion_item" style="' . esc_attr( $style ) . '">
							<div class="infi-accordion-item-heading" data-href="#section-' . esc_attr( $tab['tab_id'] ) . '" style="color:' . esc_attr( $color_tab_txt ) . ';">';
				$tabs_content .= ( 'no-icon' !== $tab_icon ) ? $tab_icon : '';
				$tabs_content .= '<span class="' . $has_icon . '">' . $tab['tab_title'] . '</span>
							</div>
						</div>
					</div>
				</div>';
			endif;

			$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'elegant_tabs', $i - 1 );
			$this->add_render_attribute( $tab_content_setting_key, [
				'id'              => 'elegant-tabs-content-' . $id_int . $i,
				'class'           => [ 'elegant-tabs-content', 'elementor-clearfix' ],
				'data-tab'        => $i,
				'role'            => 'tabpanel',
				'aria-labelledby' => 'elegant-tabs-title-' . $id_int . $i,
			] );

			$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );

			$tabs_content .= '<section id="section-' . $tab['tab_id'] . '" class="tab" data-animation="' . $tab_animation . '" style="background:' . $color_content_bg . '; color:' . $color_content_txt . ';">';
			$tabs_content .= '<div class="infi-content-wrapper" style="column-count:' . $tab['tab_content_columns'] . '; column-gap:' . $tab['tab_content_column_gap'] . 'px; column-rule: ' . $tab['tab_content_column_border_width'] . 'px ' . $tab['tab_content_column_border'] . ' ' . $tab['tab_content_column_border_color'] . ';">';
			$tabs_content .= '<div ' . $this->get_render_attribute_string( $tab_content_setting_key ) . '>';
			$tabs_content .= $this->parse_text_editor( $tab['tab_content'] );
			$tabs_content .= '</div>';
			$tabs_content .= '</div></section>';

		}

		$rand         = rand();
		$mobile_class = ( 'select' === $tab_to_mobile ) ? ' et-mobile-enabled ' : ' et-mobile-disabled ';
		$justified    = ( 'yes' === $justified && 'horizontal' === $tab_type ) ? ' justified-tabs' : ' non-justified-tabs';

		$content  = '<div class="elementor-elegant-tabs" role="tablist" style="min-height: 100px;">';
		$content .= '<section class="elegant-tabs-container">
		<div class="' . trim( 'et-tabs et-' . $tab_type . $justified . $mobile_class . 'et-tabs-style-' . $tab_style . ' tab-class-' . $rand . ' et-align-' . $tab_align ) . '" data-tab_style="' . $tab_style . '" data-active-bg="' . $color_act_bg . '" data-active-text="' . $color_act_txt . '" data-hover-bg="' . esc_attr( $color_hover_bg ) . '" data-hover-text="' . esc_attr( $color_hover_txt ) . '" data-active-tab="' . esc_attr( $default_active_tab ) . '" data-auto-switch-tab="' . esc_attr( $auto_switch ) . '" data-switch-interval="' . esc_attr( $switch_interval ) . '">';

		$content .= '<nav>
			<ul class="elegant-tabs-list-container" style="color:' . $color_act_bg . '">
			' . $tabs_nav . '
			</ul>';

		if ( 'select' === $tab_to_mobile ) {
			$content .= '<select class="et-mobile-tabs">';
			foreach ( $shortcode_tabs as $tab ) {
				if ( '' === $tab['tab_id'] ) {
					$tab['tab_id'] = $tab['_id'];
				}

				$content .= '<option value="#section-' . $tab['tab_id'] . '">' . $tab['tab_title'] . '</option>';
			}
			$content .= '</select>';
		}

		$content_bg_class = ( '' !== $color_content_bg ) ? ' content-has-bg' : '';

		$content .= '</nav>
		<div class="et-content-wrap' . $content_bg_class . '">
		' . $tabs_content . '
		</div> <!-- /et-content-wrap -->
		</div> <!-- /et-tabs -->
		</section></div>';

		echo $content; // XSS:CSRF Ok.
	}

	/**
	 * Render tabs widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<div class="elementor-elegant-tabs" role="tablist" style="min-height: 100px;">
			<#
			var $default_active_tab = ( ( 'undefined' !== typeof settings.active_tab ) && '' !== settings.active_tab ) ? settings.active_tab - 1 : 0;

			var $shortcode_tabs = settings.elegant_tabs; // Get all tabs.
			var defaultImage = '<?php echo esc_attr( Utils::get_placeholder_image_src() ); ?>';

			var $tabs_nav     = '';
			var $tabs_content = '';
			var $anchor_style = '';
			var $style        = '';
			var $tab_icon     = '';
			var $has_icon     = '';

			var $i = 0;
			var $n = 0;
			var $justified = false;
			var tabindex   = view.getIDInt().toString().substr( 0, 3 );

			if ( 'line' !== settings.tab_style && '' !== settings.color_tab_bg ) {
				$style += 'background:' + settings.color_tab_bg + ';';
			}

			if ( '' !== settings.color_tab_txt ) {
				$style += 'color:' + settings.color_tab_txt + ';';
			}

			if ( '' !== settings.color_tab_txt ) {
				$anchor_style = 'color:' + settings.color_tab_txt + ';';
			}

			var $rand         = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
			var $mobile_class = ( 'select' === settings.tab_to_mobile ) ? 'et-mobile-enabled' : 'et-mobile-disabled';
			$justified        = ( 'yes' === settings.justified && 'horizontal' === settings.tab_type ) ? 'justified-tabs' : 'non-justified-tabs';
			#>
			<section class="elegant-tabs-container">
				<div class="et-tabs et-{{ settings.tab_type }} {{ $justified }} {{ $mobile_class }} et-tabs-style-{{ settings.tab_style }} tab-class-{{ $rand }} et-align-{{ settings.tab_align }}" data-tab_style="{{ settings.tab_style }}" data-active-bg="{{ settings.color_act_bg }}" data-active-text="{{ settings.color_act_txt }}" data-hover-bg="{{ settings.color_hover_bg }}" data-hover-text="{{ settings.color_hover_txt }}" data-active-tab="{{ settings.default_active_tab }}" data-auto-switch-tab="{{ settings.auto_switch }}" data-switch-interval="{{ settings.switch_interval }}">
					<nav>
						<ul class="elegant-tabs-list-container" style="color:{{ settings.color_act_bg }}">
							<#
							_.each ( $shortcode_tabs, function( $tab, index ) {

								$i = $i + 1;

								var $tab_title = ( 'undefined' !== typeof $tab.tab_title ) ? $tab.tab_title : '';
								#>
								<li style="{{ $style }}" data-id="{{ $tab._id }}">
									<a class="et-anchor-tag" style="{{ $anchor_style }}" href="#" data-href="#section-{{ $tab._id }}">
									<#
									if ( 'icon' === $tab.icon_type && '' !== $tab.icon && 'icon' !== $tab.icon ) {
										#>
										<i class="iw-icons {{ $tab.icon }}" style="color:{{ settings.color_tab_txt }}"></i>
										<#
										$has_icon = 'has-icon';
									} else if ( 'img_icon' === $tab.icon_type && 'undefined' !== typeof $tab.icon_img ) {
										var $img_icon       = $tab.icon_img.url;
										var $img_icon_hover = 'undefined' !== typeof $tab.icon_img_hover ? $tab.icon_img_hover.url : $img_icon;

										if ( defaultImage === $img_icon_hover ) {
											$img_icon_hover = $img_icon;
										}

										var $image_icon_width  = ( 'undefined' !== $tab.icon_img_width ) ? $tab.icon_img_width + 'px' : '32px';
										var $image_icon_height = ( 'undefined' !== $tab.icon_img_height ) ? $tab.icon_img_height + 'px' : '32px';

										var $img_css  = 'width:' + $image_icon_width + ';';
										$img_css += 'height:' + $image_icon_height + ';';

										var $img_icon_original = $img_icon;

										if ( 1 === $i ) {
											$img_icon = $img_icon_hover;
										}
										#>
										<img class="elegant-tabs-image-icon" data-hover-src="{{ $img_icon_hover }}" data-original-src="{{ $img_icon_original }}" src="{{ $img_icon }}" style="{{ $img_css }}" />
										<#
										$has_icon = 'has-icon';
									}
									#>
									<span class="{{ $has_icon }}">{{{ $tab_title }}}</span>
								</a>
							</li>
							<#
							} );
							#>
						</ul>
						<#
						if ( 'select' === settings.tab_to_mobile ) {
							#>
							<select class="et-mobile-tabs">
							<#
							_.each ( $shortcode_tabs, function( $tab, index ) {
								#>
								<option value="section-{{ $tab._id }}">{{{ $tab.tab_title }}}</option>
								<#
							} );
							#>
							</select>
							<#
						}
						#>
					</nav>
					<#
					var $content_has_bg = ( '' !== settings.color_content_bg ) ? 'content-has-bg' : 'content-has-no-bg';
					#>
					<div class="et-content-wrap {{ $content_has_bg }}">
					<#
					_.each ( $shortcode_tabs, function( $tab, index ) {
						var tabCount = index + 1;
						if ( 'accordion' === settings.tab_to_mobile ) {

							var $active_class = '';

							if ( 1 === $n ) {
								$active_class = ' infi-active-tab';
								$n = $n + 1;
							}
							#>
							<div class="infi-responsive-tabs" data-tab_style="{{ settings.tab_style }}" data-active-bg="{{ settings.color_act_bg }}" data-active-text="{{ settings.color_act_txt }}" data-hover-bg="{{ settings.color_hover_bg }}" data-hover-text="{{ settings.color_hover_txt }}">
								<div class="infi-tab-accordion{{ $active_class }}">
									<div class="{{ $tab._id }}_tab infi_accordion_item" style="{{ $style }}">
										<div class="infi-accordion-item-heading" data-href="#section-{{ $tab._id }}" style="color:{{ settings.color_tab_txt }};">
											<#
											if ( 'icon' === $tab.icon_type && '' !== $tab.icon ) {
												#>
												<i class="iw-icons {{ $tab.icon }}" style="color:{{ settings.color_tab_txt }}"></i>
												<#
												$has_icon = 'has-icon';
											} else if ( 'img_icon' === $tab.icon_type && 'undefined' !== typeof $tab.icon_img ) {
												var $img_icon       = $tab.icon_img.url;
												var $img_icon_hover = 'undefined' !== typeof $tab.icon_img_hover ? $tab.icon_img_hover.url : $img_icon;

												if ( defaultImage === $img_icon_hover ) {
													$img_icon_hover = $img_icon;
												}

												var $image_icon_width  = ( 'undefined' !== $tab.icon_img_width ) ? $tab.icon_img_width + 'px' : '32px';
												var $image_icon_height = ( 'undefined' !== $tab.icon_img_height ) ? $tab.icon_img_height + 'px' : '32px';

												var $img_css  = 'width:' + $image_icon_width + ';';
												$img_css += 'height:' + $image_icon_height + ';';

												var $img_icon_original = $img_icon;

												if ( 1 === $i ) {
													$img_icon = $img_icon_hover;
												}

												#>
												<img class="elegant-tabs-image-icon" data-hover-src="{{ $img_icon_hover }}" data-original-src="{{ $img_icon_original }}" src="{{ $img_icon }}" style="{{ $img_css }}" />
												<#
												$has_icon = 'has-icon';
											}
											#>
											<span class="{{ $has_icon }}">{{{ $tab.tab_title }}}</span>
										</div>
									</div>
								</div>
							</div>
						<# } #>

						<#
						var tabCount = index + 1,
							tabContentKey = view.getRepeaterSettingKey( 'tab_content', 'elegant_tabs', index );

						view.addRenderAttribute( tabContentKey, {
							'id': 'elegant-tabs-content-' + tabindex + tabCount,
							'class': [ 'elegant-tabs-content', 'elementor-clearfix', 'elementor-repeater-item-' + $tab._id ],
							'data-tab': tabCount,
							'role' : 'tabpanel',
							'aria-labelledby' : 'elegant-tabs-title-' + tabindex + tabCount
						} );

						view.addInlineEditingAttributes( tabContentKey, 'advanced' );
						#>

						<section id="section-{{ $tab._id }}" class="tab" data-animation="{{ settings.tab_animation }}" style="background:{{ settings.color_content_bg }}; color:{{ settings.color_content_txt }};">
							<div class="infi-content-wrapper" style="column-count: {{ $tab.tab_content_columns }}; column-gap: {{ $tab.tab_content_column_gap }}px; column-rule: {{ $tab.tab_content_column_border_width }}px {{ $tab.tab_content_column_border }} {{ $tab.tab_content_column_border_color }};">
								<div {{{ view.getRenderAttributeString( tabContentKey ) }}}>
									{{{ $tab.tab_content }}}
								</div>
							</div>
						</section>
						<#
					} );
					#>
					</div> <!-- /et-content-wrap -->
				</div> <!-- /et-tabs -->
			</section>
		</div> <!-- /elementor-elegant-tabs -->
		<?php
	}
}
