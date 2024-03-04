function getBotResponse(input) {
    // Rock paper scissors
    if (input == "Hello") {
        return "Hi, and welcome to NoTreatment donation assitance!!";
    } else if (input == "Hi") {
        return "Hi, and welcome to NoTreatment donation assitance!!";
    } else if (input == "What is NoTreatment?") {
        return "NoTreatment is a website dedicated to providing a comprehensive and user-friendly platform for managing patients' needs and facilitating medical services.";
    }

    // Simple responses
    if (input == "hello") {
        return "Hi, and welcome to NoTreatment donation assitance!!";
    } else if (input == "hi") {
        return "Hi, and welcome to NoTreatment donation assitance!!";
    } else if (input == "what's your name?") {
        return "I'm just a bot, so I don't have a name, but you can call me ChatGPT!";
    } else if (input == "who created you?") {
        return "I was created by OpenAI.";
    } else if (input == "tell me a joke") {
        return "Why don't scientists trust atoms? Because they make up everything!";
    } else if (input == "what's the weather like?") {
        return "I'm sorry, I can't provide real-time weather information.";
    } else if (input == "what time is it?") {
        var d = new Date();
        return "It is currently " + d.toLocaleTimeString() + ".";
    } else if (input == "thanks" || input == "thank you") {
        return "You're welcome!";
    } else if (input == "bye" || input == "goodbye") {
        return "Goodbye! Have a great day!";
    } else if (input == "Bye" || input == "Goodbye") {
        return "Goodbye! Have a great day!";}
        else {
        return "I'm sorry, I didn't understand that. Can you please ask something else?";
    }
}
