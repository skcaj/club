<template>
            <main class="main">
            <!-- Breadcrumb -->
             <div class="">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Asistencia
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" v-if="table==0 && admin!=3 && listado==1" @click="cambiar(2)" class="btn btn-secondary" >
                            <i class="icon-pencil"></i>&nbsp;Editar
                        </button>
                        <button type="button" v-else-if="admin!=3&&table==2 && listado==1" @click="cambiar(0)" class="btn btn-secondary" >
                            <i class="fa fa-mail-reply fa-lg"></i>&nbsp;Volver
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row" v-if="admin!=3">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="">Todo</option>
                                      <option value="id_unidad">Unidad</option>
                                      <option value="created_ad">Fecha</option>
                                      
                                    </select>
                                    <select class="form-control" v-model="buscar" v-if="criterio=='id_unidad'">
                                            <option value="">Seleccione una Unidad</option>
                                            <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad">

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
                                        <th>Opciones</th>
                                        <th>Unidad</th>
                                        <th>Usuario que registro</th>
                                        <th>Total</th>
                                        <th>fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="asistencia in arrayAsistencia" :key="asistencia.id">
                                        <td v-if="table==0">
                                            <button type="button" @click="verDatos(asistencia.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <button type="button" @click="pdfVenta(asistencia.id)" class="btn btn-info btn-sm">
                                            <i class="icon-doc"></i>
                                            </button> &nbsp;
                                            
                                        </td>
                                        <td v-else-if="admin!=3&&table==2">
                                            <button type="button" title="Eliminar" class="btn btn-warning btn-sm" @click="editar(asistencia.id)">
                                                <i class="icon-pencil"></i>
                                            </button>
                                        </td>
                                        <td v-text="asistencia.unidad.nombreunidad"></td>
                                        <td v-text="asistencia.user.usuario"></td>
                                        <td v-text="asistencia.total"></td>
                                        <td v-text="asistencia.created_at"></td>
                                       
                                       
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
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        
                        <div class="form-group row border" v-if="table==0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Selecione Conquistador<span style="color:red;" v-show="idconquistador==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="ci" @keyup.enter="buscarConquis()" placeholder="C.I Conquistador">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <input type="text" readonly class="form-control" v-model="conquistador">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cuota <span style="color:red;" v-show="cuota==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="cuota">
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <div v-show="errorVenta" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th v-if="table==0">Opciones</th>
                                            <th>Conquistador</th>
                                            <th>Valor Cuota</th>
                                            <th>Puntualidad</th>
                                            <th>Uniforme</th>
                                            <th>Material</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td v-if="table==0">
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.conquistador" v-if="table==0">
                                            </td>
                                            <td v-else v-text="detalle.conquistador.nombres+' '+detalle.conquistador.apellidos">
                                            </td>    
                                            <td>
                                                <div class="input-group mb-3" >
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text" >
                                                        <input type="checkbox" v-model="p_cuota" aria-label="Checkbox for following text input">
                                                        </div>
                                                    </div>
                                                    <input type="number"  v-if="p_cuota" class="form-control" aria-label="Text input with checkbox">
                                                </div>

                                            </td>
                                            <td>
                                               <select class="form-control" v-model="puntualidad">
                                                <option value=-1>Selecionar</option>
                                                <option value=20>A Tiempo | 20 pts</option>
                                                <option value=10>Tarde hasta 15 mt | 10 pts</option>
                                                <option value=5>Atrasado | 5 pts</option>
                                               </select>
                                            </td>
                                            <td>
                                               <select class="form-control" v-model="uniforme">
                                                <option value=-1>Selecionar</option>
                                                <option value=10>En Orden</option>
                                                <option value=5>Incomplete</option>
                                                <option value=0>Sin Uniforme</option>
                                               </select>
                                            </td>
                                            <td>
                                               <select class="form-control" v-model="material">
                                                <option value=-1>Selecionar</option>
                                                <option value=10>Completo</option>
                                                <option value=5>Incopleto</option>
                                                <option value=0>Sin Material</option>
                                               </select>
                                            </td>
                                           
                                            
                                        </tr>
                                       
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Cuotas:</strong></td>
                                            <td>$ {{total=calcularTotal}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarcuota()" v-if="table==0">Registrar</button>
                                <button type="button" class="btn btn-primary" @click="actualizar()" v-else>Actualizar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Unidad</label>
                                    <p v-text="unidadC"></p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Usuario que Registro</label>
                                    <p v-text="userC"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Cuotas</label>
                                    <p v-text="cuotaC"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <p v-text="fechaC"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Conquistador</th>
                                            <th>cuota</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.conquistador.nombres +'' +detalle.conquistador.apellidos ">
                                            </td>
                                            <td v-text="detalle.cuota">
                                            </td>
                                           
                                        </tr>
                                        
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{cuotaC}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                NO hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row" v-if="admin!=3">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioU">
                                      <option value="">Todos</option>
                                      <option value="unidad">Unidad</option>
                                      
                                      
                                    </select>
                                    <select class="form-control" v-model="buscarU" v-if="criterioU=='unidad'">
                                            <option value="">Seleccione una Unidad</option>
                                            <option v-for="unidad in arrayUnidad" :key="unidad.id" :value="unidad.id" v-text="unidad.nombreunidad">

                                            </option>
                                    </select>
                                    <button type="submit" @click="listarConquis(1,buscarU,criterioU)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>identidad</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="conquistador in arrayConquistador" :key="conquistador.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(conquistador)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="conquistador.identidad"></td>
                                            <td v-text="conquistador.nombres"></td>
                                            <td v-text="conquistador.apellidos"></td>
                                           
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    export default {
        data (){
            return {
                
                total:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arrayAsistencia : [],
               
                arrayDetalle : [],
                arrayUnidad:[],
                listado:1,
                modal : 0,
                unidadC:'',
                userC:'',
                cuotaC:'',
                fechaC:'',
                tituloModal : '',
                tipoAccion : 0,
                errorVenta : 0,
                errorMostrarMsjVenta : [],
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
                criterioU : 'unidad',
                buscarU : '1',
                arrayConquistador: [],
                idconquistador: 0,
                ci: '',
                conquistador: '',
                cuota: 0,
                admin:0,
                table:0,
                id_asistencia:0,
                puntualidad:-1,
                uniforme:-1,
                material:-1,
                p_cuota:false
                
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
            },
            calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].cuota*1)
                }
                return resultado;
            }
        },
        methods : {
            listar (page,buscar,criterio){
                let me=this;
                var url= '/asistencia?page=' + page + '&buscar='+ buscar+ '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayAsistencia = respuesta.asistencias.data;
                    me.pagination= respuesta.pagination;
                    me.admin= respuesta.admin;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, mensajeRegistro(){
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
            cambiar(x){
                this.table=x;
            },
            
            buscarConquis(){
                let me=this;
                var url= '/conquistador/buscarConquistador?filtro=' + me.ci;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayConquistador = respuesta.conquistador;

                    if (me.arrayConquistador.length>0){
                        me.conquistador=me.arrayConquistador[0]['nombres'] +' '+ me.arrayConquistador[0]['apellidos'];
                        me.idconquistador=me.arrayConquistador[0]['id'];
                       
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idconquistador=0;
                    }
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
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idconquistador==id){
                        sw=true;
                    }
                }
                return sw;
            },
            pdfVenta(id){
            window.open('http://localhost:8000/venta/pdf/'+id+','+'_blank');            
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idconquistador==0 || me.cuota==0){
                }
                else{
                    if(me.encuentra(me.idconquistador)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       
                       
                           me.arrayDetalle.push({
                                idconquistador: me.idconquistador,
                                conquistador: me.conquistador,
                                cuota: me.cuota,
                                
                            });
                            me.ci="";
                            me.idconquistador=0;
                            me.conquistador="";
                            me.cuota=0;
                            
                       
                    }
                    
                }

                

            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Conquistador ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idconquistador: data['id'],
                            conquistador: data['nombres']+' '+data['apellidos'],
                            cuota:0,
                            
                        }); 
                    }
            },
            listarConquis (page,buscar,criterio){
                let me=this;
                var url= '/conquistador?page=' + page +'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayConquistador = respuesta.conquistadores.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarcuota(){
                if (this.validarCuota()){
                    return;
                }
                
                let me = this;

                axios.post('/asistencia/registrar',{
                    'total': this.total,
                    
                    'id_unidad':this.buscarU,
                    'data': this.arrayDetalle

                }).then(function (response) {

                    me.mensaje = 'Registro Exitoso';
                    me.mensajeRegistro();

                    me.listado=1;
                    me.listar(1,'','');
                    me.idcliente=0;
                   
                    me.total=0.0;
                    me.idconquistador=0;
                    me.conquistador='';
                    me.cantidad=0;
                    me.cuota=0;
                    
                    me.descuento=0;
                    me.arrayDetalle=[];

                   // window.open('http://localhost:8000/venta/pdf/'+response.data.id+','+'_blank');  

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarCuota(){
                let me=this;
                me.errorVenta=0;
                me.errorMostrarMsjVenta =[];
                var art;


                        me.arrayDetalle.map(function(x){
                    if (x.cuota<=0){
                        art= " cuota de " + x.conquistador+ " no puede ser menor o igual a 0";
                        me.errorMostrarMsjVenta.push(art);
                    }
                });

                
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjVenta.push("Ingrese algun detalle");
                
                if (me.errorMostrarMsjVenta.length) me.errorVenta = 1;

                return me.errorVenta;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='BOLETA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.18;
                me.total=0.0;
                me.idconquistador=0;
                me.articulo='';
                me.cantidad=0;
                me.cuota=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verDatos(id){
                let me=this;
                me.listado=2;
                
                var arrayVerDetalle=[];
                //Obtener los datos del ingreso
               
                var url= '/asistencia/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayVerDetalle = respuesta.asis;

                    me.cuotaC= arrayVerDetalle[0]['total'];
                    me.fechaC= arrayVerDetalle[0]['created_at'];
                    me.unidadC= arrayVerDetalle[0].unidad['nombreunidad'];
                    me.userC= arrayVerDetalle[0].user['usuario'];
                   
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/asistencia/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
                this.listarConquis(this.page,this.buscarU,this.criterioU);
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
            },
            desactivarVenta(id){
               swal({
                title: 'Esta seguro de anular esta venta?',
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

                    axios.put('/venta/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listar(1,'','');
                        swal(
                        'Anulado!',
                        'La venta ha sido anulada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            editar(id){
                let me=this;
                me.listado=0;
 
                me.id_asistencia=id;
                //Obtener los datos de los detalles 
                var urld= '/asistencia/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            actualizar(id){
                if (this.validarCuota()){
                    return;
                }
                
                let me = this;

                axios.put('/asistencia/actualizar',{
                    'total': this.total,
                    'id':this.id_asistencia,
                    'data': this.arrayDetalle

                }).then(function (response) {

                    me.mensaje = 'Actualizacion  Exitosa';
                    me.mensajeRegistro();

                    me.listado=1;
                    me.listar(1,'','');
                    me.idcliente=0;
                   
                    me.total=0.0;
                    me.idconquistador=0;
                    me.conquistador='';
                    me.cantidad=0;
                    me.cuota=0;
                    
                    me.descuento=0;
                    me.arrayDetalle=[];

                   // window.open('http://localhost:8000/venta/pdf/'+response.data.id+','+'_blank');  

                }).catch(function (error) {
                    console.log(error);
                });
            },
            
        },
        mounted() {
            this.listar(1,this.buscar,this.criterio);
            this.cargarUnidades();
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
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
