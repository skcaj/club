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
                    <div class="">
                        <i class="fa fa-align-justify"></i> Unidades 
                        <button type="button" @click="abrirModal('unidad','registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre de la Unidad</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="unidad in arrayUnidad" :key="unidad.id">
                                    <td>
                                        <button type="button" @click="abrirModal('unidad','actualizar',unidad)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                         <template v-if="unidad.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUnidad(unidad.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUnidad(unidad.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="unidad.nombreunidad"></td>
                                    <td v-text="unidad.descripcion"></td>
                                    <td>
                                        <div v-if="unidad.condicion">
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{'mostrar':modal}"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4> 
                            <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombreunidad" class="form-control" placeholder="Nombre de la Unidad">
                                        <span class="help-block">(*) Ingrese el nombre de la Unidad</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese Descripcion">
                                    </div>
                                    </div>
                                    <div v-show="errorUnidad" class="form-group row  div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsjUnidad" :key="error" v-text="error" ></div>
                                    </div>
                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUnidad()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUnidad()">Actualizar</button>
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
               unidad_id: 0,
               nombreunidad:'',
                descripcion:'',
                arrayUnidad : [],
                modal:0,
                tituloModal :'',
                tipoAccion :0,
                errorUnidad : 0,
                errorMostrarMsjUnidad : [],
                mensaje:'',
            }
        },
        methods:{
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
            listarUnidad(){
                let me=this;
                var url= '/unidad';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUnidad = respuesta.unidades;
                })
                .catch(function (error) {
                    console.log(respuesta);
                });
            }, 
            registrarUnidad(){
                    if(this.validar()){
                    return;
                }
                let me =this;
            
                     axios.post('/unidad/registrar',{
                      'nombreunidad': this.nombreunidad,
                       'descripcion': this.descripcion                       

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Registro Exitoso';
                       me.mensajeRegistro();
                       me.listarUnidad();
                              
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },
            actualizarUnidad(){
                    if(this.validar()){
                    return;
                }
                let me =this;
            
                     axios.put('/unidad/actualizar',{
                      'nombreunidad': this.nombreunidad,
                       'descripcion': this.descripcion, 
                        'id':this.unidad_id      

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Actualizacion  Exitosa';
                       me.mensajeRegistro();
                       me.listarUnidad();
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
                    case'unidad':{

                        switch (accion) {
                            case 'registrar':
                            {
                               this.modal=1;
                               this.tituloModal='Registrar Unidad';
                               this.nombreunidad=''; 
                               this.descripcion='';
                               this.tipoAccion =1;
                               break;        
                            }
                            case'actualizar':
                            {
                             this.modal=1;
                             this.tituloModal='Actualizar Unidad';
                             this.tipoAccion=2;
                             this.unidad_id=data['id'];
                             this.nombreunidad=data['nombreunidad'];
                             this.descripcion=data['descripcion'];
                             break;

                            }    
                              
                        }
                    }
                }
            },cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreunidad='';
                this.descripcion='';
                this.errorMostrarMsjCategoria='';
            },desactivarUnidad(id){
                
                swal({
                title: 'Esta seguro de desactivar esta Unidad?',
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

                    axios.put('/unidad/desactivar',{
                        'id': id
                    }).then(function (response) {
                      
                        me.listarUnidad();
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

            },activarUnidad(id){
                
                swal({
                title: 'Esta seguro de activar esta Unidad?',
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

                    axios.put('/unidad/activar',{
                        'id': id
                    }).then(function (response) {
                   

                        me.listarUnidad();
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

            },validar(){
                this.errorUnidad=0;
                this.errorMostrarMsjUnidad =[];
                // si nombr es vacio
                if(!this.nombreunidad) this.errorMostrarMsjUnidad.push("* El nombre de la Unidad no puede estar vacio.");
               // si hay datos data en errorMostrarMsjUnidad
               if(this.errorMostrarMsjUnidad.length) this.errorUnidad =1;
                return this.errorUnidad;
                
              }

        },
        mounted() {
            this.listarUnidad();
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
