<?php

function default_ini_path()
{
    return (realpath($_SERVER['DOCUMENT_ROOT']));
}

function extension_dir()
{
	$extdir = ini_get('extension_dir');
	if ($extdir == './' || ($extdir == '.\\' && is_ms_windows())) {
		$extdir = '.';
	}
	return $extdir;
}

function writeln($line_in='') 
{
   echo $line_in."<br/>";
}

function php_version()
{
    $v = explode('.',PHP_VERSION);

    return array(
           'major'      =>  $v[0],
           'minor'      =>  $v[1],
           'release'    =>  $v[2]);
}

function php_version_maj_min()
{
    $vprts = php_version();
    return ($vprts['major'] . '.' . $vprts['minor']);
}

function ini_file_name()
{
    $sysinfo = get_sysinfo();
    return (!empty($sysinfo['PHP_INI'])?$sysinfo['PHP_INI_BASENAME']:'php.ini');
}

function get_file_contents($file)
{
    if (function_exists('file_get_contents')) {
        $strs = @file_get_contents($file);
    } else {
        $lines = @file($file);
        $strs = join(' ',$lines);
    }
    return $strs;
}

function uname($part = 'a')
{
    $result = '';
    if (!function_is_disabled('php_uname')) {
        $result = @php_uname($part);
    } elseif (function_exists('posix_uname') && !function_is_disabled('posix_uname')) {
        $posix_equivs = array(
                     'm' => 'machine',
                     'n' => 'nodename',
                     'r' => 'release',
                     's' => 'sysname'
                 );
        $puname = @posix_uname();
        if ($part == 'a' || !array_key_exists($part,$posix_equivs)) {
           $result = join(' ',$puname);
        } else {
           $result = $puname[$posix_equivs[$part]];
        }
    } else {
        if (!function_is_disabled('phpinfo')) {
            ob_start();
            phpinfo(INFO_GENERAL);
            $pinfo = ob_get_contents();
            ob_end_clean();
            if (preg_match('~System.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$match)) {
                $uname = $match[2];
                if ($part == 'r') {
                    if (!empty($uname) && preg_match('/\S+\s+\S+\s+([0-9.]+)/',$uname,$matchver)) {
                        $result = $matchver[1];
                    } else {
                        $result = '';
                    }
                } else {
                    $result = $uname;
                }
            }
        } else {
            $result = '';
        }
    }
    return $result;
}

function calc_word_size($os_code)
{
    $wordsize = null;
    if ('win' === $os_code) {
        ob_start();
        phpinfo(INFO_GENERAL);
        $pinfo = ob_get_contents();
        ob_end_clean();
        if (preg_match('~Compiler.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$compmatch)) {
            if (preg_match("/(VC[0-9]+)/i",$compmatch[2],$vcmatch)) {
                $compiler = strtoupper($vcmatch[1]);
            } else {
                $compiler = 'VC6';
            }
        } else {
            $compiler = 'VC6';
        }
        if ($compiler === 'VC9' || $compiler === 'VC11' || $compiler === 'VC14') {
			if (preg_match('~Architecture.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$archmatch)) {
				if (preg_match("/x64/i",$archmatch[2])) {
					$wordsize = 64;
				} else {
					$wordsize = 32;
				}
            } elseif (isset($_ENV['PROCESSOR_ARCHITECTURE']) && preg_match('~(amd64|x86-64|x86_64)~i',$_ENV['PROCESSOR_ARCHITECTURE'])) {
                if (preg_match('~Configure Command.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$confmatch)) {
                    if (preg_match('~(x64|lib64|system64)~i',$confmatch[2])) {
                        $wordsize = 64;
                    }
                }
            } else {
				$wordsize = 32;
			}
        }
    }
    if (empty($wordsize)) {
        $wordsize = ((-1^0xffffffff)?64:32);
    }
    return $wordsize;
}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


function is_base64($data)
{
    if ( base64_encode(base64_decode($data)) === $data)
    {
        return true;
    }
    return false;
}

function getIPAddress()
{
  // Try REMOTE_ADDR
  if (isset($_SERVER['REMOTE_ADDR']) and $_SERVER['REMOTE_ADDR'] != '')
  {
    return $_SERVER['REMOTE_ADDR'];
  }
  // Fall back to HTTP_CLIENT_IP
  elseif (isset($_SERVER['HTTP_CLIENT_IP']) and $_SERVER['HTTP_CLIENT_IP'] != '')
  {
    return $_SERVER['HTTP_CLIENT_IP'];
  }
  // Finally fall back to HTTP_X_FORWARDED_FOR
  // I'm aware this can sometimes pass the users LAN IP, but it is a last ditch attempt
  elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
  {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  // Nothing? Return false
  return false;
}