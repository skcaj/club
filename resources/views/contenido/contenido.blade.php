@extends('principal')
@section('contenido')



@if(Auth::check())
            @if (Auth::user()->id_rol == 1) 
                <template v-if="menu==0">
                <ejemplo></ejemplo>
                </template>
                <template v-if="menu==1">
                <unidad></unidad>
                </template>
                <template v-if="menu==2">
                <conquistador></conquistador>
                </template>
                <template v-if="menu==3">
                <tipospagos></tipospagos>
                </template>
                <template v-if="menu==4">
                <Pago></Pago>
                </template>
                <template v-if="menu==5">
                <pagosfiltros></pagosfiltros>
                </template>
                <template v-if="menu==6">
                <asistencia></asistencia>
                </template>
                <template v-if="menu==7">
                <user></user>
                </template>
                <template v-if="menu==8">
                <roles></roles>
                </template>
            @elseif (Auth::user()->id_rol == 2)
                <template v-if="menu==0">
                    <ejemplo></ejemplo>
                    </template>
                    <template v-if="menu==1">
                    <unidad></unidad>
                    </template>
                    <template v-if="menu==2">
                    <conquistador></conquistador>
                    </template>
                    <template v-if="menu==3">
                    <tipospagos></tipospagos>
                    </template>
            @elseif (Auth::user()->id_rol == 3)
                    <template v-if="menu==0">
                        <ejemplo></ejemplo>
                        </template>
                        <template v-if="menu==1">
                        <unidad></unidad>
                        </template>
                        <template v-if="menu==2">
                        <conquistador></conquistador>
                        </template>
                        <template v-if="menu==7">
                        <user></user>
                        </template>
                        <template v-if="menu==6">
                        <asistencia></asistencia>
                        </template>
            @elseif (Auth::user()->id_rol == 4)
                    <template v-if="menu==0">
                    <ejemplo></ejemplo>
                    </template>
            @else

            @endif
 
        @endif

@endsection