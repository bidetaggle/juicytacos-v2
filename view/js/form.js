window.onload = function(){
	var parameters = {
		success: "#success",
		error: "#error",
		errorClass: "wrong"	//class html de mise en surbriance du champs où il y a l'erreur
	};

	if(document.getElementsByTagName("form").length != 0){ //to avoid console warning in case of there is no form on the page
		$("form").submit(function(e){
			e.preventDefault();

			let form = $(this);
			let deleteAction = form.attr('action').match(/[:a-z\/]+\.php\?delete/);

			if(deleteAction)
				if(!confirm('Do you really want to remove this forever ? へ[ •́ ‸ •̀ ]ʋ'))
					return;

			$.post(this.action, $(this).serialize())
			.done(function(response){
				var champs = {};
				var success = true;
				console.log(response);

				if(deleteAction && response == "true"){
					form.fadeOut();
				}
				else{
					let Response = $.parseJSON(response);
					//liste de tous les champs (input/textarea) du formulaire et mise à jour des erreurs
					$.each(Response, function(tagName, value){
						if(tagName != "Location"){
							//affiche ou non les erreurs en fonction de leur nom
							var errTag = $(parameters.error + " ." + tagName);
							//selectionne l'input (avec le name ou la class) concerné pour ajouter le style si l'erreur existe
							var input = $("[name='"+tagName+"'], ."+tagName+":not("+parameters.error+" ."+tagName+")")
							if(!value){
								success = false;
								errTag.fadeIn();
								input.addClass(parameters.errorClass);
							}
							else{
								errTag.fadeOut();
								input.removeClass(parameters.errorClass);
							}				
						}
					});

					//Dans le cas où aucune erreur n'a été relevée, on indique que le mail a été envoyé
					if(success){
						document.location.href = Response.Location;
					}
				}
			});
		});
	}
};
