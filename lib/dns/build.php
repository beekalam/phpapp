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
 * Build model Class
 *
 * @author        HSDN Team
 */
class Build_model
{
    /*
     * Config file content array
     * @access    private
     */
    private $config_array = array();

    /*
     * Record file content array
     * @access    private
     */
    private $record_array = array();


    /**
     * Build named.conf file
     *
     * @access    public
     * @param    array
     * @return    string
     */
    public function config($array)
    {
        $this->config_array = $array;

        if ($string = $this->build_config())
        {
            return $string;
        }

        return FALSE;
    }

    /**
     * Build record file
     *
     * @access    public
     * @param    array
     * @return    string
     */
    public function record($array)
    {
        $this->record_array = $array;

        if ($string = $this->build_record())
        {
            return $string;
        }

        return FALSE;
    }

    /**
     * Build config array file
     *
     * @access    private
     * @param    array
     * @param    int
     * @return    array
     */
    private function build_config($config_array = FALSE, $level = 0)
    {
        if ($config_array === FALSE)
        {
            $config_array = $this->config_array;
        }

        if (sizeof($config_array) == 0)
        {
            return FALSE;
        }

        $return = '';
        $tab = str_repeat("\t", $level);

        foreach ($config_array as $statement)
        {
            if(isset($statement['value']))
            {
                $return .= $tab;

                if (isset($statement['name']))
                {
                    $return .= $statement['name'].' ';
                }

                if (isset($statement['quoted']))
                {
                    $return .= '"'.trim($statement['value'], '"').'"';
                }
                else
                {
                    $return .= $statement['value'];
                }

                if (isset($statement['childs']))
                {
                    if (($childs = $this->build_config($statement['childs'], $level + 1)) !== FALSE)
                    {
                        $return .= " {\n";
                        $return .= $childs;

                        if ($level > 0)
                        {
                            $return .= $tab;
                        }

                        $return .= "}";
                    }
                }

                $return .= ";\n";

                if ($level == 0)
                {
                    $return .= "\n";
                }
            }
        }

        if ($return !== '')
        {
            return $return;
        }

        return FALSE;
    }

    /**
     * Rebuild array childs
     *
     * @access    public
     * @param    array
     * @return    array
     */
    public function config_childs($array)
    {
        if (sizeof($array) == 0)
        {
            return FALSE;
        }

        $return = array();

        foreach ($array as $state)
        {
            if (isset($state['name']) AND isset($state['value']))
            {
                $return[$state['name']] = $state['value'];
            }
            else if (isset($state['value']) AND isset($state['childs']))
            {
                $return[$state['value']] = $this->config_childs($state['childs']);
            }
            else if (isset($state['value']))
            {
                $return[] = $state['value'];
            }
        }

        return $return;
    }

    /**
     * Build record array file
     *
     * @access    private
     * @param    array
     * @return    string
     */
    private function build_record($record_array = FALSE)
    {
        if ($record_array === FALSE)
        {
            $record_array = $this->record_array;
        }

        if (sizeof($record_array) == 0)
        {
            return FALSE;
        }

        $max_pad_name = $this->count_max_legth($record_array, 'name');
        $max_pad_ttl = $this->count_max_legth($record_array, 'ttl');
        $max_pad_type = $this->count_max_legth($record_array, 'type');

        $return = '';

        foreach ($record_array as $line)
        {
            // build variables
            if (isset($line['variable']) AND isset($line['data']))
            {
                $return .= '$'.$line['variable'].' '.$line['data']."\n";
            }

            // build RRs
            if (isset($line['name']) 
                AND isset($line['ttl']) 
                AND isset($line['class']) 
                AND isset($line['type']) 
                AND isset($line['data']))
            {
                $return .= $line['name'].str_repeat(' ', $max_pad_name - strlen($line['name']) + 3);
                $return .= $line['ttl'].str_repeat(' ', $max_pad_ttl - strlen($line['ttl']) + 3);
                $return .= $line['class'].str_repeat(' ', 3);
                $return .= $line['type'].str_repeat(' ', $max_pad_type - strlen($line['type']) + 3);

                if (is_array($line['data']))
                {
                    $return .= $this->build_rr_data_line($line['data'], $line['type'], ($max_pad_name + $max_pad_ttl + $max_pad_type + 12));
                }
                else
                {
                    $return .= $line['data'];
                }
                
                $return .= "\n";
            }
        }

        if ($return !== '')
        {
            return $return;
        }

        return FALSE;
    }

    /**
     * Build resource record data line
     *
     * @access    private
     * @param    array
     * @param    string
     * @param    int
     * @return    string
     */
    private function build_rr_data_line($array, $type, $pad_level = 0)
    {
        switch ($type)
        {
            case 'TXT':
            case 'WKS':
                return $this->puild_rr_wks($array, $pad_level);

            case 'SOA':
                return $this->build_rr_soa($array, $pad_level);

            case 'NAPTR':
                return $this->puild_rr_naptr($array);

            default:
                return implode(' ', $array);
        }
    }

    /**
     * Build SOA resource record data
     *
     * @access    private
     * @param    array
     * @param    int
     * @return    string
     */
    private function build_rr_soa($array, $pad_level = 0)
    {
        if (!isset($array['server']) 
            OR !isset($array['person'])
            OR !isset($array['serial'])
            OR !isset($array['refresh'])
            OR !isset($array['retry'])
            OR !isset($array['expire'])
            OR !isset($array['ttl']))
        {
            return FALSE;
        }

        $before_pad = str_repeat(' ', $pad_level + 2);
        $return = $array['server'].' '.$array['person']." (\n";

        unset($array['server'], $array['person']);

        $pad_array = array_map('strlen', $array);

        rsort($pad_array);

        $max_pag = reset($pad_array) + 3;

        $return .= $before_pad.$array['serial'];
        $return .= str_repeat(' ', $max_pag - strlen($array['serial']))."; Serial\n";
        $return .= $before_pad.$array['refresh'];
        $return .= str_repeat(' ', $max_pag - strlen($array['refresh']))."; Refresh\n";
        $return .= $before_pad.$array['retry'];
        $return .= str_repeat(' ', $max_pag - strlen($array['retry']))."; Retry\n";
        $return .= $before_pad.$array['expire'];
        $return .= str_repeat(' ', $max_pag - strlen($array['expire']))."; Expire\n";
        $return .= $before_pad.$array['ttl'].' )';
        $return .= str_repeat(' ', $max_pag - strlen($array['ttl']) - 2)."; Minimum TTL";

        return $return;
    }

    /**
     * Build NAPTR resource record data
     *
     * @access    private
     * @param    array
     * @return    string
     */
    private function puild_rr_naptr($array)
    {
        if (!isset($array['order']) 
            OR !isset($array['pref'])
            OR !isset($array['flags'])
            OR !isset($array['service'])
            OR !isset($array['regexp'])
            OR !isset($array['replacement']))
        {
            return FALSE;
        }

        $return = $array['order'].' '.$array['pref'].' "';
        $return .= $array['flags'].'" "'.$array['service'].'" "';
        $return .= $array['regexp'].'" '.$array['replacement'];

        return $return;
    }

    /**
     * Build WKS and TXT resource record data
     *
     * @access    private
     * @param    array
     * @param    int
     * @return    string
     */
    private function puild_rr_wks($array, $pad_level = 0)
    {
        if (!isset($array['address']) 
            OR !isset($array['protocol'])
            OR !isset($array['services']))
        {
            return FALSE;
        }

        $return = $array['address'].' '.$array['protocol'].' ';

        if (strlen($array['services']) > 32)
        {
            $wrap = wordwrap($array['services'], 32, "\n");
            $pad_level += strlen($array['address']) + strlen($array['protocol']);

            $return .= '( ';
            $lines = '';

            foreach (split("\n", $wrap) as $line)
            {
                $lines .= str_repeat(' ', $pad_level + 6).$line."\n";
            }

            $return .= trim($lines).' )';
        }
        else
        {
            $return .= $array['services'];
        }

        return $return;
    }

    /**
     * Count max legth of string in column
     *
     * @access    public
     * @param    array
     * @param    string
     * @return    int
     */
    public function count_max_legth($array, $column)
    {
        $column_array = array();

        foreach ($array as $line)
        {
            if (isset($line[$column]) AND $line[$column] != '')
            {
                $column_array[] = strlen($line[$column]);
            }
        }

        rsort($column_array);

        return reset($column_array);
    }
}

/* End of file */