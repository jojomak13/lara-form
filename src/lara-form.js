class Form
{
	constructor(config){
		this.config = config;
		this.errors = {};

		this.myForm = document.querySelector(this.config.el);
		this.bindInputs();
	}

	bindInputs(){
		this.config.inputs.forEach(input => {
			this[input] = this.myForm.elements[input]
		})
	}

	showErrors(){
		for(let input of Object.keys(this.errors)){
			this[input].nextElementSibling.textContent = this.errors[input][0];
			this[input].classList.add('is-invalid');	
		}
	}

	parsedUrl(url){
		return url + '?' + this.config.inputs.map(input => {
			return `${input}=${this[input].value}` 
		}).join('&')
	}

	ajax({type, url}){
		let xhr = new XMLHttpRequest();
		let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

		xhr.open(type, this.parsedUrl(url));
		xhr.setRequestHeader('X-CSRF-TOKEN', token);
		xhr.send();

		return new Promise((resolve, reject) => {
			xhr.onreadystatechange = () => {
				if (xhr.readyState == 4 && xhr.status == 200) {
					let res = JSON.parse(xhr.responseText);
					if(!res.status)  
						this.errors = Object.assign({}, res.data)
					resolve(res)		
				}
			}
		});	
	}

	submit(url, requestType, callback = function(){}){		
		this.ajax({
			type: requestType,
			url: '/todos' 
		}).then(res => {
			if(res.status) callback(res.data) 
			else this.showErrors()	
		})			
	}

	post(url, callback){
		this.submit(url, 'POST', callback)	
	}

	patch(url, callback){
		this.submit(url, 'PATCH', callback)
	}

	delete(url, callback){
		this.submit(url, 'DELETE', callback)
	}
}