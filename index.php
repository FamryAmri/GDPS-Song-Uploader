<html>
    <head>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
        <title>
            GDPS SONG UPLOADER
            </title>
    </head>
    <body>
        <b>Your GDPS Host: </b><?php
            include 'config/config.php';
            $host;
            if ($gdps){
                $host = $_SERVER['SERVER_NAME']; //scan server from here
            } else {
                $host = explode('/', $gdpsurl)[2]; //from config.php
            }
            echo $host;
        ?>
            <hr>
            <form action='stuff.php' enctype='multipart/form-data' method='POST'>
                <label>File Input:</label><b>MP3 ONLY</b><br><br/><input type='file' name='FILE' accept='.mp3'/>
                <button type='submit'>
                    upload
                    </button><br>
                <br>
            </form>
        </body>
    </html>
