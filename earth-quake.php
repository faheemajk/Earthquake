<?php

//encoding: utf-8
/*
  Plugin Name: Earth Quake
  Description:
  Version: 0.1
  Author: Faheem Aslam
  Author URI: faheemaslamawan@gmail.com
  Tags:
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'EARTHQUAKE_plugin_options_install');

// function to create the DB / Options / Defaults					
function EARTHQUAKE_plugin_options_install() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'earth_quake';
	$table_name_2 = $wpdb->prefix . 'earth_quake_file';
	$table_name_3 = $wpdb->prefix . 'earth_quake_catalogue';

	$sql = "CREATE TABLE $table_name (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		file_id VARCHAR(10) DEFAULT NULL,
		time_acc VARCHAR(100) DEFAULT NULL,
		acceleration VARCHAR(100) DEFAULT NULL,
		acceleration_g VARCHAR(100) DEFAULT NULL,
		time_velocity VARCHAR(100) DEFAULT NULL,
		velocity VARCHAR(100) DEFAULT NULL,
		time_displacement VARCHAR(100) DEFAULT NULL,
		displacement VARCHAR(100) DEFAULT NULL,
		frequency VARCHAR(100) DEFAULT NULL,
		period VARCHAR(100) DEFAULT NULL,
		fourier_amplitude VARCHAR(100) DEFAULT NULL,
		fourier_phase VARCHAR(100) DEFAULT NULL,
		power_amplitude VARCHAR(100) DEFAULT NULL,
		time_spectral_displacement VARCHAR(100) DEFAULT NULL,
		spectral_displacement VARCHAR(100) DEFAULT NULL,
		time_spectral_velocity VARCHAR(100) DEFAULT NULL,
		spectral_velocity VARCHAR(100) DEFAULT NULL,
		time_spectral_acceleration VARCHAR(100) DEFAULT NULL,
		spectral_acceleration VARCHAR(100) DEFAULT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	$sql2 = "CREATE TABLE $table_name_2 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		data_datetime DATETIME DEFAULT NULL,
		magnitude VARCHAR(100) DEFAULT NULL,
		latitide VARCHAR(100) DEFAULT NULL,
		longitude VARCHAR(100) DEFAULT NULL,
		depth VARCHAR(100) DEFAULT NULL,
		region VARCHAR(500) DEFAULT NULL,
		network VARCHAR(100) DEFAULT NULL,
		station VARCHAR(100) DEFAULT NULL,
		station_name VARCHAR(500) DEFAULT NULL,
		channel VARCHAR(100) DEFAULT NULL,
		location VARCHAR(100) DEFAULT NULL,
		loc_latitude VARCHAR(100) DEFAULT NULL,
		loc_longitude VARCHAR(100) DEFAULT NULL,
		scale VARCHAR(100) DEFAULT NULL,
		distance_deg VARCHAR(100) DEFAULT NULL,
		distance_km VARCHAR(100) DEFAULT NULL,
		file_name VARCHAR(500) DEFAULT NULL,
		gm_parameters text DEFAULT NULL,
		upload_datetime DATETIME DEFAULT NULL,
		publish VARCHAR(10) DEFAULT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

    $sql3 = "CREATE TABLE $table_name_3 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		longitude VARCHAR(100) DEFAULT NULL,
		latitude VARCHAR(100) DEFAULT NULL,
		year VARCHAR(100) DEFAULT NULL,
		month VARCHAR(100) DEFAULT NULL,
		day VARCHAR(500) DEFAULT NULL,
		magnitude VARCHAR(100) DEFAULT NULL,
		depth VARCHAR(100) DEFAULT NULL,
		hour VARCHAR(500) DEFAULT NULL,
		minute VARCHAR(100) DEFAULT NULL,
		UNIQUE KEY id (id)
  ) $charset_collate;";
  
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	dbDelta( $sql2 );
    dbDelta( $sql3 );
  
}

define('EARTHQUAKE_FOLDER', 'earth-quake');
if (!defined('QUOTEBOOKING_URL'))
    define('EARTHQUAKE_URL', WP_PLUGIN_URL . '/' . EARTHQUAKE_FOLDER);

// Define the basename
define('EARTHQUAKE_BASENAME', plugin_basename(__FILE__));

// Define the complete directory path
define('EARTHQUAKE_DIR', dirname(__FILE__));

global $EARTHQUAKE_shortcodes;
$EARTHQUAKE_shortcodes = array('quick_quote_collection');


// add_action( 'plugins_loaded', array( 'Page_Template_Plugin', 'get_instance' ) );
  
function EARTHQUAKE_display_init() {
	wp_enqueue_script('jquery-3',EARTHQUAKE_URL . '/js/jquery.min.js', false);
	wp_enqueue_script( 'bootstrap', EARTHQUAKE_URL . '/js/bootstrap.min.js', false );
  wp_enqueue_script('jquery-ui-datepicker');
    
  wp_enqueue_script('jquery-datatables','https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', false);
  wp_enqueue_script('jquery-datatables-1','https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js', false);
  wp_enqueue_script('jquery-datatables-2','https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js', false);
  wp_enqueue_script('jquery-datatables-3','https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js', false);
  wp_enqueue_script('jquery-datatables-4','https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js', false);

	wp_enqueue_script('custom', EARTHQUAKE_URL . '/js/custom.js', false);
  wp_localize_script( 'ajax-script', 'my_ajax_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );	
  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	wp_enqueue_style( 'bootstrap', EARTHQUAKE_URL . '/css/bootstrap.min.css', false );

  wp_enqueue_style('jquery-datatables-css', 'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css', false); 
  wp_enqueue_style('jquery-datatables-css-1', 'https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css', false);
  wp_enqueue_style('jquery-datatables-css-2', 'https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css', false);
  wp_enqueue_style('jquery-datatables-css-3', 'https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css', false);
  wp_enqueue_style('jquery-datatables-css-4', 'https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css', false);

	wp_enqueue_style('custom-style', EARTHQUAKE_URL . '/css/custom.css', false);

}

add_action('wp_enqueue_scripts', 'EARTHQUAKE_display_init');
add_action('admin_enqueue_scripts', 'EARTHQUAKE_display_init');



function sd_register_top_level_menu(){
	add_menu_page(
		'Earth Quake Plugin',
		'Earth Quake',
		'manage_options',
		'earthquakeupload',
		'sd_display_earth_quake_upload',
		'',
		6
	);
}
add_action( 'admin_menu', 'sd_register_top_level_menu' );

// add_action( 'admin_menu', 'sd_register_sub_menu' );
 
function sd_register_sub_menu() {
	add_submenu_page(
		'earthquakeupload',
		'View Data',
		'View',
		'manage_options',
		'earthquakeview',
		'sd_display_earth_quake_view'
	);
}

function sd_display_earth_quake_upload(){
	if(isset($_GET['delete'])){
		global $wpdb;
		$table_name_2 = $wpdb->prefix . 'earth_quake_file';
		$q = "update 
		$table_name_2
		 set publish = 0 
		  where id=".$_GET['delete'];
		//   echo $q; exit;

		$wpdb->query( $q );
	}
	$edit_data = '';
  if(isset($_GET['edit'])){
    global $wpdb;
		$table_name_2 = $wpdb->prefix . 'earth_quake_file';
		$q = "select * from  
		$table_name_2
		  where id=".$_GET['edit'];
		//   echo $q; exit;

    $edit_data = $wpdb->get_row( $q );
    // print_r($edit_data->latitide); exit;
  }
	require_once( EARTHQUAKE_DIR . '/postCode-form.php' );
}
function sd_display_earth_quake_view(){

	require_once( EARTHQUAKE_DIR . '/earth-quake-view.php' );
}

function my_handle_form_submit() {
	// echo $_REQUEST['data_datetime']; exit;
	global $wpdb;
	$table_name = $wpdb->prefix . 'earth_quake';
	$table_name_2 = $wpdb->prefix . 'earth_quake_file';
	$daTi = date('m-d-Y-His');
    // echo "<p>File upload function is now running!</p>";
    $uploadDirectory = plugin_dir_path( __FILE__ ) . "uploads/";
    // echo $uploadDirectory;
    $errors = []; // Store all foreseen and unforseen errors here
    $fileExtensions = ['csv']; // Get all the file extensions
    $fileName = $_FILES['fileToUpload']['name'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileTmpName  = $_FILES['fileToUpload']['tmp_name'];
    $fileType = $_FILES['fileToUpload']['type'];
	$fileExtension = strtolower(end(explode('.',$fileName)));
	$ff = explode('.',$fileName);
	$uploadPath = $uploadDirectory . $ff[0].'_'.$daTi.'.'.$fileExtension;
    // var_dump('aa = '.$fileName);
	// var_dump('bb = '.$uploadPath);
	// print_r($fileTmpName);
	// exit;
	// $fileTmpName = $fileTmpName.time().uniqid();
	  if(isset($_POST['edit_form_save'])){
    $q = "Update " . $table_name_2 . 
		 " SET 
		  data_datetime= '".trim_prim($_REQUEST['data_datetime'], 'date') ."',
		 magnitude= '".trim_prim($_REQUEST['magnitude']) ."',
		 latitide= '".trim_prim($_REQUEST['latitide']) ."',
		 longitude= '".trim_prim($_REQUEST['longitude']) ."',
		 depth= '".trim_prim($_REQUEST['depth'])."',
		 region= '".trim_prim($_REQUEST['region']) ."',
		 network= '".trim_prim($_REQUEST['network']) ."',
		 station= '".trim_prim($_REQUEST['station'])."',
		 station_name= '".trim_prim($_REQUEST['station_name']) ."',
		 channel= '".trim_prim($_REQUEST['channel']) ."',
		 location= '".trim_prim($_REQUEST['location']) ."',
		 loc_latitude= '".trim_prim($_REQUEST['loc_latitude']) ."',
		 loc_longitude= '".trim_prim($_REQUEST['loc_longitude']) ."',
		 scale= '".trim_prim($_REQUEST['scale'])  ."',
		 distance_deg= '".trim_prim($_REQUEST['distance_deg']) ."',
		 distance_km= '".trim_prim($_REQUEST['distance_km']) ."',
		 gm_parameters='".trim_prim($_REQUEST['gm_parameters']) ."',
		 event_overview='".trim_prim($_REQUEST['event_overview']) ."',
		 start_time='".trim_prim($_REQUEST['start_time']) ."',
		 end_time='".trim_prim($_REQUEST['end_time']) ."'
          where id=".$_POST['edit_form_save'];
         $wpdb->query( $q );
         wp_redirect( admin_url( '/admin.php?page=earthquakeupload' ) );
		exit;
  }
    if (isset($_POST['submit'])) {
		
        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = '<p>This file extension is not allowed. Please upload a CSV file</p>';
        }
        // if ($fileSize > 2000000) {
        //     $errors[] = '<p>This file is more than 2MB. Sorry, it has to be less than or equal to 2MB</p>';
		// }
		// print_r($errors); exit;
        if (empty($errors)) {
			$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
				$q = "INSERT INTO " . $table_name_2 . 
				 " SET 
				  data_datetime= '".trim_prim($_REQUEST['data_datetime'], 'date') ."',
				 magnitude= '".trim_prim($_REQUEST['magnitude']) ."',
				 latitide= '".trim_prim($_REQUEST['latitide']) ."',
				 longitude= '".trim_prim($_REQUEST['longitude']) ."',
				 depth= '".trim_prim($_REQUEST['depth'])."',
				 region= '".trim_prim($_REQUEST['region']) ."',
				 network= '".trim_prim($_REQUEST['network']) ."',
				 station= '".trim_prim($_REQUEST['station'])."',
				 station_name= '".trim_prim($_REQUEST['station_name']) ."',
				 channel= '".trim_prim($_REQUEST['channel']) ."',
				 location= '".trim_prim($_REQUEST['location']) ."',
				 loc_latitude= '".trim_prim($_REQUEST['loc_latitude']) ."',
				 loc_longitude= '".trim_prim($_REQUEST['loc_longitude']) ."',
				 scale= '".trim_prim($_REQUEST['scale'])  ."',
				 distance_deg= '".trim_prim($_REQUEST['distance_deg']) ."',
				 distance_km= '".trim_prim($_REQUEST['distance_km']) ."',
				 file_name='".$ff[0].'_'.$daTi.'.'.$fileExtension."',
				 gm_parameters='".trim_prim($_REQUEST['gm_parameters']) ."',
				 event_overview='".trim_prim($_REQUEST['event_overview']) ."',
				 start_time='".trim_prim($_REQUEST['start_time']) ."',
				 end_time='".trim_prim($_REQUEST['end_time']) ."',
				 upload_datetime='".date('Y-m-d H:i:s')."',
				 publish='1'
				 ";
				 $wpdb->query( $q );
				 $lastid = $wpdb->insert_id;


                $insert_q = "INSERT INTO $table_name (time_acc, acceleration, acceleration_g, time_velocity, velocity, time_displacement, displacement, frequency, period, fourier_amplitude, fourier_phase, power_amplitude, time_spectral_displacement, spectral_displacement, time_spectral_velocity, spectral_velocity, time_spectral_acceleration, spectral_acceleration, file_id) VALUES ";
                $q_app = '';
        				if (($handle = fopen($uploadPath, "r")) !== FALSE) {
        					fgetcsv($handle);   
        					$i =0;
        					while (($data = fgetcsv($handle)) !== FALSE) {
        						$num = count($data);
        						for ($c=0; $c < $num; $c++) {
                      $col[$c] = $data[$c];
                    }
                    $i++;
                    $q_app .= "('$col[0]', '$col[1]', '$col[2]', '$col[3]', '$col[4]', '$col[5]', '$col[6]', '$col[7]', '$col[8]', '$col[9]','$col[10]','$col[11]','$col[12]','$col[13]','$col[14]','$col[15]','$col[16]', '$col[17]', '$lastid'),";
                   
                  }
                  // echo $i;
                  $q_app = substr($q_app, 0, -1);
                  // echo $q_app; exit;
                  $query = $insert_q.$q_app;
                  // echo $query; exit;
                }
                
        
				// $query = 'LOAD DATA LOCAL INFILE "'.$uploadPath.'" 
				// INTO TABLE '.$table_name .'
				// FIELDS TERMINATED BY  \',\'
				// LINES TERMINATED BY \'\n\'
				// IGNORE 1 LINES
				// (time_acc, acceleration, acceleration_g, time_velocity, velocity, time_displacement, displacement, frequency, period, fourier_amplitude, fourier_phase, power_amplitude, time_spectral_displacement, spectral_displacement, time_spectral_velocity, spectral_velocity, time_spectral_acceleration, spectral_acceleration)
				// SET file_id = "'.$lastid.'"
				// ';
				// (spectral_acceleration, time_spectral_acceleration, spectral_velocity, time_spectral_velocity, spectral_displacement, time_spectral_displacement, power_amplitude, fourier_phase, fourier_amplitude, period, frequency, displacement, time_displacement, velocity, time_velocity, acceleration_g, acceleration, time_acc)

				// echo $query;
				// die();
				//  $query = "INSERT INTO " . $table_name . 
				//  " SET 
				//  time_acc='".num_to_float($col[0])."',
				//  acceleration='".num_to_float($col[1])."',
				//  acceleration_g='".num_to_float($col[2])."',
				//  time_velocity='".num_to_float($col[3])."',
				//  velocity='".num_to_float($col[4])."',
				//  time_displacement='".num_to_float($col[5])."',
				//  displacement='".num_to_float($col[6])."',
				//  frequency='".num_to_float($col[7])."',
				//  period='".num_to_float($col[8])."',
				//  fourier_amplitude='".num_to_float($col[9])."',
				//  fourier_phase='".num_to_float($col[10])."',
				//  power_amplitude='".num_to_float($col[11])."',
				//  time_spectral_displacement='".num_to_float($col[12])."',
				//  spectral_displacement='".num_to_float($col[13])."',
				//  time_spectral_velocity='".num_to_float($col[14])."',
				//  spectral_velocity='".num_to_float($col[15])."',
				//  time_spectral_acceleration='".num_to_float($col[16])."',
				//  spectral_acceleration='".num_to_float($col[17])."',
				//  file_id='".$lastid."'
				//  ";
				//  $i++;
				//  if($i == 3){
				// 	// echo $query; exit;
				//  }

				 $results = $wpdb->query( $query );
				// }
				// fclose($handle);
				
			//  }
			 	wp_redirect( admin_url( '/admin.php?page=earthquakeupload' ) );
        		exit;
            } else {
                echo '<p>An error occurred somewhere. Try again or contact the admin</p>';
            }
        } else {
            foreach ($errors as $error) {
                echo $error . '<p>These are the errors' . '\n' . '</p>';
            }
        }
	}
	
	// $csv_file = CSV_PATH . "inventory.csv"; 

    // var_dump($uploadPath);
	
  		// echo "<h2>The inventory was successfully imported to the database!</h2>";   


    // return;

}

add_action( 'admin_post_nopriv_my_simple_form', 'my_handle_form_submit' );
add_action( 'admin_post_my_simple_form', 'my_handle_form_submit' );

add_action( 'wp_ajax_nopriv_my_front_simple_form', 'my_front_map_data' );
add_action( 'wp_ajax_my_front_simple_form', 'my_front_map_data' );

add_action( 'wp_ajax_nopriv_data-serial', 'my_front_graph_data' );
add_action( 'wp_ajax_data-serial', 'my_front_graph_data' );


$param_1 = $_GET['param_1'];
$param_2 = $_GET['param_2'];

if(isset($param_1) && isset($param_2)){

	global $wpdb;
	$table_name = $wpdb->prefix . 'earth_quake';
	// echo "SELECT ".$_REQUEST['param_1'].",".$_REQUEST['param_2']." FROM ".$table_name. " where file_id=".$_REQUEST['file_id'];
	$result = $wpdb->get_results ( "SELECT ".$_GET['param_1'].",".$_GET['param_2']." FROM ".$table_name. " where file_id=".$_GET['data'] );



		$delimiter = ",";
// 		$filename = "data_" . date('Y-m-d') . ".csv";
		
		//create a file pointer
		$f = fopen('php://memory', 'w');
		
		//set column headers
		$fields = array($_GET['param_1'], $_GET['param_2']);
		fputcsv($f, $fields, $delimiter);
		
		//output each row of the data, format line as csv and write to file pointer
		$param_1 = $_GET['param_1'];
		$param_2 = $_GET['param_2'];
			foreach ( $result as $print ){
				// echo $print->$ss; exit;
				$lineData = array($print->$param_1, $print->$param_2);
				fputcsv($f, $lineData, $delimiter);

			}
		
		//move back to beginning of file
		fseek($f, 0);
		$filename = substr($_GET['file'], 0, -21) . $param_1.'_'.$param_2. ".csv";
		//set headers to download file rather than displayed
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		
		//output all remaining data on a file pointer
		fpassthru($f);
	exit;

}

function my_front_map_data(){
	global $wpdb;
    $table_name_2 = $wpdb->prefix . 'earth_quake_file';
	$result = $wpdb->get_results ( "SELECT * FROM ".$table_name_2. " where publish=1 order by latitide,longitude" );
	$json = [
		"type"=> "FeatureCollection",
		"features" => []
	];
	
	foreach ( $result as $print ){
		$data = array(
			"type" => "Feature",
			"id"=> $print->id,
				"properties"=> array(
					"NAME" => $print->region, 
					"mag"=> $print->magnitude,
                    "depth"=> $print->depth,
                    "date"=> $print->data_datetime,	
                    "station"=> $print->station,
                    "station_name"=> $print->station_name,
                    "channel"=> $print->channel,
                    "location"=> $print->location,
                    "loc_latitude"=> $print->loc_latitude,
                    "loc_longitude"=> $print->loc_longitude,
					"id"=> $print->id,
				),
				"geometry"=> array(
					"type"=> "Point", 
					"coordinates" => [ $print->longitude, $print->latitide ] 
				)
	
		);
		array_push($json['features'],	$data);
	}
	wp_send_json_success($json);
}

function my_front_graph_data(){
	// echo $_REQUEST['file_id']; exit;
	global $wpdb;
    $table_name = $wpdb->prefix . 'earth_quake';
	if($_REQUEST['starting_val'] != ''){
      $result = $wpdb->get_results ( "SELECT * FROM ".$table_name. " where file_id=".$_REQUEST['file_id']." limit ".$_REQUEST['starting_val'].", 7000" );
    }else{
      $result = $wpdb->get_results ( "SELECT * FROM ".$table_name. " where file_id=".$_REQUEST['file_id'] );
    }
	$graph_1 = [];
	$graph_2 = [];
	$graph_3 = [];
	$graph_4 = [];
	$graph_5 = [];
	$graph_6 = [];
	$graph_7 = [];
	$graph_8 = [];
	$graph_9 = [];
	foreach ( $result as $print ){
		if($print->time_acc != '' && $print->acceleration != ''){
			$graph_1[] = array(
						"year" => $print->time_acc, 
						"value"=> $print->acceleration
			);
		}

		if($print->time_velocity != '' && $print->velocity != ''){
			$graph_2[] = array(
						"year" => $print->time_velocity, 
						"value"=> $print->velocity
			);
		}

		if($print->time_displacement != '' && $print->displacement != ''){
			$graph_3[] = array(
						"year" => $print->time_displacement, 
						"value"=> $print->displacement
			);
		}

		if($print->time_spectral_velocity != '' && $print->spectral_velocity != ''){
			$graph_4[] = array(
						"year" => $print->time_spectral_velocity, 
						"value"=> $print->spectral_velocity
			);
		}

		if($print->frequency != '' && $print->fourier_amplitude != ''){
			$graph_5[] = array(
						"year" => $print->frequency, 
						"value"=> $print->fourier_amplitude
			);
		}

		if($print->frequency != '' && $print->power_amplitude != ''){
			$graph_6[] = array(
						"year" => $print->frequency, 
						"value"=> $print->power_amplitude
			);
		}

		if($print->spectral_displacement != '' && $print->time_spectral_displacement != ''){
			$graph_7[] = array(
						"year" => $print->time_spectral_displacement, 
						"value"=> $print->spectral_displacement
			);
		}

		if($print->time_spectral_acceleration != '' && $print->spectral_acceleration != ''){
			$graph_8[] = array(
						"year" => $print->time_spectral_acceleration, 
						"value"=> $print->spectral_acceleration
			);
		}

		if($print->time_acc != '' && $print->acceleration_g != ''){
			$graph_9[] = array(
						"year" => $print->time_acc, 
						"value"=> $print->acceleration_g
			);
		}
		// array_push($json['features'],	$data);
	}
	$return = array('graph_1' => $graph_1, 'graph_2' => $graph_2, 'graph_3' => $graph_3, 'graph_4' => $graph_4, 'graph_5' => $graph_5, 'graph_6' => $graph_6, 'graph_7' => $graph_7, 'graph_8' => $graph_8, 'graph_9' => $graph_9);
	wp_send_json_success($return);
}

function trim_prim($param = '', $date = ''){
	$param = (trim($param) != '') ? trim($param) : NULL ;
	if($date == 'date'){
		$myTime = strtotime($param); 
		return date("Y-m-d H:i:s", $myTime);
	}else{
		return $param;
	}
}
function num_to_float($param){
	$param = trim($param);
	return $param;
	// return (float)$param;
}


function form_creation_map(){
	?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
   <script src="<?=plugins_url( 'earth-quake/js/leaflet-svg-shape-markers.min.js' )?>"></script>
   <!-- <script src='http://structurespro.info/wp-content/plugins/earth-quake/js/jquery.min.js?ver=5.3.2'></script> -->
   <style>
      #mapid { 
        height: 580px; 
      
      }
      @media only screen and (max-width: 7280px) and (min-width: 769px)  {
          .kab-tab{
            position: absolute;
            margin-left: 0px;
            left: 20%;
            z-index: 99999;
          }
          .mr-lfft{
              margin-left: 5px;
              padding-left: 10px;
          }
      }
    </style>
	<!-- <section id="primary" class="content-area"> -->
  <div class="row">
    <div class="col-md-12">
		<main id="main" class="site-main">
        <p style="text-align: center;font-size:18px;font-family: Arial">Magnitude  4 - 5  <span style='font-size:35px;color:orange;'>&#9679;</span> : Magnitude  5 - 6  <span style='font-size:35px;color:green;'>&#9679;</span> :  Magnitude  6 - 7  <span style='font-size:35px;color:blue;'>&#9679;</span> : Magnitude ≥ 7.0 <span style='font-size:35px;color:red;'>&#9679;</span> :&#160; Station <span style='font-size:24px;color:dodgerblue;'>&#9650;</span></p>
        <div id="mapid"></div>


    </main><!-- .site-main -->
    </div>
  </div>
  <!--  </section> -->
  <!-- .content-area -->
 
  <div class="row">
    <div class="col-md-12">
    <table border="0" cellspacing="5" cellpadding="5" style="margin: 0 auto;text-align: center;font-size:20px;font-family: Arial" class="kab-tab">
      <tbody>
        <tr>
            <td>Minimum Magnitude:</td>
            <td><input class="mr-lfft" type="text"  id="min" name="min"></td>
            <td class="mr-lfft">Maximum Magnitude:</td>
            <td><input class="mr-lfft" type="text"  id="max" name="max"></td>
        </tr>
      </tbody>
     
    </table>
    <table  class="table  table-map-rec display responsive nowrap  w-auto " style="font-size:20px;font-family: Arial ">
    <thead>
    <tr>
        <th>Date & Time (UTC)</th>
        <th>Magnitude</th>
        <th>Latitide</th>
        <th>Longitude</th>
        <th>Depth (km)</th>
        <th>Region</th>
        <th>View</th>
    </tr>
    </thead>
        <tbody>
            
<?php
    global $wpdb;
    $table_name_2 = $wpdb->prefix . 'earth_quake_file';
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name_2. " where publish=1 GROUP BY data_datetime,latitide,longitude" );
    foreach ( $result as $print )   {
    ?>
    

    <tr>
        <td><?= $print->data_datetime ?></td>
        <td><?= $print->magnitude ?></td>
        <td><?= $print->latitide ?></td>
        <td><?= $print->longitude ?></td>
        <td><?= $print->depth ?></td>
        <td><?= $print->region ?></td>
        <td>
            <button class="btn btn-xs"onclick="openMarker('<?= $print->latitide ?>', '<?= $print->longitude ?>')">Open</button>
        </td>
    </tr>
        
<?php }
  
  
  ?>
      </tbody>

    </table>
    </div>
  </div>
    <script>

      const map = L.map('mapid').setView([33.738045, 73.084488], 5);

      // layers starts

      // load a tile layer
      var osm=new L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{ 
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'});
	// https: also suppported.
	var Esri_WorldGrayCanvas = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ',
		maxZoom: 16
	}).addTo(map);
	
  var OpenStreetMap_BlackAndWhite = L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
	maxZoom: 18,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	});
	// https: also suppported.
	var Stamen_TopOSMFeatures = L.tileLayer('http://stamen-tiles-{s}.a.ssl.fastly.net/toposm-features/{z}/{x}/{y}.{ext}', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 20,
		ext: 'png',
		bounds: [[22, -132], [51, -56]],
		opacity: 0.9
	});

	// https: also suppported.
	var Esri_WorldImagery = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
	});

  // var blue = L.layerGroup([
  //       Esri_WorldGrayCanvas,
	// 	Stamen_TopOSMFeatures
	// 	]); 
  

var normal =  L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
          attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012',
          maxZoom: 18,
        }).addTo(map);
        

// Layers Ends
		console.log('i am eee');
var baseMaps = {
      "Open Street Map": osm,
      "Imagery":Esri_WorldImagery,
      "Gray":Esri_WorldGrayCanvas,
      // "Blue Base":blue,
      "OSM B&W":OpenStreetMap_BlackAndWhite,
      "normal": normal
    };
	
//Add layer control
L.control.layers(baseMaps).addTo(map);


      let markersArray = {}; // create the associative array
      // load GeoJSON from an external file

  jQuery.ajax(
    {
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
            action: 'my_front_simple_form'
        },
        success: function(data){
            data = data.data;
            console.log(data);
            var counter = 0;
            var old_lat = '';
            var old_lng = '';
            var value = '';
            var dl_i=1;
            L.geoJson(data, {
			
            // add GeoJSON layer to the map once the file is loaded
        
            pointToLayer: function(feature, latlng) {
              const mag = feature.properties.mag; // magnitude
              const geojsonMarkerOptions = {
                opacity: 0.8,
                fillOpacity: 0.6,
                // here define the style using ternary operators for circles
                weight: mag >= 7.0 ? '.2' : mag >= 6.0 ? '.1' : mag >= 5.0 ? '.05': mag >= 4.0 ? '1' : '.01',
               color: mag >= 7.0 ? 'red' : mag >= 6.0 ? 'blue' : mag >= 5.0 ? 'green': mag >= 4.0 ? 'orange' : 'black'
              };
              console.log(feature.properties.mag);
              if(counter > 0){
                if(old_lat == feature.geometry.coordinates[0] && old_lng == feature.geometry.coordinates[1]){
                  old_lat = feature.geometry.coordinates[0];
                  old_lng = feature.geometry.coordinates[1];
                  console.log('appearing again');
                  value = value + `
                    <b>Station:</b>&nbsp; ${feature.properties.station}<br>
                    <b>Channel:</b>&nbsp; ${feature.properties.channel}<br>
                    <b>Location:</b>&nbsp; ${feature.properties.location}<br>
                    <a target="_blank" href="/graphs?data=${feature.properties.id}">View</a><br>`;
                  counter = counter + 1;
                }else{
                  old_lat = feature.geometry.coordinates[0];
                  old_lng = feature.geometry.coordinates[1];
                  value = `
                    <b>Magnitude:</b>&nbsp; ${feature.properties.mag} <br>
                    <b>Region:</b>&nbsp; ${feature.properties.NAME}<br>
                    <b>Depth (km):</b>&nbsp; ${feature.properties.depth}<br>
                    <b>Date & Time (UTC):</b>&nbsp; ${feature.properties.date}<br> 
                    <b>Station:</b>&nbsp; ${feature.properties.station}<br>
                    <b>Channel:</b>&nbsp; ${feature.properties.channel}<br>
                    <b>Location:</b>&nbsp; ${feature.properties.location}<br>
                    <a target="_blank" href="/graphs?data=${feature.properties.id}">View</a><br>`;
                    counter = counter + 1;
                }
              }else{
                old_lat = feature.geometry.coordinates[0];
                old_lng = feature.geometry.coordinates[1];
                value = `
                    <b>Magnitude:</b>&nbsp; ${feature.properties.mag} <br>
                    <b>Region:</b>&nbsp; ${feature.properties.NAME}<br>
                    <b>Depth (km):</b>&nbsp; ${feature.properties.depth}<br>
                    <b>Date & Time (UTC):</b>&nbsp; ${feature.properties.date}<br> 
                    <b>Station:</b>&nbsp; ${feature.properties.station}<br>
                    <b>Channel:</b>&nbsp; ${feature.properties.channel}<br>
                    <b>Location:</b>&nbsp; ${feature.properties.location}<br>
                    <a target="_blank" href="/graphs?data=${feature.properties.id}">View</a><br>`;
                counter = counter + 1;
              }

// console.log(feature.geometry.coordinates[0]);
              markersArray[dl_i] = L.circleMarker(latlng, geojsonMarkerOptions)
                .addTo(map)
                .bindPopup(value, {
                closeButton: true,
                offset: L.point(0, -20)
              });
              dl_i++;
              // here record the mags
            //   return L.circleMarker(latlng, geojsonMarkerOptions);
              if(feature.properties.loc_latitude != ''){
                var foo = {};
                foo['lat'] = parseFloat(feature.properties.loc_latitude);
                foo['lng'] = parseFloat(feature.properties.loc_longitude);
                console.log(foo);

                const triangle_marker = {
                    fill: true,
                	fillColor: "#4390ff",
                	fillOpacity: 1.0,
                  color: "#4390ff",
                  shape: "triangle-up",
                  radius: 6
                };

                L.shapeMarker(foo, triangle_marker)
                  .addTo(map)
                  .bindPopup(`<b>Station:</b> ${feature.properties.station} <br>
                  <b>Station name:</b> ${feature.properties.station_name} <br>
                    <b>Latitude:</b> ${feature.properties.loc_latitude}<br>
                    <b>Longitude:</b> ${feature.properties.loc_longitude}<br>
                    <a href="https://ida.ucsd.edu">More details</a><br><br>`, {
                closeButton: true,
                offset: L.point(0, -20)
              });
                return L.shapeMarker(foo, triangle_marker);
              }
            },
          });
          jQuery('.leaflet-control-attribution').hide();
            
        }
        
    });

    function openMarker(lat, lng){
        console.log(lat+'='+lng);
        console.log(markersArray);
      markersArray[1].openPopup();
      var i=1;
      for(var k in markersArray) {
          console.log('inside exe');
          if(markersArray[i]._latlng.lat == lat && markersArray[i]._latlng.lng == lng){
          markersArray[i].openPopup();
          $(window).scrollTop({ top: 0, behavior: 'smooth' });
          return false;
        }
      i++;
      }
    }
    jQuery(document).ready(function() {
      var table = jQuery('.table-map-rec').DataTable();
      jQuery('#min, #max').keyup( function() {
        table.draw();
    } );
    } );

    jQuery.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = parseFloat( $('#min').val(), 10 );
        var max = parseFloat( $('#max').val(), 10 );
        var age = parseFloat( data[1] ) || 0; // use data for the age column
 
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
        return false;
    }
);
    </script>
	<?php
	}
	add_shortcode('mapData', 'form_creation_map');
	add_shortcode('graphData', 'form_creation_graph');
function form_creation_graph(){
	
    global $wpdb;
    $id = $_GET['data'];
    $earth_quake_file = $wpdb->prefix . 'earth_quake_file';
    $roww = $wpdb->get_row ( "SELECT * FROM ".$earth_quake_file. " where id=".$id );  
    
   
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
		    
      <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-3">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Date & Time (UTC): <?= $roww->data_datetime; ?></h2>
        </div>
        <div class="col-md-2">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Magnitude: <?= $roww->magnitude; ?></h2>
        </div>
        <div class="col-md-2">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Latitide: <?= $roww->latitide; ?></h2>
        </div>
        <div class="col-md-2">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Longitude: <?= $roww->longitude; ?></h2>
        </div>
        <div class="col-md-1">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold' >Depth (km): <?= $roww->depth; ?></h2>
        </div>
        <div class="col-md-2">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Region: <?= $roww->region; ?></h2>
        </div>
      </div>
      
      <div class="row" style="margin-bottom: 50px;">
        <div class="col-md-3">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'> Station: <?= $roww->station; ?></h2>
        </div>
        <div class="col-md-2">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Channel: <?= $roww->channel; ?></h2>
        </div>
        <div class="col-md-2">
          <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Location: <?= $roww->location; ?></h2>
        </div>
        <div class="col-md-2">
          <?php
          if($roww->start_time){
              ?>
            <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>Start Time: <?= $roww->start_time; ?></h2>
        <?php
          }
          ?>
        </div>
        <div class="col-md-1">
        <?php
          if($roww->end_time){
              ?>
            <h2 style='font-size:15px;font-family: Arial;font-weight:bold'>End Time: <?= $roww->end_time; ?></h2>
        <?php
          }
          ?>
        </div>
        <div class="col-md-2">
          
        </div>
      </div>
      
      <div class="row">

    <div class="col-xs-12 col-md-2">
      <ul class="nav nav-tabs tabs-left">
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph11">Event Overview</a></li>
        <li style='font-size:18px;font-weight:bold'class="active"><a data-toggle="tab" href="#graph1">Acceleration (m/s&sup2;)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph9">Acceleration (g)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph2">Velocity (m/s)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph3">Displacement (cm)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph8">Acceleration Spectrum (m/s&sup2;)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph4">Velocity Spectrum (m/s)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph7">Displacement Spectrum (cm)</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph5">Fourier Spectrum</a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph6">Power Spectrum </a></li>
        <li style='font-size:18px;font-weight:bold'><a data-toggle="tab" href="#graph10">Ground Motion Parameters</a></li>
      </ul>
    </div>

    <div class="col-xs-12 col-md-10">
        <?php
      
       // Dev Faheem: Code for drop down starts
    $table_name_for_count = $wpdb->prefix . 'earth_quake';
    $count = $wpdb->get_var ( "SELECT count(*) FROM ".$table_name_for_count. " where file_id=".$id );
    // echo $count; 
    // exit;
    
    // echo $total_entries;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_components = parse_url($actual_link); 
    parse_str($url_components['query'], $params); 

  

    // Dev Faheem: Code for drop down ends
    
      ?>
      <div class="tab-content">
        <div id="graph1" class="tab-pane fade in active" >
          <h2>Acceleration
           <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_acc&amp;param_2=acceleration&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b> </a>
          </h2>
          <div id="chartdiv_1" class="amcharts-hid"></div>
        </div>
        <div id="graph2" class="tab-pane fade">
          <h2>Velocity
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_velocity&amp;param_2=velocity&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_2" class="amcharts-hid"></div>
        </div>
        <div id="graph3" class="tab-pane fade">
          <h2>Displacement
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_displacement&amp;param_2=displacement&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_3" class="amcharts-hid"></div>
        </div>
        <div id="graph4" class="tab-pane fade in">
          <h2>Velocity Spectrum
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_spectral_velocity&amp;param_2=spectral_velocity&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_4" class="amcharts-hid"></div>
        </div>
        <div id="graph5" class="tab-pane fade">
          <h2>Fourier Spectrum
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=frequency&amp;param_2=fourier_amplitude&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_5" class="amcharts-hid"></div>
        </div>
        <div id="graph6" class="tab-pane fade">
          <h2>Power Spectrum
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=frequency&amp;param_2=power_amplitude&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_6" class="amcharts-hid"></div>
        </div>
        <div id="graph7" class="tab-pane fade in">
          <h2>Displacement Spectrum
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_spectral_displacement&amp;param_2=spectral_displacement&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_7" class="amcharts-hid"></div>
        </div>
        <div id="graph8" class="tab-pane fade">
          <h2>Acceleration Spectrum
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_spectral_acceleration&amp;param_2=spectral_acceleration&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_8" class="amcharts-hid"></div>
        </div>
        <div id="graph9" class="tab-pane fade">
          <h2>Acceleration
            <a href="/graphs/&#63;data=<?=$id?>&amp;param_1=time_acc&amp;param_2=acceleration_g&amp;file=<?= $roww->file_name ?>"> <b><button class="button button1"><i class="fa fa-download"></i>  Export To CSV</button></b></a>
          </h2>
          <div id="chartdiv_9" class="amcharts-hid"></div>
        </div>
        <div id="graph10" class="tab-pane fade">
          <h2>Ground Motion Parameters</h2>
          <p>
            <?= $roww->gm_parameters; ?>
          </p>
        </div>  
        <div id="graph11" class="tab-pane fade ">
          <h2>Event Overview</h2>
          <p>
            <?= $roww->event_overview; ?>
          </p>
        </div> 
      </div>
    </div>

      </div>
<style>
  #chartdiv_1, #chartdiv_2, #chartdiv_3, #chartdiv_4, #chartdiv_5, #chartdiv_6, #chartdiv_7, #chartdiv_8, #chartdiv_9 {
    width: 100%;
    height: 500px;
    max-width: 100%;
  }
  .amcharts-chart-div a {
    display:none !important;
  }
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  border-radius:30px;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #008CBA;
}

.button1:hover {
  background-color: #008CBA;
  color: white;
}
</style>



		</main><!-- .site-main -->
  </section><!-- .content-area -->
  <script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script>
var global_data = '';
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href") // activated tab
  var lastChar = target.substr(target.length - 1);
  console.log(global_data.graph_2);
  if(lastChar == '1'){
    var one = 'Time (sec)';
    var two = 'Acceleration (m/s\xB2)';

    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_1; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '2'){
    var one = 'Time (sec)';
    var two = 'Velocity (m/s)';

    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_2; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '3'){
    var one = 'Time (sec)';
    var two = 'Displacement (cm)';

    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_3; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '4'){
    var one = 'Period (sec)';
    var two = 'Response Velocity (m/s)';

    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_4; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '5'){
    var one = 'Frequency (Hz)';
    var two = 'Fourier Amplitude';
    
    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_5; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '6'){
    var one = 'Frequency (Hz)';
    var two = 'Power Amplitude';
    
    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_6; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '7'){
    var one = 'Period (sec)';
    var two = 'Response Displacement (cm)';
    
    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_7; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '8'){
    var one = 'Period (sec)';
    var two = 'Response Acceleration (m/s\xB2)';
    
    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_8; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }else if(lastChar == '9'){
    var one = 'Time (sec)';
    var two = 'Acceleration (g)';
    
    var values = remainingCodeHeader(lastChar);
    var am4core = values['am4core'];
    var chart = values['chart'];
    var data = values['data'];
    data = global_data.graph_9; 
    remainingCodeFooter(data, chart, am4core, one , two); 

  }

});

am4core.ready(function() {

$.ajax({  
       type: 'get',
       dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
            action: 'data-serial',
            file_id: "<?= $id ?>",
            starting_val: "<?= $starting_val ?>"
        },
       success: function (success) { 
         console.log(success.data.graph_1);
        //  return false;
        global_data = success.data;
         data = success.data.graph_1;


         var values = remainingCodeHeader('1');
        var am4core = values['am4core'];
        var chart = values['chart'];
        var data = values['data'];

        data = success.data.graph_1;
         remainingCodeFooter(data, chart, am4core, 'Time (sec)' , 'Acceleration (m/s\xB2)');

       }   
   });

// $('.amcharts-hid title').hide();
}); // end am4core.ready()


function remainingCodeHeader(divNum){

  am4core.useTheme(am4themes_animated);
// Themes end
am4core.options.minPolylineStep = 5;
var chart = am4core.create("chartdiv_"+divNum, am4charts.XYChart);
chart.paddingRight = 20;

var data = [];

return {
  am4core: am4core,
  chart: chart,
  data: data,
  };

}
function remainingCodeFooter(data='', chart='', am4core='', xParameter='', yParameter){
  chart.data = data;

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.title.text = xParameter;
categoryAxis.dataFields.category = "year";

if(yParameter == 'Power Amplitude' || yParameter == 'Fourier Amplitude'){
    // categoryAxis.logarithmic = true;
  categoryAxis.renderer.minGridDistance = 150;
}else{
  categoryAxis.renderer.minGridDistance = 50;
}

categoryAxis.renderer.grid.template.location = 0.5;
categoryAxis.startLocation = 0.5;
categoryAxis.endLocation = 0.5;
// categoryAxis.renderer.labels.template.disabled = true;

// Create value axis
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.baseValue = 0;

valueAxis.title.text = yParameter;
valueAxis.extraMin = -0.0000001;
valueAxis.extraMax = 0.0000001;

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.categoryX = "year";
series.strokeWidth = 2;
series.tensionX = 0.77;

series.minBulletDistance = 5000;
series.groupData=true;
series.groupCount = 5000;

valueAxis.minBulletDistance = 5000;
valueAxis.groupData=true;
valueAxis.groupCount = 5000;


// bullet is added because we add tooltip to a bullet for it to change color
var bullet = series.bullets.push(new am4charts.Bullet());
bullet.tooltipText = "{categoryX}: [bold]{valueY}[/]";

bullet.adapter.add("fill", function(fill, target) {
    if (target.dataItem.valueY < 0) {
        return am4core.color("#66b7dc");
    }
    return fill;
})
var range = valueAxis.createSeriesRange(series);
range.value = 0;
range.endValue = -1000;
range.contents.stroke = am4core.color("#66b7dc");
range.contents.fill = range.contents.stroke;

// Add scrollbar
var scrollbarX = new am4charts.XYChartScrollbar();
chart.scrollbarX = scrollbarX;
scrollbarX.series.push(series);

// chart.plotContainer.visible = false;



// Make a panning cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "panXY";
chart.cursor.xAxis = categoryAxis;
chart.cursor.snapToSeries = series;

//scrollbars
chart.scrollbarX = new am4core.Scrollbar();
chart.scrollbarX.background.fill = am4core.color("#017acd");
chart.scrollbarX.endGrip.background.fill = am4core.color("#017acd");
chart.scrollbarX.endGrip.background.states.getKey('hover').properties.fill = am4core.color("#017acd");
chart.scrollbarX.endGrip.background.states.getKey('down').properties.fill = am4core.color("#017acd");
chart.scrollbarX.startGrip.background.fill = am4core.color("#017acd");
chart.scrollbarX.startGrip.background.states.getKey('hover').properties.fill = am4core.color("#017acd");
chart.scrollbarX.startGrip.background.states.getKey('down').properties.fill = am4core.color("#017acd");
chart.scrollbarX.thumb.background.fill = am4core.color("#017acd");
chart.scrollbarX.thumb.background.states.getKey('hover').properties.fill = am4core.color("#017acd");
chart.scrollbarX.thumb.background.states.getKey('down').properties.fill = am4core.color("#017acd");
chart.scrollbarX.stroke = am4core.color("#017acd");

chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarX.parent = chart.bottomAxesContainer;

}

jQuery( "#display_en" ).change(function() {
  var item=jQuery(this);
    // console.log(item.val());
    // console.log(getUrlParameter('data'));
    window.location.href = window.location.origin+'/graphs/?data='+getUrlParameter('data')+'&starting_val='+item.val();
    });
</script>
<style>
  .tab-content p{
    margin: 0 auto;
    text-align: center;
  }
.tab-content h2{
     padding-top: 2px;
  color: blue;
    background-color: rgba(0,0,0,0.07);
    font-size: 15px;
    text-align: center;
    letter-spacing: 1px;
    line-height: 20px;
    padding: 15px 30px;
    border-radius: 25px 25px 25px 25px;
   
 
  }


  /*!
 * bootstrap-vertical-tabs - v1.1.0
 * https://dbtek.github.io/bootstrap-vertical-tabs
 * 2014-06-06
 * Copyright (c) 2014 Ä°smail Demirbilek
 * License: MIT
 */
.tabs-left, .tabs-right {
  border-bottom: none;
  padding-top: 2px;
  color: #404040;
    background-color: rgba(0,0,0,0.07);
    text-align: left;
    line-height: 25px;
    padding: 10px 15px;
    margin: 0 15px 10px 0;
    border-radius: 0 25px 25px 0;
    display: table-cell;
    position: relative;
    
}
.tabs-left {
  border-right: 1px solid #ddd;
   display: table-cell;
    width: 28%;
    min-width: 28%;
    vertical-align: top;
    border: none;
    border-right: 5px solid #404040;
  
}
.tabs-right {
  border-left: 1px solid #ddd;
}
.tabs-left>li, .tabs-right>li {
  float: none;
  margin-bottom: 2px
  
}
.tabs-left>li {
  margin-right: -1px;
}
.tabs-right>li {
  margin-left: -1px;
}
.tabs-left>li.active>a,
.tabs-left>li.active>a:hover,
.tabs-left>li.active>a:focus {
  border-bottom-color: #ddd;
  border-right-color: transparent;
  color: #00BFFF;
    background-color: #FFFFE0;
    border: none;
}

.tabs-right>li.active>a,
.tabs-right>li.active>a:hover,
.tabs-right>li.active>a:focus {
  border-bottom: 1px solid #ddd;
  border-left-color: transparent;
}
.tabs-left>li>a {
  border-radius: 4px 0 0 4px;
  margin-right: 0;
  display:block;
  padding: 10px 5px;
}
.tabs-right>li>a {
  border-radius: 0 4px 4px 0;
  margin-right: 0;
}
.vertical-text {
  margin-top:50px;
  border: none;
  position: relative;
}
.vertical-text>li {
  height: 20px;
  width: 120px;
  margin-bottom: 100px;
}
.vertical-text>li>a {
  border-bottom: 1px solid #ddd;
  border-right-color: transparent;
  text-align: center;
  border-radius: 4px 4px 0px 0px;
}
.vertical-text>li.active>a,
.vertical-text>li.active>a:hover,
.vertical-text>li.active>a:focus {
  border-bottom-color: transparent;
  border-right-color: #ddd;
  border-left-color: #ddd;
}
.vertical-text.tabs-left {
  left: -50px;
}
.vertical-text.tabs-right {
  right: -50px;
}
.vertical-text.tabs-right>li {
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.vertical-text.tabs-left>li {
  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  -ms-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
}
  </style>
<?php
}

add_action( 'admin_post_nopriv_my_simple_form_2', 'my_handle_form_submit_2' );
add_action( 'admin_post_my_simple_form_2', 'my_handle_form_submit_2' );


function my_handle_form_submit_2() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'earth_quake_catalogue';

	$daTi = date('m-d-Y-His');
    $uploadDirectory = plugin_dir_path( __FILE__ ) . "uploads/";
    $errors = []; // Store all foreseen and unforseen errors here
    $fileExtensions = ['csv']; // Get all the file extensions
    $fileName = $_FILES['fileToUpload']['name'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileTmpName  = $_FILES['fileToUpload']['tmp_name'];
    $fileType = $_FILES['fileToUpload']['type'];
	$fileExtension = strtolower(end(explode('.',$fileName)));
	$ff = explode('.',$fileName);
	$uploadPath = $uploadDirectory . $ff[0].'_'.$daTi.'.'.$fileExtension;
    if (isset($_POST['submit'])) {
		
        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = '<p>This file extension is not allowed. Please upload a CSV file</p>';
        }
        if (empty($errors)) {
			$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) {
				$q = "DELETE FROM " . $table_name;
				 $wpdb->query( $q );
        $insert_q = "INSERT INTO $table_name (longitude, latitude, year, month, day, magnitude, depth, hour, minute) VALUES ";
        $q_app = '';
				if (($handle = fopen($uploadPath, "r")) !== FALSE) {
					fgetcsv($handle);   
					$i =0;
					while (($data = fgetcsv($handle)) !== FALSE) {
						$num = count($data);
						for ($c=0; $c < $num; $c++) {
              $col[$c] = $data[$c];
            }
            $i++;
            $q_app .= "('$col[0]', '$col[1]', '$col[2]', '$col[3]', '$col[4]', '$col[5]', '$col[6]', '$col[7]', '$col[8]'),";
           
          }
          $q_app = substr($q_app, 0, -1);
          $query = $insert_q.$q_app;
        }
				 $results = $wpdb->query( $query );
			 	wp_redirect( admin_url( '/admin.php?page=earthquakeupload' ) );
        		exit;
            } else {
                echo '<p>An error occurred somewhere. Try again or contact the admin</p>';
            }
        } else {
            foreach ($errors as $error) {
                echo $error . '<p>These are the errors' . '\n' . '</p>';
            }
        }
	}
}


add_shortcode('catalogueData', 'form_creation_catalogue');

function form_creation_catalogue(){
	?>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
   <!-- <script src='http://structurespro.info/wp-content/plugins/earth-quake/js/jquery.min.js?ver=5.3.2'></script> -->
   <style>
      #mapid_2 { 
        height: 580px; 
      }
    </style>
	<!-- <section id="primary" class="content-area"> -->
  <div class="row">
    <div class="col-md-12">
		<main id="main" class="site-main">
<p style="text-align: center;font-size:18px;font-family: Arial">Magnitude  4 - 5  <span style='font-size:35px;color:orange;'>&#9679;</span> : Magnitude  5 - 6  <span style='font-size:35px;color:green;'>&#9679;</span> :  Magnitude  6 - 7  <span style='font-size:35px;color:blue;'>&#9679;</span> : Magnitude ≥ 7.0 <span style='font-size:35px;color:red;'>&#9679;</span></p>
        <div id="mapid_2"></div>


    </main><!-- .site-main -->
    </div>
  </div>
  <!--  </section> -->
  <!-- .content-area -->
  <div class="row">
    <div class="col-md-12">
    <table class="table table-map-rec display responsive nowrap"style="font-size:20px;font-family: Arial">
    <thead>
    <tr>
        <th>Year</th>
        <th>Month</th>
        <th>Day</th>
        <th>Hour (UTC)</th>
        <th>Minute</th>
        <th>Magnitude</th>
        <th>Depth (km)</th>
        <th>Epicenter (Long)</th>
        <th>Epicenter (Lat)</th>
         <th>View</th>
    </tr>
    </thead>
    <tbody>
<?php
    global $wpdb;
    $table_name_2 = $wpdb->prefix . 'earth_quake_catalogue';
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name_2. "" );
    foreach ( $result as $print )   {
    ?>
    <tr>
        <td><?= $print->year ?></td>
        <td><?= $print->month ?></td>
        <td><?= $print->day ?></td>
        <td><?= $print->hour ?></td>
        <td><?= $print->minute ?></td>
        <td><?= $print->magnitude ?></td>
        <td><?= $print->depth ?></td>
        <td><?= $print->longitude ?></td>
        <td><?= $print->latitude ?></td>
        <td>
            <button class="btn btn-xs"onclick="openMarker('<?= $print->latitude ?>', '<?= $print->longitude ?>')">view</button>
        </td>
    </tr>
        
<?php }
  
  
  ?>
      </tbody>

    </table>
    </div>
  </div>
    <script>

      const map = L.map('mapid_2').setView([33.738045, 73.084488], 10);

      // layers starts

      // load a tile layer
      var osm=new L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{ 
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'});
	// https: also suppported.
	var Esri_WorldGrayCanvas = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ',
		maxZoom: 16
	}).addTo(map);
	
  var OpenStreetMap_BlackAndWhite = L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
	maxZoom: 18,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
	});
	// https: also suppported.
	var Stamen_TopOSMFeatures = L.tileLayer('http://stamen-tiles-{s}.a.ssl.fastly.net/toposm-features/{z}/{x}/{y}.{ext}', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 20,
		ext: 'png',
		bounds: [[22, -132], [51, -56]],
		opacity: 0.9
	});

	// https: also suppported.
	var Esri_WorldImagery = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
	});

  // var blue = L.layerGroup([
  //       Esri_WorldGrayCanvas,
	// 	Stamen_TopOSMFeatures
	// 	]); 
  

var normal =  L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
          attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012',
          maxZoom: 18,
        }).addTo(map);

// Layers Ends
		console.log('i am eee');
var baseMaps = {
      "Open Street Map": osm,
      "Imagery":Esri_WorldImagery,
      "Gray":Esri_WorldGrayCanvas,
      // "Blue Base":blue,
      "OSM B&W":OpenStreetMap_BlackAndWhite,
      "normal": normal
    };

    var overlayMaps = {};	
//Add layer control
L.control.layers(baseMaps, overlayMaps).addTo(map);


      let markersArray = {}; // create the associative array
      // load GeoJSON from an external file

  jQuery.ajax(
    {
        type: "post",
        dataType: "json",
        url: "/wp-admin/admin-ajax.php",
        data: {
            action: 'my_front_simple_form_2'
        },
        success: function(data){
            data = data.data;
            console.log(data);
            var counter = 0;
            var old_lat = '';
            var old_lng = '';
            var value = '';
            var dl_i=1;
            L.geoJson(data, {
			
            // add GeoJSON layer to the map once the file is loaded
        
            pointToLayer: function(feature, latlng) {
              const mag = feature.properties.magnitude; // magnitude
              const geojsonMarkerOptions = {
                opacity: 0.8,
                fillOpacity: 0.6,
                // here define the style using ternary operators for circles
                 weight: mag >= 7.0 ? '.2' : mag >= 6.0 ? '.1' : mag >= 5.0 ? '.05': mag >= 4.0 ? '1' : '.01',
               color: mag >= 7.0 ? 'red' : mag >= 6.0 ? 'blue' : mag >= 5.0 ? 'green': mag >= 4.0 ? 'orange' : 'black'
              };
              console.log(feature.properties.mag);
              if(counter > 0){
                if(old_lat == feature.geometry.coordinates[0] && old_lng == feature.geometry.coordinates[1]){
                  old_lat = feature.geometry.coordinates[0];
                  old_lng = feature.geometry.coordinates[1];
                  console.log('appearing again');
                  value = value + `
                    <b>Date (UTC):</b> &nbsp; ${feature.properties.year+'-'+feature.properties.month+'-'+feature.properties.day+'-'+feature.properties.hour+':'+feature.properties.minute}<br>
                    <b>Magnitude:</b> &nbsp; ${feature.properties.magnitude}<br>
                    <b>Depth (km):</b> &nbsp; ${feature.properties.depth}<br>`;
                  counter = counter + 1;
                }else{
                  old_lat = feature.geometry.coordinates[0];
                  old_lng = feature.geometry.coordinates[1];
                  value = `
                    <b>Date (UTC):</b> &nbsp; ${feature.properties.year+'-'+feature.properties.month+'-'+feature.properties.day+'-'+feature.properties.hour+':'+feature.properties.minute}<br>
                    <b>Magnitude:</b> &nbsp; ${feature.properties.magnitude}<br>
                    <b>Depth (km):</b> &nbsp; ${feature.properties.depth}<br>`;
                    counter = counter + 1;
                }
              }else{
                old_lat = feature.geometry.coordinates[0];
                old_lng = feature.geometry.coordinates[1];
                value = `
                    <b>Date (UTC):</b> &nbsp; ${feature.properties.year+'-'+feature.properties.month+'-'+feature.properties.day+'-'+feature.properties.hour+':'+feature.properties.minute}<br>
                  <b>Magnitude:</b> &nbsp; ${feature.properties.magnitude}<br>
                  <b>Depth (km):</b> &nbsp; ${feature.properties.depth}<br>`;
                counter = counter + 1;
              }

// console.log(feature.geometry.coordinates[0]);
              markersArray[dl_i] = L.circleMarker(latlng, geojsonMarkerOptions)
                .addTo(map)
                .bindPopup(value, {
                closeButton: true,
                offset: L.point(0, -20)
              });
              dl_i++;
              // here record the mags
              return L.circleMarker(latlng, geojsonMarkerOptions);
            },
          });
          jQuery('.leaflet-control-attribution').hide();
            
        }
        
    });

    function openMarker(lat, lng){
      console.log(markersArray);
      markersArray[1].openPopup();
      var i=1;
      for(var k in markersArray) {
          if(markersArray[i]._latlng.lat == lat && markersArray[i]._latlng.lng == lng){
          markersArray[i].openPopup();
          $(window).scrollTop({ top: 0, behavior: 'smooth' });
          return false;
        }
      i++;
      }
    }
    
    jQuery(document).ready(function() {
      var table = jQuery('.table-map-rec').DataTable();
    //   jQuery('#min, #max').keyup( function() {
    //         table.draw();
    //     } );
    } );
    </script>
	<?php
  }
  


  add_action( 'wp_ajax_nopriv_my_front_simple_form_2', 'my_front_map_data_2' );
  add_action( 'wp_ajax_my_front_simple_form_2', 'my_front_map_data_2' );



  function my_front_map_data_2(){
    global $wpdb;
      $table_name_2 = $wpdb->prefix . 'earth_quake_catalogue';
    $result = $wpdb->get_results ( "SELECT * FROM ".$table_name_2. " order by latitude,longitude" );
    $json = [
      "type"=> "FeatureCollection",
      "features" => []
    ];
    
    foreach ( $result as $print ){
      $data = array(
        "type" => "Feature",
        "id"=> $print->id,
          "properties"=> array(
            "year" => $print->year, 
            "month"=> $print->month,
            "day"=> $print->day,
            "magnitude"=> $print->magnitude,
            "depth"=> $print->depth,
            "hour"=> $print->hour,
            "minute"=> $print->minute,
            "id"=> $print->id,
          ),
          "geometry"=> array(
            "type"=> "Point", 
            "coordinates" => [ $print->longitude, $print->latitude ] 
          )
    
      );
      array_push($json['features'],	$data);
    }
    wp_send_json_success($json);
  }