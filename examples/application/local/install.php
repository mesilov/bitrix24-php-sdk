<?php
declare(strict_types=1);

require dirname(__DIR__, 3) . '/vendor/autoload.php';

?>
<pre>
    Установка приложения, получили токены от Битрикс24:
    <?= print_r($_REQUEST, true) ?>
</pre>
<script src="//api.bitrix24.com/api/v1/"></script>
<script>
    BX24.installFinish();
</script>