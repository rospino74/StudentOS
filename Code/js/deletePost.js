const removePost = ( elem, session, classroom ) => {
	let id = elem.getAttribute("id").slice( 5 );
	
	var loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/deletePost");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("session=" + session + "&id=" + id + "&class=" + classroom);
		
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
		getPost( classroom, session );
		getComment( classroom, session );
	});
	
	loader.catch((result) =>{
		console.error(result);
		
		//showing a message
		SnackAlert.make({
			message: "Unable to delete",
			showAction: true, 
			actionMessage: "Retry",
			actionCallback: () => {
				removePost(elem, session, classroom);
			}
		});
	});
}