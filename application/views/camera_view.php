
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
        <div class="div_sticker">
            <img class="sticker" id="1" src="/stickers/1.png" alt="">
            <img class="sticker" id="2" src="/stickers/2.png" alt="">
            <img class="sticker" id="3" src="/stickers/3.png" alt="">
            <img class="sticker" id="4" src="/stickers/4.png" alt="">
            <img class="sticker" id="5" src="/stickers/5.png" alt="">
            <img class="sticker" id="6" src="/stickers/6.png" alt="">
        </div>
    </div>
</section>
<script src="/js/video.js" type="text/javascript"></script>