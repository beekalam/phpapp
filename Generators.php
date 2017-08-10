<?php
class Generators
{

	public static function select($options = array())
	{
		

		$id 				=	isset($options["id"])  ? $options["id"] : "__NO_NAME__";							// Id And Name Of Control
		$input 				=	isset($options["data"]) ? $options["data"] : array();								// Data In Format $key=>$value array
		$selected_option 	=	isset($options["selected_options"]) ? $options["selected_options"] : "";			// string in Single mode, Array in Multiple Mode
		$use_value_only 	=	isset($options["use_value_only"]) ? $options["use_value_only"] : false;				// keys and values are the same
		$mode 				=	isset($options["mode"]) ? $options["mode"] : "single";								// single or multiple (string)
		$classes			= 	isset($option["classes"]) ? $option["classes"] : "";								// additional user classes (string)
		$attrs				=	isset($option["attrs"]) ? $option["attrs"] : "";									// additional user html attributes (string)



		$out = "<select id='" . $id . "' name='" . $id . "' ";
		if ($mode == "multiple")
			$out .=" multiple='multiple' ";

		$out .= "class='form-control select2 select2-hidden-accessible ".$classes."' ".$attrs.">";
		$out .= '<option value="">لطفا یک آیتم انتخاب کنید</option>';

		
		// pr(array($id,$input, $mode));
		// pr("...................");
		if($use_value_only)
		{
			foreach ($input as $k=>$v) {

				if (is_array($selected_option)){
					if (in_array($v, $selected_option))
						$out .='<option value="'.$v.'" selected="selected">'.$v.'</option>';
					else
						$out .='<option value="'.$v.'">'.$v.'</option>';
				}
				else{
					if ($selected_option != $v)
						$out .='<option value="'.$v.'">'.$v.'</option>';
					else
						$out .='<option value="'.$v.'" selected="selected">'.$v.'</option>';				
				}

			}
		}
		else{	// use key value mode

			foreach ($input as $k=>$v) {

				if (is_array($selected_option)){
					if (in_array($k, $selected_option))
						$out .='<option value="'.$k.'" selected="selected">'.$v.'</option>';
					else
						$out .='<option value="'.$k.'">'.$v.'</option>';
				}
				else{
					if ($selected_option != $k)
						$out .='<option value="'.$k.'">'.$v.'</option>';
					else
						$out .='<option value="'.$k.'" selected="selected">'.$v.'</option>';
				}

			}	
		}
		
		$out .='</select>
                <script type="text/javascript">
                    $("#'.$id.'").select2();
                </script>
		';
		return $out;
	}



}