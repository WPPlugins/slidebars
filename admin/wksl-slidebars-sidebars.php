<?php
/*
 * WK SLidebars
 * Sidebars Class
 */


class WKSL_Slidebars_Sidebars {

	/*
	 * Text Domain
	 */
	public $textdomain;

	/*
	 * Constructor
	 */
	public function __construct( $textdomain ) {
		$this->textdomain = $textdomain;
	}

	/*
	 * Register Sidebars
	 */
	public function register() {

    register_sidebar( array(
      'name' => __( 'Slidebar', $this->textdomain ),
      'id' => 'wksl-slidebar-1',
      'description' => __( 'Slidebar', $this->textdomain ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4 class="widgettitle">',
      'after_title'   => '</h4>',
    ) );

	}

	/*
	 * Render Sidebars
	 */
  public function render( $settings_array ) {

    if( is_active_sidebar( 'wksl-slidebar-1' ) ) :
			$icon_class = $settings_array['button_icon'];
      ?>
      <div id="wksl-slidebar-1" class="wksl-slidebar">
				<div class="wksl-slidebar-content">
	        <?php dynamic_sidebar( 'wksl-slidebar-1' ); ?>
				</div>
				<span class="wksl-slidebar-trigger <?php echo "fa $icon_class" ?>"></span>
      </div>
			<?php if( $settings_array['use_content_overlay'] ) : ?>
				<div class="wksl-slidebar-overlay" data-targetid="wksl-slidebar-1"></div>
			<?php endif; ?>
      <?php
    endif;

	}

	/*
	 * Custom Styles
	 */
	public function custom_styles( $style_settings ) {

		?>
		<style>

			#wksl-slidebar-1 .wksl-slidebar-trigger {
				background-color: <?php echo $style_settings[0]['icon_background_color']; ?>;
				color: <?php echo $style_settings[0]['icon_color']; ?>;
			}

			#wksl-slidebar-1 {
				background-color: <?php echo $style_settings[0]['sidebar_background_color'] ?>;
			}

			<?php if( $style_settings[0]['push_content'] ) : ?>

			html {
				overflow-x: hidden !important;
			}

			body, body::before {
				transition: left 0.4s ease, right 0.4s ease;
				<?php echo $style_settings[0]['position'] == 'left' ? "left: 0px;" : "right: 0px;"; ?>
				position: relative;
			}

			html.wksl-slidebar-1-is-out body,
			html.wksl-slidebar-1-is-out body::before {
				<?php echo $style_settings[0]['position'] == 'left' ? "left: 300px;" : "right: 300px"; ?>
			}

			<?php endif; ?>

			@media screen and (max-width : 376px)  {
				html.wksl-slidebar-1-is-out body,
				html.wksl-slidebar-1-is-out body::before {
					<?php echo $style_settings[0]['position'] == 'left' ? "left: 270px" : "right: 270px"; ?>;
				}
			}

			@media screen and (max-width : 320px)  {
				html.wksl-slidebar-1-is-out body,
				html.wksl-slidebar-1-is-out body::before {
					<?php echo $style_settings[0]['position'] == 'left' ? "left: 230px" : "right: 230px"; ?>;
				}
			}

			#wksl-slidebar-1 {
				left: <?php echo $style_settings[0]['position'] == 'left' ? "0" : "auto"; ?> ;
				right: <?php echo $style_settings[0]['position'] == 'right' ? "0" : "auto"; ?> ;
				transform: <?php echo $style_settings[0]['position'] == 'left' ? "translateX(-100%)" : "translateX(100%)"; ?>;
			}

			<?php if( $style_settings[0]['position'] == 'right' ) : ?>
				#wksl-slidebar-1 .wksl-slidebar-trigger {
					right: unset;
					left: 0;
					transform: translateY(-50%) translateX(-200%);
				}
			<?php endif; ?>
			<?php foreach( json_decode( $style_settings[0]['hide_on'] ) as $page_id ) : ?>
				body.page.page-id-<?php echo $page_id; ?> #wksl-slidebar-1 {
					display: none;
				}
			<?php endforeach; ?>

			<?php if( $style_settings[0]['use_content_overlay'] ) : ?>
				.wksl-slidebar-overlay {
					background-color: black;
					pointer-events: none;
					opacity: 0;
					transition: opacity 0.4s ease;
					position: fixed;
					top: 0;
					left: 0;
					height: 100vh;
					width: 100vw;
					z-index: 1000000;
				}

				html.wksl-slidebar-1-is-out .wksl-slidebar-overlay {
					opacity: 0.2;
					pointer-events: all;
				}
			<?php endif; ?>

			/*static styles*/

				html.wksl-slidebar-1-is-out #wksl-slidebar-1 {
					transform: translateX(0) !important;
				}

			.wksl-slidebar {
				width: 300px;
			  position: fixed;
			  left: 0;
			  top: 0;
			  transform: translateX(-100%);
			  height: 100vh;
			  transition: transform 0.4s ease;
			  background-color: white;
				z-index: 1000001;
			}

			.wksl-slidebar .wksl-slidebar-content {
				padding-top: 50px;
				overflow-y: auto;
				height: 100%;
			}

			.wksl-slidebar .wksl-slidebar-trigger {
			  position: absolute;
			  top: 50%;
			  transform: translateY(-50%) translateX(200%);
			  right: 0px;
			  background-color: black;
			  color: white;
			  height: 40px;
			  line-height: 40px !important;
			  text-align: center;
			  width: 40px;
			  border-radius: 100%;
			  cursor: pointer;
			}

			.wksl-slidebar .wksl-slidebar-trigger.dashicons {
				font-family: dashicons;
				text-decoration: inherit;
				font-weight: 400;
				font-style: normal;
				vertical-align: top;
			}

			@media screen and (max-width : 376px)  {
			  .wksl-slidebar {
			    width: 270px;
			  }
			}

			@media screen and (max-width : 320px)  {
			  .wksl-slidebar {
			    width: 230px;
			  }
			}

			<?php echo $style_settings[0]['custom_css']; ?>

		</style>

		<?php
	}

}

?>
