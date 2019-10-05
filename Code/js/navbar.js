const back = document.querySelectorAll('.navbar *[data-action=back]');
const quit = document.querySelectorAll('.navbar *[data-action=quit]');
const home = document.querySelectorAll('.navbar *[data-action=home]');

back.forEach((item) => {
	item.addEventListener("click", (e) => {
		history.back();
	});
});

quit.forEach((item) => {
	item.addEventListener("click", (e) => {
		window.location.href = "../check.php";
	});
});

home.forEach((item) => {
	item.addEventListener("click", (e) => {
		window.location.href = "../";
	});
});