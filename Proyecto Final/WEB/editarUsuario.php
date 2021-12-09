<?php
    session_start();
    if(empty($_SESSION["usuario"])){
        header('Location: index.php');
    }   
    $idUsuario = $_SESSION["usuario"];
    if(!empty($_GET["usuario"])){
        $idUsuario = $_GET["usuario"];
    }
    $puedeEditar = false;
    if($idUsuario != $_SESSION["usuario"]){
        $puedeEditar = true;
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
                Nombre:<input type="text" v-model="usuario.nombre"></br>
                Password:<input type="text" v-model="usuario.password"></br>                
                <div v-if="puedeEditar">
                    Extension:<input type="text" v-model="usuario.extension"></br>
                    Nivel:<input type="number" v-model="usuario.nivel"></br>
                    Usuario:<input type="text" v-model="usuario.usuario"></br>
                    Nodo:<input type="text" v-model="usuario.nodo.id"></br>
                    Grupo:<input type="text" v-model="usuario.grupo.id"></br>
                </div>
                <button v-on:click="guardarDatos()">Guardar</button></br>             
                <a href="home.php">Ver llamadas</a></br>
            </div>
            <div v-if="puedeEditar">
                <a href="listaUsuarios.php">Ver Usuarios</a></br>
                <a href="listaNodos.php">Ver Nodos</a></br>
                <a href="listaGrupos.php">Ver Grupos</a></br>                
            </div>
            <div>
                <div>
                    Horarios de servicio:<br>
                    <table>
                        <thead>
                            <tr>
                                <th>Dia de la semana</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                                <th v-if="puedeEditar">Acciones:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="horario in horariosDeServicio">
                                <td>{{horario.diaDeLaSemana}}</td>
                                <td>{{horario.horaInicio}}</td>
                                <td>{{horario.horaFin}}</td>
                                <td v-if="puedeEditar"><button v-on:click="eliminarHorario(horario.id)">Eliminar</button></td>     
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="puedeEditar">
                        Nuevo Horario:<br>
                        Dia de la semana:<input type="number" v-model="nuevoHorario.diaDeLaSemana"><br>
                        Hora de inicio:<input type="text" v-model="nuevoHorario.horaInicio"><br>
                        Hora de fin:<input type="text" v-model="nuevoHorario.horaFin"><br>
                        <button v-on:click="agregarHorario()">Guardar</button></br>
                    </div>
                </div>
                <div>
                    Permisos de llamada:<br>
                    <table>
                        <thead>
                            <tr>
                                <th>Nodo de origen</th>
                                <th>Nodo de destino</th>
                                <th v-if="puedeEditar">Acciones:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="permiso in permisos">
                                <td>{{permiso.nodoOrigen.nombre}}</td>
                                <td>{{permiso.nodoDestino.nombre}}</td>
                                <td v-if="puedeEditar"><button v-on:click="eliminarPermiso(permiso.id)">Eliminar</button></td>                                  
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="puedeEditar">
                        Nuevo permiso:<br>
                        Nodo de origen:<input type="number" v-model="nuevoPermiso.nodoOrigen" ><br>
                        Nodo de destino:<input type="number" v-model="nuevoPermiso.nodoDestino" ><br>
                        <button v-on:click="agregarPermiso()">Guardar</button><br>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data:{
                    puedeEditar:<?=$puedeEditar?>,
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
                        id:0,
                        diaDeLaSemana:0,
                        horaInicio:"",
                        horaFin:""
                    }],
                    permisos:[{
                        id:0,
                        nodoOrigen:{
                            nombre:""
                        },
                        nodoDestino:{
                            nombre:""
                        }
                    }],
                    nuevoHorario:{
                        diaDeLaSemana:0,
                        horaInicio:"",
                        horaFin:"",                        
                    },  
                    nuevoPermiso:{                        
                        nodoOrigen:0,
                        nodoDestino:0
                    }                  
                },
                methods:{
                    guardarDatos: function(){
                        const params = new URLSearchParams();
                        params.append('idNodoOrigen', this.nuevoPermiso.nodoOrigen);                        
                        params.append('idNodoDestino', this.nuevoPermiso.nodoDestino);
                        params.append('idUsuario', this.usuario.id);                        
                        axios({
                            method:"POST",
                            headers: { 'content-type': 'application/x-www-form-urlencoded' },
                            data: params,
                            url: '/Controladores/agregarPermiso.php'})
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
                    eliminarPermiso: function(permiso){
                        const params = new URLSearchParams();
                        params.append('idPermiso', permiso);                        
                        axios({
                            method:"POST",
                            headers: { 'content-type': 'application/x-www-form-urlencoded' },
                            data: params,
                            url: '/Controladores/eliminarPermiso.php'})
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
                    eliminarHorario: function(horario){
                        const params = new URLSearchParams();
                        params.append('idHorario', horario);                                             
                        axios({
                            method:"POST",
                            headers: { 'content-type': 'application/x-www-form-urlencoded' },
                            data: params,
                            url: '/Controladores/eliminarHorario.php'})
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
                    agregarHorario: function(){

                    },
                    agregarPermiso: function(){

                    },
                    cargarInformacion: function(){
                        axios.get("/Controladores/obtenerInformacionUsuario.php?usuario=<?=$idUsuario?>")
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