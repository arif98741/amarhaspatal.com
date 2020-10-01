<?php
/**
 * File Type: Appointments
 */
require DocDirectGlobalSettings::get_plugin_path() . 'libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
if( ! class_exists('TG_Appointments') ) {
	
	class TG_Appointments {
	
		public function __construct() {
			global $pagenow;
			add_action('init', array(&$this, 'init_appointment'));
			add_action( 'add_meta_boxes', array(&$this, 'tg_appointments_add_meta_box'), 10,1);
			add_filter('manage_docappointments_posts_columns', array(&$this, 'appointments_columns_add'));
			add_action('manage_docappointments_posts_custom_column', array(&$this, 'appointments_columns'),10, 2);	
			add_action( 'restrict_manage_posts', array(&$this, 'docdirect_download_appointments'));
			add_filter( 'parse_query', array(&$this, 'docdirect_download_appointments_filters') );
			
			add_action('wp_ajax_docdirect_download_pdf', array(&$this, 'docdirect_download_pdf'));
    		add_action('wp_ajax_nopriv_docdirect_download_pdf', array(&$this, 'docdirect_download_pdf'));
		}
		
		public function docdirect_download_appointments_filters($query){
			global $pagenow;
			$type = 'docappointments';
			
			if (isset($_GET['post_type'])) {
				$type = $_GET['post_type'];
			}
			
			if ( 'docappointments' == $type && is_admin() && $pagenow == 'edit.php' 
				&& ( ( isset($_GET['date']) && $_GET['date'] != '' ) 
					|| ( isset($_GET['month']) && $_GET['month'] != '' ) 
					|| ( isset($_GET['year']) && $_GET['year'] != '' )) 
			   ){
				
				$date								= !empty( $_GET['date'] ) ? $_GET['date'] : '';
				$date	= !empty( $_GET['date'] ) ? $_GET['date'] : '';
				$month	= !empty( $_GET['month'] ) ? $_GET['month'] : '';
				$year	= !empty( $_GET['year'] ) ? $_GET['year'] : '';
				
				$query->query_vars['meta_key'] 		= 'bk_timestamp';
				
				if( !empty($date) && !empty( $month ) && !empty( $year ) ){
					$date_start	= $year.'-'.$month.'-'.$date;
					$query->query_vars['meta_value'] 	= strtotime($date_start);
					$query->query_vars['meta_compare'] 		= '=';
				} else if( empty($date) && !empty( $month ) && !empty( $year ) ) {
					$date_start	= $year.'-'.$month.'-01';
					$last_day	= cal_days_in_month(CAL_GREGORIAN, $month, $year);
					$date_end	= $year.'-'.$month.'-'.$last_day;
					$query->query_vars['meta_value'] 	= array( strtotime($date_start),strtotime($date_end) );
					$query->query_vars['meta_compare'] 		= 'BETWEEN';
					
				} else if( empty($date) && empty( $month ) && !empty( $year )) {
					$date_start	= $year.'-01-01';
					$date_end	= $year.'-12-31';
					$query->query_vars['meta_value'] 	= array( strtotime($date_start),strtotime($date_end) );
					$query->query_vars['meta_compare'] 		= 'BETWEEN';
				}

			}
		}
		
		public function docdirect_download_pdf() {
			$json	= array();
			$date	= !empty( $_POST['date'] ) ? $_POST['date'] : '';
			$month	= !empty( $_POST['month'] ) ? $_POST['month'] : '';
			$year	= !empty( $_POST['year'] ) ? $_POST['year'] : '';
			$date_start	= '';
			if( !empty($date) && !empty( $month ) && !empty( $year ) ){
				$date_start	= $year.'-'.$month.'-'.$date;
				$name	= $date_start;
				$this->download_pdf($date_start,'',$name);
				$json['type']	= 'success';
				$json['url']	= get_template_directory_uri()."/images/appointments/appointments".".pdf";
				$json['file']	= $name;
				
			} else if( empty($date) && !empty( $month ) && !empty( $year ) ) {
				$date_start	= $year.'-'.$month.'-01';
				$last_day	= cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$date_end	= $year.'-'.$month.'-'.$last_day;
				$name		= $date_start.' '.esc_html__('To','workreap_core').' '.$date_end;
				$this->download_pdf($date_start,$date_end,$name);
				$json['type']	= 'success';
				$json['url']	= get_template_directory_uri()."/images/appointments/appointments".".pdf";
				$json['file']	= $name;
			} else if( empty($date) && empty( $month ) && !empty( $year )) {
				$date_start	= $year.'-01-01';
				$date_end	= $year.'-12-31';
				$name		= $year;
				$this->download_pdf($date_start,$date_end,$name);
				$json['type']	= 'success';
				$json['url']	= get_template_directory_uri()."/images/appointments/appointments".".pdf";
				$json['file']	= $name;
			}
			wp_send_json($json);
		}
		
		public function docdirect_download_appointments(){
			$type = 'docappointments';
			$date	= !empty( $_GET['date'] ) ? $_GET['date'] : '';
			$month	= !empty( $_GET['month'] ) ? $_GET['month'] : '';
			$year	= !empty( $_GET['year'] ) ? $_GET['year'] : '';
			
			if (isset($_GET['post_type'])) {
				$type = $_GET['post_type'];
			}
			
			$array_months	= array();
			if( function_exists('docdirect_get_month_array') ){
				$array_months	= docdirect_get_month_array();
			}
			
			//only add filter to post type you want
			if ('docappointments' === $type){
				
				echo '<select name="date" id="do-date">';
				echo '<option value="">'.esc_html__('Select Day','docdirect_core').'</option>';
				for (	$days=01;	$days<=31;	$days++	) {
					$days = sprintf("%02d", $days);
					printf
						(
							'<option value="%s"%s>%s</option>',
							$days,
							$days == $date? ' selected="selected"':'',
							$days
						);
					}
				echo '</select>';
				echo '<select name="month" id="do-month">';
				echo '<option value="">'.esc_html__('Select Month','docdirect_core').'</option>';
				
				foreach( $array_months as $k_m => $val_m ) {
					printf
						(
							'<option value="%s"%s>%s</option>',
							$k_m,
							$k_m == $month? ' selected="selected"':'',
							$val_m
						);
					}
				echo '</select>';
				
				echo '<select name="year" id="do-year">';
				echo '<option value="">'.esc_html__('Select year','docdirect_core').'</option>';
				for (	$years = date("Y"); $years >= 1970; $years--	) {
					
					printf
						(
							'<option value="%s"%s>%s</option>',
							$years,
							$years == $year? ' selected="selected"':'',
							$years
						);
					}
				echo '</select>';
				?>
				<input type="button" class="button" id="download-btn" value="<?php esc_attr_e('Download','docdirect_core');?>"/>
				<?php
			}
		}
		
		/**
		 * Download PDF
		 *
		 * @throws error
		 * @author Themographics <info@themographics.com>
		 * @return 
		 */
		public function download_pdf($date,$end_date='',$name) {
			global $wpdb;

			ob_clean();
			ob_flush();
			if( !empty( $date ) ){
				$pdf_html = '';
				$dompdf 	= new Dompdf();
				$pdf_html .= $this->renderheader($date,$name);
				$pdf_html .= $this->renderPdfHtml($date,$end_date);
				$pdf_html .= $this->renderFooter();
				$dompdf->set_option('isHtml5ParserEnabled', true);
				$dompdf->loadHtml($pdf_html);
				$dompdf->setPaper('A4', 'portrait');
				$dompdf->render();
				$output = $dompdf->output();
				file_put_contents(get_template_directory()."/images/appointments/appointments".".pdf", $output);
			}

		}
		/**
		 * Render table
		 *
		 * @throws error
		 * @author Themographics <info@themographics.com>
		 * @return 
		 */
		public function renderPdfHtml($date,$end_date){
			$html = '';
			$html .= '<main>
			<table style="width: 100%; margin: 150px auto 0;font-family: sans-serif;">';
				$html .= '<thead>
					<tr style="text-align: left; border-radius:5px 0 0;">
						<th style=" padding: 15px 20px;background: #f5f5f5; font-size:14px;">'.esc_html__('ID','docdirect_core').'</th>
						<th style="padding: 15px 20px;background: #f5f5f5; font-size:14px;">'.esc_html__('Category','docdirect_core').'</th>
						<th style="padding: 15px 20px;background: #f5f5f5; font-size:14px;">'.esc_html__('Service','docdirect_core').'</th>
						<th style="padding: 15px 20px;background: #f5f5f5; font-size:14px;">'.esc_html__('Date','docdirect_core').'</th>
						<th style="padding: 15px 20px;background: #f5f5f5; font-size:14px;">'.esc_html__('Details','docdirect_core').'</th>
					</tr>
				</thead>
				<tbody>';
			
			$counter	= 0;
			$meta_query_args	= array();
			
			if( empty( $end_date ) && !empty( $date ) ){
				$meta_query_args[] = array(
							'key'     	=> 'bk_timestamp',
							'value'   	=> 	strtotime($date),
							'compare'   => '=',
							'type'	  	=> 'NUMERIC'
						);
			} else if( !empty( $date ) && !empty( $end_date ) ){
				$meta_query_args[] = array(
							'key'     	=> 'bk_timestamp',
							'value'   	=> 	array(strtotime($date),strtotime($end_date)),
							'compare'   => 'BETWEEN',
							'type'	  	=> 'NUMERIC'
						);
			}
			
			$args 		= array( 'posts_per_page' => -1, 
							 'post_type' 	=> 'docappointments', 
							 'post_status'  => 'publish', 
							 'order'		=> 'DESC',
							 'orderby'		=> 'ID',
							);


			if( !empty( $meta_query_args ) ) {
				$query_relation = array('relation' => 'AND',);
				$meta_query_args	= array_merge( $query_relation,$meta_query_args );
				$args['meta_query'] = $meta_query_args;
			}

			$query 		= new WP_Query($args);
			$count_post = $query->found_posts;  
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
			
			if( $query->have_posts() ):
				 while($query->have_posts()) : $query->the_post();
					global $post;
					$bk_code          = get_post_meta($post->ID, 'bk_code',true);
					$bk_category      = get_post_meta($post->ID, 'bk_category',true);
					$bk_service       = get_post_meta($post->ID, 'bk_service',true);
					$bk_booking_date  = get_post_meta($post->ID, 'bk_booking_date',true);
					$bk_slottime 	  = get_post_meta($post->ID, 'bk_slottime',true);
					$bk_status        = get_post_meta($post->ID, 'bk_status',true);
					$bk_userphone 	  = get_post_meta($post->ID, 'bk_userphone',true);
					$bk_username      = get_post_meta($post->ID, 'bk_username',true);
					$bk_payment       = get_post_meta($post->ID, 'bk_payment',true);
					$bk_user_to       = get_post_meta($post->ID, 'bk_user_to',true);
					$bk_user_from     = get_post_meta($post->ID, 'bk_user_from',true);
					
					$services_cats 		= get_user_meta($bk_user_to , 'services_cats' , true);	
					$booking_services 	= get_user_meta($bk_user_to , 'booking_services' , true);
			
					$bk_user_from	= get_user_by( 'id', intval( $bk_user_from ) );
					$bk_user_to	  	= get_user_by( 'id', intval( $bk_user_to ) );
			
					$bk_currency 	  = get_post_meta($post->ID, 'bk_currency', true);
					$bk_paid_amount   = get_post_meta($post->ID, 'bk_paid_amount', true);
					$bk_transaction_status = get_post_meta($post->ID, 'bk_transaction_status', true);
					$bk_booking_note  = get_post_meta($post->ID, 'bk_booking_note',true);
			
					$time 		= explode('-',$bk_slottime);
					$bk_time	= date_i18n( $time_format,strtotime('2016-01-01 '.$time[0]) ).'&nbsp;-&nbsp;'.date_i18n( $time_format,strtotime('2016-01-01 '.$time[1]) );
					
					$status			= !empty( $bk_status ) ? '<span style="display: block;">'.esc_html__('Status','docdirect_core').': <em style="font-style: normal;">'.esc_attr( docdirect_prepare_order_status( 'value',$bk_status ) ).'</em></span>' : '';
					$phone			= !empty( $bk_userphone ) ? '<span style="display: block;">'.esc_html__('Phone','docdirect_core').': <em style="font-style: normal;">'.esc_attr( $bk_userphone ).'</em></span>' : '';
					$bk_payment		= !empty( $bk_payment ) ? '<span style="display: block;">'.esc_html__('Payment Type','docdirect_core').': <em style="font-style: normal;">'.esc_attr( docdirect_prepare_payment_type( 'value',$bk_payment ) ).'</em></span>' : '';
					$counter++;
					
					$user_name				= !empty( $bk_username ) ? '<span style="display: block;">'.esc_html__('User Name','docdirect_core').': <em style="font-style: normal;">'.esc_attr( $bk_user_from->data->display_name ).'</em></span>': '';
					$bk_booking_note		= !empty( $bk_booking_note ) ? '<span style="display: block;">'.esc_html__('Note','docdirect_core').': <em style="font-style: normal;">'.esc_attr( $bk_booking_note ).'</em></span>' : '';
					$doctor_name			= !empty( $bk_user_to ) ? '<span style="display: block;">'.esc_html__('Doctor Name','docdirect_core').': <em style="font-style: normal;">'.esc_attr( $bk_user_to->data->display_name ).'</em></span>': '';
					$payment_amount  		= !empty( $bk_paid_amount ) ? '<span style="display: block;">'.esc_html__('Fee','docdirect_core').': <em style="font-style: normal;">'.esc_attr( $bk_currency.$bk_paid_amount ).'</em></span>' : '';
				
					$bk_transaction_status  = !empty( $bk_transaction_status ) ? '<span style="display: block;">'.esc_html__('Payment Status','docdirect_core').': <em style="font-style: normal;">'.esc_attr( $bk_transaction_status ).'</em></span>' : '';
					$bk_category	= !empty( $services_cats[$bk_category] ) ?  esc_attr($services_cats[$bk_category]) : '';
					$bk_service		= !empty( $booking_services[$bk_service]['title'] ) ? esc_attr($booking_services[$bk_service]['title']) : '';
			
					$html .= '<tr>
							<td style="padding: 15px 20px; border-top: 1px solid #e2e2e2; font-size:14px;">'.$counter.'</td>
							<td style="padding: 15px 20px;border-top: 1px solid #e2e2e2; font-size:14px;">'.$bk_category.'</td>
							<td style="padding: 15px 20px;border-top: 1px solid #e2e2e2; font-size:14px;">'.$bk_service.'</td>
							<td style="padding: 15px 20px;border-top: 1px solid #e2e2e2; font-size:14px;">'.$bk_booking_date.'<br>'.$bk_time.'</td>
							<td style="padding: 15px 20px;border-top: 1px solid #e2e2e2;font-size:14px;">'.$user_name.$doctor_name.$phone.$status.$bk_payment.$bk_transaction_status.$payment_amount.$bk_booking_note.'</td>
						 </tr>';

				endwhile;
			endif;
			$html .= '</tbody></table></main>';

			return $html;
		}
		
		/**
		 * Render Footer
		 *
		 * @throws error
		 * @author Themographics <info@themographics.com>
		 * @return 
		 */
		public function renderFooter(){
			$html = '</body></html>';
			return $html;
		}
		/**
		 * Render header
		 *
		 * @throws error
		 * @author Themographics <info@themographics.com>
		 * @return 
		 */
		public function renderheader($date,$name){
			$border_image = get_template_directory() . '/images/border.jpg';
			$html = '<html>
			<head>
				<style>
					@page {
						margin: 10px 0px 50px 0px;
					}

					header {
						position: fixed;
						top: -20px;
						left: 0px;
						right: 0px;
						height: 50px;
						font-family: sans-serif;
						background: url('.$border_image.');
						background-size:1px;
						background-size: 100% 2px;
						background-repeat: no-repeat;
					}
		
					footer {
						position: fixed; 
						bottom: -60px; 
						left: 0px; 
						right: 0px;
						height: 30px; 
					}
				</style>
			</head>
			<body style="font-family: sans-serif;">
				<header>
				<div style="width:100%; display: inline-block; text-align:center; font-family: sans-serif;">
					<table style="width:96%; margin:80px auto 0;">
						<tr style="text-align:left;">
							<td width="70%">
								<h1 style="font-size: 26px;line-height: 26px;margin: 0 0 10px; font-weight: 500; color: #3d4461;">'.esc_html__('Appointments','docdirect_core').'</h1>
								<span style="font-size:16px;line-height: 20px;display: block; color: #3d4461;">'.esc_html__('Appointment history of the ','docdirect_core').' '.$name.'</span>
							</td>
						</tr>
					</table>
				</div>
				</header>
				<footer style="border-top: 1px solid #eee; text-align: center;margin-top: 80px;padding: 20px 0;">
					<span style="display: block;font-size: 16px;color: #3d4461;line-height: 20px;">
						'.esc_html__('This is a computer generated Appointments List','docdirect_core').'
					</span>
				</footer>';
			return $html;
		}
		/**
		 * @Init Post Type
		 * @return {post}
		 */
		public function init_appointment(){
			$this->prepare_post_type();
		}
		
		/**
		 * @Prepare Post Type
		 * @return {}
		 */
		public function prepare_post_type(){
			$labels = array(
				'name' 				 => esc_html__( 'Appointments', 'docdirect_core' ),
				'all_items'			 => esc_html__( 'Appointments', 'docdirect_core' ),
				'singular_name'      => esc_html__( 'Appointment', 'docdirect_core' ),
				'add_new'            => esc_html__( 'Add Appointment', 'docdirect_core' ),
				'add_new_item'       => esc_html__( 'Add New Appointment', 'docdirect_core' ),
				'edit'               => esc_html__( 'Edit', 'docdirect_core' ),
				'edit_item'          => esc_html__( 'Edit Appointment', 'docdirect_core' ),
				'new_item'           => esc_html__( 'New Appointment', 'docdirect_core' ),
				'view'               => esc_html__( 'View Appointment', 'docdirect_core' ),
				'view_item'          => esc_html__( 'View Appointment', 'docdirect_core' ),
				'search_items'       => esc_html__( 'Search Appointment', 'docdirect_core' ),
				'not_found'          => esc_html__( 'No Appointment found', 'docdirect_core' ),
				'not_found_in_trash' => esc_html__( 'No Appointment found in trash', 'docdirect_core' ),
				'parent'             => esc_html__( 'Parent Appointment', 'docdirect_core' ),
			);
			$args = array(
				'capabilities'       => array( 'create_posts' => false ), //Hide add New Button
				'labels'			  => $labels,
				'description'         => esc_html__( '', 'docdirect_core' ),
				'public'              => false,
				'supports'            => array( 'title'),
				'show_ui'             => true,
				'capability_type'     => 'post',
				'show_in_nav_menus'   => false, 
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
				'show_in_menu' => 'edit.php?post_type=directory_type',
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'menu_position' 	  => 10,
				'rewrite'			  => array('slug' => 'appointments', 'with_front' => true),
				'query_var'           => false,
				'has_archive'         => false,
			); 
			register_post_type( 'docappointments' , $args );
			  
		}
		
		/**
		 * @Prepare Columns
		 * @return {post}
		 */
		public function appointments_columns_add($columns) {
			unset($columns['date']);
			$columns['apt_from'] 			= esc_html__('Appointment From','docdirect_core');
			$columns['apt_to'] 		= esc_html__('Appointment To','docdirect_core');
			$columns['apt_contact'] 		= esc_html__('Contact Number','docdirect_core');
		 
  			return $columns;
		}
		
		/**
		 * @Get Columns
		 * @return {}
		 */
		public function appointments_columns($name) {
			global $post;
			
			$apt_from 		= '';
			$apt_to = '';
			$apt_contact	= '';
					
			if (function_exists('fw_get_db_settings_option')) {
				$apt_from 	   = fw_get_db_post_option($post->ID, 'bk_user_from', true);
				$apt_to   		= fw_get_db_post_option($post->ID, 'bk_user_to', true);
				$apt_contact 	= fw_get_db_post_option($post->ID, 'bk_userphone', true);
				$apt_from_user  = get_user_by( 'id', intval($apt_from) );
				$apt_to_user 	= get_user_by( 'id', intval($apt_to) );
			}
			
			switch ($name) {
				case 'apt_from':
					if( isset( $apt_from_user->data ) && !empty( $apt_from_user->data ) ){
						echo esc_attr( $apt_from_user->data->display_name );
					}
				break;
				case 'apt_to':
					if( isset( $apt_to_user->data ) && !empty( $apt_to_user->data ) ){
						echo esc_attr( $apt_to_user->data->display_name );
					}
				break;
				case 'apt_contact':
					echo ( $apt_contact );
				break;
				
			}
		}
		
		
		/**
		 * @Init Meta Boxes
		 * @return {post}
		 */
		public function tg_appointments_add_meta_box($post_type){
			if ($post_type == 'docappointments') {
				add_meta_box(
					'tg_appointments_info',
					esc_html__( 'Appointment Info', 'docdirect_core' ),
					array(&$this,'docdirect_meta_box_appointmentinfo'),
					'docappointments',
					'side',
					'high'
				);
				
			}
			
			if ( $post_type == 'docappointments' ) {
				add_meta_box(
					'tg_appointments_detail',
					esc_html__( 'Appointment Detail', 'docdirect_core' ),
					array(&$this,'docdirect_appointment_detail'),
					'docappointments',
					'normal',
					'high'
				);
			}
		}
		
		/**
		 * @Init Appointment detail
		 * @return {post}
		 */
		public function docdirect_appointment_detail(){
			global $post;
			
			if ( function_exists('fw_get_db_settings_option') 
				 &&
				 !empty( $post->ID ) 
				 && isset( $_GET['post'] ) 
				 && !empty( $_GET['post'] )
			) {
				
				$bk_payment_date = get_post_meta($post->ID, 'bk_payment_date', true);
				$bk_transaction_status = get_post_meta($post->ID, 'bk_transaction_status', true);
				$bk_paid_amount = get_post_meta($post->ID, 'bk_paid_amount', true);
				$bk_user_from = get_post_meta($post->ID, 'bk_user_from', true);
				$payment_status = get_post_meta($post->ID, 'payment_status', true);
				$bk_status = get_post_meta($post->ID, 'bk_status', true);
				$bk_timestamp = get_post_meta($post->ID, 'bk_timestamp', true);
				$bk_user_to = get_post_meta($post->ID, 'bk_user_to', true);
				$bk_payment = get_post_meta($post->ID, 'bk_payment', true);
				$bk_booking_note = get_post_meta($post->ID, 'bk_booking_note', true);
				$bk_useremail = get_post_meta($post->ID, 'bk_useremail', true);
				$bk_userphone = get_post_meta($post->ID, 'bk_userphone', true);
				$bk_username = get_post_meta($post->ID, 'bk_username', true);
				$bk_subject = get_post_meta($post->ID, 'bk_subject', true);
				$bk_slottime = get_post_meta($post->ID, 'bk_slottime', true);
				$bk_booking_date = get_post_meta($post->ID, 'bk_booking_date', true);
				$bk_currency = get_post_meta($post->ID, 'bk_currency', true);
				$bk_service = get_post_meta($post->ID, 'bk_service', true);
				$bk_category = get_post_meta($post->ID, 'bk_category', true);
				$bk_code = get_post_meta($post->ID, 'bk_code', true);
				$services_cats = get_user_meta($bk_user_to , 'services_cats' , true);
				$booking_services = get_user_meta($bk_user_to , 'booking_services' , true);
				

				$purchase_on	 = date('d M, y',strtotime( $bk_payment_date ));
				$bk_user_from	= get_user_by( 'id', intval( $bk_user_from ) );
				$bk_user_to	  = get_user_by( 'id', intval( $bk_user_to ) );
				$payment_amount  = $bk_currency.$bk_paid_amount;
				
				$bk_booking_date	 = date('d M, y',strtotime( $bk_booking_date ));

				$date_format = get_option('date_format');
				$time_format = get_option('time_format');
				$time = explode('-',$bk_slottime);
				
			} else{
				$bk_payment_date = esc_html__('NILL','docdirect_core');
				$bk_transaction_status = esc_html__('NILL','docdirect_core');
				$bk_paid_amount = esc_html__('NILL','docdirect_core');
				$bk_user_from = esc_html__('NILL','docdirect_core');
				$payment_status = esc_html__('NILL','docdirect_core');
				$bk_timestamp = esc_html__('NILL','docdirect_core');
				$bk_user_to = esc_html__('NILL','docdirect_core');
				$bk_booking_note = esc_html__('NILL','docdirect_core');
				$bk_useremail = esc_html__('NILL','docdirect_core');
				$bk_userphone = esc_html__('NILL','docdirect_core');
				$bk_username = esc_html__('NILL','docdirect_core');
				$bk_subject = esc_html__('NILL','docdirect_core');
				$bk_slottime = esc_html__('NILL','docdirect_core');
				$bk_booking_date = esc_html__('NILL','docdirect_core');
				$bk_currency	= esc_html__('NILL','docdirect_core');
				$bk_service	= '';
				$bk_category	= '';
				$bk_code	= '';
				$payment_amount  = esc_html__('NILL','docdirect_core');
				
			}
			?>
			<ul class="invoice-info">
				<li>
					<strong><?php esc_html_e('Tracking id','docdirect_core');?></strong>
					<span><?php echo esc_attr( $bk_code );?></span>
				</li>
				<li>
					<strong><?php esc_html_e('Appointment Date','docdirect_core');?></strong>
					<span><?php echo esc_attr( $bk_booking_date );?></span>
				</li>
			 	<?php if( !empty( $services_cats[$bk_category] ) ){?>
                    <li>
                        <strong><?php esc_html_e('Appointment Category','docdirect_core');?></strong>
                        <span><?php echo esc_attr( $services_cats[$bk_category] );?></span>
                    </li>
                <?php }?>
                <?php if( !empty( $booking_services[$bk_service] ) ){?>
                    <li>
                        <strong><?php esc_html_e('Appointment Service','docdirect_core');?></strong>
                        <span><?php echo esc_attr( $booking_services[$bk_service]['title'] );?></span>
                    </li>
                <?php }?>
                <li>
                    <strong><?php esc_html_e('Appointment Fee','docdirect_core');?></strong>
                    <span><?php echo esc_attr( $payment_amount );?></span>
                </li>
                <li>
					<strong><?php esc_html_e('Contact Number','docdirect_core');?></strong>
					<span><?php echo esc_attr( $bk_userphone );?></span>
				</li>
				<?php if( !empty( $bk_user_from->data ) ){?>
					<li>
						<strong><?php esc_html_e('User From','docdirect_core');?></strong>
						<span><a href="<?php echo get_edit_user_link($bk_user_from->data->ID);?>" target="_blank" title="<?php esc_html__('Click for user details','docdirect_core');?>"><?php echo esc_attr( $bk_user_from->data->display_name );?></a></span>
					</li>
				<?php }?>
                <?php if( !empty( $bk_user_to->data ) ){?>
					<li>
						<strong><?php esc_html_e('User To','docdirect_core');?></strong>
						<span><a href="<?php echo get_edit_user_link($bk_user_to->data->ID);?>" target="_blank" title="<?php esc_html__('Click for user details','docdirect_core');?>"><?php echo esc_attr( $bk_user_to->data->display_name );?></a></span>
					</li>
				<?php }?>
                <?php if( !empty( $bk_status ) ){?>
				<li>
					<strong><?php esc_html_e('Booking Status','docdirect_core');?></strong>
					<span><?php echo esc_attr( ucwords( $bk_status ) );?></span>
				</li>
                <?php }?>
                <?php if( !empty( $bk_transaction_status ) ){?>
				<li>
					<strong><?php esc_html_e('Payment Status','docdirect_core');?></strong>
					<span><?php echo esc_attr( docdirect_prepare_order_status( 'value',$bk_transaction_status ) );?></span>
				</li>
                <?php }?>
                <?php if( !empty( $bk_payment ) ){?>
				<li>
					<strong><?php esc_html_e('Payment Method','docdirect_core');?></strong>
					<span><?php echo esc_attr( docdirect_prepare_payment_type( 'value',$bk_payment ) );?></span>
				</li>
                <?php }?>
				<?php if( !empty( $time[0] ) && !empty( $time[1] ) ){?>
                <li>
					<strong><?php esc_html_e('Metting Time','docdirect_core');?></strong>
					<span><?php echo date_i18n($time_format,strtotime('2016-01-01 '.$time[0]) );?>&nbsp;-&nbsp;<?php echo date_i18n($time_format,strtotime('2016-01-01 '.$time[1]) );?></span>
				</li>
                <?php }?>
                <li>
					<strong><?php esc_html_e('Note','docdirect_core');?></strong>
					<span><?php echo esc_attr( $bk_booking_note );?></span>
				</li>
			</ul>
			<?php
		}
		
		/**
		 * @Init Appointment info
		 * @return {post}
		 */
		public function docdirect_meta_box_appointmentinfo(){
			global $post;
			
			if (function_exists('fw_get_db_settings_option')) {
				$bk_code = fw_get_db_post_option($post->ID, 'bk_code', true);
				$bk_code	= !empty( $bk_code ) ? $bk_code : esc_html__('NILL','docdirect_core');
			} else{
				$bk_code = esc_html__('NILL','docdirect_core');
			}
			
			?>
			<ul class="invoice-info side-panel-info">
				<li>
					<strong><?php esc_html_e('Booking Code','docdirect_core');?></strong>
					<span><?php echo esc_attr( $bk_code );?></span>
				</li>
			</ul>
			<?php
		}
		
		
	}
	
  	new TG_Appointments();	
}