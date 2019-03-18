<template>
   <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
             <div class="">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Listado de Conquistadores
                        <button type="button" @click="abrirModal('conquistador','registrar')" class="btn btn-secondary" data-toggle="modal" data-target="#modalNuevo">
                            <i class="fa fa-user-plus fa-lg"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="cargarPdf()" class="btn btn-secondary" v-if="admin!=3">
                            <i class="icon-doc"></i>&nbsp;reporte
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row"  >
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio" v-on:click="modo()">
                                      <option value="nombres" >Nombre</option>
                                      <option value="identidad">Numero de identidad</option>
                                        <option value="unidad" v-if="admin!=3">Por Unidad</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarConquistador(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar" v-if="criterio!='unidad'">
                                    <select class="form-control" v-model="buscar" v-else>
                                            <option value="">Seleccione una Unidad</option>
                                            <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad">

                                            </option>
                                        </select>
                                    <button type="submit" @click="listarConquistador(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th  v-if="admin!=3">Opciones</th>
                                    <th>Identidad</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>unidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="conquistador in arrayConquistador" :key="conquistador.id">
                                    <td v-if="admin!=3">
                                        <button type="button" @click="abrirModal('conquistador','actualizar',conquistador)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                         <template v-if="conquistador.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarConquistador(conquistador.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activar(conquistador.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="conquistador.identidad"></td>
                                    <td  ><i class="fa fa-user"></i>&nbsp;&nbsp;{{conquistador.nombres+" "+conquistador.apellidos}}</td>
                                    <td v-text="conquistador.unidad.nombreunidad"> </td>
                                    <td>
                                        <div v-if="conquistador.condicion">
                                        <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{'mostrar':modal}"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4> 
                            <button type="button" class="close"  @click="cerrarModal()" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Identidad</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="identidad" class="form-control" placeholder="Numero de Identidad">
                                        <span class="help-block">(*) Numero de Identidad</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombres" class="form-control" placeholder="Nombres">
                                        <span class="help-block">(*) Ingrese Nombres</span>
                                    </div>
                                 </div> <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellidos</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos">
                                        <span class="help-block">(*) Ingrese Apellidos</span>
                                    </div>
                                </div> <div class="form-group row" v-if="admin!=3">
                                    <label class="col-md-3 form-control-label" for="text-input" >Unidad</label>
                                        <div class="col-md-9">
                                        <select class="form-control" v-model="idunidad"  >
                                            <option value="0">Seleccione una Unidad</option>
                                            <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad">

                                            </option>
                                        </select>
                                    </div>
                                    </div>
                                    <div v-show="errorUnidad" class="form-group row  div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMensajeUnidad" :key="error" v-text="error" ></div>
                                    </div>
                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" data-dismiss="modal" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarConquistador()" data-dismiss="modal">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarConquistador()" data-dismiss="modal">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </main>
</template>

<script>
    export default {

        data(){
            return{ /// aca se registran todas la Variables
               idconquistador: 0,
                nombres:'',
                apellidos:'',
                identidad:'',
                idunidad:0,
                arrayConquistador : [],
                arrayUnidad :[],
                modal:0,
                tituloModal :'',
                tipoAccion :0,
                errorUnidad : 0,
                errorMostrarMensajeUnidad : [],
                 pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombres',
                buscar : '',
                mensaje:'',
                admin:0,
                
            }
        },
         computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods:{
            modo(){
                if(this.criterio!="unidad") this.buscar="";
                else this.buscar='';
            },
            cargarPdf(){
                window.open('http://localhost:8000/conquistador/listarPdf','_blank');
            },
            mensajeRegistro(){
                const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
                });
                toast({
                type: 'success',
                title: this.mensaje
                })
            },
            listarConquistador (page,buscar,criterio){
                let me=this;
                var url= '/conquistador?page=' + page +'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayConquistador = respuesta.conquistadores.data;
                    me.pagination= respuesta.pagination;
                      me.admin  = respuesta.usuario;
                })
                .catch(function (error) {
                    console.log(error);
                });
               
            },cargarUnidades(){
                let me=this;
                var url= '/unidad/activa';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUnidad = respuesta.unidades;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarConquistador(page,buscar,criterio);
            },registrarConquistador(){
                    if(this.validarConquis()){
                    return;
                }
                let me =this;
            
                     axios.post('/conquistador/registrar',{
                      'identidad': this.identidad,
                      'nombres': this.nombres,
                       'apellidos': this.apellidos,
                       'unidad': this.idunidad
                         

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Registro Exitoso';
                       me.mensajeRegistro();
                       me.listarConquistador(1,'','nombres');
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },actualizarConquistador(){
                    if(this.validarConquis()){
                    return;
                }
                let me =this;
            
                     axios.put('/conquistador/actualizar',{
                       'identidad': this.identidad,
                      'nombres': this.nombres,
                       'apellidos': this.apellidos,
                       'unidad': this.idunidad,
                       'id':this.idconquistador    

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Actualizacion  Exitosa';
                       me.mensajeRegistro();
                       me.listarConquistador(me.pagination['current_page'],'','nombres');
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },abrirModal(modelo, accion, data=[]){

            

                switch(modelo){
                    case'conquistador':{

                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar conquistador';
                                this.nombres=''; 
                                this.apellidos='';
                                this.identidad='';
                                this.tipoAccion =1;
                                break;        
                            }
                            case'actualizar':
                            {
                             this.modal=1;
                             this.tituloModal='Actualizar conquistador';
                             this.tipoAccion=2;
                             this.idconquistador =data['id'];
                             this.identidad=data['identidad'];
                             this.nombres=data['nombres'];
                             this.apellidos=data['apellidos'];
                             this.idunidad=data.unidad['id'];
                             break;

                            }    
                              
                        }
                    }
                }
            },cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombres='';
                this.apellidos='';
                this.idunidad=0;
                this.identidad='';
                this.errorMostrarMensajeUnidad='';
            },desactivarConquistador(id){
                
                swal({
                title: 'Esta seguro de desactivar este registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/conquistador/desactivar',{
                        'id': id
                    }).then(function (response) {
                      
                        me.listarConquistador(me.pagination['current_page'],'','nombres');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelado!',
                        'Operacion Cancelada.',
                        'Error'
                        )
                }
                }) 

            },activar(id){
                
                swal({
                title: 'Esta seguro de activar Conquistador ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/conquistador/activar',{
                        'id': id
                    }).then(function (response) {
                   

                        me.listarConquistador(me.pagination['current_page'],'','nombres');
                        swal(
                        'Activado!',
                        'El registro ha sido Activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelado!',
                        'Operacion Cancelada.',
                        'Error'
                        )
                }
                }) 

            },
            validarConquis(){
                this.errorUnidad=0;
                this.errorMostrarMensajeUnidad =[];
                // si nombr es vacio
                if(!this.nombres || !this.apellidos || !this.identidad) this.errorMostrarMensajeUnidad.push("* Todos los Campos deben estar completos");
                if(!this.idunidad && this.admin!=3)  this.errorMostrarMensajeUnidad.push("* debe selecionar un campo ");
               // si hay datos data en errorMostrarMensajeUnidad
               if(this.errorMostrarMensajeUnidad.length) this.errorUnidad =1;
                return this.errorUnidad;
                
              }

            },
            
        mounted() {
            this.listarConquistador(1,this.buscar,this.criterio);
              this.cargarUnidades();
        }
    }
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute!important;
}

.mostrar{
   display: list-item !important; 
   opacity: 1 !important;
   background-color: #3c29297a !important;
       overflow-y: auto;
   
}

  .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
