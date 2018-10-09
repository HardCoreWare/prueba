//parecerá redundante pero por pequeños o simples que sean los datos
//es mejor validarlos y empaquetarlos 

class Request{

    constructor(oldId,newId){

        var json = this.onInit(oldId,newId);

    }

    onInit(oldId,newId){

        var oldFolder=$(oldId).val();
        var newFolder=$(newId).val();

        if ((oldFolder!="")&&(newFolder!="")) {
            
            this.folders={

                oldFolder:oldFolder,
    
                newFolder:newFolder
    
            }

        }

    }

    //obtenemos un JSON para el request
    getJson(){

        var json = JSON.stringify(this.folders)

        return json;

    }

}