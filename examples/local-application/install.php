<?php
declare(strict_types=1);
?>
<pre>
    Application installation started, tokens from Bitrix24:
    <?= print_r($_REQUEST, true) ?>
</pre>
<script src="//api.bitrix24.com/api/v1/"></script>
<script>
    BX24.installFinish();
</script>