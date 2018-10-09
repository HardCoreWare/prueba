<?php

class Billing{

    private $Combrobante=[];

    //leemos el comprobante
    public function bill($route){

        $Combrobante=[];

        //creamos objeto XML y procesamos los datos
        $xml = simplexml_load_file($route); 

        foreach($cfdiComprobante=$xml->xpath('//cfdi:Comprobante') as $value){

            $Comprobante['fecha']=strval($value['fecha']);
            $Comprobante['folio']=strval($value['folio']);
            $Comprobante['serie']=strval($value['serie']);

            foreach($cfdiEmisor=$xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $value){

                $Comprobante['Emisor']['rfc']=strval($value['rfc']);

                foreach($cfdiReceptor=$xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $value){


                    $Comprobante['Emisor']['Receptor']['rfc']=strval($value['rfc']);
        
                }
    
            }

        }

        // el comprobante es un array asociativo en forma de arbol
        return $Comprobante;

    }

    //funcion para mover archivos
    public function rename_and_move($old_path,$new_path){

        copy($old_path,$new_path);

    }

}




?>