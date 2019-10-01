
<section class="main-slider">
    <div class="camera">
        <div class="video">
            <video id="video" width="640" height="480" autoplay></video>
        </div>
        <button id="snapshot" user_id="<?php
        if (isset($_SESSION['user']))
            echo $_SESSION['user']['id'];
        else
            echo 0;?>">Snap Photo</button>
    </div>
    <div class="div_canvas">
        <canvas class="canvas" id="canvas" width="640" height="480"></canvas>
        <button id="save_canvas" user_id="<?php
        if (isset($_SESSION['user']))
            echo $_SESSION['user']['id'];
        else
            echo 0;?>">Save Photo</button>
    </div>
</section>
<script src="/js/video.js" type="text/javascript"></script>