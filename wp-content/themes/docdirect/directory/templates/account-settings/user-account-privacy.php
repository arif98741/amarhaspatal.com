<?php
/**
 * User Profile Main
 * return html
 */

global $current_user, $wp_roles,$userdata,$post;
$user_identity  = $current_user->ID;
$privacy		= docdirect_get_privacy_settings($user_identity);
$is_chat		= docdirect_is_chat_enabled();
$data			= get_userdata( $user_identity );

if( !empty( $data->roles[0] ) && ( $data->roles[0] !== 'professional' ) ){?>
<div class="tg-bordertop tg-haslayout">
	<div class="tg-formsection">
		<div class="tg-heading-border tg-small">
			<h3><?php esc_attr_e('Privacy','docdirect');?></h3>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php if( !empty($is_chat) && $is_chat === 'yes' ){?>
					<div class="form-group">  
						<div class="tg-privacy"> 
						  <div class="tg-iosstylcheckbox">
							<input type="hidden" name="privacy[chat_message]">
							<input type="checkbox" class="" <?php echo isset( $privacy['chat_message'] ) && $privacy['chat_message'] === 'on' ? 'checked':'';?>  name="privacy[chat_message]" id="tg-chat_message">
							<label for="tg-chat_message" class="checkbox-label" data-private="<?php esc_attr_e('Disable','docdirect');?>" data-public="<?php esc_attr_e('Enable','docdirect');?>"></label>
						  </div>
						  <span class="tg-privacy-name"><strong><?php esc_html_e('Chat message notification','docdirect');?></strong></span>
						  <p><?php esc_attr_e('You can enable this to get emails whenever any user send you a message','docdirect');?></p>
						</div>
					</div>
				<?php }?>
			</div>	
		</div>
	</div>
</div>
<?php }