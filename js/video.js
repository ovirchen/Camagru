
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

var snapshot = function() {
    const playing = video => !!(video.currentTime > 0 &&
        !video.paused && !video.ended && video.readyState > 2);
    if (!playing) alert("CAMERA ERROR");
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext("2d");
    context.drawImage(video, 0, 0, 320, 240);
    var base64dataUrl = canvas.toDataURL('image/jpeg');
    context.setTransform(1, 0, 0, 1, 0, 0);
    var img = new Image();
    img.src = base64dataUrl;
    canvas.appendChild(img);
}

camera.addEventListener('click', snapshot);