const removeComment = ( elem, session, classroom ) => {
	let id = elem.getAttribute("id").slice( 8 );
	let parent_id = elem.parentElement.parentElement.getAttribute("id").slice( 5 );
	
	let loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/deleteComment");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("session=" + session + "&id=" + id + "&parent_id=" + parent_id + "&class=" + classroom);
		
		xhr.onload = () => {
			if(xhr.status == 200){
					resolve(xhr.responseText);
			} else {
					reject(xhr.responseText);
			}
		};
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	loader.then(( result ) => {
		getComment( classroom, session );
	});
	loader.catch((r) => {
		console.error(r);
		
		//showing a message
		SnackAlert.make({
			message: "Unable to delete",
			showAction: true, 
			actionMessage: "Retry",
			actionCallback: () => {
				removeComment(elem, session, classroom);
			}
		});
	});
}