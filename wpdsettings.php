<?php
include_once 'wpdfunctions.php'; 
$current_page_number = (int) (isset($_GET['page_number']) ? $_GET['page_number'] : 1);
global $siteurl;
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"></div>
<div>
<h2 >Tried Password  </h2>
<!--<h2 style="margin-top:-40px"  align="right" id="buylink" ><a  class="btn" href="http://triedpassword.com">Buy Now </a></h2>-->
</div>
<?php $siteurl=show_wpd_tabs(); ?>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<!-- main content -->
<div id="post-body-content">
<div class="meta-box-sortables ui-sortable">
<div class="postbox" style="height:auto;width:1147PX">
<?php
$current_tab = get_wpd_current_tab();
switch ($current_tab) {
case 'login_fail':
include_once 'common.php'; 
?>
<h3><span>Below are the list of recent un-authorised access on your website :</span></h3>
<div class="inside">
<?php
$colunms = array();
$colunms['Sr-No']       = __('Sr.No.', 'wpd_security');
$colunms['th-date']       = __('Date', 'wpd_security');
$colunms['th-user']       = __('User', 'wpd_security');
$colunms['th-password']   = __('Password', 'wpd_security');
$colunms['th-ip']         = __('IP', 'wpd_security');
$colunms['th-user_agent'] = __('Browser', 'wpd_security');
$colunms['th-referer']    = __('Referer', 'wpd_security');	
$colunms['th-ipstatuscheck']    = __('IP Block', 'wpd_security');	
// get the logs of all failer login
?>
<table   id="wpdf"  class="wp-list-table widefat fixed">
<?php
// Display the table head
$items =  Run::showRecord($current_page_number);
?>
<tbody>
<?php
$links=Run::getRun();
if (!empty($items)) :
// Get the pagination
if($links)
{	 
$paginate_links = wpd_paginate_links( $current_page_number );
echo '<script>document.getElementById("buylink").style.display = "none"</script>';
}
//  pagination
wpd_pagination_table( count($colunms), $paginate_links );
wpd_table_thead($colunms);
// Displaying all the items
$counter=1;
foreach ($items as $k => $item) : ?>
<tr id="item_<?php echo $item['id'];?>"<?php echo ($k%2===0 ? ' class="alternate"' : '');?>>
<td><?php echo  $counter; ?></td>
<td><?php echo  $item['Entrydate'] ; ?></td>
<td><?php echo  $item['name'] ; ?></td>
<td><?php echo  $item['pwdmd5'] ; ?></td>
<td><?php echo $item['IPAddress']; ?><br>
<a href="http://ip2location.com/<?php echo $item['IPAddress']; ?>" target="blank">Trace IP</a>
</td>
<td><?php echo $item['Useragent']; ?></td>
<td><?php echo $item['Referer'];  $counter++; ?></td>
<?php	
if(!empty($_GET['page_number'])&&isset($_GET['page_number']))
{
$pagevar = $_GET['page_number'];          
}else{
$pagevar = "1";
}
if($item['IPstatus']==1)
{$ipopton="<a href=".$siteurl."&ipstatus=unblock&page_number=".$pagevar."&itemid=".$item['id'].">UnBlock </a>";}else{
$ipopton="<a href=".$siteurl."&ipstatus=block&page_number=".$pagevar."&itemid=".$item['id'].">Block IP</a>";
}
?>	
<td><?php echo $ipopton;  ?></td>
</tr>
<?php endforeach; ?>
<?php
if($links)
{
wpd_pagination_table( count($colunms), $paginate_links );
}else{
echo '<tr><th></th><th></th><th></th><th></th><th><a href="http://triedpassword.com">Buy Now </a></th></tr>';
}
?>
<?php else:  ?>
<tr>
<td colspan="<?php echo count($colunms); ?>"><?php _e('No Record', 'wpd_security'); ?></td>
</tr>
<?php endif; ?>
</tbody>
</table>
<script src="<?php echo LS_USER_PLUGIN_URLs; ?>/js/jquery.js" ></script>
<script type="text/javascript">
function test(id,path) {
alert(path);
}
</script>
<?php
break;
// LOGIN SUCCEED
case 'login_success':
?>
<h3><span>Below are the list of recent  successful access on your website:</span></h3>
<div class="inside">
<?php
$colunms = array();
$colunms['Sr-No']       = __('Sr.No.', 'wpd_security');
$colunms['th-date']       = __('Date', 'wpd_security');
$colunms['th-user']       = __('User', 'wpd_security');
$colunms['th-ip']         = __('IP', 'wpd_security');
$colunms['th-user_agent'] = __('Browser', 'wpd_security');
$colunms['th-referer']    = __('Referer', 'wpd_security');
// get the logs of all success login
$items = get_wpd_log_success( $current_page_number );
?>
<table class="wp-list-table widefat fixed">
<?php
$paginate_links = wpd_paginate_links( $current_page_number );   
wpd_pagination_table( count($colunms), $paginate_links );
// Display the table head
wpd_table_thead($colunms);
?>
<tbody>
<?php
if (!empty($items)) :
// Get the pagination
//  pagination
// Displaying all the items
$counter=1;
foreach ($items as $k => $item) : ?>
<tr id="item_<?php echo $item['id'];?>"<?php echo ($k%2===0 ? ' class="alternate"' : '');?>>
<td><?php echo $counter ; ?></td>
<td><?php echo $item['Entrydate'] ; ?></td>
<td><?php echo get_wpd_format_user( $item['UserId'] ); ?></td>
<td><?php echo $item['IPAddress']; ?><br><a href="http://ip2location.com/<?php echo $item['IPAddress']; ?>" target="blank">Trace IP</a></td>
<td><?php echo $item['Useragent']; ?></td>
<td><?php echo $item['Referer'];  $counter++; ?></td>
<?php                
if(!empty($_GET['page_number'])&&isset($_GET['page_number']))
{
$pagevar = $_GET['page_number'];
}else{
$pagevar = "1";
}
?>
</tr>
<?php endforeach; ?>
<?php
// Table pagination
wpd_pagination_table( count($colunms), $paginate_links );
?>
<?php else:  ?>
<tr>
<td colspan="<?php echo count($colunms); ?>"><?php _e('No Record', 'wpd_security'); ?></td>
</tr>
<?php endif; ?>
</tbody>
</table>
<?php
break;
// Setting 
case 'setting':
?>
<style>
td{
font-size:15px;
font-family:arial;
color:black;
font-weight:normal;
text-align:right ;
}
.heading{
font-size:12px;
font-family:arial;
font-weight:bold;
}
.title{
font-size:20px;
font-family:arial;
font-weight:bold;
}
</style>
<h3><span><?php 
$domain= site_url();
//$email=bloginfo('admin_email');
$email=get_option( 'admin_email' );
if(!get_option("emailaddress")){
update_option('emailaddress',$email);
}
 
if(!get_option("wpd")){
$msg= '
<table cellpadding="10">
<tr>
<td>
<h1 style="color:red">Status :  Trial   </h1>
</td>
<td>
<form action="http://triedpassword.com/payment/index.php" method="post" target="_blank">
<input type="hidden" name="email" value="'.$email.'">
<input type="hidden" name="domain" value="'.$domain.'">
<input  type="submit" value="Get License">
</td>
</tr>
</table>
</form>
<br>
'; $msg.='<form action="" method="POST">
<table    style="width:40%" cellpadding="10">
<tr><td><span>Enter Licence Key</span></td>
<td><input type="text" name="code" ></td>
<td><input type="submit" value="Confirm"  class="button-primary"></td>
</table>
</form>'; 
echo $msg; } ?>
<form method="post" action="" onsubmit="RefreshValues()" >
<table cellpadding="10" >
<tr></tr>
<tr><td>No. of Login Attempt </td> <td>
<select name="al"  style="margin-right:131px"  >
<?php
 for($i=1;$i<=10;$i++)
{ 
if(WPD_OPTIONS()->attemp_limit==$i)
{
echo $op='<option value="'.$i.'"   selected > '. $i.'</option>';
}else{
echo $op='<option value="'.$i.'"  > '. $i.'</option>';
}
}
?>
</select>
</tr>
<tr><th></th></tr>
<tr style="top:margin:300px"><td>Block IP for  Duration  </td><td>
<select name="ipdh" style="margin-left:80px"  >
<option  value="0">0 </option>
<?php
for($i=1;$i<=24;$i++)
{ 
if(WPD_OPTIONS()->ipband_durationh==$i)
{
echo $op='<option value="'.$i.'"   selected > '. $i.'</option>';
}else{
echo $op='<option value="'.$i.'"  > '. $i.'</option>';
}
}
?>
</select>Hour
<select name="ipdm">
<option value="0">0 </option>
<?php
for($i=5;$i<=30;$i=$i+5)
{ 
if(WPD_OPTIONS()->ipband_durationm==$i)
{
echo $op='<option value="'.$i.'"   selected > '. $i.'</option>';
}else{
echo $op='<option value="'.$i.'"  > '. $i.'</option>';
}
}
?>
</select>
Minute
</td></tr>
<tr><th></th></tr>
<tr><td>Enter Email Address</td><td><input   style="margin-left:80px" id="txtEmail" type="text"  name="email"  value="<?php if(get_option( 'emailaddress')){ echo get_option( 'emailaddress'); }?>"   ></td></tr>
<tr><td><input type="submit"  
name="wpdformoptions" value="Save"   onclick="return checkEmail()" class="button-primary">
</td>
</table>
</form>
<div>
<script> function checkEmail() {     var email = document.getElementById("txtEmail");    if(email.value!="")	{	    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;    if (!filter.test(email.value)) {    alert("Please provide a valid email address");    email.focus;    return false;    }	} }	 function RefreshValues()	 {      document.getElementById("container").innerHTML="<h1>Updating...<h1></tr>"		;	 }	 function isNumberKey(evt)     {        var charCode = (evt.which) ? evt.which : event.keyCode        if (charCode > 31 && (charCode < 48 || charCode > 57))         return false;         return true;     }
</script>
<?php
if(isset($_POST['wpdformoptions']))
{
$wpoptions= array('attemp_limit'=>$_POST['al'],
'ipband_durationh'=>$_POST['ipdh']!=""?$_POST['ipdh']:0,
'ipband_durationm'=>$_POST['ipdm']!=""?$_POST['ipdm']:0,
'sitem_perpage'=>$_POST['srp']!=""?$_POST['srp']:10,
'fitem_perpage'=>$_POST['frp']!=""?$_POST['frp']:10,);      
if($_POST['email']!="")	
{		
update_option('emailaddress',$_POST['email']); 
}
$wpoptions = serialize($wpoptions);
update_option('wpd-setting' ,  $wpoptions);
echo '<div id="message" class="updated fade"><p>'
. __('Settings changed Please Refresh Page to Make Changes', 'wpd_security')
. '</p></div>';
}
break;
default:
break;
}
