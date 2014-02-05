var player1turn = true;
var player1score = 0;
var player2score = 0;

var hiddenPictures = new Array();

function assignPictures() {

// list of memory words
var pictures = new Array("resources/horse.jpg", "resources/cart.jpg", "resources/ninja.jpg", 
	"resources/sword.jpg", "resources/ailurophile.jpg", "resources/comely.jpg", 
	"resources/beleaguer.jpg", "resources/embrocation.jpg");

var hit = new Array(0, 0, 0, 0, 0, 0, 0, 0);

// clearing the array
hiddenPictures.length = 0;

	for (var i = 1; i <= 16; i++) {
		var placement = Math.floor(Math.random()*(pictures.length));
		// alert("Assigned " + pictures[placement] + " to spot " + i);
		//document.getElementById(i).src = pictures[placement];
		hiddenPictures.push[i] = pictures[placement];

		if (hit[placement] < 1) {
			hit[placement]++;
		} else {
			pictures.splice(placement, 1);
			hit.splice(placement, 1);
		}
	};

	alert("The player with the orange name indicates the current turn.");

	document.getElementById("p1name").style.color = "#ccaa11";
	document.getElementById("p2name").style.color = "#ffffff";
}

var firstClick = 0;
var activeWords = new Array();
var takenWords = new Array();

function clickWord(el) {

	if (takenWords.indexOf(el.id) >= 0) {
		// word has been solved. Try again.
		return;
	}

	if (firstClick == 0) {
		document.getElementById(el.id).style.color = "#ffffff";
		activeWords.push(el.id);
		firstClick++;
	} else if (firstClick == 1) {
		document.getElementById(el.id).style.color = "#ffffff";
		activeWords.push(el.id);

		if (activeWords[0] == activeWords[1]) {
			activeWords.splice(1,1);
			return;
		}

		firstClick++;

		var firstWord = document.getElementById(activeWords[0]).textContent;
		var secondWord = document.getElementById(activeWords[1]).textContent;

		if (firstWord == secondWord) { 
			// wods match, add them to takenWords and reset. Do not change colors.
			takenWords.push(activeWords[0]);
			takenWords.push(activeWords[1]);
			activeWords.length = 0;
			firstClick = 0;
			if (player1turn) {
				player1score++;
				document.getElementById("p1score").textContent = player1score;
			} else {
				player2score++;
				document.getElementById("p2score").textContent = player2score;
			};

		};
	} else { 
		// words do not match, change color to background color and reset.
		document.getElementById(activeWords[1]).style.color = "#333333";
		document.getElementById(activeWords[0]).style.color = "#333333";
		activeWords.length = 0;
		firstClick = 0;

		if (player1turn) {
			document.getElementById("p2name").style.color = "#ccaa11";
			document.getElementById("p1name").style.color = "#ffffff";
			player1turn = false;
		} else {
			document.getElementById("p1name").style.color = "#ccaa11";
			document.getElementById("p2name").style.color = "#ffffff";
			player1turn = true;
		};
	}
}


