<?php
if (isset($_POST['cedula'])){
    function validarCI($strCedula){
        if(is_null($strCedula) || empty($strCedula)){
            echo "Por favor ingrese la cedula";
        }else{//caso contrario sigo el proceso
            if(is_numeric($strCedula)){
                $total_caracteres=strlen($strCedula);
                if($total_caracteres==10){
                    $nro_region=substr($strCedula,0,2);
                    if($nro_region>=1 && $nro_region<=24){
                        $ult_digito=substr($strCedula, -1,1);
                        $valor2=substr($strCedula,1,1);
                        $valor4=substr($strCedula,3,1);
                        $valor6=substr($strCedula,5,1);
                        $valor8=substr($strCedula,7,1);
                        $suma_pares=($valor2+$valor4+$valor6+$valor8);
                        $valor1=substr($strCedula,0,1);
                        $valor1=($valor1*2);
                        if($valor1>9){$valor1=($valor1-9);}else{ }
                        $valor3=substr($strCedula,2,1);
                        $valor3=($valor3*2);
                        if($valor3>9){$valor3=($valor3-9);}else{ }
                        $valor5=substr($strCedula,4,1);
                        $valor5=($valor5*2);
                        if($valor5>9){$valor5=($valor5-9);}else{ }
                        $valor7=substr($strCedula,6,1);
                        $valor7=($valor7*2);
                        if($valor7>9){$valor7=($valor7-9);}else{ }
                        $valor9=substr($strCedula,8,1);
                        $valor9=($valor9*2);
                        if($valor9>9){$valor9=($valor9-9);}else{ }
                        $suma_impares=($valor1+$valor3+$valor5+$valor7+$valor9);
                        $suma=($suma_pares+$suma_impares);
                        $dis=substr($suma, 0,1);
                        $dis=(($dis+1)*10);
                        $digito=($dis - $suma);
                        if ($digito==10) { $digito='0'; }else{ }
                        if ($digito==$ult_digito){
                            echo "Cédula válida";
                        }else{
                            echo 'Cédula no válida';
                        }
                    }else{
                        echo 'Cédula no válida';
                    }
                }else{
                    echo "Cédula no válida";  
                }
            }else{
                
                echo "Cédula no válida";
            }
        }
    }
    $cedula = validarCI($_POST["cedula"]);
    echo $cedula;
}
?> 