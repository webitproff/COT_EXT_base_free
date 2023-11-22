# Points to Stars
PointstoStars Плагин для фриланс биржи на Cotonti переводит userpoints в звездах в завимости от настроек в админике.
https://freelance-script.abuyfile.com/points-to-stars/
Пример:
для половины звезды нужно 5 поинтов
для 1 зведзы нужно 15 поинтов
для 1.2 звезды нужно 20 поинтов и тд.

если скажет у пользователя 35 поинтов а в настройках это 2 звезды то мы увидим

Установка:
* Залить файлы в папку с плагинами (/plugins)
* Установить через админ
* В users.tpl Заменить {USERS_ROW_USERPOINTS} на {USERS_ROW_USERPOINTS|cot_pointstostars($this)}
* В users.details.tpl заменить {USERS_DETAILS_USERPOINTS} на {USERS_DETAILS_USERPOINTS|cot_pointstostars($this)}

*Примечание чтоб вывести звезды достаочно к стандарному тегу добавить функцию |cot_pointstostars($this)
06-05-2016
