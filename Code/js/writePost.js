function openWriteWindow( session, classroom ) {
	if(document.querySelector("div.write-container") != undefined) {
		return false;
	}

	var body = document.body;
	var container = document.createElement("div");
	
	container.classList.add("write-container");
	container.innerHTML = `<div class="write-bg"></div>
	<div class="write-box">
		<label for="title">Title</label><br />
        <input id="title" type="text" placeholder="Insert the title..."/><br />
        <label for="text">Text</label><br />
        <textarea id="text" placeholder="Insert the text..."></textarea><br />
        <button name="send" class="btn-positive" onclick="writePost( '` + session + `', '` + classroom +`' );"><i class="fas fa-sticky-note"></i> Post</button><button onclick="closeWriteWindow();" class="btn-negative"><i class="fas fa-ban"></i> Close</button>
	</div>`;
	
	body.insertBefore(container, body.firstChild);
}

function closeWriteWindow() {
	if(document.querySelector("div.write-container") == undefined) {
		return false;
	}
	
	var body = document.body;
	var windows = document.querySelectorAll("div.write-container");
	
	windows.forEach(( elem ) => {
		body.removeChild( elem );
	});
}

function writePost( session, classroom ) {
	var title = document.querySelector("div.write-container .write-box #title");
	var text = document.querySelector("div.write-container .write-box #text");
	
	
	var uploader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/addPost");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("title=" + title.value + "&text=" + text.value + "&class=" + classroom + "&session=" + session);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	uploader.then(() => {
		closeWriteWindow();
		getPost( classroom, session );
	});
}