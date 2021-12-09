<?php
    session_start();
    if($_SESSION["usuario"]){
        header('Location: home.php');
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
            Usuario:<input type="text" minlegth="1" maxlength="30" v-model="usuario"/><br>
            Password:<input type="password" v-model="password"/><br>
            Nombre:<input type="text" v-model="nombre"/><br>
            <button v-on:click="enviar">Registro</button><br>
            <a href="index.php">Login</a><br>
            <p style="color:red;" v-if="mensaje.length>0">{{mensaje}}</p>
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data:{
                    usuario:"",
                    password:"",
                    mensaje:"",
                    nombre:""
                },
                methods:{
                    enviar: function(){
                        const params = new URLSearchParams();
                        params.append('usuario', this.usuario);
                        params.append('password', this.password);
                        params.append('nombre', this.nombre);
                        axios({
                            method:"POST",
                            headers: { 'content-type': 'application/x-www-form-urlencoded' },
                            data: params,
                            url: '/Controladores/agregarUsuario.php'})
                        .then(function (response) {
                            if(response.data.Estado === "ok")
                                window.location.replace("home.php");
                            else
                                alert(response.data.Descripcion);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                }
            });
        </script>
    </body>
</html>