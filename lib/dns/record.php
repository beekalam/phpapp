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
 * Record model Class
 *
 * @author        HSDN Team
 */
class Record_model
{
    /*
     * Secured record array
     * @access    private
     */
    private $record_array = array();

    /*
     * User-trusted record array
     * @access    private
     */
    private $user_array = array();

    /*
     * Secured RR types (in origins)
     * @access    private
     */
    private $secured_types = array('NS');


    /**
     * Constructor
     *
     * @access    public
     * @return    void
     */
    public function __construct()
    {
        $this->parse = Load::model('parse');
        $this->build = Load::model('build');
        $this->zone = Load::model('zone');
    }

    /**
     * Record file exists
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    public function exists($file)
    {
        $filename = $this->get_filename($file);

        return file_exists($filename);
    }

    /**
     * Get plain-text records by filename
     *
     * @access    public
     * @param    string
     * @return    string
     */
    public function get_plain($file)
    {
        if (!$this->exists($file))
        {
            return FALSE;
        }

        if ($plain = $this->read_record($file))
        {
            return trim($plain);
        }

        return FALSE;
    }

    /**
     * Get user records by filename
     *
     * @access    public
     * @param    string
     * @return    array
     */
    public function get_user($file)
    {
        if (!$this->exists($file))
        {
            return FALSE;
        }

        if (sizeof($this->record_array) != 0)
        {
            return $this->user_array;
        }

        if ($string = $this->read_record($file))
        {
            if ($this->parse_record($string))
            {
                return $this->user_array;
            }
        }

        return FALSE;
    }

    /**
     * Get secured records by filename
     *
     * @access    public
     * @param    string
     * @return    array
     */
    public function get_secured($file)
    {
        if (!$this->exists($file))
        {
            return FALSE;
        }

        if (sizeof($this->user_array) != 0)
        {
            return $this->record_array;
        }

        if ($string = $this->read_record($file))
        {
            if ($this->parse_record($string))
            {
                return $this->record_array;
            }
        }

        return FALSE;
    }

    /**
     * Create record file
     *
     * @access    public
     * @param    string
     * @param    array
     * @return    bool
     */
    public function create($file, $build_array)
    {
        if ($this->exists($file))
        {
            return FALSE;
        }

        if ($this->build_record($file, $build_array))
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Delete records
     *
     * @access    public
     * @param    string
     * @return    bool
     */
    public function delete($file)
    {
        if (!$this->exists($file))
        {
            return FALSE;
        }

        $filename = $this->get_filename($file);

        return @unlink($filename);
    }

    /**
     * Insert records to record file
     *
     * @access    public
     * @param    string
     * @param    array
     * @param    array
     * @return    bool
     */
    public function insert($file, $record_array, $user_array)
    {
        if ($record_array === FALSE OR $user_array == FALSE)
        {
            return FALSE;
        }

        $build_array = array_merge($record_array, $user_array);

        if ($this->build_record($file, $build_array))
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Generate variable array
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    array
     */
    public function gen_variable($name, $value)
    {
        return array
        (
            'variable' => $name, 
            'data' => $value
        );
    }

    /**
     * Generate resource record array
     *
     * @access    public
     * @param    string
     * @param    string
     * @param    string
     * @param    string
     * @param    string
     * @return    array
     */
    public function gen_resource($name, $type, $data, $ttl = '', $class = 'IN')
    {
        return array
        (
            'name' => $name, 
            'ttl' => $ttl, 
            'class' => $class, 
            'type' => $type, 
            'data' => $data
        );
    }

    /**
     * Generate SOA RR data array
     *
     * @access    public
     * @param    string
     * @param    string
     * @param    string
     * @param    string
     * @param    string
     * @param    string
     * @param    string
     * @return    array
     */
    public function gen_soa_data($server, $person, $serial, $refresh, $retry, $expire, $ttl)
    {
        return array
        (
            'server' => $server,
            'person' => $person,
            'serial' => $serial,
            'refresh' => $refresh,
            'retry' => $retry,
            'expire' => $expire,
            'ttl' => $ttl
        );
    }

    /**
     * Resize serial number for SOA RR data
     *
     * @access    public
     * @param    int
     * @param    int
     * @return    int
     */
    public function resize_serial($serial = 0, $time = 0)
    {
        if ($serial == 0)
        {
            $serial = date('Ymd00');
        }

        if (strlen($serial) == 10)
        {
            $time = ($time != 0) ? $time : time();
            $date = substr($serial, 0, 8);
            $seria = floor(substr($serial, 8, 2));
            $spec_date = date('Ymd', $time);

            if ($date == $spec_date)
            {
                if ($seria >= 99)
                {
                    return FALSE;
                }

                return intval($spec_date.str_repeat('0', 2 - strlen($seria)).($seria + 1));
            }
            else
            {
                return intval($spec_date.'00');
            }
        }

        return $serial + 1;
    }

    /**
     * Parse record file
     *
     * @access    private
     * @return    array
     */
    private function parse_record($string)
    {
        if ($string === '')
        {
            return FALSE;
        }

        if (!$this->record_array = $this->parse->record($string))
        {
            return FALSE;
        }

        $last_origin = FALSE;

        foreach ($this->record_array as $line => $record)
        {
            // exclude all variables
            if (isset($record['variable']))
            {
                if ($record['variable'] == 'ORIGIN')
                {
                    $last_origin = $record['data'];
                }

                continue;
            }

            // exclude SOA type records
            if (isset($record['type']) AND $record['type'] == 'SOA')
            {
                continue;
            }

            // exclude records of secured types and...
            if (isset($record['name']) AND isset($record['type'])
                AND in_array($record['type'], $this->secured_types)

                // ...the origin records!
                AND ($record['name'] == '' 
                    OR $record['name'] == '.' 
                    OR $record['name'] == '@' 
                    OR $record['name'] == $last_origin)
                )
            {
                continue;
            }

            $this->user_array[] = $record;
            unset($this->record_array[$line]);
        }

        return TRUE;
    }

    /**
     * Build record file
     *
     * @access    private
     * @return    bool
     */
    private function build_record($file, $build_array)
    {
        $string = $this->build->record($build_array);

        if ($string AND $this->write_record($file, $string))
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Read record file
     *
     * @access    private
     * @param    string
     * @return    string
     */
    private function read_record($file)
    {
        $filename = $this->get_filename($file);

        if ($string = @file_get_contents($filename))
        {
            return $string;
        }

        return FALSE;
    }

    /**
     * Write record file
     *
     * @access    private
     * @param    string
     * @param    string
     * @return    bool
     */
    private function write_record($file, $string)
    {
        if (!$string)
        {
            return FALSE;
        }

        $filename = $this->get_filename($file);

        if ($fp = @fopen($filename, "w"))
        {
            if (@flock($fp, LOCK_EX)) 
            {
                fwrite($fp, $string);
                flock($fp, LOCK_UN);
                fclose($fp);

                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Get zone filename
     *
     * @access    private
     * @param    string
     * @return    string
     */
    private function get_filename($file)
    {
        return Load::config('named_path', 'dns').'/'.$file;
    }
}

/* End of file */