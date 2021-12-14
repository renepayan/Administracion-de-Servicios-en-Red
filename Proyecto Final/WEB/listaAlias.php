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
                Alias:<br>
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario:</th>
                                <th>Alias:</th>
                                <th>Tipo de alias:</th>
                                <th>Acciones:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="alias in aliases">
                                <td>{{alias.usuario.nombre}}</td>
                                <td>{{alias.alias}}</td>
                                <td>{{alias.tipoAlias}}</td>
                                <td>                                    
                                    <button v-on:click="eliminar(alias.id)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <a href="home.php">Ver Llamadas</a></br>
                    <a href="listaUsuarios.php">Ver Usuarios</a></br>                    
                </div>
            <div>               
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data:{
                    aliases:[{
                        id:0,
                        tipoAlias:0,
                        alias:"",
                        usuario:{
                            nombre:""
                        }
                    }]                   
                },
                methods:{
                    cargarInformacion: function(){
                        axios.get("/Controladores/obtenerAlias.php")
                        .then(function(response){
                            if(response.data.Estado === "ok"){
                                app.aliases = response.data.Alias;
                            }else{
                                alert(response.data.Descripcion);
                            }
                        })
                        .catch(function(error){
                            console.log(error);
                        });
                    }  
                },
                mounted:function(){
                    console.log("montado");
                    this.cargarInformacion();
                }
            });
        </script>
    </body>
</html>