<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL.');
cot_rc_add_embed("reviewstar", "$.fn.raty.defaults.path = 'plugins/reviewstar/raty/images';
                                $.fn.raty.defaults.hints = ['Очень плохо', 'Плохо', 'Нормально', 'Хорошо', 'Очень хорошо'];");

cot_rc_add_file($cfg['plugins_dir'].'/reviewstar/raty/raty.js');                         
cot_rc_add_file($cfg['plugins_dir'].'/reviewstar/js/reviewstar.js');       