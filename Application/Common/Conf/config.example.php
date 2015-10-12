<?php
return array(
	'STOP_REPAIR'=>0, //报修系统是否关闭
	// 'SUPER_URL'=>'http://uc.fyscu.com/superlogin',
 //    'UC_LOGIN_URL'=>"http://uc.fyscu.com?appid=1009",
	// 'UC_API'=>"http://uc.fyscu.com/api",
	'SUPER_URL'=>'http://121.41.85.236:9527/superlogin',
    'UC_LOGIN_URL'=>"http://121.41.85.236:9527?appid=1009",
	'UC_API'=>"http://121.41.85.236:9527/api",	
		"APP_ID"=>1009,
	"APP_KEY"=>"xxxxxxxxx",
	'URL_HTML_SUFFIX'       =>  '',  // URL伪静态后缀设置
	'URL_MODEL'=>'2',
	'URL_CASE_INSENSITIVE' =>false,
	'TMPL_FILE_DEPR'=>'_',
	'DEFAULT_MODULE'=>'Home',
	'TMPL_VAR_IDENTIFY'=>'array',
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'localhost',
	'DB_NAME'=>'dbname',//数据库名
	'DB_USER'=>'user',//数据库用户名
	'DB_PWD'=>'123456',//数据库密码
	'DB_PORT'=>3306,
	'DB_PREFIX'=>'fy_',
	'DEFAULT_THEME'=>'Simple',
	'TMPL_L_DELIM'=>'@#',
	'TMPL_R_DELIM'=>'#@',

);

?>
