<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Производительность");
?><b>[ex2-11]</b><br>
 Самая ресурсоемкая страница - /products/index.php<br>
 Среднее время -&nbsp;0.1863<br>
 Больше всего запросов bitrix:catalog.section : 8<br>
 <b>[ex2-10]</b><br>
 Самая ресурсоемкая страница - /products/index.php<br>
 Процент нагрузки - 18.09%<br>
 Самый долгий компонент -&nbsp;bitrix:catalog:&nbsp;<nobr>0.0468 с</nobr><br>
 <b>[ex2-88]</b><br>
 Самая ресурсоемкая страница - /Exam2/simplecomp/index.php<br>
 Процент нагрузки - 11.81%<br>
 Без setResultCacheKeys кэш - 57 КБ<br>
 С setResultCacheKeys кэш - 56 КБ<br>
 Разница - 1 КБ<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>