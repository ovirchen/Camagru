// import '/application/controllers/controller_main.php'

function loginBox(id, loginBoxContent) {
    let div = document.getElementById(id);
    let loginBoxContent_div = document.getElementById(loginBoxContent);
    if(div.style.display === 'block') {
        div.style.display = 'none';
    }
    else {
        div.style.display = 'block';
    }
    // let div2 = document.getElementById('loginBox');
    // if(div.style.display === 'block')
    //     div2.style.display = 'none';
}

function createBox(id) {
    let div = document.getElementById(id);
    // let createBoxContent_div = document.getElementById(createBoxContent);
    if(div.style.display === 'block') {
        div.style.display = 'none';
    }
    else {
        div.style.display = 'block';
    }
}

// let getId = () => {
//     document.getElementById("createBox").addEventListener("click", () => {
//         document.getElementById("createBox").style.display = 'none';
//     })
// }
//
// getId();

$(document).keyup(function(e) {
    if (e.key === "Escape") { // escape key maps to keycode '27'
        document.getElementById("createBox").style.display = 'none';
    }
});

function logout() {
    // $controller = new Controller_Main();
    // $controller->action_index();
}

