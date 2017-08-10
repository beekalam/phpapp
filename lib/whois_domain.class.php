<? 
/* 
    The component of HSDN Network Operations Center 
    Copyright (C) 2005-2012 Information Networks Ltd. 
    All Rights Reserved. 
*/ 
class whois_domain 
{ 
    static $domwhois_servers_list = 'share/domain-whois-servers.csv'; 
    static $domwhois_servers = array(); 
    static $return = array(); 

    static function whois($domain) 
    { 
        if (!self::$domwhois_servers = self::parse_server_list(self::$domwhois_servers_list)) 
        { 
            self::print_out("<p>�� ������� �������� ���� Whois ��������</p>\n"); 
            return false; 
        } 

        $domain = self::get_domain_tld($domain, 1); 

        if (!$server = self::get_whois_server($domain)) 
        { 
            self::print_out("<p>��������� ���� �� ������� � ����� Whois ��������</p>\n"); 
            return false; 
        } 

        if ($server == 'whois.denic.de') 
        { 
            $domain = '-T ace,dn '.$domain; 
        } 

        $buffer = self::whois_request($domain, $server); 
        self::$return[$server] = $buffer; 

        if ($server = self::find_referral_server($buffer))  
        { 
            self::$return[$server] = self::whois_request($domain, $server); 
        } 
        return self::$return; 
    } 

    static function whois_request($domain, $whois_server) 
    { 
        if (!$whois_server) return false; 

        if (!$sock = self::connect_socket($whois_server)) 
        { 
            self::print_out('<p>������ ���������� � '.$whois_server.' ��� '.$domain."!</p>\n"); 
            return false; 
        } 
        self::print_out('<p>Whois �� ������ ������� '.$whois_server.' ��� '.$domain.":</p>\n"); 
        self::sendto_socket($sock, $domain); 
        $buffer = self::read_socket($sock); 

        self::print_out('<div class="block-text">'.display::block_prepare($buffer)."</div>\n"); 
        return $buffer; 
    } 

    static function find_referral_server($buffer) 
    { 
        $pharse_string = split("\n", $buffer); 

        for ($i = 0; $i < count($pharse_string); $i++)  
        { 
            if (ereg('Whois Server:', $pharse_string[$i])) 
            $get_string = $pharse_string[$i]; 
        } 
         
        if (isset($get_string)) 
        { 
            $server = substr($get_string, 17, (strlen($get_string) - 17)); 
            $server = str_replace('1:Whois server:', '', trim(rtrim($server))); 

            return $server; 
        } 
    } 

    static function parse_server_list($list) 
    { 
        if (!$lines = @file($list)) return false; 

        $return = array(); 
        foreach ($lines as $v) 
        { 
            $exp = explode(";", $v); 
            if(count($exp) < 3) continue; 
            $return[] = array 
            ( 
                trim($exp[0]), 
                trim($exp[1]), 
                trim($exp[2]) 
            ); 
        } 
        return $return; 
    } 

    function get_domain_tld($domain, $type=0)  
    { 
        $pharse_domain = array_reverse(split("\.", $domain)); 
        $tlds = $struct = $domains = array(); 

        for ($i = 0; $i < count(self::$domwhois_servers); $i++) 
        { 
            $tlds[] = self::$domwhois_servers[$i][0]; 
        } 

        for ($i = 0; $i < count($pharse_domain); $i++) 
        { 
            $struct[] = $pharse_domain[$i]; 
            $comp_domains[] = implode(".", array_reverse($struct)); 
        } 

        for ($i = count($comp_domains) - 1; $i >= 0; $i--) 
        { 
            if (in_array($comp_domains[$i], $tlds) && $domain != $comp_domains[$i]) 
            { 
                $return_domain = $comp_domains[$i + 1]; 
                $tld = $comp_domains[$i]; 
                break; 
            } 
        } 
        if($type == 0) return $tld; 
        if($type == 1) return $return_domain; 
    } 

    static function get_whois_server($domain)  
    { 
        $found = false; 
        $tldname = self::get_domain_tld($domain); 

        for ($i = 0; $i < count(self::$domwhois_servers); $i++) 
        { 
            if (isset(self::$domwhois_servers[$i][0]) && self::$domwhois_servers[$i][0] == $tldname)  
            { 
                $server = isset(self::$domwhois_servers[$i][1]) ? self::$domwhois_servers[$i][1] : ''; 
                $full_dom = isset(self::$domwhois_servers[$i][3]) ? self::$domwhois_servers[$i][3] : ''; 
                $found = true; 
            } 
        } 
        return strtolower($server); 
    } 

    static function get_notfound_string($domain) 
    { 
        $found = false; 
        $tldname = self::get_domain_tld($domain); 

        for ($i = 0; $i < count(self::$domwhois_servers); $i++) 
        { 
            if (self::$domwhois_servers[$i][0] == $tldname) 
            $notfound = self::$domwhois_servers[$i][2]; 
        } 
        return $notfound; 
    } 

    static function is_available($buffer, $domain)  
    { 
        $whois_string = $buffer; 
        $not_found_string = self::get_notfound_string($domain); 
        $whois_string2 = ereg_replace("$domain", '', $whois_string); 
        $whois_string = preg_replace("/\s+/", ' ', $whois_string); 
        $array = split(":", $not_found_string); 

        if ($array[0] == "MAXCHARS")  
        { 
            if(strlen($whois_string2) <= $array[1]) 
            return true; 
            else 
            return false; 
        }  
        else 
        { 
            if(preg_match("/".$not_found_string."/i", $whois_string)) 
            return true; 
            else 
            return false; 
        } 
    } 

    static function connect_socket($server, $port = 43) 
    { 
        $ips = self::get_addr($server); 

        if (is_array($ips) AND reset($ips) != $server) 
        { 
            foreach ($ips as $ip) 
            { 
                if ($socket = self::connect_socket($ip, $port)) 
                { 
                    return $socket; 
                } 
            } 
        } 
         
        $server = filter_var($server, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_IPV6) ? '['.$server.']' : $server; 

        $socket = @fsockopen($server, $port, $errnum, $errstr, 1); 

        if (is_resource($socket)) 
        { 
            return $socket; 
        } 
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

    static function get_addr($host) 
    { 
        if (filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE)) 
        { 
            return array($host); 
        } 

        $dns_a = (($dns_a = dns_get_record($host, DNS_A)) !== FALSE) ? $dns_a : array(); 
        $dns_aaaa = (($dns_aaaa = dns_get_record($host, DNS_AAAA)) !== FALSE) ? $dns_aaaa : array(); 

        $ip_array = array(); 

        foreach (array_merge($dns_aaaa, $dns_a) as $record) 
        { 
            switch ($record['type']) 
            { 
                case 'A': 
                    $ip_array[] = $record['ip']; 
                    break; 

                //case 'AAAA': 
                //    $ip_array[] = $record['ipv6']; 
                //    break; 

                case 'CNAME': 
                    $ip_array = array_merge($ip_array, self::get_addr($record['target'])); 
                    break; 
            } 
        } 

        return $ip_array; 
    } 
} 
?>