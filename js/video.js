
var video = document.querySelector('video');
var camera = document.getElementById("snapshot");

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
    if (!playing) alert("CAMERA ERROR");
    let x = e.target;
    let user_id = x.getAttribute('user_id');

    console.log('user_id:', user_id);

    if (user_id != 0) {
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, 320, 240);
        var base64dataUrl = canvas.toDataURL('image/jpeg');
        context.setTransform(1, 0, 0, 1, 0, 0);
        var img = new Image();
        img.src = base64dataUrl;
        var div_container = document.createElement("div");
        div_container.className = "canvas_img";
        canvas.appendChild(div_container);
        div_container.appendChild(img);
    }
}

camera.addEventListener('click', snapshot);