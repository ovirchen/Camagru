document.getElementById("update").addEventListener("click", (e) => {
	let inputs = e.target.closest(".edit-profile-wrapper").getElementsByTagName("input");
	let data = {}, item = {}, value = "", inputName = "";
	for(input of inputs) {
		value = input.value.trim();
		inputName = input.getAttribute("name").trim();
		item[inputName] = value;
		data = {...data, ...item};
	}
	data["notifications"] = document.getElementById('notifications').checked;
	if (data["login"] !== "" && data['login'].length < 4) return false;
	let validEmail = ()  => (data['email'].indexOf("@") > 0 && data['email'].indexOf(".", data['email'].indexOf("@")) > 0 && data['email'][data['email'].indexOf("@") + 1] !== '.' && data['email'][data['email'].indexOf(".", data['email'].indexOf("@")) + 1] !== undefined);
	if (data["email"] !== "" && !validEmail()) return false;
	postRequest(`/update_user`, data)
	.then(response => {
		let res = JSON.stringify(response);
		if (res == 200) {
			window.location.reload();
		}
	})
	.catch(error => console.error(JSON.stringify(error)));
})


let tabBarItems = document.querySelectorAll(".tab-bar-item");
let removeActive = targets => {
	for (item of targets) {
		item.setAttribute("class", "tab-bar-item")
	}
};
let activateTab = (target, active, inactiveFst, inactiveSec) => {
	target.setAttribute("class", "tab-bar-item active");
	document.getElementsByClassName(active)[0].style.display = "flex";
	document.getElementsByClassName(inactiveFst)[0].style.display = "none";
	document.getElementsByClassName(inactiveSec)[0].style.display = "none";
};
function changeAvatar() {
	document.querySelector(".avatar-input").click();
}
document.getElementById("avatar").addEventListener("click", changeAvatar);
document.querySelector(".avatar-input").addEventListener("change", e => {
	var file = e.target.files[0];
	var imagefile = file.type;
	var match= ["image/jpeg","image/png","image/jpg"];
	if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
		alert('Please select a valid image file (JPEG/JPG/PNG).');
		return false;
	}
	let fd = new FormData();
	fd.append("data", file);
	return fetch(`${API_PATH}/change_ava`, {
		method: "POST",
		body: fd,
		headers: {
			contentType: false,
			cache: false,
			processData: false
		}
	})
	.then(response => response.json() )
	.then((res) => {
		if (res["status"] == 200) {
			document.querySelector(".avatar").setAttribute("src", res["path"])
		}
	})
});
for (tabItem of tabBarItems) {
	tabItem.addEventListener("click", e => {
		switch (e.target.getAttribute("data-role")) {
			case "gallery":
				removeActive(tabBarItems);
				activateTab(e.target, "gallery-wrap", "saved-wrap", "photo-wrap");
				break;
			case "saved":
				removeActive(tabBarItems);
				activateTab(e.target, "saved-wrap", "photo-wrap", "gallery-wrap");
				break;
			case "photo":
				removeActive(tabBarItems)
				activateTab(e.target, "photo-wrap", "gallery-wrap", "saved-wrap");
				break;
			default:
				break;
		}
	})
}
document.querySelector(".save-snap").addEventListener("click", () => {
	let data = document.getElementById("canvas").toDataURL();
	postRequest(`/upload_img`, data)
	.then((res) => {
		if (res["status"] == 200) {
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			document.querySelector(".gallery-wrap").insertAdjacentHTML('afterbegin' ,`<div class="gallery-item" style="background-image: url('${res["path"]}')">
                        <div class="img-description-wrap">
                            <div class="description-item" style='background-image: url("http://localhost:8080/resources/css/icons/heart-main.png")'></div>
                        </div>
                    </div>`);
		}
	})
});