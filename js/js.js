
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

async function request(url, obj) {
    let fd = new FormData();
    fd.append('data', JSON.stringify(obj));

    let response = await fetch(url,{ method: 'POST', body: fd });
    return await response.json();
}

async function itemFunction(e) {
    let x = e.target;
    let photo_id = x.getAttribute('photo_id');
    let user_id = x.getAttribute('user_id');
    console.log(photo_id, user_id);
    if (user_id != 0) {
        let responce = await request('/profile/add_like', {userId: user_id, photoId: photo_id});
        if (responce.status == 200) {
            const sibling = x.nextElementSibling;
            sibling.innerText = responce.amount;
            console.log("sibling: ", sibling);
        } else {
            alert("ERROR");
        }
    }
}

async function commentFunction(e) {
    let x = e.target;
    e.preventDefault();
    let photo_id = x.getAttribute('photo_id');
    let user_id = x.getAttribute('user_id');
    console.log(photo_id, user_id);
    const el = x.previousElementSibling;
    if (user_id != 0 && el.value.trim() != "") {
        let responce = await request('/profile/add_comment', {userId: user_id, photoId: photo_id, text: el.value.trim()});
        el.value = '';
        if (responce.status == 200) {
            const span = x.parentElement.previousElementSibling.firstElementChild;
            span.textContent = responce.amount;
            console.log("span: ", span);
        } else {
            alert("ERROR");
        }
    }
}

likes.forEach(like => like.addEventListener('click', itemFunction));
comments.forEach(comment => comment.addEventListener('click', commentFunction));

