<?php
/**
 * HSDN SME
 *
 * Site Management Engine
 *
 * @author      HSDN Team
 * @copyright   (c) 2009-2015, Information Networks Ltd.
 * @link        http://www.hsdn.org
 * @since       Version 2.1
 */

// ------------------------------------------------------------------------

/**
 *  Socket
 *
 * @package     LRG
 * @category    Libraries
 * @author      HSDN Team
 * @version     1.1.11
 */

class Socket {

    /*
     *   
     */
    public $errno = NULL;

    /*
     *   
     */
    public $errstr = NULL;

    /*
     *   
     */
    public static $benchmarks = array();

    /*
     *    
     */
    private $benchmark;


    /**
     * 
     *
     * @param   bool
     * @return  void
     */
    public function __construct($benchmark = FALSE)
    {
        $this->benchmark = $benchmark;
    }

    /**
     *  
     *
     * @param   string
     * @param   int
     * @param   string
     * @return  bool
     */
    public function open($hostname, $port, $timeout = 10, $type = 'tcp')
    {
        $ips = $this->get_addr($hostname);

        if (is_array($ips) AND reset($ips) != $hostname)
        {
            foreach ($ips as $ip)
            {
                if ($socket = $this->open($ip, $port, $timeout, $type))
                {
                    return $socket;
                }
            }
        }

        $hostname = filter_var($hostname, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_IPV6) ? '['.$hostname.']' : $hostname;

        $socket = @stream_socket_client($type.'://'.$hostname.':'.$port, $this->errno, $this->errstr, $timeout, STREAM_CLIENT_CONNECT);

        if (is_resource($socket))
        {
            return $socket;
        }

        return FALSE;
    }

    /**
     *    
     *
     * @param   string
     * @param   int
     * @param   string
     * @param   int
     * @param   string
     * @param   string
     * @param   string
     * @return  bool
     */
    public function open_proxy($proxy_host, $proxy_port, $hostname, $port, $proxy_login = FALSE, $proxy_password = FALSE, $proxy_type = 'HTTP', $timeout = 10)
    {
        if ( ! $socket = $this->open($proxy_host, $proxy_port, $timeout))
        {
            return FALSE;
        }

        switch ($proxy_type)
        {
            case 'CONNECT':
            case 'HTTP CONNECT':
            case 'SSL CONNECT':
                if ($proxy_type == 'SSL CONNECT')
                {
                    if ( ! $this->enable_crypto($socket, TRUE))
                    {
                        return FALSE;
                    }
                }

                return $this->http_connect_authorisation($socket, $hostname, $port, $proxy_login, $proxy_password);
            
            case 'HTTP':
            case 'HTTPS':
                if ($proxy_type == 'HTTPS')
                {
                    if ( ! $this->enable_crypto($socket, TRUE))
                    {
                        return FALSE;
                    }
                }

                return $this->http_authorisation($socket, $hostname, $port, $proxy_login, $proxy_password);

            case 'SOCKS5':
                return $this->socks5_authorisation($socket, $hostname, $port, $proxy_login, $proxy_password);

            default:
                return FALSE;
        }

        return $socket;
    }

    /**
     *  
     *
     * @param   resource
     * @param   bool
     * @return  bool
     */
    public function set_blocking(&$socket, $blocking)
    {
        if ( ! is_resource($socket)) 
        {
            return FALSE;
        }

        return stream_set_blocking($socket, $blocking);
    }

    /**
     *      
     *
     * @param   resource
     * @param   int
     * @param   int
     * @return  bool
     */
    public function set_timeout(&$socket, $seconds, $microseconds = 0)
    {
        if ( ! is_resource($socket)) 
        {
            return FALSE;
        }

        return stream_set_timeout($socket, $seconds, $microseconds);
    }

    /**
     *    
     *
     * @return  array
     */
    public function get_meta_data(&$socket)
    {
        if ( ! is_resource($socket)) 
        {
            return FALSE;
        }

        return stream_get_meta_data($socket);
    }

    /**
     *    
     *
     * @param   resource
     * @return  mixed
     */
    public function read(&$socket, $length)
    {
        if( ! is_resource($socket)) 
        {
            return FALSE;
        }

        $data = @fread($socket, $length);

        if ($this->benchmark === TRUE)
        {
            self::$benchmarks[] = array('type' => __FUNCTION__, 'request' => byte::dump($data));
        }

        return $data;
    }

    /**
     *    
     *
     * @param   resource
     * @return  mixed
     */
    public function gets(&$socket, $length)
    {
        if( ! is_resource($socket)) 
        {
            return FALSE;
        }

        $data = @fgets($socket, $length);

        if ($this->benchmark === TRUE)
        {
            self::$benchmarks[] = array('type' => 'read', 'request' => byte::dump($data));
        }

        return $data;
    }

    /**
     *    
     *
     * @param   resource
     * @return  bool
     */
    public function eof(&$socket)
    {
        return feof($socket);
    }

    /**
     *    
     *
     * @param   resource
     * @param   string
     * @return  bool
     */
    public function write(&$socket, $request)
    {
        if ( ! is_resource($socket)) 
        {
            return FALSE;
        }

        $write_length = @fwrite($socket, $request);
        $request_length = strlen($request);

        if ($this->benchmark === TRUE)
        {
            self::$benchmarks[] = array('type' => __FUNCTION__, 'request' => byte::dump($request));
        }

        return ($write_length == $request_length) ? TRUE : FALSE;
    }

    /**
     *  
     *
     * @param   resource
     * @return  bool
     */
    public function close(&$socket)
    {
        if (is_resource($socket)) 
        {
            return fclose($socket);
        }
    }

    // --------------------------------------------------------------

    /**
     *  
     *
     * @param   resource
     * @param   bool
     * @param   int
     * @return  bool
     */
    public function enable_crypto(&$socket, $use_ssl, $ssl_type = STREAM_CRYPTO_METHOD_SSLv23_CLIENT)
    {
        if ($use_ssl === FALSE)
        {
            return TRUE;
        }

         if ( ! is_resource($socket)) 
        {
            return FALSE;
        }    

        if ( ! function_exists('stream_socket_enable_crypto') OR 
             ! function_exists('stream_get_transports') OR 
             ! in_array('ssl', stream_get_transports()) OR
             stream_socket_enable_crypto($socket, TRUE, $ssl_type) !== TRUE)
        {
            return FALSE;
        }

        return TRUE;
    }

    /**
     *  HTTP  (  CONNECT )
     *
     * @param   resource
     * @param   string
     * @param   int
     * @param   string
     * @param   string
     * @return  resource
     */
    private function http_connect_authorisation($socket, $hostname, $port, $proxy_login, $proxy_password)
    {
        $request = 'CONNECT '.$hostname.':'.$port.' HTTP/1.0'."\r\n";

        $request .= 'Host: '.$hostname."\r\n";

        if ($proxy_login AND $proxy_password)
        {
            $request .= 'Proxy-Authorization: Basic '.base64_encode($proxy_login.':'.$proxy_password)."\r\n";
        }

        $request .= 'Connection: Keep-Alive'."\r\n";
        $request .= 'Proxy-Connection: Keep-Alive'."\r\n\r\n";

        $this->write($socket, $request);

        $this->set_timeout($socket, 5);

        $this->read($socket, 9);
        $code = $this->read($socket, 3);

        if ($code != 200 OR ! is_resource($socket))
        {
            $this->close($socket);

            return FALSE;
        }

        while (($c = $this->read($socket, 1)) != "\n" AND !$this->eof($socket) AND $c !== FALSE);

        return $socket;
    }

    /**
     *  HTTP 
     *
     * @param   resource
     * @param   string
     * @param   int
     * @param   string
     * @param   string
     * @return  resource
     */
    private function http_authorisation($socket, $hostname, $port, $proxy_login, $proxy_password)
    {
        return $socket;
    }

    /**
     *  SOCKS 
     *
     * @param   resource
     * @param   string
     * @param   int
     * @param   string
     * @param   string
     * @return  resource
     */
    private function socks5_authorisation($socket, $hostname, $port, $proxy_login, $proxy_password)
    {
        $this->write($socket, pack('c2n', 5, 2, (empty($proxy_login) ? 0 : 2)));
        $packet = $this->read($socket, 2);

        if (ord($packet{0}) != 5)
        {
            $this->close($socket);
            return FALSE;
        }

        switch (ord($packet{1}))
        {
            case 0: 
                break;

            case 2:
                $this->write($socket, chr(1).chr(strlen($proxy_login)).$proxy_login.chr(strlen($proxy_password)).$proxy_password);
                $packet = $this->read($socket, 2);

                if (ord($packet{1}) != 0)
                {
                    $this->close($socket);
                    return FALSE;
                }
                break;

            default:
                $this->close($socket);
                return FALSE;
                break;
        }

        $long_ip = ip2long(gethostbyname($hostname));
        
        $this->write($socket, pack('c4Nn', 5, 1, 0, 1, $long_ip, (int)$port));
        $packet = $this->read($socket, 4);

        if (ord($packet{1}) != 0)
        {
            $this->close($socket);
            return FALSE;
        }

        switch (ord($packet{3}))
        {
            case 3:
                $skip = $this->get_word($this->read($socket, 2)) + 2; 
                break;

            // IPv6? o.O
            case 4: 
                $skip = 18; 
                break;

            default:
                $skip = 6;
                break;
        }

        $this->read($socket, $skip);

        return $socket;
    }

    /**
     *  
     *
     * @param   resource
     * @param   string
     * @param   int
     * @param   bool
     * @return  string
     */
    private function get_word(&$str, $pos = 0, $le = FALSE)
    {
        return $le ?
            (ord($str{$pos}) | (ord($str{$pos + 1}) << 8)) :
            ((ord($str{$pos}) << 8) | ord($str{$pos + 1}));
    }

    /**
     *   IP 
     *
     * @param   string
     * @return  array
     */
    private function get_addr($host)
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

                case 'AAAA':
                    $ip_array[] = $record['ipv6'];
                    break;

                case 'CNAME':
                    $ip_array = array_merge($ip_array, $this->get_addr($record['target']));
                    break;
            }
        }

        return $ip_array;
    }

}

/* End of file */