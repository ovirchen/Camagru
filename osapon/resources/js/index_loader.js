//scripts after DOM loaded
document.addEventListener('DOMContentLoaded', () => {
	let greetings = document.getElementById('greetings');
	let formWrapper = document.getElementById('form-wrapper');
	document.onclick = e => {
		if(!(e.target.closest('.content-wrap')) && greetings.style.display === "flex"){
			greetings.style.display = 'none';
		} else if (!(e.target.closest('.credentials')) && formWrapper.style.display === "flex") {
			formWrapper.style.display = 'none';
			restorePasswordView("restorePass", "signIn", "passwordInput");
		}
	};
	getRequest("/checkAuthorize")
	.then((result) => {
		var authorization;
		let authorizedButton = document.getElementById("toAuthorize");
		let logoutButton = document.getElementById("toLogOut");
		let profileButton = document.getElementById("toProfile");
		if (result["status"] == 201) {
			authorization = false;
			authorizedButton.style.display = "flex";
			profileButton.remove();
			logoutButton.remove();
			setTimeout(() => document.getElementById("greetings").style.display = "flex", 0);
		} else {
			authorization = true;
			logoutButton.style.display = "flex";
			profileButton.style.display = "flex";
			authorizedButton.remove();
		}
		getRequest("/getPosts")
		.then((result) => {
			if (result["status"] == 200 && result["posts"] != null) {
				result.posts.forEach((item) => {
					let likedImage = (item.liked == true) ? "http://localhost:8080/resources/css/icons/heart-liked.png" : "http://localhost:8080/resources/css/icons/heart-hover.png";
					let savedImage = (item.favourite == true) ? "http://localhost:8080/resources/css/icons/bookmark-selected.png" : "http://localhost:8080/resources/css/icons/bookmark-hover.png";
					let comments = item.comments.map(comment => `<div class="comment-item"><div class="comment-login"><a href="http://localhost:8080/profile/${comment.user_id}"><h2>@${comment.login}</h2></a></div><div class="comment-text"><p>${comment.comment}</p></div><div class="comment-time"><p>${comment.date}</p></div></div>`);
					comments = comments.join("");
					document.querySelector(".content-wrap").insertAdjacentHTML("afterbegin", `<div class="item-wrap"><div class="header-wrapper"><div class="user-profile-photo"><a href="http://localhost:8080/profile/${item.profile.id}"><img src="${item.profile.avatar}" alt=""></a></div><div><a href="http://localhost:8080/profile/${item.profile.id}"><h2>@${item.profile.login}</h2></a></div></div><div class="photo-wrapper"><img src="${item.post.path}" alt=""></div><div class="action-wrapper"><div class="action-item like-action" data-ac-role="like-action" data-type="${item.post.id}" style='background-image: url(${likedImage})'>${item.likes}</div><div class="action-item comment-action" data-ac-role="comment-action" style='background-image: url("resources/css/icons/chat-hover.png")'></div><div class="action-item favourite-action" data-ac-role="favourite-action" data-type="${item.post.id}" style='background-image: url(${savedImage})'></div></div><div class="comment-wrapper">${comments}</div><div class="leave-comment-wrapper"><textarea name="" id="textarea" cols="105" rows="1" placeholder="Leave comment..." data-type="${item.post.id}"></textarea><div class="leave-comment-button"  data-type="${item.post.id}">send</div></div></div>`)
				});
				
				let getID = e => { return e.target.getAttribute("data-type"); };
				if (authorization) {
					let commentAction = document.querySelectorAll( ".action-item" );
					for (elem of commentAction) {
						elem.addEventListener( "click", e => {
							let id;
							switch (e.target.getAttribute( "data-ac-role" )) {
								case "like-action":
									id = getID(e);
									if (Number(id)) {
										postRequest("/setLike", id)
										.then((res) => {
											switch (res["status"]) {
												case 200:
													e.target.style.backgroundImage = "url('http://localhost:8080/resources/css/icons/heart-liked.png')";
													e.target.innerText = Number(e.target.innerText) + 1;
													break;
												case 202:
													e.target.style.backgroundImage = "url('http://localhost:8080/resources/css/icons/heart-hover.png')";
													e.target.innerText = Number(e.target.innerText) - 1;
													break;
												default:
													break;
											}
										})
									}
									break;
								case "comment-action":
									e.target.closest( ".item-wrap" ).getElementsByTagName( "textarea" )[0].focus();
									break;
								case "favourite-action":
									id = getID(e);
									if (Number(id)) {
										postRequest('/favourite', id)
										.then((res) => {
											switch (res['status']) {
												case 200:
													e.target.style.backgroundImage = "url('http://localhost:8080/resources/css/icons/bookmark-selected.png')";
													break;
												case 202:
													e.target.style.backgroundImage = "url('http://localhost:8080/resources/css/icons/bookmark-hover.png')";
													break;
												default:
													break;
											}
										})
									}
									break;
								default:
									break;
							}
						} )
					}
					// send comment button
					let commentButtons = document.querySelectorAll( ".leave-comment-button" )
					for (elem of commentButtons) {
						elem.addEventListener( "click", e => {
							let value = e.target.parentNode.getElementsByTagName( "textarea" )[0].value.trim();
							if (value == "") return false;
							let id = e.target.getAttribute("data-type");
							postRequest("/comment", {"id": id, "comment": value})
							.then(result => {
								if (result["status"] == 200) {
									let div = document.createElement("div");
									div.setAttribute("class", "comment-item");
									div.innerHTML = `<div class="comment-login"><a href="http://localhost:8080/profile/${result["user"][0]}"><h2>@${result["user"][1]}</h2></a></div><div class="comment-text"><p>${result["user"][3]}</p></div><div class="comment-time"><p>${result["user"][4]}</p></div>`;
									e.target.parentNode.previousSibling.appendChild(div)
									e.target.parentNode.getElementsByTagName( "textarea" )[0].value = "";
								}
							})
						} )
					}
				}
			}
		})
	})
})