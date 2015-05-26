content=$(sed 's/<\/b>/&\n/g;' pattern-dev.php | sed -e '/<b>/!d' -e 's/.*<b>\([^>]*\)<\/b>/\1/')
sudo echo '<?php'  $content  '?>'  > pattern-build.php