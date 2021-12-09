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
                Usuarios:<br>
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre:</th>
                                <th>Usuario:</th>
                                <th>Extension:</th>
                                <th>Nivel:</th>                                
                                <th>Nodo:</th>
                                <th>Grupo:</th>
                                <th>Acciones:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="usuario in usuarios">
                                <td>{{usuario.nombre}}</td>
                                <td>{{usuario.usuario}}</td>
                                <td>{{usuario.extension}}</td>
                                <td>{{(usuario.nivel == 0)?"Usuario":"Administrador"}}</td>
                                <td>{{usuario.nodo.nombre}}</td>
                                <td><a :href="'editarUsuario.php?usuario='+usuario.id">Editar</a>                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            <div>               
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data:{
                    usuarios:[{
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
                    }]
                },
                methods:{
                    cargarInformacion: function(){
                        axios.get("/Controladores/obtenerUsuarios.php")
                        .then(function(response){
                            if(response.data.Estado === "ok"){
                                app.usuarios = response.data.Usuarios;
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