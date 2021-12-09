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
            {{message}}
        </div>
        <script>
            var app = new Vue({
                el: '#app',
                data: {
                    message: 'Hello Vue!'
                }
            });
        </script>
    </body>
</html>