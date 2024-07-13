$(document).ready(function() {
    $('#selectAllBoxes').click(function(event) {
        console.log("Checkbox clicked!"); // Debugging statement
        if (this.checked) {
            $('.checkBoxes').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function() {
                this.checked = false;
            });
        }
    });
});


