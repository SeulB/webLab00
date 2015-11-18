"use strict"
var stack = [];
window.onload = function () {
    var displayVal = "0";
    var post = [];
    var value = "";
    
    for (var i in $$('button')) {

        $$('button')[i].onclick = function () {
        	if (value == "=") {
        		stack = [];
        		displayVal ="0";
        		$('expression').innerHTML = "0";
        		$('result').innerHTML = "0";
        	}

            value = $(this).innerHTML;

            // number일 때
            if (0<=value && value<=9 && displayVal != "Error") {
                if (displayVal == 0) {
                	if ($('expression').innerHTML.charAt($('expression').innerHTML.length-1) == ")") {
                    	stack.push("*");
                    	$('expression').innerHTML += "*";
                	}
                    displayVal = value;
                }
                else {
                    displayVal += value;
                }
            }
            // AC일 때
            else if (value == "AC") {
                stack = [];
                displayVal = "0";
                $('expression').innerHTML = displayVal;
            }
            // 소수점일 때
            else if (value == "." && displayVal != "Error") {
                if (~displayVal.indexOf("."))
                    displayVal = displayVal;
                else
                    displayVal += value;
            }
            // ()일 때
            else if (displayVal != "Error" && (value == "(" || value == ")")) {
                if (displayVal.length != 1 || (displayVal.length == 1 && displayVal != 0)) 
                    stack.push(displayVal);

                if (value == "(" && displayVal == 0) {
                	if ($('expression').innerHTML.charAt($('expression').innerHTML.length-1) == ")") {
						stack.push("*")
						displayVal = "*("; 
                	}
                	else 
                 		displayVal = value;
                }
               	else if (value == ")" && $('expression').innerHTML.charAt($('expression').innerHTML.length-1) == ")") {
					displayVal = value; 
                }
                else if (value == "(" && 0<=displayVal.charAt(displayVal.length-1) && displayVal.charAt(displayVal.length-1)<=9) {
                    stack.push("*");
                    displayVal += "*(";
                }
               	else
                    displayVal += value;

                stack.push(value);
                if ($('expression').innerHTML == 0)
                    $('expression').innerHTML = displayVal;
                else
                    $('expression').innerHTML += displayVal;
                displayVal = "0";
            }
            // 연산자일 때
            else if (displayVal != "Error") {
                if (displayVal.length != 1 || (displayVal.length == 1 && displayVal != 0)) {
                    stack.push(displayVal);
                	displayVal += value;
                }
                else
                	displayVal = value;

                if ($('expression').innerHTML == 0)
                    $('expression').innerHTML = displayVal;
                else
                    $('expression').innerHTML += displayVal;

                // =일 때
                if (value == "=") {
                    if (isValidExpression($('expression').innerHTML)) {
                    	alert(stack);
                        post = infixToPostfix(stack);
                        displayVal = postfixCalculate(post);
	                    $('result').innerHTML = displayVal;
                    }
                    else {
                        displayVal = "Error";
                    }
                }
                else {
                    stack.push(value);
                	displayVal = "0"
                }
            }
            $('result').innerHTML = displayVal;
        };
    }
}
function isValidExpression(s) {
	var openBracket = 0;
	var closeBracket = 0;

	for (var i = 0; i < s.length; i++) {
		if (s[i] == "(")
			openBracket++;
		else if (s[i] == ")")
			closeBracket++;
	}

    if (openBracket == closeBracket)
        return true;
    
    return false;
}
function infixToPostfix(s) {
    var priority = {
        "+":0,
        "-":0,
        "*":1,
        "/":1
    };
    var tmpStack = [];
    var result = [];
    for(var i =0; i<stack.length ; i++) {
        if(/^[0-9]+$/.test(s[i])){
            result.push(s[i]);
        } else {
            if(tmpStack.length === 0){
                tmpStack.push(s[i]);
            } else {
                if(s[i] === ")"){
                    while (true) {
                        if(tmpStack.last() === "("){
                            tmpStack.pop();
                            break;
                        } else {
                            result.push(tmpStack.pop());
                        }
                    }
                    continue;
                }
                if(s[i] ==="(" || tmpStack.last() === "("){
                    tmpStack.push(s[i]);
                } else {
                    while(priority[tmpStack.last()] >= priority[s[i]]){
                        result.push(tmpStack.pop());
                    }
                    tmpStack.push(s[i]);
                }
            }
        }
    }
    for(var i = tmpStack.length; i > 0; i--){
        result.push(tmpStack.pop());
    }
    return result;
}
function postfixCalculate(s) {
    var i = 0;
    var temp = [];
    var x = 0;
    var y = 0;

    for (i = 0; i < s.length; i++) {
        if (s[i] == "*") {
            y = temp.pop();
            x = temp.pop();
            temp.push(parseInt(x)*parseInt(y));
        }
        else if (s[i] == "+") {
            y = temp.pop();
            x = temp.pop();
            temp.push(parseInt(x)+parseInt(y));
        }
        else if (s[i] == "-") {
            y = temp.pop();
            x = temp.pop();
            temp.push(parseInt(x)-parseInt(y));
        }
        else if (s[i] == "/") {
            y = temp.pop();
            x = temp.pop();
            temp.push(parseInt(x)/parseInt(y));
        }
        else {
            temp.push(s[i]);
        }
    }

    return temp;
}
