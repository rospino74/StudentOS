const clearComments = () => {
	let containers = document.querySelectorAll(".post .comments");

	containers.forEach(( elem ) => {
		elem.innerHTML = "";
		
		//building the infobox
		let empty = document.createElement("p");
		empty.classList.add("empty");
		empty.innerHTML = 'No Comments Here! <a onclick="openCommentWindow(settings.s_id, settings.c_id, this.parentElement.parentElement.parentElement);">Write</a> a new one';
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
		
		xhr.onload = () => {
			if(xhr.status == 200){
					resolve(xhr.responseText);
			} else {
					reject(xhr.responseText);
			}
		};
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
			if(container.querySelector("a.add-comment") == undefined && settings.can_write) {
				let writeBtn = document.createElement("a");
				writeBtn.classList.add("add-comment");
				writeBtn.addEventListener("click", () => {
					openCommentWindow(window.settings.s_id, window.settings.c_id, container.parentElement);
				});
				writeBtn.innerHTML = `<i class="fas fa-plus"></i> Add a Comment`;
				container.insertBefore( writeBtn, container.firstChild);
			}
			
			//building the comment			
			let comment = document.createElement("article");
			comment.classList.add("comment");
			comment.id = "comment-" + elem.id;
			
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
						
			//if the user is owner a menu will appear
			if( elem.isOwner ) {
				let menu = document.createElement("nav");
				menu.classList.add("menu");
				
				menu.innerHTML = `<button class="fas fa-ellipsis-h menu-btn" onclick="showMenu( this.parentElement )"></button>
									<div class="menu-content">
										<a onclick="removeComment(this.parentElement.parentElement.parentElement, settings.s_id, settings.c_id)">Delete</a>
									</div>`;

				//appending the menu after the date
				comment.insertBefore(menu, comment.querySelector(".content"));				
			}						

			container.appendChild( comment );
			
		});
		out = true;
	});
	loader.catch(( e ) => {
		console.error("Comment error: " + e);		
		out = false;
		
		//showing a message
		SnackAlert.make({
			message: "Unable to load comments",
			showAction: true, 
			actionMessage: "Retry",
			actionCallback: () => {
				getComment( session, classroom );
			}
		});
	});
	
	return out;
}