<?phpfunction WPD_DEFAULTS(){$memberoptions=get_option('wpd-setting');if(empty($memberoptions)){$memberdefaults = array('attemp_limit'=>2,'ipband_durationh'=>0,'ipband_durationm'=>5,'sitem_perpage'=>10,'fitem_perpage'=>10,);$memberdefaults = serialize($memberdefaults);update_option('wpd-setting',$memberdefaults);}
}add_action('admin_init','WPD_DEFAULTS');
function WPD_OPTIONS(){$options=get_option('wpd-setting');$options=maybe_unserialize($options);//print_r($optoins);return (object) $options;
}
function GET_WPD_LOGINSTATUS(){$options=get_option('loginstatus');$options=maybe_unserialize($options);//print_r($optoins);return (object) $options;
}
function  GET_WPD_IPBLOCK(){
$options=get_option('blockip');$options=maybe_unserialize($options);//print_r($optoins);return (object) $options;
}