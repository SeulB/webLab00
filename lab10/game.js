"use strict";

var numberOfBlocks = 9;
var targetBlocks = [];
var trapBlock;
var targetTimer;
var trapTimer;
var instantTimer;


document.observe('dom:loaded', function(){
	// when green button clicked
	$("start").observe("click", function() {
		$("state").innerHTML = "Ready!";
		$("score").innerHTML = "0";

		clearInterval(targetTimer);
		clearInterval(trapTimer);
		clearInterval(instantTimer);

		setTimeout(startGame, 3000);
	});
	// when red button clicked
	$("stop").observe("click", stopGame);
});

function startGame(){
	var blocks = $$(".block");
	targetBlocks = [];
	trapBlock = null;
	clearInterval(targetTimer);
	clearInterval(trapTimer);
	clearInterval(instantTimer);

	for (var i = 0; i < numberOfBlocks; i++){
		if (blocks[i].hasClassName("target")) {
			blocks[i].removeClassName("target");
			blocks[i].addClassName("normal");
		}
		else if (blocks[i].hasClassName("trap")) {
			blocks[i].removeClassName("trap");
			blocks[i].addClassName("normal");
		}
	}

	startToCatch();
}

function stopGame(){
	$("state").innerHTML = "Stop!";
	var blocks = $$(".block");

	targetBlocks = [];
	trapBlock = null;
	clearInterval(targetTimer);
	clearInterval(trapTimer);
	clearInterval(instantTimer);

	for (var i = 0; i < numberOfBlocks; i++){
		if (blocks[i].hasClassName("target")) {
			blocks[i].removeClassName("target");
			blocks[i].addClassName("normal");
		}
		else if (blocks[i].hasClassName("trap")) {
			blocks[i].removeClassName("trap");
			blocks[i].addClassName("normal");
		}
	}
}

function startToCatch(){
	$("state").innerHTML = "Catch!";
	var blocks = $$(".block");
	var score = 0;

	targetTimer = setInterval(showTarget, 1000);
	trapTimer = setInterval(showTrap, 3000);

	for (var i = 0; i < numberOfBlocks; i++) {
        blocks[i].observe("click", function() {
			var sel = this.getAttribute("data-index");

			console.log("target");

			if (blocks[sel].hasClassName("target")) {
				score += 20;
				blocks[sel].removeClassName("target");
				blocks[sel].addClassName("normal");
				targetBlocks.splice(targetBlocks.indexOf(sel),1);
			}
			else if (blocks[sel].hasClassName("trap")) {
				score -= 30;
				blocks[sel].removeClassName("trap");
				blocks[sel].addClassName("normal");
				trapBlock = null;
			}
			else {
				score -= 10;
				blocks[sel].removeClassName("normal");
				blocks[sel].addClassName("wrong");

				instantTimer = setTimeout(function() {
					blocks[sel].removeClassName("wrong");
		    		blocks[sel].addClassName("normal");
				}, 100);
			}

			$("score").innerHTML = score + " ";
        });
    }
}

function showTarget() {
	var temp = Math.floor(Math.random() * 9);
	var blocks = $$(".block");

	while (blocks[temp].hasClassName("target") || temp == trapBlock) {
		temp = Math.floor(Math.random() * 9);
	}

	targetBlocks.push(temp);

	blocks[temp].removeClassName("normal");
	blocks[temp].addClassName("target");

	if (targetBlocks.length > 4) {
		clearInterval(targetTimer);
		clearInterval(trapTimer);
		clearInterval(instantTimer);
		alert("you lose");
		for (var i = 0; i < numberOfBlocks; i++){
			blocks[i].stopObserving("click");
		}
		stopGame();
	}

}

function showTrap() {
	var temp = Math.floor(Math.random() * 9);
	var blocks = $$(".block");

	while (blocks[temp].hasClassName("target")) {
		temp = Math.floor(Math.random() * 9);
	}

	trapBlock = temp;

	blocks[temp].removeClassName("normal");
	blocks[temp].addClassName("trap");

	instantTimer = setTimeout(function() {
		trapBlock = null;
		blocks[temp].removeClassName("trap");
		blocks[temp].addClassName("normal");
	}, 2000);
}
