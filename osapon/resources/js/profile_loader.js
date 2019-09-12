//scripts after DOM loaded
document.addEventListener('DOMContentLoaded', () => {
	document.getElementsByClassName("choose-pic")[0].addEventListener("click", () => {
		document.getElementsByClassName("inputfile")[0].click();
	})
	let greetings = document.getElementById('greetings');
	let formWrapper = document.getElementById('form-wrapper');
	let editWrapper = document.querySelector('.edit-profile-wrapper');
	document.onclick = e => {
		if(!(e.target.closest('.content-wrap')) && greetings.style.display === "flex"){
			greetings.style.display = 'none';
		} else if (!(e.target.closest('.credentials')) && formWrapper.style.display === "flex") {
			formWrapper.style.display = 'none';
		} else if (!(e.target.closest('.credentials')) && editWrapper.style.display === "flex") {
			editWrapper.style.display = 'none';
		}
	};
	getRequest("/checkAuthorize")
	.then((result) => {
		let checkProfile = () => {
			postRequest("/whoProfile", window.location.pathname)
			.then((result) => {
				document.querySelector(".avatar").src = result["data"]["data"]["avatar"];
				document.querySelector(".fullname").innerHTML = result["data"]["data"]["firstname"] + " / " + result["data"]["data"]["lastname"];
				document.querySelector(".description").innerHTML = (result["data"]["data"]["description"]) ? result["data"]["data"]["description"] : "";
				if (result["data"]["photos"] != null) {
					document.querySelector(".amount").innerHTML = result["data"]["photos"].length;
					result["data"].photos.forEach((item) => document.querySelector(".gallery-wrap").insertAdjacentHTML('afterbegin' ,`<div class="gallery-item" style="background-image: url('${item["path"]}')">
									<div class="img-description-wrap">
										<div class="delete-user-image" type="${item["id"]}" style="background-image: url('http://localhost:8080/resources/css/icons/cancel.png')"></div>
									</div>
								</div>`))
				}
				if (result["data"]["saved"] != null) {
					result["data"].saved.forEach( ( item ) => document.querySelector( ".saved-wrap" ).insertAdjacentHTML( 'afterbegin', `<div class="saved-item" style="background-image: url('${item["path"]}')">
                                <div class="img-description-wrap"></div>
                            </div>` ) );
				}
				let deleteBtns = document.querySelectorAll(".delete-user-image");
				for (item of deleteBtns) {
					item.addEventListener("click", e => {
						postRequest("/del_image", e.target.getAttribute("type"))
						.then(res => {
							e.target.parentElement.parentElement.remove();
							if (res["status"] == 200) {
								e.target.parentElement.parentElement.remove();
							}
						})
					});
				}
				if (result["status"] == 201) {
					
					let items = document.querySelectorAll("[data-role]");
					items.forEach(item => {
						if (item.getAttribute("data-role") === "photo") item.remove();
					})
					document.querySelector(".edit-profile").remove();
					document.querySelector(".edit-profile-wrapper").remove();
					document.querySelector(".avatar").removeEventListener("click", changeAvatar)
					let removeBtns = document.querySelectorAll(".delete-user-image");
					for (btn of removeBtns) {
						btn.parentElement.remove();
					}
				}
			})
		}
		let authorizedButton = document.getElementById("toAuthorize");
		let logoutButton = document.getElementById("toLogOut");
		let profileButton = document.getElementById("toProfile");
		if (result["status"] == 201) {
			authorizedButton.style.display = "flex";
			profileButton.remove();
			logoutButton.remove();
			checkProfile();
			setTimeout(() => document.getElementById("greetings").style.display = "flex", 0);
		} else {
			logoutButton.style.display = "flex";
			profileButton.style.display = "flex";
			authorizedButton.remove();
			checkProfile();
		}
		document.querySelector(".edit-profile").addEventListener("click", e => {
			e.stopPropagation();
			editWrapper.style.display = "flex";
		});
	});
})