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
                        <i class="fa fa-align-justify"></i> Tipos de Pagos 
                        <button type="button" @click="abrirModal('registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Registrar Nuevo Pago
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre del Pago</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pagos in arrayPagos" :key="pagos.id">
                                    <td>
                                        <button type="button" @click="abrirModal('actualizar',pagos)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                         <template v-if="pagos.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivar(pagos.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activar(pagos.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="pagos.nombrepagos"></td>
                                    <td v-text="pagos.descripcion"></td>
                                    <td>
                                        <div v-if="pagos.condicion">
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
                                        <input type="text" v-model="nombrepagos" class="form-control" placeholder="Nombre del Pago">
                                        <span class="help-block">(*) Ingrese el nombre del Pago</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese Descripcion">
                                    </div>
                                    </div>
                                    <div v-show="errorModo" class="form-group row  div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMsj" :key="error" v-text="error" ></div>
                                    </div>
                                    </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrar()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizar()">Actualizar</button>
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
               id: 0,
               nombrepagos:'',
                descripcion:'',
                arrayPagos : [],
                modal:0,
                tituloModal :'',
                tipoAccion :0,
                errorModo : 0,
                errorMostrarMsj : [],
                mensaje:'',
                titulo:'Tipos Pagos',
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
            listar(){
                let me=this;
                var url= '/tipopagos';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPagos = respuesta.tipos_pagos;
                })
                .catch(function (error) {
                    console.log(respuesta);
                });
            }, 
            registrar(){
                    if(this.validar()){
                    return;
                }
                let me =this;
            
                     axios.post('/tipopagos/registrar',{
                      'nombrepagos': this.nombrepagos,
                       'descripcion': this.descripcion                       

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Registro Exitoso';
                       me.mensajeRegistro();
                       me.listar();
                              
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },
            actualizar(){
                    if(this.validar()){
                    return;
                }
                let me =this;
            
                     axios.put('/tipopagos/actualizar',{
                      'nombrepagos': this.nombrepagos,
                       'descripcion': this.descripcion, 
                        'id':this.id      

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Actualizacion  Exitosa';
                       me.mensajeRegistro();
                       me.listar();
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },abrirModal( accion, data=[]){

                        switch (accion) {
                            case 'registrar':
                            {
                               this.modal=1;
                               this.tituloModal='Registrar '+this.titulo;
                               this.nombrepagos=''; 
                               this.descripcion='';
                               this.tipoAccion =1;
                               break;        
                            }
                            case'actualizar':
                            {
                             this.modal=1;
                             this.tituloModal='Actualizar '+this.titulo;
                             this.tipoAccion=2;
                             this.id=data['id'];
                             this.nombrepagos=data['nombrepagos'];
                             this.descripcion=data['descripcion'];
                             break;

                            }    
                              
                        }
                    
                
            },cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombrepagos='';
                this.descripcion='';
                this.errorMostrarMsj='';
            },desactivar(id){
                
                swal({
                title: 'Esta seguro de desactivar?',
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

                    axios.put('/tipopagos/desactivar',{
                        'id': id
                    }).then(function (response) {
                      
                        me.listar();
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
                title: 'Esta seguro de activar ',
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

                    axios.put('/tipopagos/activar',{
                        'id': id
                    }).then(function (response) {
                   

                        me.listar();
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
                this.errorModo=0;
                this.errorMostrarMsj =[];
                // si nombr es vacio
                if(!this.nombrepagos) this.errorMostrarMsj.push("* El nombre no puede estar vacio.");
               // si hay datos data en errorMostrarMsj
               if(this.errorMostrarMsj.length) this.errorModo =1;
                return this.errorModo;
                
              }

        },
        mounted() {
            this.listar();
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
/*.modal-body{
  height: 350px;
  overflow-y: auto;
}*/
  .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
