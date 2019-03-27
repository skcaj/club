<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Conquistadores</title>
    <link  href="{{asset('css/mix.css')}}" rel="stylesheet">
   
</head>
<body>
<template >
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Unidad</label>
                                    <p ></p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Usuario que Registro</label>
                                    <p ></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Cuotas</label>
                                    <p ></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <p ></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Conquistador</th>
                                            <th>Valor Cuota</th>
                                            <th>Pts Cuota</th>
                                            <th>Pts Puntualidad</th>
                                            <th>Pts Uniforme</th>
                                            <th>Pts Material</th>
                                            <th>Puntaje total</th>

                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr >
                                            <td >
                                            </td>
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                            <td style="background-color: #f86c6b;" ></td>
                                           
                                        </tr>
                                        
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ 200</td>
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
                       
                        </div>
                    </div>
                    </template>
</body>
</html>