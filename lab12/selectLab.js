"use strict";

document.observe("dom:loaded", function() {
	/* Make necessary elements Dragabble / Droppables (Hint: use $$ function to get all images).
	 * All Droppables should call 'labSelect' function on 'onDrop' event. (Hint: set revert option appropriately!)
	 * 필요한 모든 element들을 Dragabble 혹은 Droppables로 만드시오 (힌트 $$ 함수를 사용하여 모든 image들을 찾으시오).
	 * 모든 Droppables는 'onDrop' 이벤트 발생시 'labSelect' function을 부르도록 작성 하시오. (힌트: revert옵션을 적절히 지정하시오!)
	 */
	
	var images = $$("#labs img");
	var selected = $$("#selectpad img");

	for (var i = 0; i < images.length; i++) {
		new Draggable(images[i], {revert:true});
	}

	for (var i = 0; i < selected.length; i++) { 
		new Draggable(selected[i], {revert:true});
	}

	Droppables.add("selectpad", {onDrop: labSelect});	
	Droppables.add("labs", {onDrop: labSelect});	
});

function labSelect(drag, drop, event) {
	/* Complete this event-handler function 
	 * 이 event-handler function을 작성하시오.
	 */
	
	if (drop.id != drag.parentNode.id) {	// 옮김
		if (drop.id == "selectpad") {
			var selectedimage = $$("#selectpad img");
			if (selectedimage.length < 3) {
				$('labs').removeChild(drag);
				$('selectpad').appendChild(drag);
				
				var li = document.createElement("li");
				li.innerHTML = drag.getAttribute("alt");
				$("selection").appendChild(li);

				li.pulsate({
					delay : 0.5,
					duration: 1.0
				});
			}
		}
		else if (drop.id == "labs") {
			$('selectpad').removeChild(drag);
			$('labs').appendChild(drag);

			var list = $$("#selection li");
			for (var i = 0; i < list.length; i++) {
				if (drag.getAttribute("alt") == list[i].innerHTML) {
					var remove = list[i];
				}
			}
			$('selection').removeChild(remove);
		}
	}	
}

