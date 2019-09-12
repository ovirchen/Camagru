function restorePasswordView(show, hide1, hide2) {
	document.getElementById(show).style.display = "none";
	document.getElementById(hide1).style.display = "flex";
	document.getElementById(hide2).style.display = "flex";
}


// menu actions
document.getElementById("toMain").addEventListener("click", (e) => {
	location.href = `${WEB_PATH}`;
});
document.getElementById("toProfile").addEventListener("click", (e) => {
	location.href = `${WEB_PATH}profile`;
});
document.getElementById("toAuthorize").addEventListener("click", (e) => {
	e.stopPropagation()
	document.getElementsByClassName("form-wrapper")[0].style.display = "flex";
	document.getElementById("greetings").style.display = "none";
});
document.getElementById("toLogOut").addEventListener("click", () => {
	getRequest(`/logout`)
	.then((myJson) => {
		let res = JSON.stringify(myJson);
		if (res == 200) {
			location.href = `${WEB_PATH}`;
		}
	})
});
//close welcome pop-up clicking on "x" sign
document.getElementsByClassName("exit")[0].addEventListener("click", () => {
	document.getElementById("greetings").style.display = "none";
})
function inputParse(inputs) {
	let data = {}, item = {}, value = "", inputName = "";
	for(input of inputs) {
		value = input.value.trim();
		if (value === "") return false;
		inputName = input.getAttribute("name").trim();
		item[inputName] = value;
		data = {...data, ...item};
	}
	return data;
}
document.getElementById("signIn").addEventListener("click", e => {
	let inputs = e.target.closest(".login").getElementsByTagName("input");
	let data = inputParse(inputs);
	
	if (!data) return false;
	postRequest(`/login`, data)
	.then(data => {
		let res = JSON.stringify(data);
		if (res == 200) {
			location.href = `${WEB_PATH}`;
		}
	})
	.catch(error => console.error(JSON.stringify(error)));
});
//switcher in authorization pop-up for sign-in && sign-up form
let switcherItems = document.querySelectorAll('.switcher-item');
for (let elem of switcherItems) {
	elem.addEventListener( 'click', e => {
		e.stopPropagation();
		switch (e.target.getAttribute( 'data-sw-role' )) {
			case 'sign-in':
				e.target.style.backgroundColor = "black";
				e.target.style.opacity = 1;
				document.getElementsByClassName("signUp")[0].style.opacity = "0.5";
				document.getElementsByClassName("login")[0].style.display = "block";
				document.getElementsByClassName("registration")[0].style.display = "none";
				break;
			case 'sign-up':
				e.target.style.backgroundColor = "#black";
				e.target.style.opacity = 1;
				document.getElementsByClassName("signIn")[0].style.opacity = "0.5";
				document.getElementsByClassName("login")[0].style.display = "none";
				document.getElementsByClassName("registration")[0].style.display = "block";
				break;
			default:
				break;
		}
		restorePasswordView("restorePass", "signIn", "passwordInput");
	} )
}
// sign-up form parse/validation && send to server
document.getElementById("signUp").addEventListener("click", e => {
	let inputs = e.target.closest(".registration").getElementsByTagName("input");
	let data = inputParse(inputs);

	if (!data) return false;
	if (data['login'].length < 4) return false;
	if (data['password'].length < 7) return false;
	if (data['password'] !== data['rePassword']) return false;
	let validEmail = ()  => (data['email'].indexOf("@") > 0 && data['email'].indexOf(".", data['email'].indexOf("@")) > 0 && data['email'][data['email'].indexOf("@") + 1] !== '.' && data['email'][data['email'].indexOf(".", data['email'].indexOf("@")) + 1] !== undefined);
	if (!validEmail()) return false;
	delete data["rePassword"];
	postRequest(`/registration`, data)
	.then(response => {
		let res = JSON.stringify(response);
		if (res == 200) {
			for (input of inputs) {
				input.value = "";
			}
			document.getElementById("form-wrapper").click();
		} else {
			alert(`error! ${response[400]}`)
		}
	})
	.catch(error => console.error(JSON.stringify(error)));
});


// restore password
document.querySelector(".forgot-password").addEventListener("click", e => {
	e.preventDefault();
	document.getElementById("restorePass").style.display = "flex";
	document.getElementById("signIn").style.display = "none";
	document.getElementById("passwordInput").style.display = "none";
})
document.getElementById("restorePass").addEventListener("click", () => {
	let email = document.getElementById("signInLogin").value;
	postRequest("/restore_pass", email)
	.then(res => {
		if (res["status"] == 200) {
			restorePasswordView("restorePass", "signIn", "passwordInput");
		}
	})
})