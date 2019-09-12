navigator.getUserMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
let video;
let webcamStream;
document.getElementsByClassName('inputfile')[0].addEventListener('change', e => {
	compress(e);
});
function compress(e) {
	const width = 350;
	const height = 250;
	const fileName = e.target.files[0].name;
	const reader = new FileReader();
	reader.readAsDataURL(e.target.files[0]);
	reader.onload = event => {
		const img = new Image();
		img.src = event.target.result;
		img.onload = () => {
			const elem = document.getElementById('canvas');
			elem.width = width;
			elem.height = height;
			ctx = elem.getContext('2d');
			ctx.drawImage(img, 0, 0, width, height);
			document.querySelector(".save-snap").style.display = "block";
			ctx.canvas.toBlob((blob) => {
				const file = new File([blob], fileName, {
					type: 'image/jpeg',
					lastModified: Date.now()
				});
			}, 'image/png', 1);
		}
	};
}
function getBase64FromImageUrl ( url ) {
	let img = new Image();
	img.setAttribute('crossOrigin', 'anonymous');
	
	img.onload = function () {
		ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
		document.querySelector(".save-snap").style.display = "block"
	};
	img.src = url;
}
let frames = document.querySelectorAll(".frame");
for (frame of frames) {
	frame.addEventListener("click", e => {
		getBase64FromImageUrl(e.target.src);
	})
}
function startWebcam() {
	if (navigator.getUserMedia) {
		document.getElementsByClassName("stop-btn")[0].style.backgroundImage = "url('http://localhost:8080/resources/css/icons/full-stop-active.png')";
		navigator.getUserMedia ({
				video: true,
				audio: false
			},
			function(localMediaStream) {
				video = document.querySelector('video');
				video.srcObject = localMediaStream;
				webcamStream = localMediaStream;
			},
			function(err) {
				console.log("The following error occured: " + err);
			}
		);
	} else {
		console.log("getUserMedia not supported");
	}
}
function stopWebcam() {
	document.getElementsByClassName("stop-btn")[0].style.backgroundImage = "url('http://localhost:8080/resources/css/icons/full-stop-default.png')";
	webcamStream.getVideoTracks()[0].stop();
	video = undefined;
}
let canvas, ctx;
function init() {
	canvas = document.getElementById("canvas");
	ctx = canvas.getContext('2d');
}
function snapshot() {
	if (video) {
		ctx.drawImage( video, 0, 0, canvas.width, canvas.height );
		canvas.style.width = canvas.width;
		canvas.style.height = canvas.height;
		document.querySelector(".save-snap").style.display = "block"
	}
}
function clearCanvas() {
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	document.querySelector(".save-snap").style.display = "none";
}