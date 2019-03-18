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
                        <i class="fa fa-align-justify"></i> Roles 
                        
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Tipo de Rol</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rol in arrayRoles" :key="rol.id">
                                    <td>
                                           <template v-if="rol.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUnidad(rol.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUnidad(rol.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="rol.nombre"></td>
                                    <td v-text="rol.descripcion"></td>
                                    <td>
                                        <div v-if="rol.condicion">
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
        </main>
</template>

<script>
    export default {

        data(){
            return{ /// aca se registran todas la Variables
                arrayRoles : [],
                }
        },
        methods:{
           
            listar(){
                let me=this;
                var url= '/rol';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRoles = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(respuesta);
                });
            }, 
          desactivarUnidad(id){
                
                swal({
                title: 'Esta seguro de desactivar este Registro?',
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

                    axios.put('/rol/desactivar',{
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

            },
            activarUnidad(id){
                
                swal({
                title: 'Esta seguro de activar este Registro?',
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

                    axios.put('/rol/activar',{
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

            }

        },
        mounted() {
            this.listar();
        }
    }
</script>
