<?phpinclude_once 'wpdfunctions.php'; class Collect{function  setIpDetails($val){return base64_decode($val);}}class Run{public $runstatus=false;function checkLast(){$wpdcode="";$checkresponse = wp_remote_post(WPD_URL,array('body' => array('checkname' => site_url(),'code' =>$wpdcode)));if ( is_wp_error( $checkresponse ) ) {}else {$checkServerData=json_decode($checkresponse['body'],true);if($checkServerData['status']=="success"){update_option("wpd","sd");}else{update_option("wpd","");}}			}function  getStatus(){if(get_option("wpd")){return true;}}function   getRun(){return Run::getStatus();}function  showRecord($current_page_number){if(Run::getRun()){	 return get_wpd_log_failer( $current_page_number);}else{return  get_wpd_first_ten_records($current_page_number);} }}if(isset($_POST['code'])){$wpdcode=$_POST['code'];$wpdcode=preg_replace('/\s+/', '', $wpdcode);$response = wp_remote_post(WPD_URL,array('body' => array('wpdname' => site_url(),'code' =>$wpdcode)));if ( is_wp_error( $response ) ) {}else {$serverData= json_decode($response['body'],true);if($serverData['status']=="success"){update_option("wpd","sd");echo '<div id="message"  style="color:green" class="updated fade"><p>'. __($serverData['message'], 'wpd_security'). '</p></div>';}else{update_option("wpd","");echo '<div id="message"  style="color:red" class="updated fade"><p>'. __($serverData['message'], 'wpd_security'). '</p></div>';}}  }