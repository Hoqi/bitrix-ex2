$(document).ready(function() {		
    $('#report').click(function() {
        $.get($('#report').attr("href"),function (data) {
            $('#user-text').text(`Спасибо, ваше мнение учтено : №${data}`);
        }).fail(err => {
            $('#user-text').text("Неудачная попытка");
        })
    });
    console.log($("#result"));
})