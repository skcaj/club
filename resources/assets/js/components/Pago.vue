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
                        <i class="fa fa-align-justify"></i> Listado de Pagos
                        <button type="button" @click="abrirModal('registrar')" class="btn btn-secondary" >
                            <i class="fa fa-user-plus fa-lg"></i>&nbsp;Nuevo Registro
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table  table-hover display" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre Conquistador</th>
                                    <th>Monto del Pago</th>
                                    <th>I/E</th>
                                    <th>Saldo</th>
                                    <th>Tipo de Pago</th>                                    
                                    <th>Condicion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pago in arrayPago" :key="pago.id">
                                    <td class="text-center"  >
                                        <button type="button" @click="abrirModal( 'actualizar',pago)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-info btn-sm" title="Ver Observacion" @click="abrirModal('observacion',pago)">
                                                <i class="fa fa-eye fa-lg " ></i>
                                        </button>&nbsp;
                                         <template v-if="pago.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivar(pago.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activar(pago.id)">
                                                <i class="icon-check"></i>
                                            </button> &nbsp;
                                        </template>
                                        
                                        
                                    </td>
                                    <td  ><i class="fa fa-user"></i>&nbsp;&nbsp;{{pago.conquistador.nombres+" "+pago.conquistador.apellidos}}</td>
                                    <td v-text="pago.monto" class="text-center"> </td>
                                 
                                    <td class="text-center"  v-if="pago.ie==1"><i   class="fa fa-plus-square fa-lg "></i></td>
                                     <td class="text-center" v-else ><i   class="fa fa-minus-square fa-lg  "></i></td>
                                    <td   v-text="arraySuma[(pago.id)-1]"></td>
                                                                     
                                   <td v-text="pago.tpagos.nombrepagos" class="text-center"> </td>                                    
                                   
                                    <td>
                                        <div v-if="pago.condicion">
                                        <span class="badge badge-success ">Activo</span>
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
                            <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div  v-if="tipoAccion==3" class="form-group  col-xs-12">
                            <label >Usuario que Registro: </label>
                            <label for=""  v-text="usuarioNombre"></label>
                           
                            <textarea class="form-control" v-text="descripcion"  disabled="" ></textarea>
                            

                        </div>

                        <div v-else class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                  <label class="col-md-3 form-control-label" for="text-input">Conquistador</label>
                                    
                                    <div class="col-md-9">
                                      <template v-if="tipoAccion==1">
                                           <v-select
                                       
                                        :on-search="selectConquistador"
                                        label="nombres"                      
                                         
                                        :options="arrayConquistador"
                                        placeholder="Buscar Conquistador..."
                                        :onChange="getDatosConquistador">
                                        </v-select>
                                      </template>
                                      <template v-else>
                                        <input type="text" v-model="nombres" class="form-control" disabled>
                                      </template>
                                    </div> 
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Monto</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="monto" class="form-control" placeholder="Monto">
                                        <span class="help-block">(*) Monto del Pago</span>
                                    </div>
                                 </div> 
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de Pago </label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="idpago">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tipopagos in arrayTiposPagos" :key="tipopagos.id" :value="tipopagos.id" v-text="tipopagos.nombrepagos"></option>
                                        </select>  
                                    </div>                                    
                                </div> 
                                                         
                                    <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input" >Descripcion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Descripcion del Pago" >
                                        
                                    </div>
                                </div>
                                    <div v-show="errorT" class="form-group row  div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMensaje" :key="error" v-text="error" ></div>
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
import vSelect from 'vue-select';
    export default {

        data(){
            return{ /// aca se registran todas la Variables
                idconquistador: 0,
                nombres:'',
                id:0,
                idpago:0,
                idunidad:0,
                monto:0.0,    
                descripcion:'',
                ie:1,
                arrayPago : [],
                arrayTiposPagos :[],
                arrayConquistador:[],
                arraySuma:[],
                 modal:0,
                tituloModal :'',
                tipoAccion :0,
                errorT : 0,
                errorMensaje : [],
                 pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : '',
                buscar : '',
                mensaje:'',
                j:0,
                 suma:0.0,
                resultado:0.0,
                i:0,
                usuarioNombre:'',
            }
        },
        components: {
            vSelect
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

            cargarArray(){



               
                this.suma=0.0;
                this.arraySuma=[];
              /* for(var i=0;i<this.arrayPago.length;i++){
                   if(this.arrayPago[i].ie==1 && this.arrayPago[i].condicion ==1){
                    this.suma= this.suma + this.arrayPago[i].monto;
                    this.arraySuma[i]=this.suma;
                   }else if(this.arrayPago[i].ie==0 && this.arrayPago[i].condicion ==1){
                    this.suma= this.suma - this.arrayPago[i].monto;
                    this.arraySuma[i]=this.suma;
                   }else{
                       this.arraySuma[i]=this.suma;
                   }
               }
               }*/
               
                    var k=0;
                   for(var i=this.arrayPago.length-1;i>=0;i--){
                   if(this.arrayPago[i].ie==1 && this.arrayPago[i].condicion ==1){
                     
                    this.suma= this.suma + this.arrayPago[i].monto;
                    this.arraySuma[k]=this.suma;
                      k++;
                   }else if(this.arrayPago[i].ie==0 && this.arrayPago[i].condicion ==1){
                    this.suma= this.suma - this.arrayPago[i].monto;
                    this.arraySuma[k]=this.suma;
                      k++;
                   }else{
                       this.arraySuma[k]=this.suma;
                         k++;
                   }
                   }
                   
              // this.arraySuma[0].push('suma:');

                
          //     if(this.i<arrayPago.length){             } 

            },saldo(){
               
              if(this.i<this.arraySuma.length)
              {
                  this.i++;
                 
              }
               return this.arraySuma[this.i-1];
               
                

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
            listar (page,buscar,criterio){
                let me=this;
                var url= '/pagos?page=' + page +'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPago = respuesta.pagos.data;
                   // me.arraySuma = respuesta.pagos.data;
                    me.pagination= respuesta.pagination;
                  me.cargarArray();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },cargarTiposPagos(){
                let me=this;
                var url= '/tipopagos/activa';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTiposPagos = respuesta.tipos_pagos;
                })
                .catch(function (error) {
                    console.log(error);
                });
                },
                
                selectConquistador(search,loading){
                let me=this;
                loading(true)
               var url= '/conquistador/selectConquistador?filtro='+search;
                
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayConquistador=respuesta.conquistadores;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
                },
                
                getDatosConquistador(val1){
                let me = this;
                me.loading = true;
                me.idconquistador = val1.id;
                me.idunidad=val1.unidad;
                }, 
                
                cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page,buscar,criterio);
            },registrar(){
                    if(this.validar()){
                    return;
                }
                let me =this;
            
                     axios.post('/pagos/registrar',{
                      'id_conquistador': this.idconquistador,
                      'monto': this.monto,
                       'id_pagos': this.idpago,
                       'ie': this.ie,
                       'descripcion': this.descripcion,
                       'id_unidad': this.idunidad
                         

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Registro Exitoso';
                       me.mensajeRegistro();
                       me.listar(1,'','');
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },actualizar(){
                    if(this.validar()){
                    return;
                }
                let me =this;
            
                     axios.put('/pagos/actualizar',{
                       'monto': this.monto,
                       'id_pagos': this.idpago,
                      // 'id_usuario': this.usuiaro, hay que añadir el usuario en data
                       'ie':this.ie,
                       'descripcion':this.descripcion,
                       'id':this.id    

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Actualizacion  Exitosa';
                       me.mensajeRegistro();
                       me.listar(me.pagination['current_page'],'','');
                       })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            },abrirModal( accion, data=[]){

              this.cargarTiposPagos();

             
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Pago';
                                 this.tipoAccion=1;
                                this.idconquistador=0;
                                this.idpago=0;
                                this.monto=0.0;
                                this.ie=1;
                                this.descripcion='';

                                break;        
                            }
                            case'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Pago';
                                this.tipoAccion=2;
                                this.idconquistador=data['id_conquistador'];
                                this.idpago=data['id_pagos'];
                                this.monto=data['monto'];
                                this.ie=data['ie'];
                                this.descripcion=data['descripcion'];
                                this.nombres=data.conquistador['nombres'];
                                this.id=data['id'];
                                break;

                            }  
                            
                            case'observacion':
                            {
                                this.modal=1;
                                this.tituloModal='Observacion del Pago';
                                this.tipoAccion=3;
                                this.descripcion=data['descripcion'];
                                this.usuarioNombre=data.user['name'];
                                
                                break;

                            }   
                              
                        }
               
            },cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.errorMensaje='';
            },desactivar(id){
                
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

                    axios.put('/pagos/desactivar',{
                        'id': id
                    }).then(function (response) {
                      
                        me.listar(me.pagination['current_page'],'','nombres');
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
                title: 'Esta seguro de activar este Registro ?',
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

                    axios.put('/pagos/activar',{
                        'id': id
                    }).then(function (response) {
                   

                        me.listar(me.pagination['current_page'],'','nombres');
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
            validar(){
                this.errorT=0;
                this.errorMensaje =[];
                // si nombr es vacio
                if(!this.idconquistador || !this.monto || !this.idpago) this.errorMensaje.push("* Todos los Campos deben estar completos");
                if(this.idpago==1){this.ie=0}
               // si hay datos data en errorMensaje
               if(this.errorMensaje.length) this.errorT =1;
                return this.errorT;
                
              }

            },
            
        mounted() {
            this.listar(1,this.buscar,this.criterio);
            
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
