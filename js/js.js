
menu.onclick = function menuFunction() {
    let x = document.getElementById('headerNav');

    if (x.className === 'header-navigation') {
        x.className += ' responsive';
    } else {
        x.className = 'header-navigation';
    }
};

let likes = document.querySelectorAll(".icon-item");
let comments = document.querySelectorAll(".add-comment");
let delPhotoes = document.querySelectorAll(".cross");


async function request(url, obj) {
    let fd = new FormData();
    fd.append('data', JSON.stringify(obj));
    let response = await fetch(url,{ method: 'POST', body: fd });
    return await response.json();
}

async function likeFunction(e) {
    const x = e.target;
    const photo_id = x.getAttribute('photo_id');
    const user_id = x.getAttribute('user_id');
    console.log(photo_id, user_id);
    if (parseInt(user_id) !== 0) {
        const responce = await request('/profile/add_like', {userId: user_id, photoId: photo_id});
        if (responce.status === 200) {
            const sibling = x.nextElementSibling;
            sibling.innerText = responce.amount;
            console.log("sibling: ", sibling);
        } else {
            alert(responce.message);
            location.href='http://localhost:8080';
        }
    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }
}

async function commentFunction(e) {
    const x = e.target;
    e.preventDefault();
    const photo_id = x.getAttribute('photo_id');
    const user_id = x.getAttribute('user_id');
    console.log(photo_id, user_id);
    const el = x.previousElementSibling;
    if (parseInt(user_id) !== 0 && el.value.trim() !== "") {
        let responce = await request('/profile/add_comment', {userId: user_id, photoId: photo_id, text: el.value.trim()});
        el.value = "";
        if (responce.status === 200) {
            const span = x.parentElement.previousElementSibling.firstElementChild;
            let str = responce.amount;
            if (responce.amount.length > 56)
                str = responce.amount.substr(0, 56) + '...';
            span.textContent = str;
            console.log("span: ", span);
        } else {
            alert(responce.message);
            location.href='http://localhost:8080';
        }
    }
    else {
        alert("ERROR: You are not logged in");
        location.href='http://localhost:8080/login';
    }
}

async function delPhotoFunction(e) {
    const x = e.target;
    const photo_id = x.getAttribute('photo_id');
    console.log(photo_id);
    const responce = await request('/profile/delete_photo', {photoId: photo_id});
    if (responce.status === 200) {
        const photo = x.parentElement.parentElement;
        console.log(photo);
        photo.remove();
    } else {
        alert(responce.message);
        location.href='http://localhost:8080';
    }
}


likes.forEach(like => like.addEventListener('click', likeFunction));
comments.forEach(comment => comment.addEventListener('click', commentFunction));
delPhotoes.forEach(delphoto => delphoto.addEventListener('click', delPhotoFunction));
