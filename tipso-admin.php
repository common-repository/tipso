<?php
add_action( 'admin_menu', 'tipso_add_admin_menu' );
add_action( 'admin_init', 'tipso_settings_init' );
add_action( 'admin_enqueue_scripts', 'tipso_color_picker' );
function tipso_color_picker( $hook ) {
 
    if( is_admin() ) {      
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' );         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'tipso_color_picker-handle', plugins_url( 'admin/tipso_color_picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}

function tipso_add_admin_menu(  ) { 

	add_submenu_page( 'options-general.php', 'Tipso', 'Tipso Settings', 'manage_options', 'Tipso', 'tipso_options_page' );

}


function tipso_settings_init(  ) { 

	register_setting( 'pluginPage', 'tipso_settings' );

	add_settings_section(
		'tipso_pluginPage_section', 
		__( 'Change the default Tipso tooltip settings', 'object505' ), 
		'tipso_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'speed', 
		__( 'Speed', 'object505' ), 
		'speed', 
		'pluginPage', 
		'tipso_pluginPage_section' 
	);

	add_settings_field( 
		'background', 
		__( 'Background', 'object505' ), 
		'background', 
		'pluginPage', 
		'tipso_pluginPage_section' 
	);

	add_settings_field( 
		'color', 
		__( 'Color', 'object505' ), 
		'color', 
		'pluginPage', 
		'tipso_pluginPage_section' 
	);

	add_settings_field( 
		'position', 
		__( 'Position', 'object505' ), 
		'position', 
		'pluginPage', 
		'tipso_pluginPage_section' 
	);

	add_settings_field( 
		'width', 
		__( 'Width', 'object505' ), 
		'width', 
		'pluginPage', 
		'tipso_pluginPage_section' 
	);

	add_settings_field( 
		'delay', 
		__( 'Delay', 'object505' ), 
		'delay', 
		'pluginPage', 
		'tipso_pluginPage_section' 
	);


}


function speed() { 
	$options = get_option( 'tipso_settings' );
	?>
	<input type='number' name='tipso_settings[speed]' value='<?php echo $options['speed']; ?>'>
	<p class="description">Duration of the fade effect in ms.</p>
	<p class="description">Default value -> 400</p>
	<?php
}
function background() { 
	$options = get_option( 'tipso_settings' );
	?>
	<input class="color-field" type='text' name='tipso_settings[background]' value='<?php echo $options['background']; ?>'>
	<p class="description">Background color of the tooltip.</p>
	<p class="description">Default value -> #55b555</p>
	<?php
}
function color() { 
	$options = get_option( 'tipso_settings' );
	?>
	<input class="color-field" type='text' name='tipso_settings[color]' value='<?php echo $options['color']; ?>'>
	<p class="description">Text color of the tooltip.</p>
	<p class="description">Default value -> #ffffff</p>
	<?php
}
function position() {
	$options = get_option( 'tipso_settings' );
	?>
	<select name='tipso_settings[position]'>
		<option value='top' <?php selected( $options['position'], 'top' ); ?>>top</option>
		<option value='bottom' <?php selected( $options['position'], 'bottom' ); ?>>bottom</option>
		<option value='left' <?php selected( $options['position'], 'left' ); ?>>left</option>
		<option value='right' <?php selected( $options['position'], 'right' ); ?>>right</option>
	</select>

	<!-- <input type='text' name='tipso_settings[position]' value='<?php echo $options['position']; ?>'> -->
	<p class="description">Position of the tooltip.</p>
	<p class="description">Default value -> top</p>
	<?php
}
function width() { 
	$options = get_option( 'tipso_settings' );
	?>
	<input type='number' name='tipso_settings[width]' value='<?php echo $options['width']; ?>'>
	<p class="description">Width of the tooltip in px.</p>
	<p class="description">Default value -> 200</p>
	<?php
}
function delay() {
	$options = get_option( 'tipso_settings' );
	?>
	<input type='number' name='tipso_settings[delay]' value='<?php echo $options['delay']; ?>'>
	<p class="description">Delay before showing the tooltip in ms.</p>
	<p class="description">Default value -> 200</p>
	<?php
}


function tipso_settings_section_callback() {

	echo __('Here you can change the default values of Tipso. If you want the values to be the same as the default ones just keep the fields empty.');
}


function tipso_options_page() { 

	?>
	<div class="wrap">
		<form action='options.php' method='post'>			
			<h2>Tipso Tooltip Settings</h2>
			
			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>
			
		</form>
	</div>
	<?php

}

?>