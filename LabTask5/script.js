function analyze() {

    var text = document.getElementById("text").value;

    if (text == "") {
        document.getElementById("result").innerHTML = "Please enter text";
        return;
    }


    var characters = text.length;


    var words = text.trim().split(" ");
    var wordCount = 0;

    for (var i = 0; i < words.length; i++) {
        if (words[i] != "") {
            wordCount++;
        }
    }

    var reversed = "";
    for (var i = text.length - 1; i >= 0; i--) {
        reversed = reversed + text[i];
    }

    document.getElementById("result").innerHTML =
        "Characters: " + characters + "<br>" +
        "Words: " + wordCount + "<br>" +
        "Reversed: " + reversed;
}