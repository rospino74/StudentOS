const clearComments = () => {
	let containers = document.querySelectorAll(".post .comments");

	containers.forEach(( elem ) => {
		elem.innerHTML = "";
		
		//building the infobox
		let empty = document.createElement("p");
		empty.classList.add("empty");
		empty.innerHTML = 'No Comments Here! <a onclick="openCommentWindow(s_id, c_id, this.parentElement.parentElement.parentElement);">Write</a> a new one';
		elem.appendChild( empty );
	});
}

const getComment = ( classroom, session ) => {	
	var out = false;
	
	let loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/getComment");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("class=" + classroom + "&session=" + session);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	loader.then((result) => {
		let data = JSON.parse( result );
		
		clearComments();
		
		data.forEach(( elem ) => {
			let container = document.querySelector("#post-" + elem.parent_id + " .comments");
			
			
			//removing the infobox
			let box = container.querySelector(".empty");
			if(box != undefined)
				container.removeChild( box );
			
			//adding the button to write a new comment if it doesn't exist
			if(container.querySelector("a.add-comment") == undefined) {
				let writeBtn = document.createElement("a");
				writeBtn.classList.add("add-comment");
				writeBtn.addEventListener("click", () => {
					openCommentWindow(window.s_id, window.c_id, container.parentElement);
				});
				writeBtn.innerHTML = `<i class="fas fa-plus"></i> Add a Comment`;
				container.insertBefore( writeBtn, container.firstChild);
			}
			
			//building the comment			
			let comment = document.createElement("article");
			comment.classList.add("comment");
			comment.id = "comment-" + elem.id;
			
			/*if( elem.isOwner ) {
				comment.innerHTML = `<nav class="menu">
									<button class="fas fa-ellipsis-v menu-btn" onclick="showMenu( this.parentElement )"></button>
									<div class="menu-content">
										<a href="#" onclick="removePost(this.parentElement.parentElement.parentElement, s_id, c_id)">Delete</a>
									</div>
								</nav>`;
			}*/
			
		comment.innerHTML += `
						<h3 class="author">
							${elem.author.name}
						</h3>
						<p class="date">
							${elem.date}
						</p>
						<p class="content">
							${elem.text}
						</p>`;

			container.appendChild( comment );
			
		});
		out = true;
	}).catch(( e ) => {
		console.error("Comment error: " + e);		
		out = false;
	});
	
	return out;
}