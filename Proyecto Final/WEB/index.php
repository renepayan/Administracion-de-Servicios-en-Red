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
    </head>
    <body>
        <div id="app">
            Usuario:<input type="text" minlegth="1" maxlength="30" v-model="usuario"/><br>
            Password:<input type="password" v-model="password"/><br>
            <button v-on:click="enviar">Login</button><br>
            <p style="color:red;" v-if="mensaje.length>0">{{mensaje}}</p>
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data:{
                    usuario:"",
                    password:"",
                    mensaje:""
                },
                methods:{
                    enviar: function(){
                        alert("hola");
                    }
                }
            });
        </script>
    </body>
</html>