<?php

// se utiliza herencia anidando en las clases hijas, los metodos
// de las clases padre
require_once('billing.php');

final class Scheduler extends Billing{

    private $files=[];

    private $oldFolder;
    private $newFolder;

    private $table=[];

    public function __construct($req){
        
        $this->scan($req);
        $this->read();
        $this->transcrypt();
        $this->tables();

    }

/***********************************************************************/    

    //esta funcion es intencionalmente re-iterativa
    //cuidando cotejar todos los archivos y etiquetarlos al maximo
    //pensando en a partir de estos datos crear funcionalidades mas complejas opcionalmente
    public function scan($req){

        $folders = json_decode($req);
        $this->oldFolder = $folders->oldFolder;
        $this->newFolder = $folders->newFolder;

        // checamos que existan las carpetas
        if((file_exists($this->oldFolder))&&(file_exists($this->newFolder))){

            $files=scandir($this->oldFolder);    

            foreach ($files as $file) {
    
                $file_comp = explode(".",$file);
    
                $ext = $file_comp[1];

                $name = $file_comp[0];

                $line=[];

                switch ($ext) {

                    case 'xml': $this->files[$name]['xml'] = $file;  break;

                    case 'pdf': $this->files[$name]['pdf'] = $file;  break;
    
                }
    
            }

            //se asegura que existan ambos archivos en su respectivo formato
            foreach ($this->files as $name => $couple) {

                if ((isset($couple['xml']))&&(isset($couple['pdf']))) {

                    $this->files[$name]['parity']=true;

                }

                else{

                    $this->files[$name]['parity']=false;

                }

            }

        }

        //en caso de no leer las carpetas marcamos error
        else{ 

            echo("error");
            $this->files=null;

        }

    }
    
/**************************************************************************************/
 
    //leemos la matriz de archivos y creamos tabla con nuevos nombres
    public function read(){

        $i=0;


        foreach ($this->files as $key=>$data) {

            if($data['parity']){

                $xml_file=$data['xml'];

                $pdf_file=$data['pdf'];

                $factura=$this->bill($this->oldFolder.'/'.$xml_file);

                $fecha=$factura['fecha'];

                $serie=$factura['serie'];

                $folio=$factura['folio'];

                $rfce=$factura['Emisor']['rfc'];

                $rfcr=$factura['Emisor']['Receptor']['rfc'];

                $ff=explode("-",$fecha);


                $nn=array($ff[1].$ff[0],$rfce,$folio.$serie);

                $new_name=implode("_",$nn);
                
                $this->table[$i]['old']=$xml_file;
                $this->table[$i]['new']=$new_name."."."xml";

                $i++;

                $this->table[$i]['old']=$pdf_file;
                $this->table[$i]['new']=$new_name."."."pdf";

                $i++;
                
            }

            $this->files=null;

        }

    }

/***********************************************************************/    

    // trascribimos los archivos a partir de la tabla creada
    public function transcrypt(){

        foreach ($this->table as $file) {

            $this->rename_and_move($this->oldFolder.'/'.$file['old'],$this->newFolder.'/'.$file['old']);

        }

    }

/***********************************************************************/    

    //imprimimos la tabla como un JSON
    public function tables(){

        foreach ($this->table as $line) {

            $jsons[]=json_encode($line);

        }

        $json=implode(",",$jsons);

        $response="[".$json."]";

        echo($response);

    }

}

?>