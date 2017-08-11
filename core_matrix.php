<?php
$a = "a=matrix{2}{2}{1 2 3 5}*matrix{2}{2}{5 52 3 55}+matrix{2}{2}{5 52 3 55}";

function wp_math_matrix($content){
  preg_match_all("/matrix{[0-9]+}{[0-9]+}{[a-zA-Z0-9\._ ]+}/", $content, $regs, PREG_SET_ORDER);
  $k = 0;
  foreach($regs as $t){
    preg_match_all("/{(.*?)}/", $t[0], $t_values, PREG_SET_ORDER);
    $i_stop = $t_values[0][1];
    $j_stop = $t_values[1][1];
    $values = $t_values[2][1];
    $values = explode(" ", $values);
    $z = 0;
    for($i=0;$i<$i_stop;$i++){
      for($j=0;$j<$j_stop;$j++){
        $matrix[$i][$j] = $values[$z++];
        }
      }
    $MaTrIx[$k] = $matrix;
    $content = str_replace($t[0],'MaTrIx['.$k++.']',$content);
    }
  //$content = preg_replace("/([a-zA-Z_]+)/",'$\1',$content);
  if($k != 0){
  
    $content_new = preg_replace("/MaTrIx\[[0-9]+\]/","ß",$content);
    
    //echo $content_new;
    }
  //echo $content;
  }

wp_math_matrix($a);
/* 
matice 0.2

operacie s maticami:
vynasob_matice($A,$B,$show)   - vynásobi maticu $A a maticu $B
                              - 1 - nepovinny argument, zobrazi vysledok

vynasob($A,$show)             - vrati transponovanu maticu
                              - 1 - nepovinny argument, zobrazi vysledok

inverzna_matica($A,$show)     - vrati inverznu maticu
                              - 1 - nepovinny argument, zobrazi vysledok
                              - inverzna matica sa pocita pomocou determinanta
                          
jednotkova_matica($n,$show)   - vrati jednotkovu matici $nx$n
                              - 1 - nepovinny argument, zobrazi vysledok                          
                          
minimum($A,$show)             - vráti minimálnu hodnotu z mnoziny
                              - 1 - nepovinny argument, zobrazi vysledok
                          
maximum($A,$show)             - vráti maximalnu hodnotu z mnoziny
                              - 1 - nepovinny argument, zobrazi vysledok                          

determinant_matice($A,1)      - vrati determinant matice
                              - 1 - nepovinny argument, zobrazi determinant
                              
cofactor($A,1)                - vrati cofactor matice
                              - 1 - nepovinny argument, zobrazi determinant

zmensi_o_riadok_a_stlpec($A,$i,$j)- zmensi maticu $A a riadok $i a stlpec $j
                              - 1 - nepovinny argument, zobrazi determinant

scitaj_matice($A,$B,1)        - scita matice
                              - 1 - nepovinny argument, zobrazi determinant
                              
odcitaj_matice($A,$B,1)       - odcita matice
                              - 1 - nepovinny argument, zobrazi determinan                              
                                                       
kontrola_stvorca($A)          - skontroluje ci je matica stvorcova ak ano vrati
                              true






******************************************************************************                          
funkcie na zobrazovanie   
zobraz($A)                - zobrazi funkciu $A      

nasobenie($A,$B,$show)    - zobrazi nasobenie matic $A a $B
                          - 0 - nepovinny argument, nezobrazi vysledok
                          
                          
*******************************************************************************

*/




//************************** nasobenie matic **********************************
function vynasob_matice($A,$B,$show=0){
   if(count($B) == 1 && count($B[0]) == 0 && count($A) != 1 && count($A[0]) != 0){
      for($i=0;$i<count($A);$i++){
        for($j=0;$j<count($A[0]);$j++){
          $C[$i][$j] = $A[$i][$j]*$B;
          }
        }
      if($show==1){zobraz($C);}
      return $C;   
      }
    elseif(count($A) == 1 && count($A[0]) == 0 && count($B) != 1 && count($B[0]) != 0){
      for($i=0;$i<count($B);$i++){
        for($j=0;$j<count($B[0]);$j++){
          $C[$i][$j] = $B[$i][$j]*$A;
          }
        }
      if($show==1){zobraz($C);}
      return $C;  
      }
    elseif(count($B) == 1 && count($B[0]) == 0 && count($A) == 1 && count($A[0]) == 0){
      $C = $A*$B;
      if($show==1){zobraz($C);}
      return $C; 
      }
    elseif(count($A[0]) == count($B)){ //pocet stlpcov lavej matice sa musi rovnat poctu riadkov pravej matice
      $A_x = count($A[0]);     //pocet stlpcov $A
      $A_y = count($A);        //počet riadkov $A
      $B_x = count($B[0]);      //pocet stlpcov $B
      $B_y = count($B);         //pocet riadkov $B
    
  
      for($i=0;$i<$A_y;$i++){
        for($j=0;$j<$B_x;$j++){
          $c[$i][$j] = 0;
          for($k=0;$k<$A_x;$k++){
            $c[$i][$j] = $c[$i][$j]+($A[$i][$k]*$B[$k][$j]);
            }
          }
         }
      if($show==1){zobraz($c);}
      return $c; 
      }
    else{
      echo "Tieto matice sa nedaju vynasobit. Pocet stlpcov lavej matice sa musi rovnat poctu riadkov pravej matice.";
      }
     }

//********************** transponovana matica *********************************

function transponuj_maticu($A,$show=0){
  for($i=0;$i<count($A[0]);$i++){
    for($j=0;$j<count($A);$j++){
      $c[$i][$j]= $A[$j][$i];
      }
    }
  if($show==1){
    zobraz($c);
    }
  return $c;  
  }

//********************** inverzna matica **************************************


function inverzna_matica_1($A,$show=0){
  if(count($A) != count($A[0])){
    echo ("<table><tr><td>");
    zobraz($A);
    echo ("</td><td>Inverzna matica sa da robit len zo stvorcovej matice</td></tr></table>");
    die();
    }
  elseif(count($A) == count($A[0])){
    for($riadok=0;$riadok<count($A);$riadok++){
      if($A[$riadok][$riadok]==0){
        echo ("<table><tr><td>");
        zobraz($A);
        echo ("</td><td>Na diagonale nesmie byt nula</td></tr></table>");
        die();        
        }
      }
    }

    //2. vytvorenie jednotkovej matice
for($riadok=0;$riadok<count($A);$riadok++){
    for($stlpec=0;$stlpec<count($A);$stlpec++){    
        if($riadok==$stlpec){
            $I[$riadok][$stlpec]=1;
        }else{
            $I[$riadok][$stlpec]=0;    
        }
    }
}
//3. inverzna matica pre diagonalu a dolny trojuholnik
for($riadok=0;$riadok<count($A);$riadok++){                //1.cyklus - inverzna matica pre diagonalu
    $t=$A[$riadok][$riadok];                            //ulozenie diagonalneho prvku do prechodnej premennej
    if($t==0){
        echo("<P>Chyba: Pri výpočte sa na diagonále objavila nula!</P>");
        die;
    }
    for($stlpec=0;$stlpec<count($A);$stlpec++){        //predelenie vsetkych prvkov v riadku diag. prvkom
        $A[$riadok][$stlpec]/=$t;
    }
    for($stlpec=0;$stlpec<count($A);$stlpec++){            //to iste pre jednotkovu maticu
        $I[$riadok][$stlpec]/=$t;        
    }
    for($r=$riadok+1;$r<count($A);$r++){                    //2.cyklus - inverzna matica pre dolny trojuholnik
        $t=$A[$r][$riadok];                                //t je prvok pod diagonalou
        for($stlpec=$riadok;$stlpec<count($A);$stlpec++){    
            $A[$r][$stlpec]-=$A[$riadok][$stlpec]*$t;    //od r-riadku odpocitame t*predchadzajuci riadok
        }
        for($stlpec=0;$stlpec<count($A);$stlpec++){        //to iste pre jednotkovu maticu
            $I[$r][$stlpec]-=$I[$riadok][$stlpec]*$t;
        }
    }
}
//4. inverzna matica pre horny trojuholnik
for($riadok=count($A)-1;$riadok>0;$riadok--){                //3.cyklus - inverzna matica pre horny trojuholnik
    for($r=$riadok-1;$r>=0;$r--){
        $t=$A[$r][$riadok];                                //t je prvok nad diagonalou
        for($stlpec=$riadok;$stlpec<count($A);$stlpec++){    
            $A[$r][$stlpec]-=$A[$riadok][$stlpec]*$t;    
        }
        for($stlpec=0;$stlpec<count($A);$stlpec++){
            $I[$r][$stlpec]-=$I[$riadok][$stlpec]*$t;    
        }
    }
}
    if($show==1){zobraz($I);}
    return $I;
    
    
  }


//**************************** JEDNOTKOVA MATICA ******************************
function jednotkova_matica($n,$show=0){
  for($i=0;$i<$n;$i++){
    for($j=0;$j<$n;$j++){
      if($j==$i){$C[$i][$j] = 1;}
      else{$C[$i][$j] = 0;}
      }
    }
  if($show==1){zobraz($C);}
  return $C;  
  }
  
//*************************** MAXIMALNE CISLO ********************************
function maximum($A,$show=0){
  if(count($A[0]) == 0 &&  count($A) == 1){
    if($show==1){zobraz($A);}
    return $A;  
    }
    elseif((count($A) != 1 && count($A[0]) == 1) || (count($A[0]) != 1 && count($A) == 1)){
      $x = max($A);
      if($show==1){zobraz($x);}
      return $x;      
      }
  else{
    $x = $A[0][0];
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        if($x<$A[$i][$j]){$x=$A[$i][$j];}
        }
      }
    if($show==1){zobraz($x);}
    return $x;
    } 
  }




//*************************** MINIMALNE CISLO ********************************
function minimum($A,$show=0){
  if(count($A[0]) == 0 &&  count($A) == 1){
    if($show==1){zobraz($A);}
    return $A;  
    }
    elseif((count($A) != 1 && count($A[0]) == 1) || (count($A[0]) != 1 && count($A) == 1)){
      $x = min($A);
      if($show==1){zobraz($x);}
      return $x;      
      }
  else{
    $x = $A[0][0];
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        if($x>$A[$i][$j]){$x=$A[$i][$j];}
        }
      }
    if($show==1){zobraz($x);}
    return $x;
    }  
  }

//*************************** DETERMINANT MATICE ******************************

    
function determinant_matice($A,$show=0){
  if(!kontrola_stvorca($A)){}
  elseif(count($A) == 1){return $A[0][0];}
  else{
    $det=0;
    for($i=0;$i<count($A);$i++){        //0-pocet riadkov
      $riadok1=0;
      for($riadok=0;$riadok<count($A);$riadok++){
        if($riadok!=$i){
          for($stlpec=0;$stlpec<count($A)-1;$stlpec++){
            $A1[$riadok1][$stlpec]=$A[$riadok][$stlpec+1];
            }    
          $riadok1++;
          }
        }
      if($i%2==0){                    //parne +
        $det+=$A[$i][0]*determinant_matice($A1);
        }
      else{                            //neparne -
        $det-=$A[$i][0]*determinant_matice($A1);
        }
      }
    if($show==1){zobraz($det);}  
    return $det;
    }
  }

//************************* COFACTOR FUNKCIE **********************************
function cofactor($A,$show=0){
  for($i=0;$i<count($A);$i++){
    for($j=0;$j<count($A[0]);$j++){
      $C[$i][$j] = pow(-1,$i+$j)*$A[$i][$j];
      }
    }
  if($show==1){zobraz($C);}  
  return $C;
  }
//*************************** ZMENSI MATICU O JEDEN RIADOK A STLPEC **********


function zmensi_o_riadok_a_stlpec($A,$i,$j){
$n = 0;
  for($a=0;$a<count($A);$a++){
    $m = 0;
    for($b=0;$b<count($A[0]);$b++){
      if($a==$i){}
      elseif($b==$j){}
      else{
        $X[$i][$j][$m][$n] = $A[$b][$a];
        $m++;
        }
      }
    if($a==$i){}
      elseif($b==$j){}
      else{
      $n++;
      }
    }
  return $X[$i][$j]; 
  }

//*************************** INVERZNA MATICA DETERMINANTOM ******************

function inverzna_matica($A,$show=0){
  if(kontrola_stvorca($A)){
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        $X[$i][$j] = zmensi_o_riadok_a_stlpec($A,$i,$j);
        $D[$i][$j] = determinant_matice($X[$i][$j]);
        }
      }
    $D = cofactor($D);
    $det = 1/determinant_matice($A);
    $I = vynasob_matice($det,$D);
    if($show==1){zobraz($I);}
    return $I;
    }
  }


//*************************** SCITAVANIE MATIC ********************************

function scitaj_matice($A,$B,$show=0){
  if(count($A) != count($B) || count($A[0]) != count($B[0])){echo "matice sa nedaju scitat";}
  else{
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        $D[$i][$j] = $A[$i][$j]+$B[$i][$j];
        }
      }
    if($show==1){zobraz($D);}
    return $D;           
    }
  }

//*************************** ODCITANIE MATIC ********************************

function odcitaj_matice($A,$B,$show=0){
  if(count($A) != count($B) || count($A[0]) != count($B[0])){echo "matice sa nedaju scitat";}
  else{
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        $D[$i][$j] = $A[$i][$j]-$B[$i][$j];
        }
      }
    if($show==1){zobraz($D);}
    return $D;           
    }
  }

//*************************** KONTROLA CI JE STVORCOVA MATICA *****************

function kontrola_stvorca($A){
  if(count($A)==count($A[0])){return true;}
  else{
    echo "<table><tr><td style='text-align: center;'>";
    zobraz($A);
    echo "</td></tr><tr><td style='text-align: center;'><b>Matica nieje stvorcova</b></td></tr></table>";
    return false;
    }
  }

//*************************** RIESENIE ROVNIC *********************************
//*************************** LINEARNE ROVNICE ********************************
//*************************** REISENIE POMOCOU INVERZNEJ MATICE ***************

function linearne_funkcie($A,$B,$show=0){
  $A = inverzna_matica($A);
  $D = vynasob_matice($A,$B);
  if($show==1){zobraz($D);}
  return $D;
  }



//*************************** ZOBRAZOVANIE ************************************  
//*************************** ZOBRAZ MATICU ***********************************


function zobraz($A){
  if(count($A) == 1 &&  count($A[0]) == 0){echo $A;}
  else{
    echo "<table style='border-left: 1px solid black; border-right: 1px solid black'>";
    for($i=0;$i<count($A);$i++){
      echo "<tr>";
      for($j=0;$j<count($A[0]);$j++){
        if(count($A[$i][$j]) == 1 && count($A[$i][$j] == 1)){
          echo "<td style=\"text-align: center; padding: 0px 3px 0px 3px\">".$A[$i][$j]."</td>";
          }
        else{
          echo "<td style=\"text-align: center; padding: 0px 3px 0px 3px\">";        
          zobraz($A[$i][$j]);
          echo "</td>";
          }
        }     
      echo "</tr>";
      }
    echo "</table>";
    }
  }


function nasobenie($A,$B,$show=1){
  echo "<table><tr><td>";
  zobraz($A);
  echo "</td><td>&nbsp;&nbsp;x&nbsp;&nbsp; </td><td>";
  zobraz($B);
  echo "</td>";
  if($show==1){
    echo "<td>&nbsp;&nbsp;=&nbsp;&nbsp;</td>";
    }
  echo "<td>";
  vynasob_matice($A,$B,$show);
  echo "</td></tr></table>";
  }


  ?>