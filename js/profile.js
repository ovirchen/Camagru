// import '/application/controllers/controller_main.php'

// function loginBox(id, loginBoxContent) {
//     let div = document.getElementById(id);
//     let loginBoxContent_div = document.getElementById(loginBoxContent);
//     if(div.style.display === 'block') {
//         div.style.display = 'none';
//     }
//     else {
//         div.style.display = 'block';
//     }
//     // let div2 = document.getElementById('loginBox');
//     // if(div.style.display === 'block')
//     //     div2.style.display = 'none';
// }
//
// function createBox(id) {
//     let div = document.getElementById(id);
//     // let createBoxContent_div = document.getElementById(createBoxContent);
//     if(div.style.display === 'block') {
//         div.style.display = 'none';
//     }
//     else {
//         div.style.display = 'block';
//     }
// }

// let getId = () => {
//     document.getElementById("createBox").addEventListener("click", () => {
//         document.getElementById("createBox").style.display = 'none';
//     })
// }
//
// getId();

// $(document).keyup(function(e) {
//     if (e.key === "Escape") { // escape key maps to keycode '27'
//         document.getElementById("createBox").style.display = 'none';
//     }
// });

let delProfile = document.querySelector(".delete_profile");


async function request(url, obj = null) {
    let fd = new FormData();
    fd.append('data', JSON.stringify(obj));
    let response = await fetch(url, { method: 'POST', body: fd });
    return await response.json();
}

async function deleteProfile(e)
{
    e.preventDefault();
    if (confirm("Do you really want to die?")) {
        let responce = await request('http://localhost:8080/profile/delete');
        if (responce.status != 200) {
            alert("Database ERROR");
            location.href='http://localhost:8080/profile';
        }
        else {
            window.location = 'http://localhost:8080/login/logout';
        }
    }
}

delProfile.addEventListener('click', deleteProfile);


