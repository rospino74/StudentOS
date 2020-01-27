const openCommentWindow = ( session, classroom, parentPost ) => {
	if(document.querySelector("div.write-container") != undefined) {
		return false;
	}
	
	//hiding the body overflow
	document.body.style.overflow = "hidden";
	
	//getting the post id
	let parent_id = parentPost.getAttribute("id").slice( 5 );

	let body = document.body;
	let container = document.createElement("div");
	
	container.classList.add("write-container");
	container.innerHTML = `<div class="write-bg"></div>
	<div class="write-box">
		<h1>Write a Comment</h1>
        <label for="text">Text</label><br />
        <textarea id="text" placeholder="Write the comment here..."></textarea><br />
        <button name="send" class="btn-positive" onclick="writeComment( '${session}', '${classroom}', ${parent_id} );"><i class="fas fa-sticky-note"></i> Post</button><button onclick="closeWriteWindow();" class="btn-negative"><i class="fas fa-ban"></i> Close</button>
	</div>`;
	
	//adding event to the textarea
	container.addEventListener("keypress", (e) => {
		if(e.ctrlKey || e.charCode == 13) {
			writeComment( session, classroom, parent_id);
		} else {
			return;
		}
	});
	
	body.insertBefore(container, body.firstChild);
}

const writeComment = ( session, classroom, parent_id ) => {
	let text = document.querySelector("div.write-container .write-box #text");
	
	
	let uploader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/addComment");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("text=" + encodeURI(text.value) + "&parent_id=" + parent_id + "&class=" + classroom + "&session=" + session);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	uploader.then(() => {
		closeWriteWindow();
		getPost( classroom, session );
		getComment( classroom, session );
	});
}