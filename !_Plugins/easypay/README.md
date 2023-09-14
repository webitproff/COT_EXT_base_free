Плагин позволяет создавать типовые платежки с фиксированной или свободной ценой. Такой плагин можно использовать для организации приема пожертвований на сайте или для приема оплаты за определенные типовые услуги сайта с фиксирвоанной стоимостью. Такие платежки могут оплачивать любые посетители сайта. Если оплата производится гостем, то при оплате он должен указать свой email для того, чтобы знать от кого пришла оплата.

Плагин работает только вместе с платежным модулем Payments.

В настройках плагина можно создать платежки и указать их названия и стоимость при необходимости.

 

Инструкция по установке

1. Распакуйте исходники в папку plugins вашего сайта.
2. Зайдите в панель администратора и установите данный плагин.
3. В настройках плагина создайте платежки. Для примера, уже создана платежка для пожертвований с кодом donation. 
4. Разместите в нужном вам шаблоне тэг платежки, например:

{PHP|cot_get_easypay('donation')}
, где в скобках указывается уникальный код платежки. Этот тэг выведет ссылку на оплату платежки ее название и стоимость, если платежка с фиксированной стоимостью.