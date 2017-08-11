<?php

//***************************** CHECK FOR VALUE IN ARRAY *********************
//if value exist return true, else return false
function array_value_exist($value,$array){
  $find = false;
  if(in_array("$value", $array)){$find = true;}

  if($find){return true;}
  else{return false;}
  }

//*************************** ACTIVATION **************************************
function wp_math_activate() {
  add_option('wp_math_size', 18);        //font size
  add_option('wp_math_mail', 1);         //convert mail to png
  add_option('wp_math_only_mail', 0);    //convert only mail to png
  add_option('wp_math_round', 3);        //number decimal place
  add_option('wp_math_static', 1);       //enable/disable static
  }

//*************************** DEACTIVATION ************************************  
function wp_math_deactivate() {
	delete_option('wp_math_size');
	delete_option('wp_math_mail');
	delete_option('wp_math_only_mail');
	delete_option('wp_math_round');
	delete_option('wp_math_static');
	}


//**************************** convert e-mails to image *********************** 
function wp_math_mail($content){
  $size = get_option('wp_math_size');
  $content = preg_replace("/([a-zA-Z0-9\.-]+@[a-zA-Z0-9\.-]+\.[a-zA-Z0-9]{1,3})/", '<m>\1</m>' , $content);
  $content = mathfilter("$content",$size, WP_PLUGIN_URL."/wp-math/img/",false);
  return $content;  
  }

//************************** REPLACE STRING ***********************************
function wp_math_replace($content,$reverse=false){
  $replace = array('&lt;m&gt;' => '<m>', '&lt;/m&gt;' => '</m>',
  '&lt;x&gt;' => '<x>', '&lt;/x&gt;' => '</x>', '–' => '-', 
  '&#8211;' => '-', '&lt;' => '<', '&gt;' => '>');
  if($reverse){
    $keys = array_keys($replace);
    $replace_reversed = "";
    for($i=0;$i<count($keys);$i++){
      $key = $keys[$i];
      $value = $replace["$key"];
      $replace_reversed["$value"] = "$key";
      }
    $replace = $replace_reversed;
    }                   

  $content = strtr($content, $replace);
  return $content; 
  }

//***************************** ADD/remov <m></m> ****************************
function wp_math_replace_tag($string,$find=";",$replace_with="<m>",$add=true){
  if($add){$string = str_replace($find,$replace_with,$string);}
  else{$string = str_replace($replace_with,$find,$string);}
  return $string;
  } 
  
function wp_math_remove($string,$find){
  return str_replace($find,"",$string);
  }
?>