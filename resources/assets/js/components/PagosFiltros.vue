<template>
   <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
 <div class="">
        <div class="row">
                <div class="col-lg-12">
                        <div class="card">
                             <div class="card-header form-group">
                                <div class="row">
                                    <div class="col-md-2 form-group">
                            <label class="fa fa-edit">  Filtrar </label>  

                            </div>
                            <div class="col-md-3 form-group ">
                                    <select class="form-control" v-model="busqueda">
                                    <option value="0" >Filtrar todo </option>
                                    <option value="1" >Filtrar Por Fecha</option>
                                    <option value="2" >Filtrar por  Rangos</option>
                                    <option value="3" >Filtrar por tipo</option>
                                    
                                </select> 
                                
                            </div> 
                            <div class="col-md-3 form-group">
                            <button type="button" @click="cargar()" class="btn btn-secondary" >
                            <i class="fa fa-user-plus fa-lg"></i>&nbsp;Buscar
                        </button> 
                            </div> 
                                </div>            
                            
                            </div>
             <div class="card-body  ">
                    <div class="form-group row border" v-if="busqueda==1">  
                        
                        <div class="col-md-3" >
                            <h1></h1>
                            <div class="form-group">
                            
                                <span class="fa fa-calendar fa-lg "> Selecionar  por Fecha:  </span>    
                            </div>
                        </div>
                        <div class="col-md-3" >
                            <h1></h1>
                            <div class="form-group">
                            
                                <input id="date" v-model="fechaA" type="date">
                               
                            </div>
                        </div>
                        
                        <div class="col-md-4" >
                        <h1></h1>
                                <label for="">Filtrar por (*)</label>
                            <select class="form-control" v-model="filtrar">
                                    <option value="0" >General</option>
                                    <option value="1" >Unidades</option>
                                    <option value="2" >Tipo de Pago</option>
                                    
                                </select>  
                        <h1></h1>
                        </div>
                        <div v-if="filtrar==1" class="col-md-4" >
                        
                                <label for="">unidades</label>
                            <select class="form-control" v-model="idunidades">
                                            <option value="0" disabled>Todas</option>
                                            <option v-for="unidad in arrayUnidades" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad"></option>
                                        </select>      
                        <h1></h1>
                        </div>
                        <div v-else-if="filtrar==2" class="col-md-4" >
                        
                                <label for="">Tipo de pago</label>
                            <select class="form-control" v-model="idtipospagos">
                                            <option value="0" disabled>Todos Tipos de pagos</option>
                                            <option v-for="tipospagos in arrayTiposPagos" :key="tipospagos.id" :value="tipospagos.id" v-text="tipospagos.nombrepagos"></option>
                            </select>  
                        <h1></h1>
                        </div>
                        
                    </div>
                    <div class="form-group row border" v-else-if="busqueda==2">  
                        
                        <div class="col-md-2" >
                            <h1></h1>
                            <div class="form-group">
                            
                                <span class="fa fa-calendar fa-lg "> Busar desde   </span>    
                            </div>
                        </div>
                        <div class="col-md-3" >
                            <h1></h1>
                            <div class="form-group">
                                <input id="date" v-model="fechaA" type="date">  
                            </div>
                        </div>
                        <div class="col-md-2" >
                            <h1></h1>
                            <div class="form-group">
                            
                                <span class="fa fa-calendar fa-lg "> hasta  </span>    
                            </div>
                            
                        </div>
                        <div class="col-md-3" >
                            <h1></h1>
                            <div class="form-group">
                                 <input id="date" v-model="fechaB" type="date">  
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <label for="">Filtrar por (*)</label>
                            <select class="form-control" v-model="filtrar">
                                <option value="0" >General</option>
                                    <option value="1" >Unidades</option>
                                    <option value="2" >Tipo de Pago</option>
                                    
                                </select>  
                                <h1></h1>
                        </div>
                         <div v-if="filtrar==1" class="col-md-4" >
                        
                                <label for="">unidades</label>
                            <select class="form-control" v-model="idunidades">
                                            <option value="0">Todas</option>
                                            <option v-for="unidad in arrayUnidades" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad"></option>
                                        </select>      
                        <h1></h1>
                        </div>
                        <div v-else-if="filtrar==2" class="col-md-4" >
                        
                                <label for="">Tipo de pago</label>
                            <select class="form-control" v-model="idtipospagos">
                                            <option value="0" >Todos Tipos de pagos</option>
                                            <option v-for="tipospagos in arrayTiposPagos" :key="tipospagos.id" :value="tipospagos.id" v-text="tipospagos.nombrepagos"></option>
                            </select>  
                        <h1></h1>
                        </div>
                        
                    </div>
                    <div class="form-group row border" v-if="busqueda==3">  
                        
                       
                        
                        <div class="col-md-6" >
                        
                                <label for="">Filtrar por (*)</label>
                            <select class="form-control" v-model="tipo">
                                    <option value="0" >Unidades</option>
                                    <option value="1" >Tipo de Pago</option>
                                   
                                    
                                </select>  
                        <h1></h1>
                        </div>
                        <div v-if="tipo==0" class="col-md-6" >
                        
                                <label for="">unidades</label>
                            <select class="form-control" v-model="idunidades">
                                            <option value="0" disabled>Todas</option>
                                            <option v-for="unidad in arrayUnidades" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad"></option>
                                        </select>      
                        <h1></h1>
                        </div>
                        <div v-else-if="tipo==1" class="col-md-" >
                        
                                <label for="">Tipo de pago</label>
                            <select class="form-control" v-model="idtipospagos">
                                            <option value="0" disabled>Todos Tipos de pagos</option>
                                            <option v-for="tipospagos in arrayTiposPagos" :key="tipospagos.id" :value="tipospagos.id" v-text="tipospagos.nombrepagos"></option>
                            </select>  
                        <h1></h1>
                        </div>
                        
                    </div>


                    <div class="card">
                        <div class="card-body">
                    
                            <div class="table-responsive">
                            <table class="table  table-hover display" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre Conquistador</th>
                                        <th>Monto del Pago</th>
                                        <th>I/E</th>
                                        
                                        <th>Tipo de Pago</th>                                    
                                        <th>Condicion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="pago in arrayPago" :key="pago.id"  >
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
             </div>
        <div class="card-footer">

        </div>
</div>

</div>

</div>
                            </div>       

        </main>
</template>

<script>


    export default {

        data(){
            return{ /// aca se registran todas la Variables
                arrayPago : [],
                arrayTiposPagos :[],
                arrayUnidades :[],
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
                fechaA:'',
                fechaB:'',
                filtrar:0,
                busqueda:0,
                tipo:0,
                idunidades:0,
                idtipospagos:0,
                id:0,

                    
                
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
            cargar(){
                let me=this;

                if(me.busqueda==3){
                        me.fechaA ="";
                        me.fechaB ="";
                    if(me.tipo==0){
                        me.criterio='id_unidad';
                        if(me.idunidades!=0){
                            me.id=me.idunidades;
                        } 
                    }else if(me.tipo==1){
                        me.criterio='id_pagos';
                        if(me.idtipospagos!=0){
                            me.id=me.idtipospagos;
                        } 
                }
                me.listar (me.pagination['current_page'],me.fechaA,me.fechaB,me.criterio,me.id);


                }else if(me.busqueda==1){
                       me.fechaB ="";
                 //  me.fechaA ="2019-01-23";
                        if(me.filtrar==1){
                        me.criterio='id_unidad';
                        if(me.idunidades!=0){
                            me.id=me.idunidades;
                        } 
                    }else if(me.filtrar==2){
                        me.criterio='id_pagos';
                        if(me.idtipospagos!=0){
                            me.id=me.idtipospagos;
                        } 
                    }
                me.listar (me.pagination['current_page'],me.fechaA,me.fechaB,me.criterio,me.id);


                }

            },

            listar (page,fechaA,fechaB,criterio,id){
                let me=this;
                var url= '/pagos/filtrar?page=' + page +'&fechaA='+fechaA+'&fechaB='+fechaB+'&criterio='+criterio+'&id='+id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPago = respuesta.pagos.data;
                    me.pagination= respuesta.pagination;
                   
                })
                .catch(function (error) {
                    console.log(error);
                });
            },cargartiposPagos(){
                let me=this;
                var url= '/tipopagos/activa';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTiposPagos = respuesta.tipos_pagos;
                })
                .catch(function (error) {
                    console.log(error);
                });
                },  cargarUnidades(){
                let me=this;
                var url= '/unidad/activa';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUnidades = respuesta.unidades;
                })
                .catch(function (error) {
                    console.log(error);
                });
                },
                abrirModal( accion, data=[]){

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
                      
                        me.listar(me.pagination['current_page'],me.fechaA,me.fechaB,me.criterio,me.id);
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
                   

                        me.listar(me.pagination['current_page'],me.fechaA,me.fechaB,me.criterio,me.id);
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
                }

            
                
                
               
        },   
        mounted() {
            this.listar(1,this.fechaA,this.fechaB,this.criterio,this.id);
            this.cargartiposPagos();
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
