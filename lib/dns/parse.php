<?php defined('APPPATH') or die('No direct access allowed.');
/**
 * HSDN SME
 *
 * Site Management Engine
 *
 * @package        ELISA
 * @author        HSDN Team
 * @copyright    Copyright (c) 2009-2010, Information Networks Ltd.
 * @link        http://www.hsdn.org
 * @since        Version 1
 */

// ------------------------------------------------------------------------

/**
 * Parse model Class
 *
 * @author        HSDN Team
 */
class Parse_model
{
    /*
     * Config file content string
     * @access    private
     */
    private $config_string = '';

    /*
     * Diff config_index
     * @access    private
     */
    private $config_index = 0;

    /*
     * RR file content string
     * @access    private
     */
    private $rr_string = '';

    /*
     * RR classes 
     * @see        RFC 1035
     * @access    private
     */
    private $rr_classes = array
    (
        'IN',        // 1 the Internet
        'CS',        // 2 the CSNET class (Obsolete - used only for examples in some obsolete RFCs)
        'CH',        // 3 the CHAOS class
        'HS'        // 4 Hesiod [Dyer 87]
    );

    /*
     * RR types
     * @see        RFC 1035
     * @access    private
     */
    private $rr_types = array
    (
        'A',        // 1 a host address
        'NS',        // 2 an authoritative name server
        'MD',        // 3 a mail destination (Obsolete - use MX)
        'MF',        // 4 a mail forwarder (Obsolete - use MX)
        'CNAME',    // 5 the canonical name for an alias
        'SOA',        // 6 marks the start of a zone of authority
        'MB',        // 7 a mailbox domain name (EXPERIMENTAL)
        'MG',        // 8 a mail group member (EXPERIMENTAL)
        'MR',        // 9 a mail rename domain name (EXPERIMENTAL)
        'NULL',        // 10 a null RR (EXPERIMENTAL)
        'WKS',        // 11 a well known service description
        'PTR',        // 12 a domain name pointer
        'HINFO',    // 13 host information
        'MINFO',    // 14 mailbox or mail list information
        'MX',        // 15 mail exchange
        'TXT',        // 16 text strings
        'RP',        // 17 Responsible person [RFC 1183]
        'AFSDB',    // 18 AFS database [RFC 1183]
        'NSAP',        // 22 NSAP Resource Records [RFC 1706]
        'AAAA',        // 28 IP Version 6 [RFC 3596]
        'LOC',        // 29 Geographic location Resource Records [RFC 1876]
        'SRV',        // 33 for specifying the location of services [RFC 2782]
        'NAPTR',    // 35 Locating SIP Servers [RFC 3263]
        'A6',        // 38 IP Version 6 [RFC 3596] [RFC 2874]
        'DNAME'        // 39 Domain Name [RFC 2672]
    );


    /**
     * Parse named.conf file
     *
     * @access    public
     * @param    string
     * @return    array
     */
    public function config($string)
    {
        $string = $this->strip_comments($string);
        $string = $this->strip_dashes($string);
        $this->config_string = $string;

        return $this->parse_config_token();
    }

    /**
     * Parse record file
     *
     * @access    public
     * @param    string
     * @return    array
     */
    public function record($string)
    {
        $string = $this->strip_comments($string, TRUE);
        $string = $this->prepare_rrs($string);
        $this->rr_string = $string;

        return $this->parse_rrs();
    }

    /**
     * Parse time string to seconds
     *
     * @access    public
     * @param    string
     * @return    int
     */
    public function seconds($time)
    {
        if (is_numeric($time)) 
        {
            return $time;
        } 

        $split = preg_split('/([0-9]+)([smhdw]+)/i', $time, -1, 
                    PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        if (sizeof($split) != 2) 
        {
            return FALSE;
        }

        switch (strtoupper($split[1]))
        {
            case 'S':
                $times = 1; // seconds
                break;

            case 'M':
                $times = 1 * 60; // minute
                break;

            case 'H':
                $times = 1 * 60 * 60; // hour
                break;

            case 'D':
                $times = 1 * 60 * 60 * 24; // day
                break;

            case 'W':
                $times = 1 * 60 * 60 * 24 * 7; // week
                break;

            default:
                return FALSE;
        }

        return $split[0] * $times;
    }

    /**
     * Parse part list
     *
     * @access    public
     * @param    string
     * @return    array
     */
    public function part_list($string, $separator = ';')
    {
        return array_map('trim', split($separator, $string));
    }

    /**
     * Parse config token string
     *
     * @access    private
     * @return    array
     */
    private function parse_config_token()
    {
        $return = array();
        $word = '';
        $j = 0;

        do
        {
            $char = $this->config_string{$this->config_index};
            $this->config_index++;

            if ($char == ';' OR $char == '{')
            {
                if ($word === '')
                {
                    continue;
                }

                if ($char == ';')
                {
                    $return[$j] = $this->parse_config_statement($word);
                }
                else if ($char == '{')
                {
                    $return[$j] = $this->parse_config_statement($word, $this->parse_config_token());
                }

                $word = '';
                $j++;
            }
            else if ($char == '}')
            {
                break;
            }
            else
            {        
                $word .= $char;
            }
        }
        while (strlen($this->config_string) > $this->config_index);

        return $return;
    }

    /**
     * Parse config statement string
     *
     * @access    private
     * @return    array
     */
    private function parse_config_statement($word, $params = array())
    {
        $word = trim($word);

        if (strpos($word, ' ') != 0)
        {
            $wp = array_map('trim', split(' ', $word, 2));

            if (isset($wp[0]) AND isset($wp[1]) AND $wp[0] ==! '' AND $wp[1] ==! '')
            {
                $return = array
                (
                    'name' => $wp[0], 
                    'value' => $wp[1]
                );

                if (($value = trim($wp[1], '"')) !== $wp[1])
                {
                    $return = array
                    (
                        'name' => $wp[0], 
                        'value' => $value, 
                        'quoted' => 'true'
                    );
                }
            }
        }
        else
        {
            $return = array('value' => $word);

            if (($value = trim($word, '"')) !== $word)
            {
                $return = array
                (
                    'value' => $word, 
                    'quoted' => 'true'
                );
            }
        }

        if (sizeof($params) != 0)
        {
            $return = array_merge($return, array('childs' => $params));
        }

        return $return;
    }

    /**
     * Parse resource records
     *
     * @access    private
     * @return    array
     */
    private function parse_rrs()
    {
        $lines = array();

        foreach (split("\n", $this->rr_string) as $line)
        {
            if (!$rr_line = $this->parse_rrs_line($line))
            {
                return FALSE; // parse error
            }

            // Parse special types
            if (isset($rr_line['type']) AND isset($rr_line['data']))
            {
                switch ($rr_line['type'])
                {
                    case 'SOA':
                        $rr_line['data'] = $this->parse_rr_soa($rr_line['data']);
                        break;

                    case 'MX':
                        $rr_line['data'] = $this->parse_rr_mx($rr_line['data']);
                        break;

                    case 'WKS':
                        $rr_line['data'] = $this->parse_rr_wks($rr_line['data']);
                        break;

                    case 'RP':
                        $rr_line['data'] = $this->parse_rr_rp($rr_line['data']);
                        break;

                    case 'SRV':
                        $rr_line['data'] = $this->parse_rr_srv($rr_line['data']);
                        break;

                    case 'NAPTR':
                        $rr_line['data'] = $this->parse_rr_naptr($rr_line['data']);
                        break;

                    case 'A6':
                        $rr_line['data'] = $this->parse_rr_a6($rr_line['data']);
                        break;
                }

                if ($rr_line['data'] === FALSE)
                {
                    return FALSE; // parse error
                }
            }

            $lines[] = $rr_line;
        }

        return $lines;
    }

    /**
     * Parse resource records
     *
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rrs_line($line)
    {
        $array = array();
        $line_array = array();

        // Variables
        if (preg_match('/\$([A-Z0-9_-]+)\s(\S*)/s', $line, $matches) AND sizeof($matches) == 3)
        {
            return array
            (
                'variable' => $matches[1], 
                'data' => $matches[2]
            );
        }

        $segments = split(' ', $line, 5);

        // RRs with TTL
        if (preg_match("/^[0-9smhdw]+$/i", $segments[1]))
        {
            if (in_array($segments[2], $this->rr_classes))
            {
                $line_array = $segments;
            }
        }
        // RRs without TTL
        else
        {
            $segments = split(' ', $line, 4);

            if (in_array($segments[1], $this->rr_classes))
            {
                $line_array = array_merge(array(reset($segments), ''), array_slice($segments, 1));
            }
            else
            {
                $line_array = $segments;
            }
        }

        if (($line_size = sizeof($line_array)) == 5)
        {
            $build_array = $line_array;
        }
        else
        {
            $build_array = array();

            for ($i = 0; $i < $line_size - 1; $i++)
            {
                if ($i < 3)
                {
                    $build_array[] = $line_array[$i];
                }
                else
                {
                    $build_array[] = implode(' ', array_slice($line_array, $i));
                }
            }
        }

        if (isset($build_array[2]) 
            AND in_array($build_array[3], $this->rr_types) 
            AND sizeof($build_array) == 5)
        {
            return array
            (
                'name' => $build_array[0],
                'ttl' => $build_array[1],
                'class' => $build_array[2],
                'type' => $build_array[3],
                'data' => $build_array[4]
            );
        }

        return FALSE;
    }

    /**
     * Parse SOA resource record data
     *
     * @see        RFC 1035
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_soa($string)
    {
        preg_match("/(\S*)\s(\S*)\s([0-9]+)\s([0-9smhdw]+)\s([0-9smhdw]+)\s([0-9smhdw]+)\s([0-9smhdw]+)/i", $string, $matches);

        if (sizeof($matches) == 8)
        {
            return array
            (
                'server' => $matches[1],
                'person' => $matches[2],
                'serial' => $matches[3],
                'refresh' => $matches[4],
                'retry' => $matches[5],
                'expire' => $matches[6],
                'ttl' => $matches[7]
            );
        }

        return FALSE;
    }

    /**
     * Parse MX resource record data
     *
     * @see        RFC 1035
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_mx($string)
    {
        preg_match("/([0-9]+)\s(\S*)/i", $string, $matches);

        if (sizeof($matches) == 3)
        {
            return array
            (
                'preference' => $matches[1],
                'exchanger' => $matches[2]
            );
        }

        return FALSE;
    }

    /**
     * Parse WKS resource record data
     *
     * @see        RFC 1035
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_wks($string)
    {
        preg_match("/(\S*)\s(\S*)\s(.*)/i", $string, $matches);

        if (sizeof($matches) == 4)
        {
            return array
            (
                'address' => $matches[1],
                'protocol' => $matches[2],
                'services' => $matches[3]
            );
        }

        return FALSE;
    }

    /**
     * Parse RP resource record data
     *
     * @see        RFC 1183
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_rp($string)
    {
        preg_match("/(\S*)\s(\S*)/i", $string, $matches);

        if (sizeof($matches) == 3)
        {
            return array
            (
                'mbox-dname' => $matches[1],
                'txt-dname' => $matches[2]
            );
        }

        return FALSE;
    }

    /**
     * Parse SRV resource record data
     *
     * @see        RFC 2782
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_srv($string)
    {
        preg_match("/([0-9]+)\s([0-9]+)\s([0-9]+)\s(\S*)/i", $string, $matches);

        if (sizeof($matches) == 5)
        {
            return array
            (
                'priority' => $matches[1],
                'weight' => $matches[2],
                'port' => $matches[3],
                'target' => $matches[4],
            );
        }

        return FALSE;
    }

    /**
     * Parse NAPTR resource record data
     *
     * @see        RFC 3263
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_naptr($string)
    {
        preg_match("/([0-9]+)\s([0-9]+)\s\"(\S*)\"\s\"(\S*)\"\s\"(\S*)\"\s(\S*)/i", $string, $matches);

        if (sizeof($matches) == 7)
        {
            return array
            (
                'order' => $matches[1],
                'pref' => $matches[2],
                'flags' => $matches[3],
                'service' => $matches[4],
                'regexp' => $matches[5],
                'replacement' => $matches[6]
            );
        }

        return FALSE;
    }

    /**
     * Parse A6 resource record data
     *
     * @see        RFC 2874
     * @access    private
     * @param    string
     * @return    array
     */
    private function parse_rr_a6($string)
    {
        preg_match("/([0-9]+)\s([0-9\:]+)\s(\S*)/i", $string, $matches);

        if (sizeof($matches) == 4)
        {
            return array
            (
                'len' => $matches[1],
                'suffix' => $matches[2],
                'name' => $matches[3],
            );
        }

        return FALSE;
    }

    /**
     * Preparing RR zone
     *
     * @access    private
     * @param    string
     * @return    string
     */
    private function prepare_rrs($string)
    {
        $string = $this->strip_spaces_from_rrs($string);

        $tag_opened = FALSE;
        $return = '';
        $line = '';
        $index = 0;

        do
        {
            $char = $string{$index};

            $control = isset($string{$index - 1}) ? $string{$index - 1} : '';
            $control .= $char;
            $control .= isset($string{$index + 1}) ? $string{$index + 1} : '';

            if (preg_match('/[\r\n\t\s]\([\r\n\t\s]/', $control) AND $tag_opened == FALSE)
            {
                $tag_opened = TRUE;
            }

            if ($tag_opened)
            {
                $line .= str_replace("\n", '', $char);
            }
            else
            {
                $return .= $char;
            }

            if (preg_match('/[\r\n\t\s]\)[\r\n\t\s]/', $control) AND $tag_opened === TRUE)
            {
                $tag_opened = FALSE;
                $return .= trim(trim($line), '() '); // trim control chars
                $line = '';
            }

            $index++;
        }
        while (strlen($string) > $index);

        return $return;
    }

    /**
     * Strip spaces from RR lines
     *
     * @access    private
     * @param    string
     * @return    string
     */
    private function strip_spaces_from_rrs($string)
    {
        $string = str_replace(array("\r\n", "\r"), "\n", $string);
        $lines = array();

        foreach (split("\n", $string) as $line)
        {
            if ($line !== '')
            {
                $lines[] = rtrim(preg_replace("/[\s\t\r]+/", ' ', $line));
            }
        }

        $return = implode("\n", $lines);

        return $return;
    }

    /**
     * Strip comments
     *
     * @access    private
     * @param    string
     * @param    bool
     * @return    string
     */
    private function strip_comments($string, $semicolon = FALSE)
    {
        $lines = array();

        foreach (split("\n", $string) as $line)
        {
            if ($semicolon)
            {
                $line = preg_replace("/\;(.*)$/s", '', $line);
            }

            $lines[] = preg_replace("/\/\/(.*)$/s", '', $line);
        }

        $return = implode("\n", $lines);
        $return = preg_replace("/\/\*(.*)\*\//s", '', $return);

        return $return;
    }

    /**
     * Strip dashes from a string
     *
     * @access    public
     * @param    string
     * @return    string
     */
    private function strip_dashes($string)
    {
        $string = preg_replace("/([\r\n\t\s])/i", ' ', $string);
        $string = preg_replace("/\s+/", ' ', $string);

        return $string;
    }
}

/* End of file */