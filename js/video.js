
const video = document.querySelector('video');
const snap_btn = document.getElementById("snapshot");
const save_btn = document.getElementById("save_canvas");
const stickers = document.querySelectorAll(".sticker");

// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        // video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream;
        video.play();
    });
}

async function request(url, obj = null) {
    const fd = new FormData();
    fd.append('data', JSON.stringify(obj));
    const response = await fetch(url, {
        method: 'POST',
        body: fd
    });
    return await response.json();
}

function snapshot(e) {
    const playing = video => !!(video.currentTime > 0 &&
        !video.paused && !video.ended && video.readyState > 2);
    if (!playing) {
        alert("ERROR: connect your camera");
        location.href='http://localhost:8080';
    }
    const x = e.target;
    const user_id = x.getAttribute('user_id');

    console.log('snapshot user_id:', user_id);

    if (parseInt(user_id) !== 0) {
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext("2d");
        context.drawImage(video, 0, 0, 640, 480);
        const base64dataUrl = canvas.toDataURL('image/jpeg');
        context.setTransform(1, 0, 0, 1, 0, 0);
        const img = new Image();
        img.src = base64dataUrl;
        canvas.appendChild(img);
    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }
}

function saveCanvas(e)
{
    const x = e.target;
    const user_id = x.getAttribute('user_id');
    console.log('save_canvas user_id:', user_id);
    if (parseInt(user_id) !== 0) {
        const canvas = document.getElementById("canvas");
        const dataURL = canvas.toDataURL("image/jpeg");
        request('/profile/add_camera_photo', { userId: user_id, photoURL: dataURL })
            .then(res => {
                if (res.status === 200) {
                    alert(res.message);
                } else {
                    alert(res.message);
                    location.href='http://localhost:8080';
                }
            });

        // const link = document.createElement("a");
        // link.href = dataURL;
        // link.download = "image.jpg";
        // link.click();
    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }
}

function addSticker(e)
{
    const x = e.target;
    const user_id = x.getAttribute('user_id');
    const id = x.getAttribute('id');

    console.log('save_canvas user_id:', user_id);

    if (parseInt(user_id) !== 0) {
        console.log('image:', id);
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext('2d');
        const img = new Image();
        img.src = document.getElementById(id).src;
        img.onload = function()
        {
            context.translate(20,20);
            const pattern = context.createPattern(img, 'no-repeat');
            context.fillStyle = pattern;
            context.rect(0, 0, canvas.width, canvas.height);
            context.fill();
        }
    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }
}

snap_btn.addEventListener('click', snapshot);
save_btn.addEventListener('click', saveCanvas);
stickers.forEach(sticker => sticker.addEventListener('click', addSticker));