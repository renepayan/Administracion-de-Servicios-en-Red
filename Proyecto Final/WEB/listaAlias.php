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
                    Nuevo alias:
                    Usuario: <input type="number" min="1" step="1" v-model="nuevoAlias.idUsuario"/>
                    Alias: <input type="text" v-model="nuevoAlias.alias" />
                    Tipo: <input type="number" min="0" max="10" step="1" v-mode="nuevoAlias.tipo"/>
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
                    nuevoAlias:{
                        idUsuario:0,
                        tipo:0,
                        alias:""
                    },
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
                    eliminar:function(id){
                        const params = new URLSearchParams();
                        params.append('idAlias', id);
                        axios({
                            method:"POST",
                            headers: { 'content-type': 'application/x-www-form-urlencoded' },
                            data: params,
                            url: '/Controladores/eliminarAlias.php'})
                        .then(function (response) {
                            if(response.data.Estado === "ok")
                                app.cargarInformacion();
                            else
                                alert(response.data.Descripcion);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    },
                    crear:function(){
                        const params = new URLSearchParams();
                        params.append('idUsuario', this.nuevoAlias.idUsuario);
                        params.append('tipo', this.nuevoAlias.tipo);
                        params.append('alias', this.nuevoAlias.alias);
                        axios({
                            method:"POST",
                            headers: { 'content-type': 'application/x-www-form-urlencoded' },
                            data: params,
                            url: '/Controladores/agregarAlias.php'})
                        .then(function (response) {
                            if(response.data.Estado === "ok")
                                app.cargarInformacion();
                            else
                                alert(response.data.Descripcion);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    },
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