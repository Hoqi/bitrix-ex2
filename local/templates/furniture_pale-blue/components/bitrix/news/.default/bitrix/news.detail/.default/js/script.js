 $(document).ready(function() {
     if (($("#ajax-result").text()).length > 0){
         $("#user-text").text("Cпасибо за ваше важное очень мнение! " + $("#ajax-result").text());
     }
 })
