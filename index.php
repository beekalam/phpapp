<?php
//region init
error_reporting(E_ALL);
// echo phpinfo();
// ini_set('default_socket_timeout',   120);
// ini_set('assert.active', 'On');
// ini_set('assert.active', 1);
// ini_set('zend.assertions','1');
// ini_set('assert.exception','1');
// echo "test";
session_save_path( dirname(__FILE__) . '/tmp/sessions');
ini_set('session.gc_probability', 1);
require __DIR__ . '/vendor/autoload.php';
require "utils.php";
require "Generators.php";

use Guzzle\Http\Client;
use DusanKasan\Knapsack\Collection;
use DusanKasan\Knapsack\first;
use Symfony\Component\Console\Application;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;
Debug::enable();
ErrorHandler::register();
ExceptionHandler::register();
DebugClassLoader::enable();

$app =Base::instance();

$loader = new Twig_Loader_Filesystem(__DIR__ . DIRECTORY_SEPARATOR .'templates');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__ . DIRECTORY_SEPARATOR .'templates' . DIRECTORY_SEPARATOR ."cache",
    'auto_reload' => true
));

$app->set('DEBUG', 3);
$app->set('twig',$twig);
$app->set('UI','templates/');


//endregion

$app->set("current_user_can",function($args)
{
	var_dump($args);
	exit;
	
	
});
//region GET /
$app->route("GET /", function($app)
{
    $myvar = 123;
    $app->current_user_can("can_read_th");
    // echo preview::instace()->render('test.php','php',array("myvar"=> $myvar));
	//$app->reroute("home");
});
//endregion

//region GET /renderfactor
$app->route("GET /renderfactor", function($app)
{
    // $package = __DIR__."/render/render_factor.php";
    // echo $package;
    echo view::instance()->render(__DIR__."/render/render_factor.php");
});
//endregion

//region GET /index
$app->route("GET /index",function($app)
{
		// $var =  $app->get("SESSION.doesnotexists");
		// if($var && $var=='123')
		// {
		// 	echo "var is defined";
		// }
		// exit;
		$content =  $app->get('twig')->render('index.html', array('name' => 'Fabien',"app" => $app));
		echo $content;
});
//endregion

//region GET /home
$app->route("GET /home", function($app)
{
	$links = [
		  "/test/index",
		 "/test/home",
		 "/test/valid-mcode",
		 "/xbs",
		 "/xbs-res",
		 "http://crm5.farahoosh.ir/XBS2",
		 "http://crm.farahoosh.ir/XBS2",
		 "http://crm.farahoosh.ir/AAA",
		 "http://crm5.farahoosh.ir/AAA",
		 "http://crm5.farahoosh.ir/AAA2/",
		 "http://crm.farahoosh.ir/AAA2/",
		 "http://crm.farahoosh.ir/AAA2/tail",
		 "http://crm.farahoosh.ir/AAA2/xbstail",
		 "http://crm5.farahoosh.ir/AAA3/",
		 "http://crm.farahoosh.ir/AAA3/",
		 "http://crm.farahoosh.ir/AAA3/tail",
		 "/uplon/uplon-org/themeforest-16607656-uplon-responsive-bootstrap-4-web-app-kit/Admin/PHP/",
		 "http://crm5.farahoosh.ir/AAA2/userinfo/120625",
		 "http://crm5.farahoosh.ir/AAA2/userinfo/105157",
		 "http://crm.farahoosh.ir/AAA2/userinfo/122910",
		 "http://crm5.farahoosh.ir/AAA2/userinfo/106301",
		 "http://crm.farahoosh.ir/AAA2/userinfo/69623",
		 "http://crm5.farahoosh.ir/AAA2/userinfo/86967",
		 "http://crm5.farahoosh.ir/AAA2/package-manager/11932",
		 "/toothpaste/",
		 "http://crm5.farahoosh.ir/AAA2/tail",
		 "http://crm5.farahoosh.ir/AAA2/xbstail",
		 "http://24.farahoosh.ir",
          "http://94.74.128.19/XBS/admin",
          "http://crm19.farahoosh.ir/AAA3/packagelistl",
		 "/smartadmin1.5.2",
		 "/bek/index.html",
		 "/test/base64-encode-decode",
		 'http://www.tabnak.ir/fa/news/339296/%D8%A7%D8%B3%D9%86%D8%A7%D8%AF-%DA%A9%D9%88%D8%AF%D8%AA%D8%A7%DB%8C-28-%D9%85%D8%B1%D8%AF%D8%A7%D8%AF-%D8%A7%D9%88%D9%84%DB%8C%D9%86-%D8%A8%D8%A7%D8%B1-%D8%AF%D8%B1-%D8%AA%D8%A7%D8%A8%D9%86%D8%A7%DA%A9-%D9%85%D9%86%D8%AA%D8%B4%D8%B1-%D8%B4%D8%AF-%D9%81%D8%A7%DB%8C%D9%84-%D8%A7%D8%B3%D9%86%D8%A7%D8%AF'
          ,
          'ftp://192.168.1.100:3721/'
	];
	
		
	// echo $app->get("twig")->render('home.html', array('links' => $links, 'hive' => $app->hive()));
	$app->set("links", $links);
	$app->set("content", "templates/_links.htm");
	echo view::instance()->render("templates/layout.htm");
});
//endregion

//region GET /valid-mcode
$app->route("GET /valid-mcode",function($app)
{
	
	function ab_mc($vmc)
	{
			 $mc = $vmc;
			
			if( 10 != strlen($mc) )
				return false;
			if("1111111111" == $mc||"0000000000"== $mc||"2222222222"== $mc||"3333333333"== $mc||"4444444444"== $mc|| 
				"5555555555"== $mc||"6666666666"== $mc||"7777777777"== $mc||"8888888888"== $mc||"9999999999"== $mc)
				return false;
				
				$c = intval($mc[9]);
				$n = 10 * intval($mc[0]) +
					 9 * intval($mc[1] ) + 
					 8 * intval($mc[2] ) + 
					 7 * intval($mc[3] ) +
					 6 * intval($mc[4] ) + 
					 5 * intval($mc[5] ) + 
					 4 * intval($mc[6] ) + 
					 3 * intval($mc[7] ) +
					 2 * intval($mc[8] ) ;
							   
				$r= $n - 11 * intval($n/11);
				
				if( (0==$r && $r==$c) || (1==$r && 1== $c) || ($r > 1 && $c== 11 - $r) )
					return true;
								
				return false;
	}
	foreach( range(1,10) as $k)
	{
		do{
			$num = mt_rand(5139953323, 9999999999);
			//echo $count++ . "<br/>";
		}while(! ab_mc(strval($num)) );
		echo $num;
		echo "<hr/>";
	}
	
});
//endregion

//region GET /phpinfo
$app->route('GET /phpinfo', function($app)
{
	// writeln("extension dir: " . extension_dir());	
	// writeln("ini path: " . default_ini_path());
	// writeln("ini filename: " . ini_file_name());
	//exit;
	phpinfo();
	exit;
	//echo uname();
});
//endregion

//region GET /tails
$app->route('GET /tails', function($app)
{
	
	echo <<<HTML
			<html><body>
				<iframe src='http://crm5.farahoosh.ir/AAA2/tail' style='width:100%; height:400px;'></iframe>
				<iframe src='http://crm5.farahoosh.ir/AAA2/tail' style='width:100%; height:400px;'></iframe>
			</body>
			</html>
HTML;
	//exit;
	//echo uname();
});
//endregion

//region GET /test
$app->route('GET /test', function($app)
{
	function commify_series($list)
	{
	  $n = str_word_count($list); $series = str_word_count($list, 1);

	  if ($n == 0) return NULL;
	  if ($n == 1) return $series[0];
	  if ($n == 2) return $series[0] . ' and ' . $series[1];
	  
	  return join(', ', array_slice($series, 0, -1)) . ', and ' . $series[$n - 1];
	}

	// ----------------------------------------------------------------------------------

	echo commify_series('red') . "\n";
	writeln();
	echo commify_series('red yellow') . "\n";
	writeln();
	echo commify_series('red yellow green') . "\n";
	writeln();
	$mylist = 'red yellow green';
	echo 'I have ' . commify_series($mylist) . " marbles.\n";
});
//endregion

//region GET /whois/ip/@ip
$app->route('GET /whois/ip/@ip', function($app, $params)
{
	require_once "./lib/Socket.class.php";
	require_once "./lib/Http.class.php";
	require_once "./lib/telnet.class.php";
	require_once "./lib/whois_ip.class.php";
	require_once './lib/RTG.php';

	$ip = $params['ip'];

	$res =	 whois_ip::whois($ip);
	// Print CSS styles for HTML Table
	echo '<style>';
	echo RTG::css();
	echo '</style>';
	RTG::table($res,true);
	
});
//endregion

//region 
$app->route('GET /whois/domain/@domain',function($app, $params)
{
	require_once "./lib/Socket.class.php";
	require_once "./lib/Http.class.php";
	require_once "./lib/telnet.class.php";
	require_once "./lib/whois_ip.class.php";
	require_once './lib/RTG.php';
	// $http = new Http(true);
	// $socket = $http->open("192.168.1.1");
	// $res = $http->read($socket);
	// var_dump($res);
	
	
	// $http->read_head($socket);
	// var_dump($res);
	// $http->read_body($socket);
	// var_dump($res);
	//////////////////////////////////////////
	

	// Example array
	$array = array
	(
	    'key_1' => 'Value 1',
	    'key_2' => 'Value 2',
	    'bool_Test' => TRUE,
	    'null_Test' => NULL,
	    'array_test' => array
	    (
	        'Value 1',
	        'Value 2',
	    ),
	);

	// Print CSS styles for HTML Table
	echo '<style>';
	echo RTG::css();
	echo '</style>';

	// Print HTML Table for array
	RTG::table($array, TRUE);

	// Build Table with return as string
	$table = RTG::table($array, FALSE);

	// Build Table with custom CSS
	$table = RTG::table($array, FALSE, array('width' => '750px'));
	exit;
	$telnet = new Telnet("192.168.1.1");
	try
	{
		if($telnet->connect())
		{
			// echo $telnet->exec("show all");
			echo 'succesfuly connected....';
		}else{
			writeln("could not connect");
		}

	}catch(Exception $e)
	{
		echo "could not continue.";
	}
});

$app->route('GET /test123',function($app, $params)
{
	require_once "./lib/Socket.class.php";
	require_once "./lib/Http.class.php";
	require_once "./lib/telnet.class.php";
	require_once "./lib/whois_ip.class.php";
	require_once './lib/RTG.php';
	// $http = new Http(true);
	// $socket = $http->open("telnet://192.168.1.1");
	// $res = $http->read($socket);
	// var_dump($res);
	
	// $http->read_head($socket);
	// var_dump($res);
	// $http->read_body($socket);
	// var_dump($res);
	//////////////////////////////////////////
		if(!function_exists('fsockopen')) 
		{
			die("fsockopen function is not enabled"); 
		}

		$telnet = null;
		$telnet = new Telnet("192.168.1.1");
		$telnet->setPrompt("TP-LINK>");
		if($telnet->login("admin","shivaalihamid"))
		{
			// echo $telnet->exec("show all");
			echo 'succesfuly connected....';
			echo "<br/>";
			echo nl2br($telnet->exec("ip route status"));
			echo str_repeat("-", 100) . "<br/>";
			echo nl2br($telnet->exec("show wan status"));
			echo str_repeat("-", 100) . "<br/>";
			echo nl2br($telnet->exec("show lan status"));
			echo str_repeat("-", 100) . "<br/>";
			echo nl2br($telnet->exec("show cpe"));
			
			
		}else
		{
			writeln("could not connect");
		}

	try
	{

	}catch(Exception $e)
	{
		var_dump($e);
	}
	
});
//endregion
//region GET /session
$app->route('GET /session', function($app)
{	
	
    $start= microtime_float();
	session_start();
	if( !isset($_SESSION['csrf']) ){
		echo "session is not set";
		$_SESSION['csrf'] = array();
	}else{
		echo "appending sth to csrfs";
		for($var=0; $var < 50;++$var){
			$_SESSION['csrf'][] = md5(uniqid(mt_rand(), true));
		}
		if(in_array("ece93aecc55f0e96d958cac90e415cc3", $_SESSION['csrf']) ){
			echo "found needle";
		}
	}
	$end = microtime_float()  - $start;
	echo "time taken: " . $end;
	//dump($_SESSION['csrf']);
	//session_destroy();
});
//endregion

//region GET /base64-encode-decode
$app->route('GET /base64-encode-decode',function($app)
{
	$app->set("result", "");
	$app->set("show_encode", true);
	$app->set("content", "templates/base64-encode-decode.htm");
	echo view::instance()->render("templates/layout.htm");
});
//endregion

//region POST /base64-encode-decode
$app->route('POST /base64-encode-decode',function($app)
{
	$string = $app->get("POST.string");
	if(is_base64($string))
	{
		$app->set("result", base64_decode($string));
		$app->set("show_encode", true);
	}
	else
	{
		$app->set("result", base64_encode($string));
		$app->set("show_encode", false);
	}

	$_SESSION["base64_encode_decode"] = "";
	$app->set("content", "templates/base64-encode-decode.htm");
	echo view::instance()->render("templates/layout.htm");
});
//endregion

//region GET /uuid
$app->route('GET /uuid',function($app)
{
	function gen_uuid()
	{
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,

	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}
	$app->set("uuid", gen_uuid());
	$app->set("result", "");
	$app->set("content", "templates/uuid.htm");
	echo view::instance()->render("templates/layout.htm");
});
//endregion

//region GET /delimiter
$app->route('GET /delim', function($app)
{
	$app->set("js_includes",	array($app->get("BASE") . "/ui/jquery-linedtextarea/jquery-linedtextarea.js" ) 	);
	$app->set("css_includes", 	array($app->get("BASE") . "/ui/jquery-linedtextarea/jquery-linedtextarea.css")	);
	$app->set("content","templates/delim.htm");
	echo view::instance()->render('templates/layout.htm');
});
//endregion

//region GET /text-process/@operation
$app->route('GET /text-process/@operation', function($app, $params)
{
	$operation = $params['operation'];
	$data = $_GET['data'];
	$operation = explode('/n',',');
	$success = false;

	switch ($params['operation'])
	{
		case "commify":
			$success = true;
			$data = join(preg_split('/\n/',$data),",");
			break;
		case "uncommify":
			$success = true;
			$data =join(explode(',',$data), "\n");
			break;
		case "replace":
			$success = true;
			$from 	= sprintf("%s", $_GET['from']) ;
			$to 	= sprintf("%s", $_GET['to']);
			// $data 	= sprintf("from: %s,  to: %s, data: %s", $from, $to, $data);
			$data = str_replace($from,$to, $data);
			break;
		default:
			$data = "no operation provided.";
			$sucess = false;
			break;
	}

	echo json_encode(array("success" => $success, "data" => $data ));
});
//endregion


//region crontab-generator
$app->route("GET /crontab-generator", function($app, $params)
{
	// https://crontab-generator.org/
	//fixme js validations https://crontab-generator.org/assets/js/app.js?
	$app->set("content","templates/crontab-generator.htm");
	echo view::instance()->render('templates/layout.htm');
});
//endregion

//region POST /crontab-generator
$app->route("POST /crontab-generator", function($app, $params)
{
	$res = '';
	$minutes=$hours=$days=$months=$weekdays=$command = $output= '';
	if($_POST['minutes'] != 'select')
	{
		$minutes = $_POST['minutes'];
	}else
	{
		$minutes = join( $_POST['selectMinutes'],',');
	}

	if($_POST['hours']  != 'select')
	{
		$hours = $_POST['hours'];
	}else
	{
		$hours = join( $_POST['selectHours'],',');
	}

	if($_POST["days"] != 'select')
	{
		$days = $_POST['days'];
	}else
	{
		$days = join( $_POST['selectDays'], ',');
	}

	if($_POST['months'] != 'select')
	{
		$months = $_POST['months'];
	}else
	{
		$months = join ( $_POST['selectMonths'] );
	}

	if($_POST['weekdays'] != 'select')
	{
		$weekdays = $_POST['weekdays'];
	}else
	{
		$weekdays = join ( $_POST['selectWeekdays'] );
	}

	if($_POST["output"] == '1')
	{
		$output = ' >/dev/null 2>&1';
	}

	if($_POST['output'] == '2')
	{
		$output = ' > ' . $_POST['filePath'];
	}
	$command = $_POST['command'];

	$cron_string =  sprintf("%s %s %s %s %s %s %s",$minutes, $hours, $days, $months, $weekdays, $command , $output);
	$app->set("content","templates/crontab-generator.htm");
	$app->set("cron_string", $cron_string);
	echo view::instance()->render('templates/layout.htm');
});
//endregion

$app->route("GET /json-formatter", function($app, $params)
{
	$app->set("content","templates/json-formatter.htm");
		$test = <<<JSON
{
   "anObject": {
      "numericProperty": -122,
      "stringProperty": "An offensive \" is problematic",
      "nullProperty": null,
      "booleanProperty": true,
      "dateProperty": "2011-09-23"
   },
   "arrayOfObjects": [
      {
         "item": 1
      },
      {
         "item": 2
      },
      {
         "item": 3
      }
   ],
   "arrayOfIntegers": [
      1,
      2,
      3,
      4,
      5
   ]
}
JSON;
$s = new stdClass;
$s->a=array(1,2,3);
$s->b = new stdClass;
$s->c = array(3,4,4);
// echo "<pre>" . json_decode($test, JSON_PRETTY_PRINT) . "<pre>";
//echo sprintf("<pre>%s</pre>", json_encode($s, JSON_PRETTY_PRINT) );
$out = json_encode($s,JSON_PRETTY_PRINT);
// $out = str_replace("[", sprintf("<span class='%s'>%s</span>", "json-open-bracket","["), $out);
// $out = str_replace("]", sprintf("<span class='%s'>%s</span>", "json-close-bracket","]"), $out);
// $out = str_replace(": ", sprintf("<span class='%s'>: </span>", "json-semi-colon"), $out);

// $out = str_replace("{}", sprintf("<span class='%s'> {} </span>", "json-empty-object"), $out);
// $out = str_replace("{", sprintf("<span class='%s'>%s</span>", "json-open-bracket","{"), $out);
// $out = str_replace("}", sprintf("<span class='%s'>%s</span>", "json-close-bracket","}"), $out);
// $out = preg_replace("/(.*: )({)(\s+)/", '${1}<span class="">{</span>${3}', $out);
// $out = preg_replace("/^\{/", '${1}<span class="json-open-bracket">{</span>${3}', $out);
// $out = preg_replace("/^(\})(\s*)/", '${1}<span class="json-close-bracket">}</span>${2}', $out);
// $out = preg_replace("/(\s*)(])(\s*)/", '${1}<span class="json-close-bracket">]</span>${3}', $out);
// $out = str_replace("{","{\n", $out);
// $out = preg_replace("/(\.*: )({)([ a-zA-Z0-9])/", '${1}<span class="json-open-bracket">{</span>${3}', $out);
// $out = preg_replace("/(\.*)(})(,\s*)/", '${1}<span class="json-close-bracket">}</span>${3}', $out);
echo $out;exit;
	// echo view::instance()->render('templates/layout.htm');	
});

//region POST

// $app->route('GET /view', function($app)
// {
// 	$vm = array('title'=>'some title','date'=> time(), 'footer' => "my footer");
// 	$_SESSION['start']=time();
// 	echo view::instance()->render('factor_render.php','',$vm);
// });

$app->run();
