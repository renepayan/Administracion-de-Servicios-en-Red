<?php
    session_start();
    if(empty($_SESSION["usuario"])){
        header('Location: index.php');
    }    
?>
<!Doctype html>
<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    </head>
    <body>
        <div id="app">
            <div>
                Usuario:{{usuario.usuario}}</br>
                Nivel:{{(usuario.nivel == 0)?"Usuario":"Administrador"}}</br>
                Nombre:{{usuario.nombre}}</br>
                Extension:{{usuario.extension}}</br>                
                <div>
                    Nodo:<br>
                    Nombre:{{usuario.nodo.nombre}}</br>
                    IP:{{usuario.nodo.ip}}</br>
                    Dominio:{{usuario.nodo.dominio}}</br>
                </div>
                <div>
                    Grupo:<br>
                    Nombre:{{usuario.grupo.nombre}}</br>
                    Extension:{{usuario.grupo.extension}}</br>                    
                </div>                
                <a href="editarUsuario.php">Editar usuario</a></br>
            </div>
            <div v-if="usuario.nivel == 1">
                <a href="listaUsuarios.php">Ver Usuarios</a></br>
                <a href="listaNodos.php">Ver Nodos</a></br>
                <a href="listaGrupos.php">Ver Grupos</a></br>                
            </div>
            <div v-else>
                <div>
                    Horarios de servicio:<br>
                    <table>
                        <thead>
                            <tr>
                                <th>Dia de la semana</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="horario in horariosDeServicio">
                                <td>{{horario.diaDeLaSemana}}</td>
                                <td>{{horario.horaInicio}}</td>
                                <td>{{horario.horaFin}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    Permisos de llamada:<br>
                    <table>
                        <thead>
                            <tr>
                                <th>Nodo de origen</th>
                                <th>Nodo de destino</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="permiso in permisos">
                                <td>{{permiso.nodoOrigen.nombre}}</td>
                                <td>{{permiso.nodoDestino.nombre}}</td>                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data:{
                    usuario:{
                        id:0,
                        nivel:0,
                        nombre:"",
                        usuario:"",
                        extension:"",
                        nodo:{
                            id:0,
                            nombre:"",
                            ip:"",
                            dominio:""
                        },
                        grupo:{
                            id:0,
                            nombre:"",
                            extension:""
                        }
                    },
                    horariosDeServicio:[{
                        diaDeLaSemana:0,
                        horaInicio:"",
                        horaFin:""
                    }],
                    permisos:[{
                        nodoOrigen:{
                            nombre:""
                        },
                        nodoDestino:{
                            nombre:""
                        }
                    }]
                },
                methods:{
                    cargarInformacion: function(){
                        axios.get("/Controladores/obtenerInformacionUsuario.php")
                        .then(function(response){
                            if(response.data.Estado === "ok"){
                                app.usuario = response.data.Usuario;
                                app.horariosDeServicio = response.data.Horarios;
                                app.permisos = response.data.Permisos;
                            }else{
                                alert(response.data.Descripcion);
                            }
                        })
                        .catch(function(error){
                            console.log(error);
                        });
                    },
                    cargarLlamadas: function(){
                        axios.get("/Controladores/obtenerLlamadas.php")
                        .then(function(response){
                            console.log(response);
                        })
                        .catch(function(error){
                            console.log(error);
                        });
                    }                    
                },
                mounted:function(){
                    console.log("montado");
                    this.cargarLlamadas();
                    this.cargarInformacion();
                }
            });
        </script>
    </body>
</html>