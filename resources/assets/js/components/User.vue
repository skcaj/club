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
                        <i class="fa fa-align-justify"></i> Listado de usuarios
                        <button type="button" @click="abrirModal('user','registrar')" class="btn btn-secondary" >
                            <i class="fa fa-user-plus fa-lg"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" v-if="table==0 && admin!=3" @click="cambiar(2)" class="btn btn-secondary" >
                            <i class="fa fa-user-times fa-lg"></i>&nbsp;Eliminar
                        </button>
                        <button type="button" v-else-if="admin!=3&&table==2" @click="cambiar(0)" class="btn btn-secondary" >
                            <i class="fa fa-mail-reply fa-lg"></i>&nbsp;Volver
                        </button>
                    </div>
    
                    <div class="card-body">
                        <div class="form-group row" v-if="admin!=3">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio" v-on:click="modo()">
                                      <option value="usuario">Nombre de usuario</option>
                                      <option value="id_rol">Listar por Roles</option>
                                      <option value="unidad_cargo">Listar por unidades</option>
                                    </select>
                                    <input  type="text" v-model="buscar" @keyup.enter="listar(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar" v-if="criterio=='usuario'">
                                    <select class="form-control" v-model="buscar" v-if=" criterio=='id_rol'">
                                            <option value="0">Selecionar</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre">

                                            </option>
                                    </select>
                                     <select class="form-control" v-model="buscar" v-if="criterio=='unidad_cargo'">
                                         <option value="0">Selecionar</option>
                                            <option v-for="unidad in arrayUnidades" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad">

                                    </option>
                                     </select>

                                    <button type="submit" @click="listar(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th >Opciones</th>
                                    <th>Usuario</th>
                                     <th>Nombre Conquistador</th>
                                     <th>Rol de usuario</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in arrayUser" :key="user.id">
                                    <td v-if="table==0 ">
                                        <button type="button" @click="abrirModal('user','actualizar',user)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                         <template v-if="user.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivar(user.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activar(user.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-else-if="admin!=3&&table==2">
                                            <button type="button" title="Eliminar" class="btn btn-danger btn-sm" @click="eliminar(user.id)">
                                                <i class="fa fa-times-rectangle fa-lg"></i>
                                            </button>
                                    </td>
                                    <td v-text="user.usuario"></td>
                                    <td  ><i class="fa fa-user"></i>&nbsp;&nbsp;{{user.conquistador.nombres+" "+user.conquistador.apellidos}}</td>
                                   <td v-text="user.roles.nombre"></td>
                                    <td>
                                        <div v-if="user.condicion">
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
                            <button type="button" class="close"  @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body"  >
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                             <div class="form-group row ">
                                  <label class="col-md-3 form-control-label" for="text-input">Conquistador</label>
                                    
                                    <div class="col-md-9" v-if="tipoAccion==1">
                                      <v-select
                                        :on-search="selectConquistador"
                                        label="nombres"                      
                                         
                                        :options="arrayConquistador"
                                        placeholder="Buscar Conquistador..."
                                        :onChange="getDatosConquistador">
                                        </v-select>
                                      
                                      
                                    </div> 
                                    <div class="col-md-9" v-else>
                                        <label type="text"   class="form-control" disabled>{{nombres+" "+apellidos}}  </label>                  
                                      
                                    </div> 
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre de Usuario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre de usuario">
                                        <span class="help-block">(*) usuario</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Password (*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Password de acceso">
                                        <span class="help-block">(*) password</span>
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Confirmar Password (*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password2" class="form-control" placeholder="Confiramr Password de acceso">
                                        <span class="help-block ">(*) password</span>
                                    </div> 
                                </div>
                                <div class="form-group row" v-if="admin!=3">
                                    <label class="col-md-3 form-control-label" for="text-input">Rol Del Usuario</label>
                                        <div class="col-md-9">
                                        <select class="form-control" v-model="idrol">
                                            <option value="0">Selecionar</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre">

                                            </option>
                                        </select>
                                        <span class="help-block">(*) Selecionar Rol</span>
                                    </div>
                                </div>

                                  <div class="form-group row" v-if="idrol==3">
                                    <label class="col-md-3 form-control-label" for="text-input">Unidad a Cargo</label>
                                        <div class="col-md-9">
                                        <select class="form-control" v-model="idunidad">
                                            <option value="0">Selecionar</option>
                                            <option v-for="unidad in arrayUnidades" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad">

                                            </option>
                                        </select>
                                        <span class="help-block">(*) Selecionar Unidad</span>
                                    </div>
                                </div>
                                    <div v-show="errorUnidad" class="form-group row  div-error">
                                    <div class="text-center text-error" >
                                        <div v-for="error in errorMostrarMensaje" :key="error" v-text="error" ></div>
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
                id:0,
                usuario:'',
                idunidad:0,
                idrol:0,
                arrayUser : [],
                arrayRol :[],
                arrayConquistador:[],
                admin:0,
                arrayUnidades:[],
                modal:0,
                tituloModal :'',
                tipoAccion :0,
                errorUnidad : 0,
                errorMostrarMensaje : [],
                 pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'usuario',
                buscar : '',
                mensaje:'',
                password:'',
                password2:'',
                nombres:'',
                apellidos:'',
                table:0,
                
            }
        },components: {
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
            cambiar(x){
                this.table=x;
            },
             modo(){
                if(this.criterio=="usuario") this.buscar="";
                else this.buscar=0;
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
                var url= '/user?page=' + page +'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUser = respuesta.users.data;
                    me.pagination= respuesta.pagination;
                   // me.arrayAdmin = JSON.parse(user.content);
                   me.admin  = respuesta.usuario;
                })
                .catch(function (error) {
                    console.log(error);
                });
              
            },                
            selectConquistador(search,loading){
                let me=this;
                loading(true)
                if(this.admin!=3){
                var url= '/conquistador/selectConquistador?filtro='+search;
                }else{
                    var url= '/conquistador/selectConquistadorUnidad?filtro='+search;
                }
               
                
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
                cargarRoles(){
                let me=this;
                var url= '/rol/activa';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargaUnidad(){
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
            
                     axios.post('/user/registrar',{
                      'usuario': this.usuario,
                      'password': this.password,
                       'id_conquistador': this.idconquistador,
                       'id_rol': this.idrol,
                       'unidad_cargo': this.idunidad

                         

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Registro Exitoso';
                       me.mensajeRegistro();
                       me.listar(1,'','nombres');
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
                
            
                     axios.put('/user/actualizar',{
                       'usuario': this.usuario,
                      'nombres': this.nombres,
                       'password': this.password,
                       'id_rol': this.idrol,
                       'id_rol': this.idrol,
                       'unidad_cargo':this.idunidad,    
                       'id':this.id    

                     }).then(function (response) {
                       me.cerrarModal();
                       me.mensaje = 'Actualizacion  Exitosa';
                       me.mensajeRegistro();
                       me.listar(me.pagination['current_page'],'','nombres');
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
                    case'user':{

                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Usuario';
                                this.tipoAccion =1;
                                if(this.admin==3){
                                    this.idrol=4;
                                }
                                break;        
                            }
                            case'actualizar':
                            {
                             this.modal=1;
                             this.tituloModal='Actualizar Usuario';
                             this.tipoAccion=2;
                             this.usuario=data['usuario'];
                             this.idconquistador=data['id_conquistador'];
                             this.idrol=data['id_rol'];
                             this.nombres=data.conquistador['nombres'];
                             this.apellidos=data.conquistador['apellidos'];
                             this.idunidad=data['unidad_cargo'];
                             this.id =data['id'];
                             break;

                            }    
                              
                        }
                    }
                }
            },cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.usuario='';
                this.idconquistador='';
                this.idunidad=0;
                this.idrol=0;
                this.password='';
                this.password2='';
                this.errorMostrarMensaje='';
                this.tipoAccion =0;
            },desactivar(id){
                
                swal({
                title: 'Esta seguro de desactivar El  Usuario?',
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

                    axios.put('/user/desactivar',{
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
                title: 'Esta seguro de activar el Usuario ?',
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

                    axios.put('/user/activar',{
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

            },eliminar(id){
                
                swal({
                title: 'Esta seguro de eliminar el Usuario ?',
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

                    axios.put('/user/delete',{
                        'id': id
                    }).then(function (response) {
                   

                        me.listar(me.pagination['current_page'],'','nombres');
                        swal(
                        'Activado!',
                        'El registro ha sido Eliminado con éxito.',
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
                this.errorUnidad=0;
                this.errorMostrarMensaje =[];
                // si nombr es vacio
                if(!this.idconquistador || !this.idrol || !this.usuario) this.errorMostrarMensaje.push("* Todos los Campos deben estar completos");
               // si hay datos data en errorMostrarMensaje
               if(this.password!=this.password2) this.errorMostrarMensaje.push("* Los Password No Coinciden");
               if(this.idrol==3 && this.idunidad==0) this.errorMostrarMensaje.push("* Favor Selecionar una Unidad");
              // if(this.idrol==3)this.idunidad=0;
               if(this.password.length<6 && this.tipoAccion==1) this.errorMostrarMensaje.push("* Password no puede ser vacio ni  menor a 6 digitos");
               if(this.errorMostrarMensaje.length) this.errorUnidad =1;
                return this.errorUnidad;
                
              }

            },
            
        mounted() {
            this.listar(1,this.buscar,this.criterio);
            this.cargarRoles();
            this.cargaUnidad();

        }
    }
</script>
<style>
.modal-content{
    width: 100% !important;
    position: absolute!important;
}
/*.modal-body{
  height: 350px;
  overflow-y: auto;
}*/
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
    .div-password{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    .text-ok{
        color: rgb(0, 211, 112) !important;
        font-weight: bold;
    }
</style>
