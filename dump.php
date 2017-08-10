
exit;


file_put_contents('./xbs/tmp/test.log',str_repeat("*****", pow(10,7)));
$arr = array();
if( !isset($_SESSION['tokens']) )
{
    echo "in if" . "<br/>";
    $_SESSION['tokens'] = array(time());
}else{
    echo "in else" . "<br/>";
    $_SESSION['tokens'] = array_merge((array)$_SESSION['tokens'], array(time()));
}

echo print_r($_SESSION['tokens']);
// echo count($arr);
// $res =in_array('1', $arr);
// echo print_r($arr,true);
// die();
// echo "<hr>";

// if($res){
//     echo "yes";
// }else{
//     echo "no";
// }
// die();

// $result = Collection::iterate([1,1], function($v){
//     return [$v[1] , $v[0] + $v[1]];
// })->map('\DusanKasan\Knapsack\first')->take(5)->toArray();

// Collection::from(range(1,100))->average();
// $res = Collection::from(range(1,5))->countBy(function($value){
//     return $value % 2 == 0 ? 'even' : 'odd';
// })->toArray();


// $res = Collection::from([1, 3, 3, 2])->cycle()->take(8)->values()->toArray();
// // $res = Collection::from(range(1,5))->each(function($i){ //echo $i. PHP_EOL;})->toArray();
// $res = Collection::from(range(1,3))->every(function($v){ return $v < 3; } );
// $res = Collection::from([['a' => ['b' => 1]], ['a' => ['b' => 2]], ['c' => ['b' => 3]]])->toArray();
// $res = Collection::from([['a' => ['b' => 1]], ['a' => ['b' => 2]], ['c' => ['b' => 3]]])->flatten()->keys()->toArray();
// $res = Collection::from([1,3,3,2])->filter(function($value){return $value > 2;})->values()->toArray();
// $res = Collection::from(range(1,20))->filter(function($value, $key){ return $value > 2 and $key > 1; })->toArray();
// $res = Collection::from([0, 0.0, false, null, "", []])->filter()->isEmpty();
// $res = Collection::from([1,[2,[3]]])->flatten()->values()->toArray();
// $res = Collection::from(array_merge(range(1,3),range(1,10), range(1,15)))->frequencies()->toArray();
// // $res = Collection::from(range(1,30))->each(function($v){ echo generatePassword(). "<br/>"; })->toArray();

// echo <<<HTML
// <html>
// <head>
// <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
// <link href="http://sandywalker.github.io/webui-popover/dist/jquery.webui-popover.min.css" rel="stylesheet">
// <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/black-tie/jquery-ui.css" type="text/css">
// <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
// <script src="http://malsup.github.com/jquery.form.js"></script> 
// <script src="https://github.com/js-cookie/js-cookie/blob/latest/src/js.cookie.js"></script>
// <script src="https://raw.githubusercontent.com/js-cookie/js-cookie/latest/src/js.cookie.js"></script>
// <script src="https://rawgit.com/jeresig/jquery.hotkeys/master/jquery.hotkeys.js"></script>
// </head>
// <body>
// <div class="col-md-3">
// 					<div class="panel panel-default panel-demo">
//   						<div class="panel-heading">
// 							<a href="#" class="pull-right icon-setup" id="setup" data-placement="right-bottom" data-target="webuiPopover0">
// 								<i class="glyphicon glyphicon-cog"></i>
// 							</a>
//   							WebUI-Popover Demos
//   						</div>
// 						<div class="list-group list-example">
// 							<a href="#specify" class="list-group-item active">
// 							    <h4 class="list-group-item-heading">Specified placement</h4>
// 							    <p class="list-group-item-text">Use the specified placement</p>
// 							</a>
// 							<a href="#auto" class="list-group-item">
// 							    <h4 class="list-group-item-heading">Auto detect placement</h4>
// 							    <p class="list-group-item-text">Auto detect the placement, always poped in page, can be contrained by horizontal or vertical</p>
// 							</a>
// 							<a href="#animation" class="list-group-item">
// 							    <h4 class="list-group-item-heading">Pop with animation</h4>
// 							    <p class="list-group-item-text">Set animation by data-attribute or code</p>
// 							</a>
// 							<a href="#delayed" class="list-group-item">
// 							    <h4 class="list-group-item-heading">Delayed show/hide</h4>
// 							    <p class="list-group-item-text">Control delay show/hide by data-attribute or code</p>
// 							</a>

// 							<a href="#advanced" class="list-group-item">
// 							    <h4 class="list-group-item-heading">Advanced examples</h4>
// 							    <p class="list-group-item-text">table in popover, larget content, async mode, iframe mode</p>
// 							</a>

// 							<a href="#events" class="list-group-item">
// 							    <h4 class="list-group-item-heading">Events</h4>
// 							    <p class="list-group-item-text">show,shown,hide,hidden</p>
// 							</a>
// 						</div>
// 					</div>
// 				</div>


// </body>
// </html>
// HTML;
// exit;

// $var = array(
//     'a simple string' => 'in an array of 5 elements',
//     'a flaot' => 1.0,
//     'an integer' =>1,
//     'a boolean' => true,
//     'an empty array'=>array());

// //dump($var);

// die();
// $redis = new  Redis();
// echo print_r($a, true);
// $redis->connect('127.0.0.1', 6379);
// // echo "<pre>";
// // echo (print_r ( $redis->info(), true));
// echo (print_r( $redis->keys('*'),true));
// // ech "</pre>";

// exit;
// assert_options(ASSERT_ACTIVE, 1);
// assert_options(ASSERT_WARNING, 0);
// assert_options(ASSERT_BAIL,true);
// // assert_options(ASSERT_QUIET_EVAL, 1);
// function assert_failed($file, $line, $expr) {
//     echo "Assertion failed at $file:$line: $code";
//     if ($desc) {
//         echo ": $desc";
//     }
//     echo "\n";
//     // print "Assertion failed in $file on line $line: $expr\n";
// }

// assert_options(ASSERT_CALLBACK, "assert_failed"); 
// assert(true==false,"in reseller info");
// assert(true==false);
// assert(true==true,"......");
// assert('2 < 1');
// assert('2 < 1', 'Two is less than one');
// echo "<br/>";
// echo "*******************************";
// exit;
// // ob_start();
// // echo "-------------" . PHP_EOL;
// // ob_flush();
// // if(function_exists("mt_rand")){
// //     echo "function exists." . PHP_EOL;
// // }

// // $rand_sleep = mt_rand(1,5);
// // usleep($rand_sleep * 100000);
// // echo "---------------" . PHP_EOL;
// // echo $rand_sleep;  
// // exit;
// function generatePassword($length=9, $strength=0) {
//     $vowels = 'aeuy';
//     $consonants = 'bdghjmnpqrstvz';
//     IF ($strength & 1) {
//         $consonants .= 'BDGHJLMNPQRSTVWXZ';
//     }
//     IF ($strength & 2) {
//         $vowels .= "AEUY";
//     }
//     IF ($strength & 4) {
//         $consonants .= '23456789';
//     }
//     IF ($strength & 8) {
//         $consonants .= '@#$%';
//     }
 
//     $password = '';
//     $alt = TIME() % 2;
//     FOR ($i = 0; $i < $length; $i++) {
//         IF ($alt == 1) {
//             $password .= $consonants[(RAND() % STRLEN($consonants))];
//             $alt = 0;
//         } ELSE {
//             $password .= $vowels[(RAND() % STRLEN($vowels))];
//             $alt = 1;
//         }
//     }
//     RETURN $password;
// }
// function send_remote_syslog($message, $component = "web", $program = "next_big_thing") {
//     $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
//     foreach(explode("\n", $message) as $line) {
//         $syslog_message = "<22>" . date('M d H:i:s ') . $program . ' ' . $component . ': ' . $line;
//         socket_sendto($sock, $syslog_message, strlen($syslog_message), 0,'localhost','5120');
//     }
//     socket_close($sock);
// }

// // send_remote_syslog(str_shuffle("abcdedefghijklk"));
// send_remote_syslog( str_shuffle("abcdedefghijklk"));
// exit;

// // # replace PAPERTRAIL_HOSTNAME and PAPERTRAIL_PORT
// // # see http://help.papertrailapp.com/ for additional PHP syslog options

// // function send_remote_syslog($message, $component = "web", $program = "next_big_thing") {
// //     $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
// //     foreach(explode("\n", $message) as $line) {
// //         $syslog_message = "<22>" . date('M d H:i:s ') . $program . ' ' . $component . ': ' . $line;
// //         socket_sendto($sock, $syslog_message, strlen($syslog_message), 0, PAPERTRAIL_HOSTNAME, PAPERTRAIL_PORT);
// //     }
// //     socket_close($sock);
// // }

// // send_remote_syslog("Test");
// // # send_remote_syslog("Any log message");
// // # send_remote_syslog("Something just happened", "other-component");
// // # send_remote_syslog("Something just happened", "a-background-job-name", "whatever-app-name");
// // ?>

// echo str_repeat("*", 80);
// echo send_remote_syslog("test-mansouri");

// exit;
// //$app->route('GET /index.php',function($app){
//     // echo "test";
// // });

// // $app->run();
// echo "<html><!--<meta http-equiv='refresh' content='2,http://localhost/index.php'/>--><head></head><body>";
// $log = new Monolog\Logger('name');
// $log->pushHandler(new Monolog\Handler\StreamHandler('/tmp/app.log', Monolog\Logger::WARNING));
// //$log->addWarning('Foo');

// $collection1 = new Collection([1, 2, 3]);
// //var_dump($collection1);
// //var_dump(Collection::from([1,2,3]));

// //var_dump(Collection::from(new ArrayIterator([1,2,3])));
// /*
// var_dump(Collection::from(function(){
//     foreach([1,2,3] as $value){
//         yield $value;
//     }
// }));
// */
// // $result = Collection::from([1,2])->map(function($v){ return $v * 2; })
//                                  // ->reduce(function($tmp,$v){ return $tmp+$v;},0);
// // var_dump($result);
// // $result = reduce(map([1,2],function($v){ return $v * 2;}),
//                      // function($tmp, $v){ return $tmp + $v;},0
// // );
// class PropertyExample
// {
//     public $publicProperty = 'The `+` prefix denotes a public properties';
//     protected $protectedProperty = 'The `#` denotes protected and `-` private ones';
//     private $privateProperty = 'hovering over a property shows reminder.';
// }

// $var = new PropertyExample();
// // dump($var);

//$client = new Client("https://api.github.com");
// $client = new Client("http://crm5.farahoosh.ir");
// $client->setUserAgent("Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.90 Safari/537.36");
// $request= $client->get('/XBS2/login');
// $response = $request->send();
// echo $response->getBody();
// echo $response->getHeader('Content-length');
// echo $response->getBody();


// var_dump(file_get_contents("https://api.github.com/users/beekalam/events"),true);
// $res = file_get_contents("http://farahoosh.ir/",true);
// echo $res;
// exit;


//https://www.schmengler-se.de/en/2017/02/tdd-kata-08-functions-pipeline/

// function pipe(...$params){
//     return function($input) use($params){
//         foreach($params as $p){
//             $input = call_user_func($p,$input);
//         }
//         return $input;
//     };
// }

function pipe(){
    // get all function arguments
    $numArgs = func_num_args();
    if($numArgs < 2){
        throw InvalidArgumentException('pipe takes 2 or more arguments');
    }
    // assume first argument is the input
    $input = func_get_arg(0);
    // loop in all functions
    $ret = $input;
    for($i=1; $i < $numArgs; $i++){
        $ret = func_get_arg($i)($input);
    }
    //return the results
    return $ret;

    // return function($input) use($params){
    //     foreach($params as $p){
    //         $input = call_user_func($p,$input);
    //     }
    //     return $input;
    // };
}

$f = pipe("test",'strtoupper','strtolower','ucwords');
// echo $f('FOO BAR');
echo $f;
// http://osherove.com/tdd-kata-1/

echo "<hr/></body></html>";
function githubScore($username)
{
    $url="https://api.github.com/users/{$username}/events";
    echo "url: " . $url;
    $events = file_get_contents($url, true);
    var_dump($events);
    exit;

    //get all event types
    $eventTypes=[];

    foreach($events as $event){
        $eventTypes=$event['type'];
    }

    $score = 0;

    foreach($eventTypes as $eventType){
        switch($eventType){
        case 'PushEvent':
            $score +=5;
            break;
        case 'CreateEvent':
            $score +=4;
            break;
        case 'IssueEvent':
            $score += 3;
            break;
        case 'CommitCommentEvent':
            $score += 2;
            break;
        default:
            $score +=1;
            break;
        }
    }

    return $score;
}

//echo githubScore('beekalam');

class ArrayCollection extends \ArrayIterator
{
    public static function fromArray(array $array)
    {
        return new static($array);
    }

    public static function fromTraversal(\Traversal $traversable)
    {
        return new static(\iterator_to_array($traversable));
    }

    /**
     * @param callable $callback
     * @return static
     */
    public function map(callable $callable)
    {
        return new static(\array_map($callable, $this->getArrayCopy(), $this->keys()->getArrayCopy()));
    }

    public function filter(callable $callable)
    {
        return new static(\array_filter($this->getArrayCopy(), $callback));
    }

    public function reduce(callable $callable, $initial = null)
    {
        return new static(\array_reduce($this->getArrayCopy(), $callback, $initial));
    }
}
/*
error_reporting(E_ALL);
if(isset($_GET['num'])){
    $num = $_GET['num'];
    $res = "f-1." . base64_encode("c=t&uid=" . $num);
    echo $res;
    exit;
}

$url="http://localhost/xbs-res/usersearch";


//$action = $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
$action =  $_SERVER['PHP_SELF'];

print <<<HTML
<html>
<head>
</head>
<body>
<form method="GET" action='{$action}'>
<input type="text" id="num" name="num" value="" style="width:50%;"/>
<input type="submit"/>
</form>
</body>
</html>
HTML;
*/

function stringCalculator(){
   
}

/*
////////////////////////////////////////////////////////

// Domain name to check
//$domainName = "http://www.farahoosh.ir" ;
//var_export($domain_name);
 
// function DomainCheck($domain_name){
//     $start_time = microtime(TRUE);
//     $openDomain = fsockopen ($domain_name, 80, $errno, $errstr, 10);
//     $end_time  = microtime(TRUE);
//     $server_status    = 0;
 
//     if (!$openDomain){
//         $server_status = -1;  
//     }else{
//         fclose($openDomain);
//         $status = ($end_time - $start_time) * 1000;
//         $server_status = floor($server_status);
//     }
//     return $server_status;
// }
 
// $server_status = DomainCheck($domain_name);
 
 
// if ($server_status != -1) {
//   print "Cannot reach the server." ;
// }else{
//   print "Server is responding properly." ;
// }

// ini_set('error_reporting', E_ALL | E_STRICT);
// ini_set('display_errors', 'On');


// set_error_handler('my_error_handler');
//     function my_error_handler($number, $string, $file, $line, $context)
//     {
//       $error = "=  ==  ==  ==  ==\nPHP ERROR\n=  ==  ==  ==  ==\n";
//       $error .= "Number: [$number]\n";
//       $error .= "String: [$string]\n";
//       $error .= "File:   [$file]\n";
//       $error .= "Line:   [$line]\n";
//       $error .= "Context:\n" . print_r($context, TRUE) . "\n\n";
//       // error_log($error, 3, '/usr/local/apache/logs/error_log');
//     }

// //A basic exception handler would look similar to this:
// function handleMissedException($e) {
//   echo "Sorry, something is wrong. Please try again, or contact us if the problem persists";
//  // error_log('Unhandled Exception: ' . $e->getMessage() . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
// }
// set_exception_handler('handleMissedException');


// echo date('s');

// echo str_repeat("xxxxxxx", 10) . "<br/>";

// class ParsShahkarError
// {
//     private $res = '';
//     private $error = '';

//     function __construct($error){
//         $this->error = $error;
//         $this->parse();
//     }
    
//     private function parse()
//     {
//          $okToContinue = is_string($this->error);
//          if(!$okToContinue)
//          {
//              return;
//          }

//         $errorNames = ["RequiredField" => "وارد نشده است ", "InvalidField" => "مقدار نامعتبر "];
//         $errorValues = ["fatherName" => "نام پدر", "certificateNo" =>"شماره شناسنامه", "name" => "نام",
//                        "family" => "نام خانوادگی","birthDate" =>"تاریخ تولد" , "service.wirelessId" => "wirelessid",
//                        "identificationNo" => "شماره ملی",
//                         "address" => "آدرس"];

//         $errors  =  explode(";",$this->error);
//         if(count($errors) > 0){
//             foreach($errors as $err){
//                 $sub = explode(':', $err);
//                 $errorName  = $sub[0];
//                 $errorValue = $sub[1];
//                     if(isset($errorValues[$errorValue])){
//                     $this->res .= $errorValues[$errorValue];
//                 }else{
//                     $this->res .= $errorValue;
//                 }

//                 if($errorName == 'RequiredField')
//                 {
//                     $this->res .= $errorNames[$errorName];
//                 }
//                 else if($errorName == 'InvalidField')
//                 {
//                     $this->res .= $errorNames[$errorName];
//                 }

//                 $this->res .= "<br/>";
//             }
//         }

//     }

//     public function toString()
//     {
//         return $this->res;
//     }

//     public function __toString()
//     {
//       return $this->res;
//     }
// }

// $c = new ParsShahkarError("RequiredField:fatherName;");
// echo (strlen((string)$c) > 0) ? "success" : "false";
// echo "<br/>";

// $c  = new ParsShahkarError("InvalidField:fatherName");
// echo (strlen((string)$c) > 0) ? "success" : "false";
// echo "<br/>";

// $c  = new ParsShahkarError("InvalidField:M");
// echo (strlen($c) > 0) ? "success" : "false";

// try{
//   $c = new ParsShahkarError("");
//   var_dump($c);
// }catch(Exception $e){
//   echo $e;
// }


// echo ((string)$c) == ''
// echo "test";
// var_dump($c);
// echo $c->result();
//var_dump( split(";","RequiredField:fatherName;RequiredField:certificateNo") );


/////////////////////

function humanNetworkSpeed($traffic_in_bits){
    if ($traffic_in_bits == 0)
    {
        $out_arr = array();
        $out_arr["traffic"] = 0;
        $out_arr["unit"] = "Kb";
        return $out_arr;
    }

    $out = abs($traffic_in_bits);
    $unit = "b";
    if ($out >= 1000){
      $out = $out / 1000;
      $unit = "Kb";

      if ($out >= 1000)
      {
          $out = $out/1000;
          $unit = "Mb";

          if ($out >= 1000)
          {
              $out = $out/1000;
              $unit = "Gb";

              if ($out >= 1000)
              {
                  $out = $out/1000;
                  $unit = "Tb";
              }

          }
      }
  }

    $out_arr = array();
//    $out_arr["traffic"] = round($out,3);
    $out_arr["traffic"] = $out;
    $out_arr["unit"] = $unit;
    return join(' ', $out_arr);
}


// echo humanNetworkSpeed(1025);

/*
$json=<<<JSON
{
  "package_status": {
    "has_package": true,
    "remain_traffic_org": 5,
    "max_traffic_org": 1048576,
    "package_validity": "366",
    "current_pck_fi": 0,
    "consumed_traffic_org": 1048571,
    "current_pck_name": "gift",
    "current_pck_id": 11859,
    "has_unlimited_traffic": false
  },
  "online_status": false,
  "attrs": {
    "can_use_promotion": "none",
    "last_renew_package_gregorian": "2016-12-28 20:42",
    "normal_username": "M-mansori",
    "user_id": 109687,
    "abs_exp_date_unit": "jalali",
    "package": "gift",
    "first_login": "1395-10-12 18:04",
    "nearest_exp_date": "1396-10-12 18:04",
    "normal_charge": "gift",
    "rel_exp_date": 366,
    "last_renew_package": "1395-10-08 20:42",
    "rel_exp_date_unit": "Days",
    "nearest_exp_date_epoch": 1514903649,
    "mcode": "5139953323",
    "last_renew_package_unit": "jalali",
    "time_to_nearest_exp_date": 26082445.901286,
    "abs_exp_date": "1400-12-29 16:52"
  },
  "basic_info": {
    "group_name": "gift",
    "credit": 0.00488281,
    "res_name": "main",
    "owner_name": "main",
    "user_id": 109687,
    "loc_name": "Shiraz",
    "res_id": 54,
    "group_id": 36,
    "creation_date": "1395-10-08 20:40",
    "owner_id": 46
  },
  "full_name": "-",
  "comments": "دفتر",
  "email": "-",
  "technician": "-",
  "has_old_log": "1",
  "old_log_path": "http://user.farahoosh.ir",
  "old_system": "IBSng",
  "gender": "",
  "id_card_number": "",
  "country": "",
  "birth_date": "1364/04/31",
  "user_address": "",
  "mobile_number": "9359012419",
  "phone_number": "",
  "fname": "محمد رضا",
  "lname": "منصوری",
  "nationality": "ایرانی",
  "province": "",
  "city": "",
  "father_name": "امیر",
  "id_type": "0",
  "cert_no": "69",
  "shahkar_create": "YES",
  "factor_type": "base_package",
  "can_use_promotion": "second",
  "reseller_info": {
    "0": {
      "res_id": 54,
      "res_parent_id": 1,
      "res_name": "main",
      "res_desc": "",
      "res_status": "",
      "creator_id": 0,
      "res_deposit": "0"
    },
    "crm_attrs": {
      "reseller_benefit_percent": "0",
      "user_panel_template": "default_template",
      "user_panel_title": "دفتر مرکزی",
      "users_panel_contact_info": "شماره تماس دفتر مرکزی:3207",
      "tax_percent": "9",
      "reseller_payment_limit": "0",
      "bank_gateway": "mellat_bank",
      "reseller_acounting_type": "sale_percent",
      "users_can_change_password": "0",
      "default_ippool": "vpn",
      "default_exp_group_id": "group_fail",
      "reseller_name": "دفتر مرکزی",
      "default_owner_admin": "main",
      "user_factor_header": "شرکت فراهوش دنا",
      "user_factor_footer": "دارای مجوز سروکو به شماره 16-95-100 از سازمان تنظیم مقررات و ارتباطات رادیویی"
    },
    "perms": [
      false
    ]
  },
  "factor": {
    "package": {
      "_pck_creator": 0,
      "_pck_type": "Package",
      "_pck_parent_id": -1,
      "_pck_id": 12058,
      "_pck_fi": 330000,
      "_zir_pcks": [],
      "_pck_reseller_name": "test",
      "_pck_nikname": "2 مگابیت 3 ماهه 3 گیگ",
      "_pck_unit": "MBytes",
      "_pck_res_id": 44,
      "_pck_name": "ECO_2048_03_003",
      "_pck_attr_names": [],
      "_pck_parent_name": "",
      "_pck_attrs": {
        "pck_traffic_amount": "3145728",
        "pck_promotion_group": "B-2048-silver",
        "pck_expire_group": "group_fail",
        "pck_expire_type": "Calculate Expire From Renew Time",
        "pck_promotion_price": "150000",
        "pck_reseller_price": "",
        "pck_default_group": "A-2048-Gold",
        "pck_emergency_traffic": "200",
        "pck_reseller_amount": "",
        "pck_validity_duration": "93",
        "pck_convert_as": "1",
        "pck_has_unlimited_traffic": "False",
        "is_periodic": "no"
      },
      "crm_info": {
        "pck_crm_desc": "",
        "pck_crm_pic": "",
        "pck_crm_speed": "2048",
        "pck_crm_due": "سه ماهه",
        "pck_crm_traffic": "3 گیگ",
        "pck_crm_tags": "سرویس های حجمی-2Mb",
        "pck_crm_sub_tags": "2 مگابیت",
        "pck_crm_show_priority": "",
        "pck_crm_show_sub_priority": "",
        "pck_crm_second_promotion_title": "شبانه نامحدود",
        "pck_crm_second_promotion_desc": "از ساعت 3 تا 8 بامداد"
      }
    },
    "factor_number": 10061628,
    "jalali_date": "1395/12/16",
    "promotion_price": "150000",
    "promotion_group": "B-2048-silver",
    "can_use_promotion": "second",
    "new_package_fi": 523200,
    "user_current_package_value": 0,
    "user_bes_before_factor": 0,
    "user_bed_before_factor": 0,
    "change_balance": 0,
    "to_pay": 523200,
    "db_balance": 0,
    "final_balance": 0,
    "factor_tax": 43200,
    "tax_percent": 9,
    "absolute_package_fi": 480000,
    "package_nikname": "2 مگابیت 3 ماهه 3 گیگ",
    "package_type": "Package",
    "total_traffic_org": 1048576,
    "remain_traffic_org": 5,
    "remain_days": 302,
    "deference_between_current_pkg_value_and_new_pkg_value": 523200
  },
  "extra_traffic": 0,
  "i": 0,
  "has_unlimited_traffic": false,
  "payment_url": "http://94.74.128.17/AAA/modules/user/U_user_send_to_bank.php?xapi=CRM5_94_74_128_22&xtik=eyJ0eXAiOiJKV1MiLCJhbGciOiJIUzI1NiIsImp0aSI6IjRmMWcyM2ExMmFhIn0.eyJpc3MiOiI5NC43NC4xMjguMjkiLCJhdWQiOiJBVURJRU5DRSIsImp0aSI6IjRmMWcyM2ExMmFhIiwiaWF0IjoxNDg4ODE3ODI5LCJuYmYiOjE0ODg4MTc4MjksImV4cCI6MTQ4ODkwNDIyOSwidWlkIjoicWI1N251dGltbWI4bXRhYnN2YjA3aGRjODIifQ.O1piJEch7F3HGdusXmh9nTEEu29_ymYS4UzZrc6gSpg.027d53250014c0005f061bb7acda7798.8fe48d7e857ab62c46b238d8aa972a19&pkg=12058&c="
}
JSON;

// var_dump(json_decode($json));


function squash($array, $prefix = '')
{
    $flat = array();
    $sep = ".";
    
    if (!is_array($array)) $array = (array)$array;
    
    foreach($array as $key => $value)
    {
        $_key = ltrim($prefix.$sep.$key, ".");
        
        if (is_array($value) || is_object($value))
        {
            // Iterate this one too
            $flat = array_merge($flat, squash($value, $_key));
        }
        else
        {
            $flat[$_key] = $value;
        }
    }
    
    return $flat;
}

var_dump(squash(json_decode($json)));
/*
class ExtendedArrayObject extends ArrayObject
{
    private $_array;

    public function __construct()
    {
        if (is_array(func_get_args(0)))
            $this->_array = func_get_arg(0);
        else
            $this->array = func_get_args();
        parent::__construct($this->_array);
    }

    public function each($callback)
    {
        $iterator = $this->getIterator();
        while ($iterator->valid()) {
            $callback($iterator->current());
            $iterator->next();
        }
    }

    public function without()
    {
        $args = func_get_args();
        return array_values(array_diff($this->_array, $args));
    }

    public function first()
    {

        return $this->_array[0];
    }

    public function indexOf($value)
    {
        return array_search($value, $this->_array);
    }

    public function inspect()
    {
        echo "<pre>" . print_r($this->array, true) . "</pre>";
    }

    public function last()
    {
        return $this->_array[count($this->_array) - 1];
    }

    public function reverse($applyToSelf = false)
    {
        if (!$applyToSelf)
            return array_reverse($this->_array);
        else {
            $_array = array_reverse($this->_array);
            $this->_array = $_array;
            parent::__construct($this->_array);
            return $this->_array;
        }
    }

    public function shift()
    {
        $_element = array_shift($this->_array);
        parent::__construct($this->_array);
        return $_element;
    }

    public function pop()
    {
        $_element = array_pop($this->_array);
        parent::__construct($this->_array);
        return $_element;
    }
}

function speak($value)
{
    echo $value;
}

//$newArray = new ExtendedArrayObject(array(1,2,3,4,5,6));
//$newArray = new ExtendedArrayObject(1,2,3,4,5,6);

?>
<html>

<body>
test content
</body>
</html>
*/

