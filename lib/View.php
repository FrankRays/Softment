<?php
include_once '../lib/User.php';

class View{
    public static function start(){
        echo <<<HEADER
        <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="UTF-8"> 
                        <title>SoftMent</title>
                        <link rel="stylesheet" href="../style.css">
                    </head>
                    
                    <body>
                        <header>
                            <img src="../img/SoftMent.png" alt="SoftMent">
                        </header>
HEADER;
        User::session_start();
        return;
    }

    public static function end(){
        echo <<<CLOSE
        <footer>
            <p>SoftMent&copy;</p>
        </footer>
    </body>
</html>
CLOSE;
    }

}
?>