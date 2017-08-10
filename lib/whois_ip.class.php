<?php
/* 
    The component of HSDN Network Operations Center 
    Copyright (C) 2005-2010 Information Networks Ltd. 
    All Rights Reserved. 
*/ 
class whois_ip 
{ 
    static $arin_server = 'whois.arin.net';
    static $referral_print = false; 
    static $return = array(); 
    static $ipaddr = ''; 

    static $extra_arguments = array 
    ( 
        'whois.arin.net' => array('n ', ''), 
        'whois.ripe.net' => array('-B ', ''), 
        'whois.nic.ad.jp' => array('', '/e')
    ); 

    static function whois($ipaddr) 
    { 
        self::$ipaddr = $ipaddr; 

        $server = self::$arin_server; 
        $buffer = self::whois_request(self::$ipaddr, $server); 
        self::$return[$server] = $buffer; 
        self::$return[$server] = self::arin_multi_whois($buffer, $server); 

        return self::$return; 
    } 

    static function whois_request($ipaddr, $whois_server, $whois_port = 43) 
    { 
        if (!$whois_server) return false; 

        if (isset(self::$extra_arguments[$whois_server]) && $arguments = self::$extra_arguments[$whois_server]) 
        { 
            if (count($arguments) == 2) 
            { 
                $ipaddr = $arguments[0].$ipaddr.$arguments[1]; 
            } 
        } 

        if (!$sock = self::connect_socket(gethostbyname($whois_server), $whois_port)) 
        { 
            self::print_out('<p>___ '.$whois_server.' ___ '.$ipaddr."!</p>\n"); 
            return false; 
        } 
        self::sendto_socket($sock, $ipaddr); 
        $buffer = self::read_socket($sock); 

        if ( !self::find_referral_server($buffer, $server, $port) || self::$referral_print )  
        { 
            self::print_out('<p>Whois server:'.$whois_server.' ip: '.$ipaddr.":</p>\n"); 
            // self::print_out('<div class="block-text">'.display::block_prepare($buffer)."</div>\n");  //fixme
            // self::print_out('<div class="block-text">'.print_r($buffer, true)."</div>\n"); 
        } 
        self::$return[$server] = self::whois_request(self::$ipaddr, $server, $port); 

        return $buffer; 
    } 

    static function arin_multi_whois($buffer, $whois_server) 
    { 
        $return = array(); 

        if (preg_match("|\(NET-.*-.*-.*-.*-.*\)|isU", $buffer))  
        { 
            preg_match_all("|\(NET-(.*)\)|isU", $buffer, $pretarget); 
            for ($i = 0; $i < count($pretarget[1]); $i++)  
            { 
                $ipaddr = "! NET-".$pretarget[1][$i]; 
                $return[$ipaddr] = self::whois_request($ipaddr, $whois_server); 
            } 
        } 
        return $return; 
    } 

    static function find_referral_server($buffer, &$server, &$port) 
    { 
        $get_string = ""; 
        $pharse_string = preg_split("/\n/", $buffer); 

        for ($i = 0; $i < count($pharse_string); $i++)  
        { 
            // if (eregi("^ReferralServer\:", $pharse_string[$i])) 
            if(preg_match("/^ReferralServer\:/", $pharse_string[$i]))
                $get_string = $pharse_string[$i]; 
        } 
        $server_string = preg_replace("/^ReferralServer\: (.+)$/is", "\\1", trim(rtrim($get_string))); 

        if ($parse_server = parse_url($server_string))     
        { 
            if (isset($parse_server['host'])) 
            { 
                $server = trim($parse_server['host']); 
            } 
            elseif (strpos($server_string, '//') !== FALSE) 
            { 
                $server = explode('//', $server_string, 2); 
                $server = end($server); 
            } 
            $port = isset($parse_server['port']) ? trim($parse_server['port']) : 43; 
        } 
        return $server; 
    } 

    static function connect_socket($server, $port = 43) 
    { 
        $sock = @fsockopen($server, $port, $errnum, $errstr, 10); 
        return $sock; 
    } 

    static function sendto_socket($sock, $request) 
    { 
        fputs($sock, $request."\r\n"); 
    } 

    static function read_socket($sock) 
    { 
        $buffer = ''; 
        while (!feof($sock))  
        { 
            $buffer .= fgets($sock, 128); 
        } 
        fclose($sock); 

        return $buffer; 
    } 

    static function print_out($string) 
    { 
        print $string; 
        flush(); 
    } 
}

?>