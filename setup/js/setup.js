/**
 *
 * Conjunto de Funcoes Essenciais para o Funcionamento do Setup 
 * 
 * @version 1.0
 * @author Yan Gabriel da Silva Machado <yangsmachado@gmail.com>
 */
(function () {
	"use strict";
	
	// Mede a distancia entre elementos e o top da pagina [INICIO]
	window.Object.defineProperty(HTMLElement.prototype, 'documentOffsetTop', {
		get: function () { 
			return this.offsetTop + (this.offsetParent ? this.offsetParent.documentOffsetTop : 0);
		}
	});
	// Mede a distancia entre elementos e o top da pagina [FIM]
	
	
	// Checa a existencia de uma Classe CSS [INICIO] 
    var hasClass = function (element, cssClass) {
        var cssClasses, found = false;
        
        if (element!==undefined && element!==null && element!=='' && cssClass!==undefined && cssClass!==null && cssClass!=='') {
            if (element.className!==undefined && element.className!==null && element.className!=='') {
                cssClasses = element.className.trim().split(/\s+/g);
                
                for (var i = 0, l = cssClasses.length; i < l; i++) {
                    if (cssClasses[i] === cssClass) {
                        found = true;
                        break;
                    }
                }
            }
        } return found;
    };
	// Checa a existencia de uma Classe CSS [FIM] 
    
    
    // Remove uma Classe CSS [INICIO] 
    var removeClass = function (element, cssClass) {
        if (element!==undefined && element!==null && element!=='' && cssClass!==undefined && cssClass!==null && cssClass!=='') {
            if (hasClass(element, cssClass)) {
                var cssClasses = element.className.trim().split(/\s+/g),
                newClasses = '';
                
                for(var i = 0, l = cssClasses.length; i < l; i++) {
                    if (cssClasses[i] !== cssClass) {
                        newClasses = newClasses !== '' ? newClasses = newClasses + ' ' + cssClasses[i] : cssClasses[i];
                    }
                }
                    
                element.className = '';
                element.className = newClasses;
            }
        } return !hasClass(element, cssClass);
    };
    // Remove uma Classe CSS [FIM] 
    
    
    // Adiciona uma Classe CSS [INICIO] 
    var addClass = function (element, cssClass) {
        if (element!==undefined && element!==null && element!=='' && cssClass!==undefined && cssClass!==null && cssClass!=='') {
            if (!hasClass(element, cssClass)) {
                element.className = element.className !== '' ? element.className = element.className + ' ' + cssClass : element.className = cssClass;
            }
        } return hasClass(element, cssClass);
    };
    // Adiciona uma Classe CSS [FIM] 
    
	
	// Mostra ou Esconde a Imagem de Carregamento [INICIO]
	var toggleLoading = (function () {
		var isHidden = true;
		
		var loading = document.getElementById('background--loading');
		
		return function () {
			if (loading) {
				loading.style.display = isHidden ? 'block' : 'none';
				isHidden = isHidden ? false : true;
			}
		};
	})();
	// Mostra ou Esconde a Imagem de Carregamento [FIM]
	
	
	// Cria a Notificacao de Erro [INICIO]
	function ErrorNotification (message, notifacationId, element) {
		var node = document.createElement('SPAN');
		var msg = document.createTextNode('\u2718 ' + message);
		
		var attr = document.createAttribute('class');
		attr.value = 'error';
		
		var id = document.createAttribute('id');
		id.value = notifacationId;
		
		node.setAttributeNode(attr);
		node.setAttributeNode(id);
		
		node.appendChild(msg);
		
		element.parentNode.insertBefore(node, element);
	}
	// Cria a Notificacao de Erro [FIM]
	
	
	// Checa se o Formulario pode ser Enviado [INICIO]
	var canSubmitFields = function () {
		var emptyFields = 0;
		var firstEmpty = null;
		
		var required = document.getElementsByClassName('required');
		for (var j = 0, lj= required.length; j < lj; j++) {
			if (required[j].value==='') {
				if (firstEmpty === null) {
					firstEmpty = required[j];
				}
				
				var x = document.getElementById((required[j].getAttribute('id') + '-error'));
				
				if (!x) {
					new ErrorNotification(
						required[j].getAttribute('data-error-message'),
						(required[j].getAttribute('id') + '-error'),
						required[j]
					);
				}
				
				addClass(required[j].parentNode, 'container--field--error');
				
				emptyFields++;
			} else {
				var y = document.getElementById((required[j].getAttribute('id') + '-error'));
				
				if (y) {
					y.parentNode.removeChild(y);	
				}
				
				removeClass(required[j].parentNode, 'container--field--error');
			}
		}
		
		if (firstEmpty !== null) {
			window.scrollTo(0, firstEmpty.parentNode.documentOffsetTop);
			firstEmpty.focus();
		}
		
		return emptyFields > 0 ? false : true;
	};
	// Checa se o Formulario pode ser Enviado [FIM]
	
	
	// Junta funcoes para serem aplicadas ao Formulario [INICIO]
	var stuff = function () {
		toggleLoading();
		if (!canSubmitFields()) {
			toggleLoading();
			return false;
		}
	};
	// Junta funcoes para serem aplicadas ao Formulario [FIM]
	
	
	// Aplica as funcoes as Formulario [INICIO]
	var setup = document.forms.setup;
	if (setup) {
		setup.onsubmit = stuff;
	}
	// Aplica as funcoes as Formulario [FIM]
})();