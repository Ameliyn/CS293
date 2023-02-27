function playGuessingGame(numToGuess = 5, totalGuesses = 10){

    let guess = prompt("Enter a number between 1 and 100.");
    for(i = 0; i < totalGuesses; i++){
        if(guess != null){
            if(isNaN(guess)){
                guess = prompt("Please enter a number.");
                i--;
            }
            else if(guess == numToGuess){
                return i+1;
            }
            else if(guess < numToGuess){
                guess = prompt(guess + " is too small. Guess a larger number.");
            }
            else{
                guess = prompt(guess + " is too large. Guess a smaller number.");
            }
        }
        else{
            return 0;
        }
    }
    return 0;
}