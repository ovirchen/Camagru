
var video = document.querySelector('video');
var camera = document.getElementById("snapshot");
var canvas_btn = document.getElementById("save_canvas");

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        // video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        video.play();
    });
}

function snapshot(e) {
    const playing = video => !!(video.currentTime > 0 &&
        !video.paused && !video.ended && video.readyState > 2);
    if (!playing) {
        alert("ERROR: connect your camera");
        location.href='http://localhost:8080';
    }
    let x = e.target;
    let user_id = x.getAttribute('user_id');

    console.log('user_id:', user_id);

    if (user_id != 0) {
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, 640, 480);
        var base64dataUrl = canvas.toDataURL('image/jpeg');
        context.setTransform(1, 0, 0, 1, 0, 0);
        let img = new Image();
        img.src = base64dataUrl;
        canvas.appendChild(img);
        // var div_container = document.createElement("div");
        // div_container.className = "canvas_img";
        // canvas.appendChild(div_container);
        // div_container.appendChild(img);
    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }
}

function save_canvas(e)
{
    let x = e.target;
    let user_id = x.getAttribute('user_id');
    console.log('user_id:', user_id);
    if (user_id != 0) {
        let img = x.previousElementSibling.firstElementChild;

    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }

}

camera.addEventListener('click', snapshot);
canvas_btn.addEventListener('click', save_canvas);