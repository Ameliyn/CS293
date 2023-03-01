window.addEventListener("DOMContentLoaded", domLoaded);

function domLoaded() {
   document.getElementById("convertButton").addEventListener("click",convertBoxes);
   document.getElementById("cInput").addEventListener("input", clearFValueOnInput);
   document.getElementById("fInput").addEventListener("input", clearCValueOnInput);
   
}

function convertBoxes(){
    let c = document.getElementById("cInput");
    let f = document.getElementById("fInput");
    let degFarenheit = 0;
    if (c.value !== ""){
        let floatValue = parseFloat(c.value);
        if (isNaN(floatValue)){
            document.getElementById("errorMessage").innerHTML = c.value + " is not a number";
            return;
        }
        else{
            document.getElementById("errorMessage").innerHTML = "";
            degFarenheit = convertCtoF(floatValue);
            f.value = convertCtoF(floatValue);
            c.value = "";            
        }

    }
    else{
        let floatValue = parseFloat(f.value);
        if (isNaN(floatValue)){
            document.getElementById("errorMessage").innerHTML = f.value + " is not a number";
            return;
        }
        else{
            document.getElementById("errorMessage").innerHTML = "";
            degFarenheit = f.value;
            c.value = convertFtoC(floatValue);
            f.value = "";            
        }

    }
    
    if (degFarenheit < 32){
        document.getElementById("weatherImage").src = "cold.png";
    }
    else if (degFarenheit <= 50){
        document.getElementById("weatherImage").src = "cool.png";
    }
    else{
        document.getElementById("weatherImage").src = "warm.png";
    }
}

function clearFValueOnInput(){
    document.getElementById("fInput").value = "";
}
function clearCValueOnInput(){
    document.getElementById("cInput").value = "";
}
function convertCtoF(degreesCelsius) {
   return degreesCelsius * 9/5 + 32;
}

function convertFtoC(degreesFahrenheit) {
   return (degreesFahrenheit - 32) * 5/9;
}
