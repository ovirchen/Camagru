
const getRequest = url => {
	return fetch(`${API_PATH}${url}`)
			.then((response) => response.json())
};

const postRequest = (url, data) => {
	let fd = new FormData();
	fd.append("data", JSON.stringify(data));
	return fetch(`${API_PATH}${url}`, {
				method: "POST",
				body: fd,
			})
			.then(response => response.json() )
};