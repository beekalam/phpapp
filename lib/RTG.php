<?php
/**
 * HSDN Recursive Table Generator
 *
 * @version     0.08.0b
 * @author      HSDN Team
 * @copyright   Copyright (c) 2015-2017, Information Networks Ltd.
 * @link        http://www.hsdn.org
 */
class RTG
{
	/*
	 * Array of the CSS styles
	 */
	private static $css = array
	(
		'table.rtg_outer { border: 0; border-collapse: separate; border-spacing: 0; border: 2px solid #000; padding: 5px; background: #fff; }',
		'table.rtg_inner { border: 0; border-collapse: separate; border-spacing: 0; width: 100%; }',
		'th.rtg_outer { border-bottom: 1px solid #000; padding: 0 3px 2px 3px; }',
		'td.rtg_inner { border-bottom: 1px solid #000; padding: 3px 4px 1px 4px; }',
		'td.rtg_outer { border-bottom: 1px solid #000; border-left: 1px solid #000; padding: 3px 4px 1px 4px; }',
		'td.rtg_outer:last-child { border-right: 1px solid #000; }',
		'td.rtg_inner:last-child { border-left: 1px solid #000; }',
	);

	/*
	 * Table settings array
	 */
	private static $settings = array
	(
		'width'      => '100%',
		'color'      => '#ccffcc',
		'color_raw'  => '#ccccff',
		'color_null' => '#ffcccc',
		'color_bool' => '#ccc',
		'raw_params' => array
		(
			'raw',
			'header',
			'banner',
		),
	);

	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------

	/**
	 * Returns or print the CSS style
	 *
	 * @access  public
	 * @param   bool
	 * @return  string|void
	 */
	public static function css($print = FALSE)
	{
		$css = implode(' ', self::$css);

		if (!$print)
		{
			return $css;
		}

		echo $css;
	}

	/**
	 * Returns or print the table
	 *
	 * @access  public
	 * @param   array
	 * @param   bool
	 * @param   array
	 * @return  string|void
	 */
	public static function table($content, $print = FALSE, $settings = array())
	{
		self::$settings = array_merge(self::$settings, $settings);

		$table = self::build_table($content);

		if (!$print)
		{
			return $table;
		}

		echo $table;
	}

	// --------------------------------------------------------------------
	// Private methods
	// --------------------------------------------------------------------

	/**
	 * Builds table
	 *
	 * @access  private
	 * @param   array
	 * @param   int
	 * @param   string
	 * @param   string
	 * @param   bool
	 * @return  string
	 */
	private static function build_table($content, $width = NULL, $td_width = '50%', $class = 'rtg_outer', $build_th = TRUE)
	{
		if (!$width)
		{
			$width = self::$settings['width'];
		}

		$table = '<table class="'.$class.'" style="width:'.$width.'">';

		if ($build_th)
		{
			$table .= '<tr><th class="'.$class.'">Parameter</th><th colspan="2" class="'.$class.'">Value</th></tr>';
		}

		foreach ($content as $param => $value)
		{
			$table .= self::build_tr($param, $value, $class, $td_width);
		}

		if ($build_th)
		{
			$table .= 
					'<tr><th colspan="2" style="padding-top:4px;font-size:9px;font-weight:normal;text-align:right">'.
						'<i>HSDN Recursive Table Generator</i>'.
					'</th></tr>';
		}
		$table .= '</table>';

		return $table;
	}

	/**
	 * Builds table tr
	 *
	 * @access  private
	 * @param   string
	 * @param   mixed
	 * @param   string
	 * @param   string
	 * @return  string
	 */
	private static function build_tr($param, $value, $class, $width)
	{
		$bg_color = self::$settings['color'];

		list($color, $param) = self::build_param($param);

		if (!is_null($color))
		{
			$bg_color = $color;
		}

		list($color, $value) = self::build_value($value);

		if (!is_null($color))
		{
			$bg_color = $color;
		}

		$tr  = '<tr>';
		$tr .= '<td style="background:#fff;width:'.$width.'" class="'.$class.'"><b>'.$param.'</b></td>';

		if (is_array($value))
		{
			$tr .= '<td style="background:'.$bg_color.';padding:0;border-bottom:0" class="'.$class.'">';
			$tr .= self::build_table($value, '100%', '1%', 'rtg_inner', FALSE);
			$tr .= '</td>';
		}
		else
		{
			$tr .= '<td style="background:'.$bg_color.'" class="'.$class.'">';
			$tr .= $value;
			$tr .= '</td>';
		}

		$tr .= '</tr>';

		return $tr;
	}

	/**
	 * Build param
	 *
	 * @access  private
	 * @param   string
	 * @return  array
	 */
	private static function build_param($param)
	{
		$color = NULL;

		foreach (self::$settings['raw_params'] as $raw_param)
		{
			if ($param === $raw_param)
			{
				$color = self::$settings['color_raw'];

				break;
			}
		}

		if (is_numeric($param))
		{
			$param = 'Entry&nbsp;'.($param + 1);
		}
		else
		{
			$param = str_replace(' ', '&nbsp;', ucwords(str_replace('_', ' ', htmlspecialchars($param))));
		}

		return array($color, $param);
	}

	/**
	 * Build value
	 *
	 * @access  private
	 * @param   string
	 * @return  array
	 */
	private static function build_value($value)
	{
		$color = NULL;

		if (!is_array($value))
		{
			if (is_null($value))
			{
				$color = self::$settings['color_null'];
				$value = '&lt;no data&gt;';
			}
			elseif (is_bool($value))
			{
				$color = self::$settings['color_bool'];

				if ($value === TRUE)
				{
					$value = '&lt;data boolean: <b>TRUE</b>&gt;';
				}
				else
				{
					$value = '&lt;data boolean: <b>FALSE</b>&gt;';
				}
			}
			else
			{
				$value = nl2br(htmlspecialchars($value));
			}
		}

		return array($color, $value);
	}
}

/* End of File */