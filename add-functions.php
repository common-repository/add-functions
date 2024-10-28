<?php
/*
Plugin Name: Add Functions
Plugin URI: http://tigor.me/add-functions/
Description: Add php code without editing functions.php.  
Version: 0.2
Author: TIgor
Author URI: http://tigor.org.ua
License: GPL2
*/


/*  Copyright 2011 Tesliuk Igor  (email : tigor@tigor.org.ua)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function add_functions_init() {
	add_functions_on_init();
	}
	
	
	
function add_functions_on_init() {
	$options = get_option('add_functions');
	
	
	if ('false' != $options['on_init']) 
		{
		$options['on_init'] = 'false';
		update_option('add_functions',$options);
		
		eval($options['code']);
		
		$options['on_init'] = 'true';
		update_option('add_functions',$options);
		
		
		
		}
	
	
	}

function options_add_functions() {
	

	?>	<div class="wrap">

        <h2>Add Functions</h2>

        <form method="post" action="options.php">
		<?php 
		$adds_dir = str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		settings_fields('add_functions_group');
		
		$options = get_option('add_functions');
		
		?>
			<script src="<?php echo WP_PLUGIN_URL.'/'.$adds_dir.'codepress/codepress.js'; ?>" type="text/javascript"></script> 
			<script type="text/javascript">
			function addfunctions()
				{
				functionscode = myCpWindow.getCode();
				var count = functionscode.length - 7;
				document.getElementById('hidden').innerHTML = functionscode.substr(5,count);
				}
			</script> 
			<table class="form-table">
			<br />
			
			Don't forget PHP tags on start and end (<?php echo '&lt;?php .....  ?&gt;';?>).
			
			<br />
			<?php if ('false' == $options['on_init'])
				{?>
				<div style="background-color:red;">There was an error in last code run!!!!</div>
				
				<?php }?>
			
			
			<textarea cols="100" rows="30" id="myCpWindow" name="add_functions[editor]"  class="codepress php"><?php echo '<?php '.$options['code'].'?>';  ?></textarea>
			<br />
			
			<textarea cols="1" rows="5" id="hidden" style="visibility:hidden; display:none;" name="add_functions[code]"><?php echo $options['code'];  ?></textarea>
			
			<input type="hidden" name="add_functions[on_init]" value="true">
			
			</table>
			
			
		    <p class="submit">
				<input onMouseOver="addfunctions()" onclick="addfunctions()" type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>

        </form>

    </div> 	<?php

	update_option('add_functions',$options);
	
	}
	
	
function register_add_functions_settings() {
	register_setting('add_functions_group','add_functions');
	}


function admin_add_functions() {
	add_options_page('Add Functions', 'Add Functions', 'manage_options', 'add_functions', 'options_add_functions');
	add_action( 'admin_init', 'register_add_functions_settings' );
	}
function add_functions_activator() {

	}
register_activation_hook(__FILE__,'add_functions_activator');
add_action("plugins_loaded", "add_functions_init");
add_action('admin_menu',"admin_add_functions");
?>