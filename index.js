const decks = [];

function addNewDeck() {
    const deckForm = document.querySelector(".deck-form");
    deckForm.classList.toggle("d-none");
};    

function Deck(name) {
    this.name = name;
    this.id = Date.now();
}

function createDeck() {
    const template = document.getElementById("deckTemplate");
    const clone = template.content.cloneNode(true);

    const deckName = document.querySelector(".deck-name-input").value;

    const newDeck = new Deck(deckName);
    decks.push(newDeck);

    const deck = clone.querySelector(".deck");
    deck.classList.remove("d-none");

    deck.id = newDeck.id;

    const buttonName = clone.querySelector(".deck-name");
    buttonName.textContent = deckName;

    const decksDisplay = document.getElementById("decksDisplay");
    decksDisplay.appendChild(clone);

    document.querySelector(".deck-name-input").value = "";

    const addNewCard = deck.querySelector(".add-new-card");
    addNewCard.addEventListener("click", () => {
        const newCardForm = deck.querySelector(".card-form");
        newCardForm.classList.remove("d-none");
    });

    const createFlashCard = deck.querySelector(".create-card");
    createFlashCard.addEventListener("click", () => {
            const question = deck.querySelector(".card-question-input").value;
            const answer = deck.querySelector(".card-answer-input").value;
            const cardDisplay = deck.querySelector(".card-display");
            const newCardForm = deck.querySelector(".card-form");
        
            if (!question || !answer) {
                alert("please fill both fileds");
                return;
            }
        
            const newCard = new Card(question, answer);
            cards.push(newCard);
        
            const cardElement = document.createElement("div");
            cardElement.classList.add("card");
            cardElement.dataset.id = newCard.id;
        
            cardElement.innerHTML = `
                <div class="card-body">
                <div class="card-front">
                <p class="card-text">${newCard.question}</p>
                <button class="show-answer">Show Answer</button>
                </div>
                <div class="card-back d-none">  
                <p class="card-text">${newCard.answer}</p>
                </div> 
                <div class="card-actions">
                    <button class="edit-card btn btn-success">Edit</button>
                    <button class="delete-card btn btn-warning">Delete</button>
                </div>
                </div>`;
        
            cardDisplay.appendChild(cardElement);
        
            deck.querySelector(".card-question-input").value = "";
            deck.querySelector(".card-answer-input").value = "";
            newCardForm.classList.add("d-none");
        
            setupCardEvents(cardElement);
    });
};

const cards = [];

function Card(question, answer) {
  this.question = question;
  this.answer = answer;
  this.id = Date.now();
}

// function createFlashCard() {
//     const question = document.querySelector(".card-question-input").value;
//     const answer = document.querySelector(".card-answer-input").value;
//     const cardDisplay = document.querySelector(".card-display");
//     const newCardForm = document.querySelector(".card-form");

//     if (!question || !answer) {
//         alert("please fill both fileds");
//         return;
//     }

//     const newCard = new Card(question, answer);
//     cards.push(newCard);

//     const cardElement = document.createElement("div");
//     cardElement.classList.add("card");
//     cardElement.dataset.id = newCard.id;

//     cardElement.innerHTML = `
//         <div class="card-body">
//         <div class="card-front">
//         <p class="card-text">${newCard.question}</p>
//         <button class="show-answer">Show Answer</button>
//         </div>
//         <div class="card-back d-none">  
//         <p class="card-text">${newCard.answer}</p>
//         </div> 
//         <div class="card-actions">
//             <button class="edit-card btn btn-success">Edit</button>
//             <button class="delete-card btn btn-warning">Delete</button>
//         </div>
//         </div>`;

//     cardDisplay.appendChild(cardElement);

//     document.querySelector(".card-question-input").value = "";
//     document.querySelector(".card-answer-input").value = "";
//     newCardForm.classList.add("d-none");

//     setupCardEvents(cardElement);
// };

function setupCardEvents(cardElement) {
    cardElement.querySelector(".show-answer").addEventListener("click", function () {
        cardElement.querySelector(".card-back").classList.toggle("d-none");
    });

    cardElement.querySelector(".delete-card").addEventListener("click", function () {
        const cardId = parseInt(cardElement.dataset.id);
        const cardIndex = cards.findIndex(card => card.id === cardId);

        if (cardIndex > -1) {
            cards.splice(cardIndex, 1);
            cardElement.remove();
        }
    });

    cardElement.querySelector(".edit-card").addEventListener("click", function () {
        const cardId = parseInt(cardElement.dataset.id);
        const card = cards.find(card => card.id === cardId);

        if (!card) {
            return;
        }

        cardElement.querySelector(".card-front").classList.add("d-none");
        cardElement.querySelector(".card-back").classList.add("d-none");

        const editForm = document.createElement("div");
        editForm.id = "editForm";
        
        editForm.innerHTML = `
        <div id="editForm" class="">
        <input type="text" id="editQuestion" value="${card.question}">
        <input type="text" id="editAnswer" value="${card.answer}">
        <button class="save-edit">Save</button>
        <button class="cancel-edit">Cancel</button>
        </div>`;

        cardElement.appendChild(editForm);

        editForm.querySelector(".save-edit").addEventListener("click", function () {
            editQuestion = document.getElementById("editQuestion").value;
            editAnswer = document.getElementById("editAnswer").value;
            
            card.question = editQuestion;
            card.answer = editAnswer;

            cardElement.querySelector('.card-front p').textContent = card.question;
            cardElement.querySelector('.card-back p').textContent = card.answer;

            editForm.remove();
            cardElement.querySelector(".card-front").classList.remove("d-none");
        });

        editForm.querySelector('.cancel-edit').addEventListener('click', () => {
            editForm.remove();
            cardElement.querySelector('.cancel').classList.remove('d-none');
        });
    });
}

console.log(decks);
console.log(cards);