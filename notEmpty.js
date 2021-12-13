var forms = document.getElementsByTagName('form');
for (let form of forms) {
    form.addEventListener('submit', event => {
        var inputs = Array.from(form.querySelectorAll("*")).filter(e => e.tagName == "INPUT"),
            count = 0;
        for (let input of inputs) {
            if (!input.value) {
                if (count == 0) {
                    alert("Please fill the fields below.");
                    count++;
                }
                input.style.borderColor = "var(--danger)";
                event.preventDefault();
            }
        }
    });
}

var inputs = document.querySelectorAll('form input');
for (let input of inputs) {
    input.addEventListener('focus', () => {
        input.style.borderColor = "";
    });
}