class Table{

    constructor(title,json,divId){

        this.onInit(json);
        this.write(title,divId);

    }

    onInit(json){

        this.data=JSON.parse(json);

    }

    write(title,divId){

        this.table='';

        this.table+='<div class="card mb-3">';
        this.table+='<div class="card-header">';
        this.table+=title;
        this.table+='</div>';
        this.table+='<div class="card-body">';
        this.table+='<div class="table-responsive">';
        this.table+='<table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">';

        this.table+='<thead>';
        this.table+='<tr>';
        this.table+='<th>';
        this.table+='Formato Viejo';
        this.table+='</th>';
        this.table+='Formato Nuevo';
        this.table+='<th>';
        this.table+='</th>';
        this.table+='</tr>';
        this.table+='</thead>';

        this.table+='<tbody>';

        for(var i=0; i<this.data.length; i++){

            this.table+='<tr>';
            this.table+='<td>';
            this.table+=this.data[i].old;
            this.table+='</td>';
            this.table+='<td>';
            this.table+=this.data[i].new;
            this.table+='</td>';
            this.table+='</tr>';

        }

        this.table+='</tbody>';

        this.table+='</table>';
        this.table+='</tbody>';
        this.table+='</table>';
        this.table+='</div>';
        this.table+='</div>';

        $(divId).html(this.table);
    }

}
