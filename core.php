<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
date_default_timezone_set('Asia/shanghai'); 
error_reporting(0);
C(require('db.php'));
$dbcon = new mysqli(C('db_host'),C('db_user'),C('db_pass'),C('db_base'));
!$dbcon && die('数据库连接错误');
$dbcon->query('set names utf8;'); 
 

function C($name=null, $value=null) {
    static $_config = array();
    if (empty($name)) return $_config;
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtolower($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : null;
            $_config[$name] = $value;
            return;
        }
        $name = explode('.', $name);
        $name[0]   =  strtolower($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : null;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    if (is_array($name)){
        return $_config = array_merge($_config, array_change_key_case($name));
    }
    return null; 
}

function V($view=''){
    require $view.'.php';
}

function S($name='',$value='') {
	if ($value==='') {
	    if ($name==='') { 
		    return $_SESSION;
		} elseif(is_null($name)) {
			session_destroy();
		} else {
			return isset($_SESSION[$name]) ? $_SESSION[$name] :false;
		}
	 } elseif(is_null($value)) {
		 unset($_SESSION[$name]);
	 } else {
		 $_SESSION[$name]=$value;
	 }
}

function U($uri='') {
    if (substr($uri,0,4)=='http') {
		return $uri;
	} else {
	    if ($uri=='-2') {
		    $h = $_SERVER['HTTP_HOST'];
			$h = strtolower($h);
			if (strpos($h,'/')!==false) {
				$p = @parse_url($h);
				$h = $p['host']; 
			}
			$l = array('com','edu','gov','int','mil','net','org','biz','info','pro','name','museum','coop','aero','xxx','idv','mobi','cc','me'); 
			$s = '';
			foreach($l as $v){
				$s.=($s ? '|' : '').$v;
			}
			$m = "[^\.]+\.(?:(".$s.")|\w{2}|((".$s.")\.\w{2}))$";
			if (preg_match("/".$m."/ies",$h,$t)) {
				$d = $t['0'];
			} else{
				$d = $h;
			}
			return $d;
		}elseif ($uri=='-1') {
		    $url1 = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
			$url2 = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
			$url3 = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
			$url4 = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $url2.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $url3);
			return $url1.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$url4;
		}
		return 2==1 ? base_url($uri) : site_url($uri);
	}
}

function R($url, $d='', $method='GET', $headers=array()) {
    if (substr($url,0,4)!='http')  $url = U($url);
	$ci = curl_init();
	curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ci, CURLOPT_TIMEOUT, 30);
	if ($method=='POST') {
		curl_setopt($ci, CURLOPT_POST, TRUE);
		curl_setopt($ci, CURLOPT_POSTFIELDS, $d);
	}
	curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ci, CURLOPT_URL, $url);
	$response = curl_exec($ci);
	curl_close($ci);
	return $response;
}

function J($msg,$type=0) {
    if (is_array($msg)) {
		$j = $msg;
		$msg = $j['msg'];
	}else{
		$j['msg'] = $msg;
	}	
	switch($type) {
        case '0': $j['state'] = 'error';break;   
        case '1': $j['state'] = 'success';break;   
        default:  $j['state'] = $type;break;  
    }
	//header('Content-type: application/json');
	die(json_encode($j)); 
	 
}

function I($name,$default='',$filter='str_htmlencode') {
    if (strpos($name,'.')) { 
        list($method,$name) = explode('.',$name,2);
    } else { 
        $method = 'param';
    }
    switch(strtolower($method)) {
        case 'get'   : $input =& $_GET;break;
        case 'post'  : $input =& $_POST;break;
        case 'put'   : parse_str(file_get_contents('php://input'), $input);break;
        case 'param' :
            switch($_SERVER['REQUEST_METHOD']) {
                case 'POST':$input  = $_POST;break;
                case 'PUT' :parse_str(file_get_contents('php://input'), $input);break;
                default    :$input  = $_GET;
            }
            break;
        case 'request' : $input =& $_REQUEST;break;
        case 'session' : $input =& $_SESSION;break;
        case 'cookie'  : $input =& $_COOKIE;break;
        case 'server'  : $input =& $_SERVER;break;
        case 'globals' : $input =& $GLOBALS;break;
        default:return NULL;
    }

    if (empty($name)) {
        $data = $input;
        $filters = $filter;
        if ($filters) {
            $filters  = explode(',',$filters);
            foreach($filters as $filter){
                $data = $filter($data); 
            }
        }
    } elseif (isset($input[$name])) { 
        $data = $input[$name];
        $filters = $filter;
        if ($filters) {
            $filters = explode(',',$filters);
            foreach($filters as $filter){
                if (function_exists($filter)) {
                    $data = $filter($data); 
                }
            }
			if (!$data) return isset($default)?$default:NULL;
        }
    } else {  
        $data = isset($default) ? $default:NULL;
    }
    return $data;
}

function base_url($uri = '') {
    if (isset($_SERVER['HTTP_HOST'])) {
		$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
		$base_url .= '://'. $_SERVER['HTTP_HOST'];
		$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	} else {
		$base_url = 'http://localhost/';
	}		
    if (is_array($uri)) $uri = implode('/', $uri);
	$uri = trim($uri, '/');
	return $base_url.ltrim($uri, '/');
}


function site_url($uri = '') {
    return base_url().'index.php/'.$uri; 
}

function sys_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown',$arr);
        if (false!==$pos) unset($arr[$pos]);
        $ip=trim($arr[0]);
    } elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif(isset($_SERVER['REMOTE_ADDR'])) {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
    return $ip;
}

function set_token($str='token') {
	$data = md5(time().uniqid());
	setcookie($str,$data,time()+3600*24);
	return $data;
}

function get_token($str='token') {
	$post   = I($str,'token');
	$token  = $_COOKIE[$str];
	if ($token && $post == $token) {
	    setcookie($str,'',time()+3600*24);
		return true;
	}
	return false;
}

function redirect($url) {
	header("Location: $url"); 
	exit;
}

function db_sql($sql,$type=2) { 
    global $dbcon;
	$r = array();
    $result = $dbcon->query($sql);
	switch ($type) {
		case 1:$r = mysqli_fetch_assoc($result); break;  
		case 2:while ($row=@mysqli_fetch_assoc($result)) {$r[] = $row;} break; 	
		case 3:$r =  mysqli_num_rows($result);break; 
		default:$r = $result;break; 
	}
	return $r;
}

function escape($str){
	if (is_string($str)){
		$str = "'".$str."'";
	}elseif (is_bool($str)){
		$str = ($str === FALSE) ? 0 : 1;
	}elseif (is_null($str)){
		$str = 'NULL';
	}
	return $str;
}



function _has_operator($str){
	$str = trim($str);
	if(!preg_match("/(\s|<|>|!|=|is null|is not null)/i", $str))return FALSE;
	return TRUE;
}

function _where($key, $value = NULL, $type = ' AND ', $escape = NULL){
	if (!is_array($key))$key = array($key => $value);
	foreach ($key as $k => $v){
		if (!is_null($v)){
			if ($escape===TRUE)$v = ' '.escape($v);
			if (!_has_operator($k))$k .= ' = ';
			$ar_where = $type.$k.$v;
		}
		return $ar_where;
	}
}

function _like($field, $match = '', $type = ' AND ', $side = 'both', $not = ''){
	if (!is_array($field))$field = array($field=>$match);
	foreach ($field as $k => $v){
		if ($side == 'none'){
			$like = $type." $k $not LIKE '{$v}'";
		}elseif ($side == 'before'){
			$like = $type." $k $not LIKE '%{$v}'";
		}elseif ($side == 'after'){
			$like = $type." $k $not LIKE '{$v}%'";
		}else{
			$like = $type." $k $not LIKE '%{$v}%'";
		}
	}
	return $like;
}

function _where_in($key = NULL, $values = NULL, $not = FALSE, $type = ' AND '){
	if ($key === NULL OR $values === NULL)return;
	if (!is_array($values)) $values = explode(',',$values);
	$not = ($not) ? ' NOT ' : '';
	foreach ($values as $value){
		$ar_wherein[] = escape($value);
	}
	$where_in = $type . $key . $not . " IN (" . implode(", ", $ar_wherein) . ") ";
	return $where_in;
}


function db_where($search) { 
	$where = ' (1=1) '; 
	$string = $order = $group = $limit1 = $limit2 = $having = '';
	if (!is_array($search)) return $where.$search; 
	if (isset($search['_string'])) {
		if (is_array($search['_string'])) {
			foreach ($search['_string'] as $arr=>$row) { 
				$string .= $row;
			}
		} else {
			$string = $search['_string'];
		}
		unset($search['_string']);
	}
	if (isset($search['limit2'])){$limit2 = ','.$search['limit2'];unset($search['limit2']);}
	if (isset($search['limit1'])){$limit1 = $search['limit1'];$limit1 = ' limit '.$limit1.$limit2;unset($search['limit1']);}
	if (isset($search['group'])){ $group  = ' group by '.$search['group'];unset($search['group']);}
	if (isset($search['order'])){ $order  = ' order by '.$search['order'];unset($search['order']);}
	if (isset($search['having'])){$having = $search['having'] ? ' having '.$search['having'] :'';unset($search['having']);}
	foreach ($search as $key=>$val) { 
		if (!is_array($val) && strlen($val)==0) continue;
		if (is_array($val)) {
		    $side = isset($val[2]) ? $val[2] : '';
		    if ($val[0]=='like') $where .= _like($key, $val[1], ' and ', $side, '');
			if ($val[0]=='or_like') $where .= _like($key, $val[1], ' or ', $side, '');
			if ($val[0]=='not_like') $where .= _like($key, $val[1], ' and ', $side, ' NOT ');
			if ($val[0]=='or_not_like') $where .= _like($key, $val[1], ' or ', $side, ' NOT ');
			if ($val[0]=='where_in') $where .= _where_in($key, $val[1], FALSE);
			if ($val[0]=='or_where_in') $where .= _where_in($key, $val[1], FALSE,' or ');
			if ($val[0]=='where_not_in') $where .= _where_in($key, $val[1], TRUE);
			if ($val[0]=='or_where_not_in') $where .= _where_in($key, $val[1], TRUE,' or ');
		} else {
		    $where .= _where($key, $val, $type = ' and ', TRUE);
		}
	} 
	return $where.$string.$group.$having.$order.$limit1; 
} 



function db_list($table,$where='',$type=2,$files=''){ 
	if (isset($where['select'])){
	    $field = $where['select'];
	    unset($where['select']);
	} else {
	    $field = '*';	 
	}
	$join = '';
	if (isset($where['join'])){
		foreach ($where['join'] as $arr=>$row) {
			if (is_array($row)) { 
			    $join .= $row[1].' join '.$arr.' ON '.$row[0].'';
			} else {
				$join .= 'left join '.$arr.' ON '.$row.'';	
			}
		}
		unset($where['join']);
	}  
	 
    $result = db_sql('select '.$field.' from '.C('PREFIX').$table.' '.$join.' where '.db_where($where),$type);
	if($files) $result = isset($result[$files]) ? $result[$files] :'';	 
	return $result;
}
 
function db_insert($table,$data) {
    global $dbcon;
	$field='';
	$value='';
	if (!is_array($data)) return false;
	if (isset($data[0])&&is_array($data[0])) {
	    foreach ($data as $arr=>$row) {
			foreach(array_values($row) as $k=>$v) $c[] = escape($v);
			$value[$arr] = '('.implode(',',$c).')';
			unset($c);
		}
		$field = implode(',',array_keys($data[0]));
		$value = implode(',',$value);
		
		return db_sql('insert into `'.C('PREFIX').$table.'` ('.$field.') values '.$value.'',0);
	} else {
	    foreach($data as $key=>$val) {
			$field .= $key.',';
			$value .= escape($val).',';
		}
		$field = substr($field,0,-1);
		$value = str_replace('\\','\\\\',substr($value,0,-1)); 
		db_sql('insert into '.C('PREFIX').$table.' ('.$field.') values ('.$value.')',0);
		return mysqli_insert_id($dbcon);
	}
}

 
function db_update($table,$data,$where='') {
    if (!is_array($data)) return false;  
    if (isset($data[0])&&is_array($data[0])) {
	    $field  = '';
		$ids  = array();
		$keys = array();
		$id   = $where;
		if (!$id) return false;  
		if (!is_array($data)) return false;  
		if (!is_array($data[0])) return false;  
		$key = array_keys($data[0]);
		foreach ($data as $arr=>$row) $ids[] = escape($row[$id]);	
		foreach($key as $v) {
			if ($v!=$id)  $keys[] = $v;
		}
		foreach($keys as $v) {
			$field .= '`'.$v.'` = CASE ';
			foreach ($data as $x=>$y) { 
				$field .= 'WHEN `'.$id.'` = '.$y[$id].' THEN \''.$y[$v].'\' ';
			}
			$field .= 'ELSE `'.$v.'` END,';
		}
		$field = rtrim($field, ',');
		return db_sql('UPDATE `'.C('PREFIX').$table.'` SET  '.$field.'  WHERE `'.$id.'` IN ('.implode(',',$ids).')',0);
	} else {
	    $value = '';
		foreach($data as $key=>$val) {
			if (is_array($val)) { 
				$value .= $key.' = '.$val[0].',';
			} else {
				$value .= $key.' = '.escape($val).',';
			}
		}
		 
		$value = str_replace('\\','\\\\',substr($value,0,-1)); 
		return db_sql('update '.C('PREFIX').$table.' set '.$value.' where '.db_where($where),0);
	}
}
 

function db_delete($table,$where=''){ 
    return db_sql('DELETE FROM '.C('PREFIX').$table.' where '.db_where($where),0); 
}


function D($t,$w='',$y=2,$f='') {
	switch ($y) {
		case 1:$r = db_list($t,$w,1,$f);break;  
		case 2:$r = db_list($t,$w,2);break;  	
		case 3:$r = db_list($t,$w,3);break; 	
		case '+':$r = db_insert($t,$w);break; 
		case '-':$r = db_delete($t,$w);break; 
		case '*':$r = db_sql($t,$w);break; 
		case 'BEGIN':$r = db_sql('BEGIN',0);break; 
		case 'COMMIT':$r = db_sql('COMMIT',0);break; 
		case 'ROLLBACK':$r = db_sql('ROLLBACK',0);break; 
		default:$r  = db_update($t,$w,$y);break; 
	}
	return $r;
}

function str_alert($str,$url='') {
	$str = $str ? 'alert("'.$str.'");' : '';
	$url = $url ? 'location.href="'.$url.'";' : 'history.go(-1);';
	die('<script>'.$str.$url.'</script>');
}

function str_htmlencode($str) {
	if (!is_array($str)) return addslashes(htmlspecialchars(trim($str)));
	foreach ($str as $key=>$val) {
		$str[$key] = str_htmlencode($val);
	}
	return $str;
}

function str_htmldecode($str) {
	if (!is_array($str)) return stripslashes(htmlspecialchars_decode(trim($str)));
	foreach ($str as $key=>$val) {
		$str[$key] = str_htmldecode($val);
	}
	return $str;
}

function str_substr($user_name){
    $strlen     = mb_strlen($user_name, 'utf-8');
    $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
    $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
} 

function str_cut($str, $length, $start=0 ,$f='...', $charset="utf-8") {
    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
    } else {
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312']  = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']     = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']    = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join('',array_slice($match[0], $start, $length));
    }
    return strlen($str) > $length ? $slice.$f : $slice;
}

function str_guid() {
    $charid = strtolower(md5(uniqid(mt_rand(),true))); 
    $hyphen = chr(45);// "-" 
    $guid   = substr($charid, 0, 8).$hyphen 
    .substr($charid, 8, 4).$hyphen 
    .substr($charid,12, 4).$hyphen 
    .substr($charid,16, 4).$hyphen 
    .substr($charid,20,12);
    return $guid; 
}

function str_no($str='') {    
    return $str.date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

function is_mobile() { 
    $user_agent = $_SERVER['HTTP_USER_AGENT']; 
    $mobile_agents = array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel", 
"amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio", 
    "au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu", 
    "cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ", 
    "fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi", 
    "htc","huawei","hutchison","inno","ipad","ipaq","iphone","ipod","jbrowser","kddi", 
    "kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9", 
"lg-","lge-","lge9","longcos","maemo", 
    "mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-", 
    "moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia", 
    "nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-", 
    "playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo", 
    "samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank", 
    "sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit", 
    "tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin", 
    "vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce", 
    "wireless","xda","xde","zte"); 
    foreach ($mobile_agents as $device) { 
        if (stristr($user_agent, $device)) { 
			return true; 
            break; 
        } 
    } 
    return false; 
} 

 

function image_all($content,$order='ALL'){
	$pattern = "/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/";
	preg_match_all($pattern,$content,$match);
	if(isset($match[1])&&!empty($match[1])){
		if($order==='ALL'){
			return $match[1];
		}
		if(is_numeric($order)&&isset($match[1][$order])){
			return $match[1][$order];
		}
	}
	return '';
}

function http_curl($url, $data='', $method='GET', $headers=array()) {
	$ci = curl_init();
	curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ci, CURLOPT_TIMEOUT, 30);
	if ($method=='POST') {
		curl_setopt($ci, CURLOPT_POST, TRUE);
		if ($postfields != '') curl_setopt($ci, CURLOPT_POSTFIELDS, $data);
	}
	$headers[] = "User-Agent: qqPHP(piscdong.com)";
	curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ci, CURLOPT_URL, $url);
	$response = curl_exec($ci);
	curl_close($ci);
	return $response;
}

if (!function_exists('array_sort')) {
	function array_sort($list, $field, $sortby = 'asc') {
		if (is_array($list)) {
			$refer = $resultset = array();
			foreach ($list as $i => $data) {
				$refer[$i] = &$data[$field];
			}
			switch ($sortby) {
				case 'asc':  // 正向排序
					asort($refer);
					break;
				case 'desc': // 逆向排序
					arsort($refer);
					break;
				case 'nat':  // 自然排序
					natcasesort($refer);
					break;
			}
			foreach ($refer as $key => $val) {
				$resultset[] = &$list[$key];
			}
			return $resultset;
		}
		return false;
	}
}
 
function date_query($type=1){
	switch ($type) {
		case 1:   #本周一
			return date('Y-m-d',(time()-((date('w')==0?7:date('w'))-1)*24*3600));
			break;
		case 2:   #本周日
			return date('Y-m-d',(time()+(7-(date('w')==0?7:date('w')))*24*3600));
			break;
		case 3:  #上周一
			return date('Y-m-d',strtotime('-1 monday', time()));
			break;
		case 4:  #上周日
			return date('Y-m-d',strtotime('-1 sunday', time()));
			break;
		case 5:  #本月初
			return date('Y-m-d',strtotime(date('Y-m', time()).'-01 00:00:00'));
			break;
		case 6:  #本月末
			return date('Y-m-d',strtotime(date('Y-m', time()).'-'.date('t', time()).' 00:00:00'));
			break;
		case 7:  #上月初
			return date('Y-m-01', strtotime('-1 month'));
			break;
		case 8:  #上月末
			return date('Y-m-t', strtotime('-1 month'));
			break;		
	}
}

function date_diffs($date1,$date2,$where='d') {
    $time = strtotime($date1) - strtotime($date2);
    switch ($where){
        case 'w': $retval = bcdiv($time,604800); break; //星期
        case 'd': $retval = bcdiv($time,86400); break;  //天
        case 'h': $retval = bcdiv($time,3600); break;   //小时
        case 'n': $retval = bcdiv($time,60); break;     //分钟
        case 's': $retval = $time; break;               //秒
    }
    return $retval;
}

function date_adds($num,$date='',$where='d'){
    $date = $date ? $date : date('Y-m-d');
    if ($where=='d') $days = date("Y-m-d",strtotime($date.'+'.$num.' day'));
    if ($where=='m') $days = date("Y-m-d",strtotime($date.'+'.$num.' month'));
    if ($where=='y') $days = date("Y-m-d",strtotime($date.'+'.$num.' year'));
    return $days;
}


function random($len,$chars='ABCDEFJHIJKMNOPQRSTUVWSYZ1234567890'){
	$hash= '';
	$max=strlen($chars) - 1;
	for($i=0;$i<$len;$i++) {
		$hash.=$chars[mt_rand(0,$max)];
	}
	return $hash;
}


function date_maktime($time){
   $t = time() - strtotime($time);
   $f = array(
        '31536000'=> '年',
        '2592000' => '个月',
        '604800'  => '星期',
        '86400'   => '天',
        '3600'    => '小时',
        '60'      => '分钟',
        '1'       => '秒'
    );
    foreach ($f as $k=>$v){        
        if (0 !=$c=floor($t/(int)$k)){
            return $c.$v.'前';
        }
    }
} 

function file_down($name,$dir){
    $ua = $_SERVER["HTTP_USER_AGENT"];
	$file = fopen($dir,'r'); 
	header('Content-Type: application/octet-stream');
	if(preg_match("/MSIE/", $ua)) {
		header('Content-Disposition: attachment; filename="' .$name. '"');
	}else if (preg_match("/Firefox/", $ua)) {
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $name. '"');
	}else{
		header('Content-Disposition: attachment; filename="' .$name. '"');
	}
	echo fread($file, filesize($dir));
	fclose($file);
}


function write_file($path, $data, $mode = 'w+') {
	if ( ! $fp = @fopen($path, $mode)) return FALSE;
	flock($fp, LOCK_EX);
	fwrite($fp, $data);
	flock($fp, LOCK_UN);
	fclose($fp);
	return TRUE;
}



function dir_path($path) {
	$path = str_replace('\\', '/', $path);
	if(substr($path, -1) != '/') $path = $path.'/';
	return $path;
}
 
function dir_create($path, $mode = 0777) {
	if(is_dir($path)) return TRUE;
	$ftp_enable = 0;
	$path = dir_path($path);
	$temp = explode('/', $path);
	$cur_dir = '';
	$max = count($temp) - 1;
	for($i=0; $i<$max; $i++) {
		$cur_dir .= $temp[$i].'/';
		if (@is_dir($cur_dir)) continue;
		@mkdir($cur_dir, 0777,true);
		@chmod($cur_dir, 0777);
	}
	return is_dir($path);
}
 
function dir_copy($fromdir, $todir) {
	$fromdir = dir_path($fromdir);
	$todir = dir_path($todir);
	if (!is_dir($fromdir)) return FALSE;
	if (!is_dir($todir)) dir_create($todir);
	$list = glob($fromdir.'*');
	if (!empty($list)) {
		foreach($list as $v) {
			$path = $todir.basename($v);
			if(is_dir($v)) {
				dir_copy($v, $path);
			} else {
				copy($v, $path);
				@chmod($path, 0777);
			}
		}
	}
    return TRUE;
}
 
function dir_iconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
	if($in_charset == $out_charset) return false;
	$list = dir_list($dir);
	foreach($list as $v) {
		if (pathinfo($v, PATHINFO_EXTENSION) == $fileexts && is_file($v)){
			file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
		}
	}
	return true;
}
 
function dir_list($path, $exts = '', $list= array()) {
	$path = dir_path($path);
	$files = glob($path.'*');
	foreach($files as $v) {
		if (!$exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
			$list[] = $v;
			if (is_dir($v)) {
				$list = dir_list($v, $exts, $list);
			}
		}
	}
	return $list;
}
 
function dir_touch($path, $mtime = TIME, $atime = TIME) {
	if (!is_dir($path)) return false;
	$path = dir_path($path);
	if (!is_dir($path)) touch($path, $mtime, $atime);
	$files = glob($path.'*');
	foreach($files as $v) {
		is_dir($v) ? dir_touch($v, $mtime, $atime) : touch($v, $mtime, $atime);
	}
	return true;
}
 
function dir_tree($dir, $parentid = 0, $dirs = array()) {
	global $id;
	if ($parentid == 0) $id = 0;
	$list = glob($dir.'*');
	foreach($list as $v) {
		if (is_dir($v)) {
            $id++;
			$dirs[$id] = array('id'=>$id,'parentid'=>$parentid, 'name'=>basename($v), 'dir'=>$v.'/');
			$dirs = dir_tree($v.'/', $id, $dirs);
		}
	}
	return $dirs;
}
 
function dir_delete($dir) {
	$dir = dir_path($dir);
	if (!is_dir($dir)) return FALSE;
	$list = glob($dir.'*');
	foreach($list as $v) {
		is_dir($v) ? dir_delete($v) : @unlink($v);
	}
    return @rmdir($dir);
}

 
	function sys_xls($name){
		header("Content-type:text/xls");
		header("Content-Disposition:attachment;filename=".$name);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0'); 
		header('Pragma:public');
	} 
 


function lib_captcha($props=array()){
    header('Content-Type:image/png');
	$data['num']      = 4;
	$data['width']    = 65;
	$data['high']     = 25;
	$data['line_num'] = 10;
	$data['snow_num'] = 30;
    if (count($props) > 0) {
		foreach ($props as $key => $val) {
			$data[$key] = $val;
		}
	}
    session_start();
    //生成随机数字＋字母
    for($a = 0;$a < $data['num'];$a++){
        $code .= dechex(mt_rand(0, 15));//dechex — 十进制转换为十六进制
    }
    //把生成的验证码保存在SESSION超级全局数组中
    $_SESSION['captcha'] = $code;
    //创建画布
    $img = imagecreatetruecolor($data['width'],$data['high']);
    //填充背景色为白色
    $backcolor = imagecolorallocate($img, '255', '255', '255');
    imagefill($img, '0', '0', $backcolor);
    //添加黑色边框
    $bordercolor = imagecolorallocate($img, 0, 0, 0);
    imagerectangle($img, 0, 0, $data['width']-1, $data['high']-1, $bordercolor);
    //随机画线条
    for($i=0;$i<$data['line_num'];$i++){
        imageline($img, mt_rand(0, $data['width']*0.1), mt_rand(0, $data['high']), mt_rand($data['width']*0.9, $data['width']), mt_rand(0, $data['high']),
        imagecolorallocate($img, mt_rand(150, 255), mt_rand(150, 255), mt_rand(150, 255)));
    }
    //随机打雪花
    for ($i=0;$i<$data['snow_num'];$i++){
    imagechar($img,1, mt_rand(0, $data['width']), mt_rand(0, $data['high']),'*',
    imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255)));
    }
    //画验证码
    for ($b = 0;$b < strlen($_SESSION['captcha']);$b++){
    imagechar($img,5, $b*$data['width']/$data['num']+mt_rand(5,10), mt_rand(2, $data['high']/2),$_SESSION['captcha'][$b],
    imagecolorallocate($img, mt_rand(10, 150), mt_rand(10, 150), mt_rand(0, 100)));
    }
    ob_clean();//清空输出缓冲区
    imagepng($img);
    imagedestroy($img);
	die();
}

function lib_upload($props=array()) {
    $data['filepath'] = 'upload/';
	$data['file']     = 'file';
	$data['newfile']  = date('YmdHis');  
    $data['ext']      = array('gif','jpg','jpeg','png','bmp','mp3');
    $data['maxsize']  = 9999999;
	if (count($props) > 0) {
		foreach ($props as $key => $val) {
			$data[$key] = $val;
		}
	}
	$oldname  = $_FILES[$data['file']]['name'];                 
	$filesize = $_FILES[$data['file']]['size'];               
	$type     = $_FILES[$data['file']]['type'];  
	$tmp      = $_FILES[$data['file']]['tmp_name'];    
	if (!empty($_FILES[$data['file']]['error'])) {
		switch($_FILES[$data['file']]['error']){
			case '1':$error = '超过php.ini允许的大小';break;
			case '2':$error = '超过表单允许的大小';break;
			case '3':$error = '图片只有部分被上传';break;
			case '4':$error = '请选择图片';break;
			case '6':$error = '找不到临时目录';break;
			case '7':$error = '写文件到硬盘出错';break;
			case '8':$error = 'File upload stopped by extension';break;
			default: $error = '未知错误。';
		}
		return array('error'=>$error);
	}
	if (!is_dir($data['filepath'])) dir_create($data['filepath'],0777); 	                                         
	$fileext = strtolower(trim(substr(strrchr($oldname,'.'),1)));   
	$newname = $data['newfile'].'.'.$fileext;  
	if (!in_array($fileext,$data['ext'])) return array('error'=>'上传文件类型不符');
	if ($filesize>$data['maxsize']) return array('error'=>'文件大小超过指定大小');       							
	if (!move_uploaded_file($tmp,$data['filepath'].$newname)) return array('error'=>'文件移动失败');
	$info = array(
				"oldname"  =>$oldname, 
				"newname"  =>$newname,   
				"filepath" =>$data['filepath'].$newname,           
				"filesize" =>$filesize,  
				"fileext"  =>$fileext
	);
	return $info;
}


function page_config(){
    $p['rollpage'] = 5; 
	$p['show']     = '';
    $p['parameter']= array();  //页数跳转时要带的参数
	$p['url']      = '';       //分页URL地址
    $p['limit1']   = 0;        //limit1的参数
	$p['limit2']   = 10;       //起始行数
    $p['totalrows']= 0;        //总条数                 
    $p['varpage']  = 'p';   //默认分页变量名
	return $p;
}
 
function geturl($num) {
    $p   = page_config();
	$str = getparam().'&'.$p['varpage'].'='.$num;
	$str = str_replace('?&','?',$str);
	if($num==1) $str = str_replace('&'.$p['varpage'].'='.$num,'',$str);
	return $str;
}

function getparam() {
	$url = '';
	$p   = page_config();
	$parse = parse_url($_SERVER['REQUEST_URI']); 
	if (isset($parse['query'])) {
		parse_str($parse['query'],$params);   #把url字符串解析为数组
		unset($params[$p['varpage']]);               #删除数组下标为page的值
		$url = http_build_query(array_filter($params));     #再次构建url
	}
	return '?'.$url;
}
 
function lib_page($props=array()) {
    $p = page_config();
	if (count($props) > 0) {
		foreach ($props as $k=>$v) {
			$p[$k] = $v;
		}
	}
    $p['totalpages'] = ceil($p['totalrows']/$p['limit2']);    //总页数   
    $p['nowpage']    = max(intval(I($p['varpage'],1)),1);
    if($p['nowpage']>=$p['totalpages']) $p['nowpage'] = $p['totalpages'];
    $p['limit1']     = $p['limit2']*($p['nowpage']-1); 
    if ($p['nowpage']==1) { 
		$p['show'] .= '<span class="disabled" style="font-family: Tahoma, Verdana;"><b>«</b></span>';
		$p['show'] .= '<span class="disabled" style="font-family: Tahoma, Verdana;">‹</span>';    
	} else {	
	    $p['show'] .= '<a style="font-family: Tahoma, Verdana;" href="'.geturl(1).'">«</a>';
		$p['show'] .= '<a style="font-family: Tahoma, Verdana;" href="'.geturl($p['nowpage']-1).'">‹</a>'; 
	}
	if ($p['nowpage'] < $p['rollpage']) $start=1; $end=5;
	if ($p['nowpage'] >= $p['rollpage']){
		$start = $p['nowpage']-2;
		$end   = $p['nowpage']+2;
	}
	$end = $end > $p['totalpages'] ? $p['totalpages'] : $end;
	for ($i=$start;$i<=$end;$i++) {
		if ($i == $p['nowpage']) {
		    $p['show'] .= '<span class="current">'.$i.'</span>';
		} else {
			$p['show'] .= '<a href="'.geturl($i).'">'.$i.'</a>';
		}
	}
	if ($p['nowpage']>=$p['totalpages']) {
		 $p['show'] .= '<span class="disabled" style="font-family: Tahoma, Verdana;">›</span>';
		 $p['show'] .= '<span class="disabled" style="font-family: Tahoma, Verdana;"><b>»</b></span>';
	} else {
	     $p['show'] .= '<a style="font-family: Tahoma, Verdana;" href="'.geturl($p['nowpage']+1).'">›</a>';
		 $p['show'] .= '<a style="font-family: Tahoma, Verdana;" href="'.geturl($p['totalpages']).'"><b>»</b></a>';                           
		  
	}
	$p['show'] .= '  共'.$p['totalpages'].'条 ';
	return $p;
}



if (I('get.act')=='search') {
    $l = D('lottory',array('tel'=>I('get.mobile',0),'limit1'=>0,'limit2'=>20)); 
	if(isset($l[0])) {
	    foreach($l as $k=>$v){
		     echo '于'.$v["adddate"].'抽中('.$v["award_name"].')<br>'; 
		}
		die();
	}
	echo '手机号不存在';
	die(); 
} 

if (I('get.act')=='cjm') {
    $cjm = D('cjm',array('no'=>I('post.verify',0)),1);
	count($cjm['state'])<1 && J('抽奖码不存在'); 
    $cjm['state']>0 && J('抽奖码已经使用过'); 
	S('cjm',I('post.verify',0));
	D('cjm',array('state'=>1),array('no'=>(int)S('cjm')));
	J('验证成功',1); 
	die();
}

//抽奖	
if (I('get.act')=='lottery') {
    
	if(!S('cjm')){  
	
	    $j['msg']    = '请先验证抽奖码在抽奖';     
		$j['res']    = 'needverify';
		$j['rotate'] = 0;
		$j['angle']  = 0;
		J($j,1);
	}
	 
    function getRand($proArr) {        
		$rs = '';                 
		$proSum = array_sum($proArr);  
		foreach ($proArr as $key => $proCur) { 
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$rs = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset($proArr);
		return $rs;
	}
	$prize_arr = array();
	$i = 0;
	foreach(D('award',array('qty >'=>0,'v >'=>0,'order'=>'id')) as $arr=>$row) {
	   $prize_arr[$i]['id']    = $row['id'];
	   $prize_arr[$i]['prize'] = $row['prize'];
	   $prize_arr[$i]['v']     = $row['v'];
	   $i++;
	}
	$arr = array(); 
	foreach ($prize_arr as $k=>$v) { 
		$arr[$v['id']] = $v['v']; 
	} 
	
	$prize_id = (int)getRand($arr);  
	if(S('award_id')) $prize_id = (int)S('award_id');  
 
	S('award_id',$prize_id);
	$d = D('award',array('id'=>$prize_id),1);   
    $j['msg']    = $d['name'];  
	$j['pic']    = $d['pic']; 
	$j['angle']  = (int)$d['rotate'];    
	$j['res']    = (int)$d['rotate'];
	S('rotate',$d['rotate']);
	S('msg',$d['name']);
	S('pic',$d['pic']); 
	J($j,1);	 
} 


//抽奖	
if (I('get.act')=='add') {
    !S('award_id') && J('您没有抽奖奖品');
	$a = D('award',array('id'=>S('award_id')),1);   
	//$d                 = I('post.');
	$d['award_id']     = $a['id'];
	$d['award_name']   = $a['name'];
	$d['award_prize']  = $a['prize'];
	$d['adddate']      = date('Y-m-d');
	$d['addtime']      = date('Y-m-d H:i:s');
	$d['ip']           = sys_ip(); 
	$d['cjm']          = S('cjm');
	$d['name']         = I('post.field1'); 
	$d['tel']          = I('post.field2');
	$d['address']      = I('post.field3'); 
	//$d['address']      = $d['province'].$d['city'].$d['area'].$d['address']; 
    D('lottory',$d,'+');
	D('award',array('qty'=>$a['qty']-1),array('id'=>$a['id']));
	S('rotate',NULL);
	S('msg',NULL);
	S('pic',NULL); 
	S('cjm',NULL); 
	S('award_id',NULL);
	J('提交成功,请等待发奖',1);    
 } 