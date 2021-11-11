window.addEventListener('DOMContentLoaded', (event) => {
	let button = document.querySelector('.whatsapp-sale')

	if (button) {
		let link = button.getAttribute('href')
		let completeLink = link + ' - [' + productObject.name + ']'
		button.setAttribute('href', completeLink)
	}
})
