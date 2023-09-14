Плагин выбора категории через ajax

Copyright 2014 CMSWorks Team (http://cmsworks.ru)

Плагин для замены стандартного выбора категории (при создании и редактировании записи) на выбор с подгрузкой подкатегорий в дополнительном select через ajax. Плагин работает только для тех модулей, которые используют категории из базовой структуры Cotonti (Админка / Структура).

 

###Инструкция по установке

1. Распакуйте исходники в папку plugins вашего сайта.
2. Зайдите в панель администратора и установите данный плагин.
3. Замените тэги выбора категорий в формах создания и редактирования страниц:

###В модуле Page:

В шаблоне page.add.tpl заменяем тэг {PAGEADD_FORM_CAT} на {PHP.c|catselector_selectbox('page', $this, 'rpagecat', '', 'W')}
В шаблоне page.edit.tpl заменяем тэг {PAGEEDIT_FORM_CAT} на {PHP.pag.page_cat|catselector_selectbox('page', $this, 'rpagecat', '', 'W')}

###В модуле Projects (фриланс-биржа):

В шаблоне projects.add.tpl заменяем тэг {PRJADD_FORM_CAT} на {PHP.c|catselector_selectbox('projects', $this, 'rcat', '', 'W')}
В шаблоне projects.edit.tpl заменяем тэг {PRJEDIT_FORM_CAT} на {PHP.item.item_cat|catselector_selectbox('projects', $this, 'rcat', '', 'W')}

###В модуле Market (фриланс-биржа):

В шаблоне market.add.tpl заменяем тэг {PRDADD_FORM_CAT} на {PHP.c|catselector_selectbox('market', $this, 'rcat', '', 'W')}
В шаблоне market.edit.tpl заменяем тэг {PRDEDIT_FORM_CAT} на {PHP.item.item_cat|catselector_selectbox('market', $this, 'rcat', '', 'W')}


Чтобы отключить обязательный выбор всех подкатегорий, необходимо добавить дополнительный параметр в конце функции: 

{PHP.c|catselector_selectbox('projects', $this, 'rcat', '', 'W', 0)}
 

Если вам понравился данный плагин, то вы можете финансово поддержать разработчика по ссылке в правой колонке.
