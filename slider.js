const cards = document.querySelectorAll(".card");
let cardIndex = 0;

document.addEventListener('DOMContentLoaded', showCard);

function showCard(index) {

    const firstCard = cards[0];
    firstCard.querySelector(".prev").classList.add("disabled");

    if (index === cards.length - 1) {
        exitReviseMode();
        restartDeck();
        const currentCard = cards[index];
        currentCard.querySelector(".next").classList.add("d-none");
        currentCard.querySelector(".prev").classList.add("d-none");
    }

    else if (index < 0) {
        cardIndex = cards.length - 1;
    }

    cards.forEach(card => {
        card.classList.add("d-none");
    });
    cards[cardIndex].classList.remove("d-none");  
}

function exitReviseMode() {
    const exitButton = document.querySelector(".exit");
    exitButton.classList.remove("d-none");
}

function restartDeck() {
    const restartButton = document.querySelector(".restart");
    restartButton.classList.remove("d-none");
}

function prevCard(){
    cardIndex--;
    showCard(cardIndex);
}

function nextCard(){
    cardIndex++;
    showCard(cardIndex);
}