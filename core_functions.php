<?php
//******************** ADD INPUTS FROM FORM **********************************
function wp_math_inputs($content){
  if(isset($_POST["add_inputs"])){
    preg_match_all("|[a-zA-Z_]+=[0-9\.]+|", $_POST["inputs"], $regs, PREG_SET_ORDER);
    $inputs = "";
    foreach($regs as $inputs_securited){
      $inputs .= $inputs_securited[0]."\n";
      }       
    $inputs = "Input Values:<br /><m>".str_replace("\n","</m> <m>",$inputs)."</m>";
    $content = str_replace("[/form]","[/form] <br />$inputs <br /><br />",$content);
    }
  else{
    preg_match_all("|\[form\](.*?)\[\/form\]|", $content, $form, PREG_SET_ORDER);
    $form = "Default Values:<br /><m>".str_replace(";","</m> <m>",$form[0][1])."</m>";
  
    $content = str_replace("[/form]","[/form] <br />$form <br /><br />",$content);
    }
  return $content;
  }

//*********************FIND AND REPLACE *************************************
function wp_math_find_count_replace($content){
  
  preg_match_all("|<m>(.*?)</m>|", $content, $regs, PREG_SET_ORDER);
  foreach($regs as $math){
    $t = $math[0];
    $t = str_replace(";","</m><m>",$t);
    $t = preg_replace("|(<m>p:)(.*?)(</m>)|",' \2 ',$t);
    $content = str_replace($math[0],$t,$content); 
    }
  $content = str_replace("<m>n</m>","<br />",$content);  
  
  preg_match_all("|<m>(.*?)</m>|", $content, $regs, PREG_SET_ORDER);
 
  foreach($regs as $math){
    $code = $math[0]; 
    $t=str_replace('<m>','',$math[0]);
  	$t=str_replace('</m>','',$t);
  	
    //$t = wp_math_matrix($t);
    
    $t=str_replace('{','(',$t);
  	$t=str_replace('}',')',$t);

    $lenght = strlen($t);
    
    if($t[$lenght-1] == "=" && $t[$lenght-2] != "="){
      $t = substr($t, 0, -1);
      }
    elseif($t[$lenght-1] == "=" && $t[$lenght-2] == "="){
      $t = substr($t, 0, -2);
      }

    // math variables:
    include("math_variables.php");

    $t = wp_math_units($t);
    $t = preg_replace("/([a-zA-Z_]+)/",'$\1', $t);
    
    $t = wp_math_functions_replace($t);
    $t = wp_math_implemented_functions($t);
    
    $t .= ";";
    eval($t);
    
    $t=str_replace(array('<m>','</m>'), array('',''), $code);
  
    $lenght = strlen($t);
    
    if($t[$lenght-1] == "=" && $t[$lenght-2] != "="){
      $t = substr($t, 0, -1);
      $vysledok = explode("=",$t);
      $vysledok = $$vysledok[0];
      $vysledok = round($vysledok,get_option("wp_math_round"));
      $t = $t."=".$vysledok;
      }
    elseif($t[$lenght-1] == "=" && $t[$lenght-2] == "="){
      $t = substr($t, 0, -2);
      $t_new = explode("=",$t);
      $vysledok = $$t_new[0];
      $vysledok = round($vysledok,get_option("wp_math_round"));
      $t_new = $t_new[1];
              
      preg_match_all("|[a-zA-Z_]+|", $t_new, $result, PREG_SET_ORDER);
      //print_r($result);    
      foreach($result as $result_in){
        if(wp_math_check_for($result_in[0])){}
        else{
          if($$result_in[0] == ""){
            $$result_in[0] = "Missing";
            $vysledok = "Error";
            }
          $t_new = str_replace($result_in[0], $$result_in[0], $t_new);
          }
        }                                    
      $t = $t."=".$t_new."=".$vysledok;
      }
    $t = " <m>$t</m> ";
    $t = preg_replace("/abs\((.*?)\)/",'delim{|}{\1}{|}',$t);  //delete abs add absolute value
    $t = preg_replace("/log\((.*?),(.*?)\)/",'log_\2(\1)',$t);  //convert logarithm 
    $content = str_replace($math[0], $t, $content);
    }
  //******************* BUG with tabular need to add . on the end***************
    
  return $content;  
  }
  

?>